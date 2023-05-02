<?php

namespace App\Http\Controllers;

use App\Model\empinfo;
use App\Model\leaveorder;
use Illuminate\Support\Facades\Response;
use App\Services\CheckinServices;
use App\Services\HumanResourceServices;
use Illuminate\Http\Request;
use App\Model\checkin;
use App\Model\log\checkin_log;
use Session;
use Arr;
use Illuminate\Support\Collection;


class checkinController extends Controller
{
    private $HumanResourceServices;
    private $CheckinServices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->CheckinServices = new CheckinServices();

    }

    public function index()
    {
        $status = '';
        return view('attendance.checkin', ['status' => $status]);
    }


    public function create()
    {
        //跳轉至upcheckin補卡頁面
        $status = '';
        return view('attendance.upcheckin', ['status' => $status]);
    }


    public function store(Request $request)
    {
        //儲存上下班打卡資訊
        try {
            foreach ($request->input()['data'] as $i => $v) {
                $data[$v['name']] = $v['value'];
            }
            /*unset($data['_token']);
                 $res=checkin::where('empid','=',$data['empid'])->
                 where('checkdate','=',$data['checkdate'])->
                 where('btnactionid','=',$data['btnactionid'])->update($data);*/
            $res = checkin::create($data);
            return response()->json(['status' => 'true']);
        } catch (\Exception $e) {

            return response()->json(['status' => 'false']);
        }

    }


    public function show($id)
    {//秀出所有自己的出勤

        $checklist = $this->CheckinServices->showcheck($id);
        //$checklist[0]->leaveorder='Y';

        foreach ($checklist as $i => $c) {

            if ($c->checkintime == "" || $c->checkouttime == "") {
                $nodate = $c->checkdate;;
                $res = $this->CheckinServices->leaveorderdatilday($nodate, $id);

                if (count($res) > 0) {
                    $checklist[$i]->leaveorder = 'Y';
                } else {
                    $checklist[$i]->leaveorder = 'N';
                }

            } else {
                $checklist[$i]->leaveorder = "";

            }

        }
//dd($checklist);

        return view("attendance.persolwork", ['checklist' => $checklist]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {//補卡

        try {
            $data = $request->input();

            $res = checkin::create($data);
            $checklist = $this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡成功'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin", ['checklist' => $checklist]);
        } catch (\Exception $e) {
            $checklist = $this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡失敗'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin", ['checklist' => $checklist]);
        }
    }


    public function destroy(Request $id)
    {
        $id = $id->input('id');
        //dd($id);
        checkin::where('id', $id)->update(['sign' => 'D']);

        $checkdata = checkin::where('id', $id)->get();
        $checkdata[0]->action = 'delete';
        checkin_log::create($checkdata->toArray()[0]);
        checkin::where('id', $id)->delete();//
        $checklist = $this->CheckinServices->showchecksign(session::get('empid'));
        Session::put('check', count($checklist));//設定簽核數量
        return view("sign.checkinsign", ['checklist' => $checklist]);
    }

    public function search_checkin(Request $request)
    {//查詢自己的月份出勤表
        $empid = $request->input('empid');
        $months = $request->input('months');
        $checklist = $this->CheckinServices->showmonthcheckin($months, $empid);

        foreach ($checklist as $i => $c) {

            if ($c->checkintime == "" || $c->checkouttime == "") {
                $nodate = $c->checkdate;;
                $res = $this->CheckinServices->leaveorderdatilday($nodate, $empid);

                if (count($res) > 0) {
                    $checklist[$i]->leaveorder = 'Y';
                } else {
                    $checklist[$i]->leaveorder = "N";
                }

            } else {
                $checklist[$i]->leaveorder = "";

            }

        }
        return view("attendance.persolwork", ['checklist' => $checklist, 'months' => $months]);
    }

    public function showchecksign(Request $request)
    {//秀出簽核頁面
        $id = $request->input(' id');
        $checklist = $this->CheckinServices->showchecksign(session::get('empid'));

        Session::put('check', count($checklist));//設定簽核數量
        return view("sign.checkinsign", ['checklist' => $checklist]);
    }

    public function signcheckin(Request $request)
    {//簽核
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        //從陣列中刪除Checkbox _token PS;如果懶得做白名單或者怕model發生衝突 用這種方式最保險
        $data = array_except($request->input(), ['_token', 'Checkbox']);
        //用in一次修改多個不同ID的資料
        checkin::whereIn('id', $request->Checkbox)->update($data);

        $id = session::get('empid');
        $checklist = $this->CheckinServices->showchecksign($id);
        Session::put('check', count($checklist));//重新整理簽核數量
        return view("sign.checkinsign", ['checklist' => $checklist]);
    }

    public function showallemplist(Request $request)
    {//秀出所有員工出勤表頁面
        //$empid= $request->input('empid');
        //$months=$request->input('months');

        //$checklist=$this->CheckinServices->showmonthcheckin($months,$empid);

        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
//        foreach ($checklist as $i=>$c) {
//
//            if ($c->checkintime == "" || $c->checkouttime == "") {
//                $nodate = $c->checkdate;;
//                $res = $this->CheckinServices->leaveorderdatilday($nodate, $empid);
//
//                if (count($res) > 0) {
//                    $checklist[$i]->leaveorder = 'Y';
//                } else {
//                    $checklist[$i]->leaveorder = 'N';
//                }
//
//            } else {
//                $checklist[$i]->leaveorder = "";
//
//            }
        //  }
        return view("attendance.showallemplist", ['emp_list1' => $emp_list1]);

    }

    public function search_checkemp(Request $request)
    {//查詢所有員工每月出勤表
        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
        $empid = $request->input('empid');
        $months = $request->input('months');
        $checklist = $this->CheckinServices->showmonthcheckin($months, $empid);

        foreach ($checklist as $i => $c) {

            if ($c->checkintime == "" || $c->checkouttime == "") {
                $nodate = $c->checkdate;;
                $res = $this->CheckinServices->leaveorderdatilday($nodate, $empid);

                if (count($res) > 0) {
                    $checklist[$i]->leaveorder = 'Y';
                } else {
                    $checklist[$i]->leaveorder = "N";
                }

            } else {
                $checklist[$i]->leaveorder = "";

            }

        }
        return view("attendance.showallemplist", ['emp_list1' => $emp_list1, 'checklist' => $checklist, 'empid' => $empid, 'months' => $months]);
    }

    public function historysign(Request $request)
    {
        $checklist = $this->CheckinServices->historyshowchecksign();
        return view("sign.history_checkinsign", ['checklist' => $checklist]);
    }

    public function leaveorderdatilday(Request $request)
    {
        $emp_list = $this->CheckinServices->leaveorderdatilday($request->input()['day'], $request->input()['empid']);
        return view('sign.persolorder', ['emp_list' => $emp_list]);
    }

    //選擇month的function
    public function selectmonthshowcheckintotal()
    {
        //跳至遲到總表頁面
        return view('attendance.checkintotal');
    }

    public function selectmonth(Request $request)
    {
        //查詢當月遲到總表
        $selected = $request->input('sreachdateorder');
        $emp_list = empinfo::where('jobsts', 'like', 'Y')->get();;//所有的員工表
        $da = str_replace('-', '', $request->input('sreachdateorder'));//月份
        $everyday = $this->CheckinServices->showmontheveryday($da);//抓取DB內選擇的月份所有的日期
        //  $emp_list=  json_decode( json_encode($emp_list), true);
        $everyday = json_decode(json_encode($everyday), true);

        foreach ($emp_list as $k => $emp) {

            foreach ($everyday as $i => $day) {
                $latetime = $this->CheckinServices->sumworktime($day['checkdate'], $emp['empid']);

                $latetime = json_decode(json_encode($latetime), true);//dd($latetime);
                $latelist[$day['checkdate']][$emp['empid']] = $latetime[0]['worktimes'];


            }
            $latemonthsum = $this->CheckinServices->showmonthlatesum($da, $emp['empid']);//sum(負數)
           $isint=get_object_vars($latemonthsum[0])['summonthlate'];

           if($isint<0){
            $latemonthsum == json_decode(json_encode($latemonthsum), true);

            $latemonth[$emp['empid']]= get_object_vars($latemonthsum[0]);
            $late[$emp['empid']]=$latemonth[$emp['empid']]['summonthlate'];
           }
           elseif($isint==null){
               $latemonthsum == json_decode(json_encode($latemonthsum), true);

               $latemonth[$k]= get_object_vars($latemonthsum[0]);
               $late[$emp['empid']]='0';
           }
           else{
               $latemonthsum == json_decode(json_encode($latemonthsum), true);

               $latemonth[$k]= get_object_vars($latemonthsum[0]);
               $late[$emp['empid']]='0';
           }
        }

        return view('attendance.checkintotal', ['emp_list' => $emp_list, 'everyday' => $everyday, 'latelist' => $latelist,
            'late'=>$late,'selected' => $selected]);

    }


    public function showcheckinoflate(Request $request)
    {

    }

    public function checkinoflate(Request $request)
    {


    }
}

