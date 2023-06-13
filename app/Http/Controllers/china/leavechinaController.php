<?php

namespace App\Http\Controllers\china;
use App\Services\HumanResourceServices;
use App\Services\empinforservices;
use App\Services\CheckinServices;
use App\Services\ChinaServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\leaveorder;
use Session;
use DB;

class leavechinaController
{
    private $HumanResourceServices;
    private $empinforservices;
    private $CheckinServices;
    private $ChinaServices;
    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
        $this->CheckinServices = new CheckinServices();
        $this->ChinaServices=new ChinaServices();
    }

    public function index()
    {
        $emp_list1 = $this->ChinaServices->emp_list_china();
        $now = date('Y-m');
        $emp_vacation = $this->empinforservices->years_vactation($now, Session::get('empid'));

        return view('leave.leaveorder', ['emp_list1' => $emp_list1, 'emp_vacation' => $emp_vacation]);
    }


    public function create()
    {

    }


    public function store(Request $request)//申請請假單
    {

    }

    public function show($id)////我的個人請假資料
    {

    }

    public function edit(Request $request)//主管需要的簽核資料
    {

    }

    public function update(Request $request, $id)
    {


    }

    public function destroy(Request $id)
    {
    }



    public function finshorderchina()//秀出請假單需要結案的列表
    {
        $data = $this->ChinaServices->finshsignchina(10);
        return view('china.empmanage.hrsys.finshsign', ['emp_list' => $data]);
    }

    public function signfinshchina(Request $request)//結案簽核
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

    public function showleaveallchina(Request $request)//請假總表
    {//秀出全部資料-------------------*************
        $emp_list1 = $this->ChinaServices->select_emp_china();//抓所有員工資料
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

            $emp_leavetotal = $this->empinforservices->sumleavedate($emp->empid, $selected);

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
            $da = str_replace('-', '', $selected);//月份
            $latemonthsum = $this->CheckinServices->showmonthlatesum($da, $emp['empid']);//sum(負數)
            $isint=get_object_vars($latemonthsum[0])['summonthlate'];

            if($isint<0){
                $latemonthsum == json_decode(json_encode($latemonthsum), true);

                $latemonth[$id]= get_object_vars($latemonthsum[0]);
                $emp_list1[$id]['late']=$latemonth[$id]['summonthlate'];
            }
            elseif($isint==null){
                $latemonthsum == json_decode(json_encode($latemonthsum), true);

                $latemonth[$id]= get_object_vars($latemonthsum[0]);
                $emp_list1[$id]['late']='0';
            }
            else{
                $latemonthsum == json_decode(json_encode($latemonthsum), true);

                $latemonth[$id]= get_object_vars($latemonthsum[0]);
                $emp_list1[$id]['late']='0';
            }
        }
      //  dd($late);
        return view('sign.totaltable', ['emp_list1' => $emp_list1, 'selected' => $selected]);

    }


    public function historysignfinshchina()
    { //歷史簽核完畢資料
        $data = $this->ChinaServices->historysignfinshchina(10);

        return view('china.empmanage.hrsys.history_finshsign', ['emp_list' => $data]);
    }

}
