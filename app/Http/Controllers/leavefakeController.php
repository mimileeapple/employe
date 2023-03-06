<?php

namespace App\Http\Controllers;

use App\Model\log\leaveorder_log;
use App\Services\HumanResourceServices;
use App\Services\empinforservices;
use App\Services\PayServices;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Model\empinfo;
use App\Model\leaveorder;
use App\Model\isholiday;
use App\Model\jobyears;
use App\Model\tripdata;
use Session;
use DB;

class leavefakeController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;
    private $PayServices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
        $this->PayServices = new PayServices();
    }

    public function index()
    {
        $emp_list1 = $this->HumanResourceServices->select_emp();
        $now = date('Y-m');
        $emp_vacation = $this->empinforservices->years_vactation($now, Session::get('empid'));

        return view('leave.leaveorder', ['emp_list1' => $emp_list1, 'emp_vacation' => $emp_vacation]);
    }


    public function create()
    {
        $status = '';
        $emp_list1 = $this->HumanResourceServices->select_emp();
        $now = date('Y-m');
        $emp_vacation = $this->empinforservices->years_vactation($now, Session::get('empid'));
        return view('leave/leaveorder', ['emp_list1' => $emp_list1, 'emp_vacation' => $emp_vacation]);
    }


    public function store(Request $request)//申請請假單
    {
        $id = $request->empid;
        //上傳的檔案

        if (isset($request->uploadfile)) {
            //檔名
            $image = $request->file('uploadfile');
            $filename = $image->getClientOriginalName();
            //套用哪個模組 模組位置 config/filesystems.php -> disks
//        Storage::disk('設定好的模組')->put('檔名','要上船的檔案'); 上傳成功會回傳true 失敗false

            $newfilename=Session::get('empdata')->ename;
            $date=date("Ymd");
            $newfilename=$newfilename.$date;
            $arr = explode(".", $filename);
            $myfilename=$newfilename.".".$arr[1];
            

            $uploadPic = Storage::disk('Leave')->put($myfilename, file_get_contents($image->getRealPath()));

            //取得存好檔案的URL
            $photoURL = Storage::disk('Leave')->url($myfilename);

            $emp_list1 = $this->HumanResourceServices->selectemp($id);

            $data = array('uploadfile' => $photoURL);
            $data = array_merge(array_except($request->input(), '_token'), $data);
        } else {
            $data = array_except($request->input(), '_token');
        }

        $res = leaveorder::create($data);//用model的名字
        //寄信
       /* $title = "簽核通知-" . $request->name . "-請假單簽核";
        $tomail = $request->manage1mail;
        $towho = $request->manage1mail;;
        $content = "你有請假單尚未簽核，請至人資系統簽核";
        $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/

        if ($res != false) {
            $res = true;
        }
        $data = $this->HumanResourceServices->selectmyleave(Session::get('empid'),10);
       return view('leave.personalleaveorder', ['emp_list' => $data]);//跳到總表

    }

    public function show($id)////我的個人請假資料
    {
        $data = $this->HumanResourceServices->selectmyleave(Session::get('empid'),10);
        return view('leave.personalleaveorder', ['emp_list' => $data]);
    }

    public function edit(Request $request)//主管需要的簽核資料
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

    public function update(Request $request, $id)
    {


    }
//我剛剛加了Request 是宣告說 他要接從前台丟來的參數 你取消的話  他會變成 GET 但是 正常來說 是都有會有
//現在發惠生這樣的情況 主要是因為他是resource的路由 resource本身都有特別的規則在限制 你說他的這些含是嬤
//對 新 修 查 改 都有 特別的規則 就是沒照著寫 很容易錯誤就對了
//對 你現在的寫法比較偏向 沒照規則走  就是自己創一個路由 那樣的話 什麼規則都沒有  你想怎麼寫就怎麼寫 一班都是怎樣?
    public function destroy(Request $id)
    {//刪除請假單 sts=D
  $id = $id->input('id');

        leaveorder::where('orderid', $id)->update(['ordersts'=>'D']);
        $data = $this->HumanResourceServices->bosssignall(Session::get('empid'));
        foreach ($data as $i => $v) {

            $data[$i]->order_data = $v->orderid . ',' . $v->signsts . ',' . $v->manage1empsign . ',' . $v->manage2empsign;
        }
       $leavedata= leaveorder::where('orderid', $id)->get();
        $leavedata[0]->action='delete';
        leaveorder_log::create($leavedata->toArray()[0]);
        leaveorder::where('orderid', $id)->delete();//

        return view('sign.bosssign', ['emp_list1' => $data]);
    }


    public function signleaveorder(Request $request)//簽核請假單
    {
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        $leaveorder = new  leaveorder();

        foreach ($request->Checkbox as $i => $v) {
            $upda = explode(',', $v);
            //$upda_data[$i]['orderid'] = $upda[0];
            $upda_data['signsts'] = $upda[1];
            if ($upda_data['signsts'] == 0) {//申請中
                $upda_data['manage1empsign'] = 'Y';
                $upda_data['signsts'] = '1';
                $upda_data['manage2empsign'] = 'N';
                $upda_data['updatedate'] = $today;
                $upda_data['updateemp'] = Session::get('name');
                $upda_data['manage1empsigndate'] = $today;
                //寄信

                /* $title = "簽核通知-" . $request->name[0] . "-請假單簽核";
                 $tomail = $this->empinforservices->empdata($request->manage2id, 3);
                 $towho = $this->empinforservices->empdata($request->manage2id, 1);//取name
                 $content = "你有請假單尚未簽核，請至人資系統簽核";
                 $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/


            } else if ($upda_data['signsts'] == 1) {//一階主管已簽核 二階主管作業
                $upda_data['signsts'] = '2';
                $upda_data['manage2empsign'] = 'Y';//1簽過了
                $upda_data['manage1empsign'] = $upda[2];
                $upda_data['updatedate'] = $today;
                $upda_data['updateemp'] = Session::get('name');
                $upda_data['manage2empsigndate'] = $today;
                //寄信
                /* $title = "簽核通知-misa-請假單簽核";
                 $tomail = "misa.lee@hibertek.com";//結案人
                 $towho = "misa.lee";;
                 $content = "你有請假單尚未簽核，請至人資系統簽核";
                 $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/


            }
            leaveorder::where('orderid', $upda[0])->update($upda_data);

        }
        $data = $this->HumanResourceServices->bosssignall(Session::get('empid'));

        Session::put('j', count($data));
        return redirect()->back();
    }

    public function sreachdate(Request $request)//以月分搜尋某人請假單
    {//以日期
        $id = $request->empid;

        $emp_list1 = $this->HumanResourceServices->selectmyleave($id,10);//抓自己全部請假資料
        $data = $this->HumanResourceServices->sreachdate($request->sreachdateorder, $id,10);//以月分搜尋某人請價單
        return view('leave.personalleaveorder', ['emp_list' => $data, 'emp_list1' => $emp_list1, 'selected' => $request->sreachdateorder]);

    }

    public function finshorder()//秀出請假單需要結案的列表
    {
        $data = $this->HumanResourceServices->finshsign(10);
        return view('sign.finshsign', ['emp_list' => $data]);
    }

    public function signfinsh(Request $request)//結案簽核
    {
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        //審核----->結案
        $leaveorder = new  leaveorder();
        $data = [];
        foreach ($request->Checkbox as $k => $y) {

            $data['signsts'] = '3';
            $data['ordersts'] = 'Y';
            $data['signfinshdate'] = $today;
            $data['updateemp'] = Session::get('name');

            leaveorder::where('orderid', $y)->update($data);
        }
        return redirect()->back();
    }

    public function showleaveall(Request $request)//請假總表
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

            $personlyears = $years . "年" . $months . "月" . $days . "日";//年資
            $emp_list1[$id]['personlyears'] = $personlyears;//年資(詳細 含字串)
            $emp_list1[$id]['jobyears'] = $jobyears;//年.月(也算年資 沒算日)



            //$yearsdata = $this->empinforservices->sumjobyears($years);// 依年資取得休假列表

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


//******************************************************************//

            $emp_leavetotal = $this->empinforservices->sumleavedate($emp->empid, $selectmonths, $enddate);
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

    public function orderdetail($orderid)//以單號搜尋某張請假單明細
    {
        $months = date('Y-m');
        $emp_list = $this->empinforservices->orderdetail($orderid);
        $a = $this->empinforservices->orderdetailmyid($orderid);//,'emp_list1'=>$data
        $data = $this->empinforservices->years_vactation($months, $a);

        return view('sign.orderdetail', ['emp_list' => $emp_list, 'emp_list1' => $data]);
    }

    public function isholiday(Request $request)//判斷是否為假日
    {
        $date_countday = $this->HumanResourceServices->isholiday($request->leavestart, $request->leaveend);
        //將抓到的資料用count來計算筆數 如果他抓到100筆符合條件的資料 就會計算出100
        return response()->json(['data' => $date_countday]);
    }
    public function workinfo(Request  $request){
        $date_countday = $this->HumanResourceServices->workinfo($request->leavestart);
        return response()->json(['data' => $date_countday]);
    }
    public function showleaveorder(Request $request)
    {//秀出某月某人特定假期請假列表 EX:全部病假


        $emp_list = $this->empinforservices->leaveorderdatil($request->input()['fakeid'], $request->input()['month'], $request->input()['empid']);

        return view('sign.persolorder', ['emp_list' => $emp_list]);
    }

    public function historysignfinsh()
    { //歷史簽核完畢資料
        $data = $this->empinforservices->historysignfinsh(10);

        return view('sign.history_finshsign', ['emp_list' => $data]);
    }

}
