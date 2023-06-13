<?php

namespace App\Http\Controllers;

use App\Model\leaveorder;
use App\Services\HumanResourceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Model\empinfo;
use App\Model\emp_vacation;
use Session;
use DB;
use  App\Services\empinforservices;

class vacationController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
    }

    public function index()
    {
        $emp_list = $this->HumanResourceServices->select_emp();
        return view('sign.specialdate', ['emp_list' => $emp_list]);
    }


    public function create()
    {
        $thismonth = date(Session::get('thismonth'));
        $emp_list = $this->HumanResourceServices->select_emp();
        foreach ($emp_list as $id => $emp) {//員工資料 這張就是empinfo
            $selectmonths = date($thismonth . "-01");
            $startdate = date($emp->achievedate);//就職日
            // $enddate = date('Y-m-t');
            // $enddate=date('Y-m-d', strtotime(date('Y-m-01', strtotime($selectmonths)) . ' 1 month -1 day'));//最後一天
            $enddate = date('Y-m-t', strtotime($thismonth));

            $dateDifference = abs(strtotime($enddate) - strtotime($startdate));//年資阿
            $years = floor($dateDifference / (365 * 60 * 60 * 24));//年資滿幾年 未滿為0
            $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            $jobyears = $years . '.' . $months;//這裡已經有了阿 //0.6

            $personlyears = $years . "年" . $months . "月" . $days . "日";//年資
            $emp_list[$id]['personlyears'] = $personlyears;//年資(詳細 含字串)
            $emp_list[$id]['jobyears'] = $jobyears;//年.月(也算年資 沒算日)

            //特休年修結束
            $vacaion = $this->empinforservices->years_vactation($thismonth, $emp->empid);
            //1.判斷year跟month都等於0時候維剛開始2.有year但month=0 則為周年 則將病假重設15840分鐘
            if($months==0){
                $sickday=15840;
                $emp_list[$id]['add_sickday']=$sickday;
                }


            if ($years==0&&$months==6) {

                $year= 0.6;
                $jobvaction=$this->empinforservices->sumjobyears($year);
                foreach ($jobvaction as $v){

                    $emp_list[$id]['add_specialdate'] = $v->specialdate;
                    $emp_list[$id]['add_years_date'] = $v->years_date;
                }
            }
            else if($years>0&&$months==0){
                $jobvaction=$this->empinforservices->sumjobyears($years);
                foreach ($jobvaction as $v){

                    $emp_list[$id]['add_specialdate'] = $v->specialdate;
                    $emp_list[$id]['add_years_date'] = $v->years_date;

                }

            }
            else{
                $emp_list[$id]['add_specialdate'] = 0;
                $emp_list[$id]['add_years_date'] =0;
            }
            foreach ($vacaion as $a) {

                $emp_list[$id]['specialdate_m'] = $a->specialdate;
                $emp_list[$id]['years_date_m'] = $a->years_date;
                $emp_list[$id]['comp_time_m'] = $a->comp_time;
                $emp_list[$id]['add_comp_time'] = $a->add_comp_time;
                $emp_list[$id]['remain_specialdate'] = $a->remain_specialdate;
                $emp_list[$id]['remain_years_date'] = $a->remain_years_date;
                $emp_list[$id]['remain_comp_time'] = $a->remain_comp_time;
            }
            $emp_leavetotal = $this->empinforservices->sumleavedate($emp->empid, $selectmonths, $enddate);//昨天寫死 今天要寫活的
            foreach ($emp_leavetotal as $date) {


                if ($emp->empid == $date->empid) {
                    $emp_list[$id]['a1'] = $date->a1 * 60;
                    $emp_list[$id]['a2'] = $date->a2 * 60;
                    $emp_list[$id]['a11'] = $date->a11 * 60;
                    $emp_list[$id]['a6'] = $date->a6 * 60;
                }
            }


        }
        $status = '';

        return view('sign.specialdate', ['emp_list' => $emp_list, 'status' => $status]);
    }


    public function store(Request $request)
    {
        $emp_list1 = $this->HumanResourceServices->select_emp();

        $today = date('Y-m-d');
        $thistoday=date('Y-m', strtotime(Session::get('thismonth')));
        $nextmonth = date('Y-m', strtotime(date('Y-m-01', strtotime(Session::get('thismonth'))) . 'last day of 1 month'));
        $thismonth_list=$this->empinforservices->nextmonthdata($thistoday);
        $month_list = $this->empinforservices->nextmonthdata($nextmonth);
        try {

            foreach ($emp_list1 as $emp) {
                if($thismonth_list>0){
                    //有資料
                $status = DB::update('update emp_vacation set
          add_specialdate = ?,add_years_date = ?,add_comp_time = ?,
          specialdate=?, years_date=?,comp_time=?,sub_specialdate=?,sub_years_date=?,sub_comp_time=?,
          remain_specialdate=?,remain_years_date=?,remain_comp_time=?,updateemp=?,updatedate=?,sts=?
                    where empid =? and months=?',
                    [
                        $_POST['add_specialdate'][$emp->empid],
                        $_POST['add_years_date'][$emp->empid],
                        $_POST['add_comp_time'][$emp->empid],
                        $_POST['specialdate'][$emp->empid],
                        $_POST['years_date'][$emp->empid],
                        $_POST['comp_time'][$emp->empid],
                        $_POST['sub_specialdate'][$emp->empid],
                        $_POST['sub_years_date'][$emp->empid],
                        $_POST['sub_comp_time'][$emp->empid],
                        $_POST['remain_specialdate'][$emp->empid],
                        $_POST['remain_years_date'][$emp->empid],
                        $_POST['remain_comp_time'][$emp->empid],
                        Session::get('name'),$today,'update',
                        $emp->empid,
                        date(Session::get('thismonth'))]);
                $status = true;
            }
                else{
                    //沒資料
                    $status = DB::insert('insert into emp_vacation (
                    empid,name,ename,achievedate,months,
                    specialdate,years_date,comp_time,add_specialdate ,add_years_date,
                    add_comp_time,sub_specialdate,sub_years_date,sub_comp_time,remain_specialdate,
                    remain_years_date,remain_comp_time,updateemp,createmp,updatedate,
                    creatdate,sts)
        values (?,?,?,?,?,
                ?,?,?,?,?,
                ?,?,?,?,?,
                ?,?,?,?,?,
                ?,?
               )',
  [$_POST['empid'][$emp->empid], $_POST['name'][$emp->empid], $_POST['ename'][$emp->empid], $_POST['achievedate'][$emp->empid], $thistoday,
  $_POST['specialdate'][$emp->empid],$_POST['years_date'][$emp->empid],$_POST['comp_time'][$emp->empid],$_POST['add_specialdate'][$emp->empid],$_POST['add_years_date'][$emp->empid],
   $_POST['add_comp_time'][$emp->empid],$_POST['sub_specialdate'][$emp->empid],$_POST['sub_years_date'][$emp->empid],$_POST['sub_comp_time'][$emp->empid], $_POST['remain_specialdate'][$emp->empid],
$_POST['remain_years_date'][$emp->empid],$_POST['remain_comp_time'][$emp->empid],Session::get("name"),Session::get("name"), $today, $today,'insert']);
                    $status = true;

                }
                if ($month_list == 0) {//下月
                    try {
                        $status = DB::insert('insert into emp_vacation (
                    empid,name,ename,achievedate,months,
                     specialdate,years_date,comp_time,createmp,updateemp,creatdate,updatedate,sts)
        values (?,?,?,?,?,
              ?,?,?,?,?,?,?,?
               )',
                            [$_POST['empid'][$emp->empid], $_POST['name'][$emp->empid], $_POST['ename'][$emp->empid], $_POST['achievedate'][$emp->empid], $nextmonth,
                             $_POST['remain_specialdate'][$emp->empid],$_POST['remain_years_date'][$emp->empid],$_POST['remain_comp_time'][$emp->empid],
                             $_POST['updateemp'][$emp->empid], Session::get("name"), $today, $today,'insert']);
                        $status = true;
                    }

                   catch (\Exception $e) {
                    }
                }
                else{
                    $status = DB::update('update emp_vacation set
          specialdate=?, years_date=?,comp_time=?,updateemp=?,updatedate=?,sts=?
                    where empid =? and months=?',
                        [

                            $_POST['remain_specialdate'][$emp->empid],
                            $_POST['remain_years_date'][$emp->empid],
                            $_POST['remain_comp_time'][$emp->empid],
                            Session::get('name'),$today,'update',
                            $emp->empid,
                            $nextmonth]);
                    $status = true;
                }


            }
            $emp_list = $this->empinforservices->emp_vacation_all(Session::get('thismonth'));

            if ($status) {
                //更新成功
                echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
                return view('sign.specialdate', ['emp_list' => $emp_list, 'status' => true]);
            }
            else {
                return view('sign.specialdate', ['emp_list' => $emp_list, 'status' => false]);
            }
        } catch (Exception $e) {
            //錯誤

        }


    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {

    }


    public function destroy($id)
    {
        //
    }
}
