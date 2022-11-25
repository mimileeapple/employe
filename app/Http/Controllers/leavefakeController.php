<?php

namespace App\Http\Controllers;

use App\Services\HumanResourceServices;
use App\Services\empinforservices;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\empinfo;
use App\leaveorder;
use App\isholiday;
use App\jobyears;
use Session;
use DB;

class leavefakeController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp_list1 = $this->HumanResourceServices->select_emp();
        $now = date('Y-m');
        //dd($now);
        $emp_vacation = $this->empinforservices->years_vactation($now, Session::get('empid'));


        return view('leave.leaveorder', ['emp_list1' => $emp_list1, 'emp_vacation' => $emp_vacation]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = '';
        $emp_list1 = $this->HumanResourceServices->select_emp();

        return view('leave/leaveorder', ['emp_list1' => $emp_list1]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->empid;
        //上傳的檔案
//dd($request);
        if (isset($request->uploadfile)) {
            //檔名
            $image = $request->file('uploadfile');
            $filename = $image->getClientOriginalName();
            //套用哪個模組 模組位置 config/filesystems.php -> disks
//        Storage::disk('設定好的模組')->put('檔名','要上船的檔案'); 上傳成功會回傳true 失敗false
            $uploadPic = Storage::disk('Leave')->put($filename, file_get_contents($image->getRealPath()));
            //取得存好檔案的URL
            $photoURL = Storage::disk('Leave')->url($filename);

            $emp_list1 = $this->HumanResourceServices->selectemp($id);

            $data = array('uploadfile' => $photoURL);
            $data = array_merge(array_except($request->input(), '_token'), $data);
        } else {
            $data = array_except($request->input(), '_token');
        }


        $res = leaveorder::create($data);//用model的名字

        //寄信

        $title = "簽核通知-" . $request->name . "-請假單簽核";

        $tomail = $request->manage1mail;

        $towho = $request->manage1mail;;
        $content = "你有請假單尚未簽核，請至人資系統簽核";
        $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);

        if ($res != false) {
            $res = true;
        }

        $data = $this->HumanResourceServices->selectmyleave(Session::get('empid'));
        return view('leave.personalleaveorder', ['emp_list' => $data]);//跳到總表

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//
    {
        //我的個人請假資料

        $data = $this->HumanResourceServices->selectmyleave(Session::get('empid'));
        return view('leave.personalleaveorder', ['emp_list' => $data]);
    }

    /**
     *
     *
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //簽核總表頁面
        //先抓1階主管
        /* if($request->signsts==0&&$request->manage1id=Session::get('empid')){
         $data= $this->HumanResourceServices->bosssign1(Session::get('empid'));}
         if($request->signsts==1&&$request->manage2id=Session::get('empid')){
              $data= $this->HumanResourceServices->bosssign2(Session::get('empid'));}*/
        $data = $this->HumanResourceServices->bosssignall(Session::get('empid'));


        foreach ($data as $i => $v) {

            $data[$i]->order_data = $v->orderid . ',' . $v->signsts . ',' . $v->manage1empsign . ',' . $v->manage2empsign;
        }


        return view('sign.bosssign', ['emp_list1' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function isholiday(Request $request)
    {//判斷是否為假日
        $date_countday = $this->HumanResourceServices->isholiday($request->leavestart, $request->leaveend);
        //將抓到的資料用count來計算筆數 如果他抓到100筆符合條件的資料 就會計算出100
        return response()->json(['data' => $date_countday]);
    }

    public function signleaveorder(Request $request)
    {
        $leaveorder = new  leaveorder();
        $data = [];

        foreach ($request->Checkbox as $i => $v) {
            $upda = explode(',', $v);
//        $upda_data[$i]['orderid'] = $upda[0];
            $upda_data['signsts'] = $upda[1];
            if ($upda_data['signsts'] == 0) {//申請中
                $upda_data['manage1empsign'] = 'Y';
                $upda_data['signsts'] = '1';
                $upda_data['manage2empsign'] = 'N';
                //寄信

                $title = "簽核通知-" . $request->name[0] . "-請假單簽核";
                $tomail = $this->empinforservices->empdata($request->manage2id, 3);
                $tomail = $tomail[0]->mail;

                $towho = $this->empinforservices->empdata($request->manage2id, 1);//取name

                $towho = $towho[0]->name;
                $content = "你有請假單尚未簽核，請至人資系統簽核";
                $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);


            } else if ($upda_data['signsts'] == 1) {//一階主管已簽核 二階主管作業
                $upda_data['signsts'] = '2';
                $upda_data['manage2empsign'] = 'Y';//1簽過了
                $upda_data['manage1empsign'] = $upda[2];
                //寄信
                $title = "簽核通知-misa-請假單簽核";
                $tomail = "misa.lee@hibertek.com";//結案人
                $towho = "misa.lee";;
                $content = "你有請假單尚未簽核，請至人資系統簽核";
                $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);


            }
            leaveorder::where('orderid', $upda[0])->update($upda_data);
            $data = $this->HumanResourceServices->bosssignall(Session::get('empid'));
            //因為你勾選 他要處理一堆資料 最後在一開始就處理好 會方便很多

            Session::put('j', count($data));
        }
        return redirect()->back();
    }

    public function sreachdate(Request $request)
    {
        $id = $request->empid;
        $emp_list1 = $this->HumanResourceServices->selectmyleave($id);

        $data = $this->HumanResourceServices->sreachdate($request->sreachdateorder, $id);
        return view('leave.personalleaveorder', ['emp_list' => $data, 'emp_list1' => $emp_list1, 'selected' => $request->sreachdateorder]);

    }

    public function finshorder()//
    {
        //秀出列表

        $data = $this->HumanResourceServices->finshsign();
        return view('sign.finshsign', ['emp_list' => $data]);
    }

    public function signfinsh(Request $request)
    {

        //審核----->結案
        if ($request->signsts == 2) {
            foreach ($request->Checkbox as $k => $y) {
                $data[] = array('orderid' => $y, 'signsts' => '3', 'ordersts' => 'Y');

            }
        }
        $leaveorder = new  leaveorder();
        $leaveorder->updateBatch($data);
        return redirect()->back();
    }


    public function showleaveall(Request $request)
    {//秀出全部資料-------------------*************
        $emp_list1 = $this->HumanResourceServices->select_emp();//抓所有員工資料
//dd($request->input());
        if (!isset($request->sreachdateorder)) {//如果沒抓到時間
            $months = date('Y-m');//預設當月
        } else {
            $months = $request->sreachdateorder;//前台送來的搜尋時間 ---->selected
        }
        Session::put('thismonth', $months);
        $selectmonths = date($months . "-01");//抓搜尋時間的月初
        $years = "";
        $jobyears = "";
        $enddate = "";
        $selected = $months;

        foreach ($emp_list1 as $id => $emp) {//員工資料 這張就是empinfo

            $startdate = date($emp->achievedate);//就職日
            // $enddate = date('Y-m-t');
            // $enddate=date('Y-m-d', strtotime(date('Y-m-01', strtotime($selectmonths)) . ' 1 month -1 day'));//最後一天
            $enddate = date('Y-m-t', strtotime($selectmonths));
            $dateDifference = abs(strtotime($enddate) - strtotime($startdate));//年資阿
            $years = floor($dateDifference / (365 * 60 * 60 * 24));//年資滿幾年 未滿為0
            $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $jobyears = $years . '.' . $months;//這裡已經有了阿 //0.6

            $personlyears = $years . " year,  " . $months . " months , " . $days . " days";//年資
            $emp_list1[$id]['personlyears'] = $personlyears;//年資(詳細 含字串)
            $emp_list1[$id]['jobyears'] = $jobyears;//年.月(也算年資 沒算日)

            if ($emp->jobyears >= 0.6 && $emp->jobyears < 1 && $years == 0.0) {

                $years = 0.6;

            }
            $yearsdata = $this->empinforservices->sumjobyears($years);// 依年資取得休假列表

            $vacaion = $this->empinforservices->years_vactation($request->sreachdateorder, $emp->empid);

            foreach ($vacaion as $a) {
                $emp_list1[$id]['specialdate_m'] = $a->specialdate;
                $emp_list1[$id]['years_date_m'] = $a->years_date;
                $emp_list1[$id]['comp_time_m'] = $a->comp_time;
                $emp_list1[$id]['add_specialdate'] = $a->add_specialdate;
                $emp_list1[$id]['add_years_date'] = $a->add_years_date;
                $emp_list1[$id]['add_comp_time'] = $a->add_comp_time;
                $emp_list1[$id]['remain_specialdate'] = $a->remain_specialdate;
                $emp_list1[$id]['remain_years_date'] = $a->remain_years_date;
                $emp_list1[$id]['remain_comp_time'] = $a->remain_comp_time;
            }
            foreach ($yearsdata as $date) {
//floor(
                if ($years == $date->definition_years) {//年資有到的人

                    $emp_list1[$id]['specialdate'] = $date->specialdate;
                }
                if ($years >= 3) {//年休大於3年88

                    $emp_list1[$id]['years_date'] = $date->years_date;
                }
            }//特休年修結束


//******************************************************************//

            $emp_leavetotal = $this->empinforservices->sumleavedate($emp->empid, $selectmonths, $enddate);//昨天寫死 今天要寫活的
            foreach ($emp_leavetotal as $date) {


                if ($emp->empid == $date->empid) {
                    $emp_list1[$id]['a1'] = $date->a1;
                    $emp_list1[$id]['a2'] = $date->a2;
                    $emp_list1[$id]['a3'] = $date->a3;
                    $emp_list1[$id]['a4'] = $date->a4;
                    $emp_list1[$id]['a5'] = $date->a5;
                    $emp_list1[$id]['a6'] = $date->a6;
                    $emp_list1[$id]['a7'] = $date->a7;
                    $emp_list1[$id]['a8'] = $date->a8;
                    $emp_list1[$id]['a9'] = $date->a9;
                    $emp_list1[$id]['a10'] = $date->a10;
                    $emp_list1[$id]['a11'] = $date->a11;
                }
            }


        }


        return view('sign.totaltable', ['emp_list1' => $emp_list1, 'selected' => $selected]);

    }

    public function orderdetail($orderid)
    {
        $months = date('Y-m');
        $emp_list = $this->empinforservices->orderdetail($orderid);
        $a = $this->empinforservices->orderdetailmyid($orderid);//,'emp_list1'=>$data
        $data = $this->empinforservices->myvacation($a, $months);

        return view('sign.orderdetail', ['emp_list' => $emp_list, 'emp_list1' => $data]);
    }

}
