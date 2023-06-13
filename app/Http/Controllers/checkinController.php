<?php

namespace App\Http\Controllers;

use App\Model\checkin_sign;
use App\Model\checkin_signlog;
use App\Model\empinfo;
use App\Model\isholiday;
use App\Model\leaveorder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Services\CheckinServices;
use App\Services\HumanResourceServices;
use Illuminate\Http\Request;
use App\Model\checkin;
use Illuminate\Support\Arr;
use Session;
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
    //用匯入的 所以不用了
    }


    public function show($id)
    {//秀出所有自己的出勤

        $checklist = $this->CheckinServices->showcheck($id);
        //$checklist[0]->leaveorder='Y';

        foreach ($checklist as $i => $c) {

            $nodate = $c->checkdate;;
            $res = $this->CheckinServices->leaveorderdatilday($nodate, $id);

            if (count($res) > 0) {
                $checklist[$i]->leaveorder = 'Y';
            } else {
                $checklist[$i]->leaveorder = 'N';
            }

        }
//dd($checklist);
        return view("attendance.persolwork", ['checklist' => $checklist]);
    }


    public function edit($id)
    {
        //
    }


    public function search_checkin(Request $request)
    {//查詢自己的月份出勤表
        $empid = $request->input('empid');
        $months = $request->input('months');
        $da = str_replace('-', '', $months);//月份
        $everyday = $this->CheckinServices->showmontheveryday($da);//抓取DB內選擇的月份所有的日期

        $everyday = json_decode(json_encode($everyday), true);
        $late = [];
        $latelist = [];
        foreach ($everyday as $i => $day) {

            $latetime['worktimein'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('worktimein');//人員每日打卡時間
            $latetime['worktimeout'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('worktimeout');

            $latelist[$day['checkdate']] = $latetime;
            $starttime = leaveorder::where('startdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leavestart');
            $endtime = leaveorder::where('enddate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leaveend');

            $start = Carbon::parse($starttime);
            $end = Carbon::parse($endtime);
            $diff = $start->diffInMinutes($end, false);
            $minutes = $diff;  // 取得請假分鐘數
            $isleave = leaveorder::where('startdate', 'like', $day['checkdate'])->where('enddate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leavefakename');
//有請假的 isleave為何假 minutes為請假時數
            if ($minutes == 540) {
                if ($isleave != "") {
                    $latetime['latemin'] = "";
                    $latetime['leavetime'] = $isleave . $minutes . "分";
                }
            } elseif ($minutes < 535) {
                $latesum = $this->CheckinServices->sumworktime($day['checkdate'], $empid);//人員每日遲到分鐘數函數
                $latesum = json_decode(json_encode($latesum), true);//轉為數組
                $latesum = Arr::flatten($latesum);//扁平化陣列
                $templatetime = implode($latesum);
                //如果有請假須扣除請假分鐘數 才會等於真正的遲到時間
                $latetimes = $minutes + (int)$templatetime;
                if ($latetimes > 0) {
                    $latetime['latemin'] = $latetimes;
                } else {
                    $latetime['latemin'] = $latetimes;
                    $late[$day['checkdate']] = $latetimes;
                }
                $latetime['leavetime'] = $isleave . $minutes . "分";
            }
            //當小於8小時等於只有當天 則可直接顯示
            //當大魚8小時等於超過一天，則需撈取假日表來換算 總共請了多少分鐘 再顯示出來
            $latelist[$day['checkdate']] = $latetime;
            if ($latetime['worktimein'] == "" && $latetime['worktimeout'] == "") {
                $isholiday = isholiday::where('date', 'like', $day['checkdate'])->value('isholiday');
                if ($isholiday == '2') {
                    $latetime = ["worktimein" => "-", "worktimeout" => "-",
                        "latemin" => "-", "leavetime" => "-"];
                    $latelist[$day['checkdate']] = $latetime;
                }
            }
            //存入每天每人的打卡時間
            $latelist = json_decode(json_encode($latelist), true);

        }
        // dd($latelist);
        // 將數組轉換為 Collection
        $collection = collect($late);
// 使用 Collection 的 sum 方法加總日期後的值
        $total = $collection->sum();

        return view("attendance.persolwork",['everyday' => $everyday, 'latelist' => $latelist, 'total' => $total, 'months' => $months]);
    }

    public function showallemplist(Request $request)
    {//秀出所有員工出勤表頁面並跳轉至該頁面

        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
        return view("attendance.showallemplist", ['emp_list1' => $emp_list1]);

    }

    public function search_checkemp(Request $request)
    {//查詢所有員工每月出勤表
        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
        $empid = $request->input('empid');
        $months = $request->input('months');
        $da = str_replace('-', '', $months);//月份
        $everyday = $this->CheckinServices->showmontheveryday($da);//抓取DB內選擇的月份所有的日期

        $everyday = json_decode(json_encode($everyday), true);
        $late = [];
        $latelist = [];
        foreach ($everyday as $i => $day) {
            $latetime['worktimein'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('worktimein');//人員每日打卡時間
            $latetime['worktimeout'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('worktimeout');

            $latelist[$day['checkdate']] = $latetime;
            $starttime = leaveorder::where('startdate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leavestart');
            $endtime = leaveorder::where('enddate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leaveend');

            $start = Carbon::parse($starttime);
            $end = Carbon::parse($endtime);
            $diff = $start->diffInMinutes($end, false);
            $minutes = $diff;  // 取得請假分鐘數
            $isleave = leaveorder::where('startdate', 'like', $day['checkdate'])->where('enddate', 'like', $day['checkdate'])->where('empid', '=', $empid)->value('leavefakename');
//有請假的 isleave為何假 minutes為請假時數
            if ($minutes == 540) {
                if ($isleave != "") {
                    $latetime['latemin'] = "";
                    $latetime['leavetime'] = $isleave . $minutes . "分";
                }
            } elseif ($minutes < 535) {

                //存入每天每人的打卡時間
                $latesum = $this->CheckinServices->sumworktime($day['checkdate'], $empid);//人員每日遲到分鐘數函數
                $latesum = json_decode(json_encode($latesum), true);//轉為數組
                $latesum = Arr::flatten($latesum);//扁平化陣列
                $templatetime = implode($latesum);
                $latetimes = $minutes + (int)$templatetime;
                if ($latetimes > 0) {
                    $latetime['latemin'] = $latetimes;
                } else {
                    $latetime['latemin'] = $latetimes;
                    $late[$day['checkdate']] = $latetimes;//遲到表用日期當key value是遲到分數
                }
                $latetime['leavetime'] = $isleave . $minutes . "分";//
            }
            //當小於8小時等於只有當天 則可直接顯示
            //當大魚8小時等於超過一天，則需撈取假日表來換算 總共請了多少分鐘 再顯示出來


            $latelist[$day['checkdate']] = $latetime;
            if ($latetime['worktimein'] == "" && $latetime['worktimeout'] == "") {//如果上下班都沒有資料 則判斷該天是否為休假日
                $isholiday = isholiday::where('date', 'like', $day['checkdate'])->value('isholiday');
                if ($isholiday == '2') {
                    $latetime = ["worktimein" => "-", "worktimeout" => "-",
                        "latemin" => "-", "leavetime" => "-"];
                    $latelist[$day['checkdate']] = $latetime;
                }
            }
            $latelist = json_decode(json_encode($latelist), true);
            //如果有請假須扣除請假分鐘數 才會等於真正的遲到時間

        }
        // dd($latelist);

        // 將數組轉換為 Collection
        $collection = collect($late);
// 使用 Collection 的 sum 方法加總日期後的值
        $total = $collection->sum();

        return view("attendance.showallemplist", ['emp_list1' => $emp_list1, 'everyday' => $everyday, 'latelist' => $latelist, 'total' => $total, 'months' => $months]);
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
        $emp_list = empinfo::where('jobsts', 'like', 'Y')->where('depareaid', 'like', 'T')->where('depid', '<>', 1)->get();//所有的員工表
        $da = str_replace('-', '', $request->input('sreachdateorder'));//月份
        $everyday = $this->CheckinServices->showmontheveryday($da);//抓取DB內選擇的月份所有的日期
        //  $emp_list=  json_decode( json_encode($emp_list), true);
        $everyday = json_decode(json_encode($everyday), true);
        $late = [];
        foreach ($emp_list as $k => $emp) {

            foreach ($everyday as $i => $day) {

                $latetime['worktimein'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $emp['empid'])->value('worktimein');//人員每日打卡時間
                $latetime['worktimeout'] = checkin::where('checkdate', 'like', $day['checkdate'])->where('empid', '=', $emp['empid'])->value('worktimeout');

                $latelist[$day['checkdate']][$emp['empid']] = $latetime;
                $starttime = leaveorder::where('startdate', 'like', $day['checkdate'])->where('empid', '=', $emp['empid'])->value('leavestart');
                $endtime = leaveorder::where('enddate', 'like', $day['checkdate'])->where('empid', '=', $emp['empid'])->value('leaveend');

                $start = Carbon::parse($starttime);
                $end = Carbon::parse($endtime);
                $diff = $start->diffInMinutes($end, false);
                $minutes = $diff;  // 取得請假分鐘數
                $isleave = leaveorder::where('startdate', 'like', $day['checkdate'])->where('enddate', 'like', $day['checkdate'])->where('empid', '=', $emp['empid'])->value('leavefakename');
//有請假的 isleave為何假 minutes為請假時數
                if ($minutes == 540) {
                    if ($isleave != "") {
                        $latetime['latemin'] = "";
                        $latetime['leavetime'] = $isleave . $minutes . "分";
                    }
                } elseif ($minutes < 535) {

                    $latesum = $this->CheckinServices->sumworktime($day['checkdate'], $emp['empid']);//人員每日遲到分鐘數函數
                    $latesum = json_decode(json_encode($latesum), true);//轉為數組
                    $latesum = Arr::flatten($latesum);//扁平化陣列
                    $templatetime = implode($latesum);
                    $latetimes = $minutes + (int)$templatetime;//如果有請假須扣除請假分鐘數 才會等於真正的遲到時間
                    if ($latetimes > 0) {
                        $latetime['latemin'] = $latetimes;
                    } else {
                        $latetime['latemin'] = $latetimes;
                        $late[$emp['empid']][$day['checkdate']] = $latetimes;
                    }
                    $latetime['leavetime'] = $isleave . $minutes . "分";
                }
                //當小於8小時等於只有當天 則可直接顯示
                //當大魚8小時等於超過一天，則需撈取假日表來換算 總共請了多少分鐘 再顯示出來

                $latelist[$day['checkdate']][$emp['empid']] = $latetime;
                if ($latetime['worktimein'] == "" && $latetime['worktimeout'] == "") {
                    $isholiday = isholiday::where('date', 'like', $day['checkdate'])->value('isholiday');
                    if ($isholiday == '2') {
                        $latetime = ["worktimein" => "-", "worktimeout" => "-",
                            "latemin" => "-", "leavetime" => "-"];
                        $latelist[$day['checkdate']][$emp['empid']] = $latetime;
                    }
                }
                //存入每天每人的打卡時間
                $latelist = json_decode(json_encode($latelist), true);

            }
        }

        $total = [];//加總
        foreach ($late as $k => $values) {
            $total[$k] = array_sum($values);//使用日期來加總來存入k=empid
        }
        return view('attendance.checkintotal', ['emp_list' => $emp_list, 'everyday' => $everyday, 'latelist' => $latelist, 'total' => $total, 'selected' => $selected]);
    }


    /*****************************************************************************/
    public function update(Request $request, $id)
    {//補卡
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        try {
            $data = $request->input();
            $checkdate = $request->input("checkdate");

            $dataToUpdate = [];

            foreach ($data as $key => $value) {
                if ($request->filled($key)) {
                    $dataToUpdate[$key] = $value;
                }
            }

            $dataToUpdate = array_except($dataToUpdate, ['_token', '_method']);
//dd($dataToUpdate);
            //***確定需要checkin裡面的欄位.並確定要更改的欄位例如sts與哪個time被修改過
            $res = checkin::where('checkdate', 'like', $checkdate)->where('empid', '=', $id)->update($dataToUpdate);


            $checkinid = checkin::where('checkdate', 'like', $checkdate)->where('empid', '=', $id)->value('id');
            $checkofdata = checkin::where('id', '=', $checkinid)->get();
            if ($request->input("checkworkin") != "") {
                $checkofdata['checkworkin'] = $request->input("checkworkin");
            } else if ($request->input("checkworkout") != "") {
                $checkofdata['checkworkout'] = $request->input("checkworkout");
            }

            $checkdate['createemp'] = Session::get("name");
            $checkdate['updateemp'] = Session::get("name");
            $checkdate['creatdate'] = $today;
            $checkdate['updatedate'] = $today;
            $checkdate['checkinid'] = $checkinid;
            //****新增入sign簽核表中
            checkin_sign::create($checkofdata);
            $checklist = $this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡成功'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin", ['checklist' => $checklist]);
        } catch (\Exception $e) {
            $checklist = $this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡失敗'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin", ['checklist' => $checklist]);
        }
    }

    /*簽核部分*/
    public function showchecksign(Request $request)
    {//秀出簽核頁面
        $id = $request->input(' id');
        //**抓取checksign裡sts!=Y

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
        //**將checksign裡面資料改變後將時間寫回checkin資料表
        checkin_sign::whereIn('id', $request->Checkbox)->update($data);
       $checkid= checkin_sign::where('id', $request->Checkbox)->value('checkinid');
        $checkinsts= checkin_sign::where('id', $request->Checkbox)->value('checkinsts');
        $checkoutsts= checkin_sign::where('id', $request->Checkbox)->value('checkoutsts');
        if($checkinsts!=null&&$checkinsts!=""){
        $checksigndata['checkinsts']=$checkinsts;}
        if($checkoutsts!=null&&$checkoutsts!=""){
        $checksigndata['checkoutsts']=$checkoutsts;}
        checkin::where('id','=',$checkid)->update($checksigndata);
        $checklist = $this->CheckinServices->showchecksign(session::get('empid'));
        Session::put('check', count($checklist));//重新整理簽核數量
        return view("sign.checkinsign", ['checklist' => $checklist]);
    }


    public function destroy(Request $id)
    {
        //刪除補卡
        $id = $id->input('id');
        //dd($id);
        $checkinid= checkin_sign::where('id', $id)->value('checkinid');
        $upcheckworkinstsname= checkin_sign::where('id', $id)->value('upcheckworkinstsname');
        $checkinsts= checkin_sign::where('id', $id)->value('checkinsts');
        $upcheckworkoutstsname= checkin_sign::where('id', $id)->value('upcheckworkoutstsname');
        $checkoutsts= checkin_sign::where('id', $id)->value('checkoutsts');
        $worktimein= checkin_sign::where('id', $id)->value('worktimein');
        $worktimeout= checkin_sign::where('id', $id)->value('worktimeout');
        $checkin= checkin_sign::where('id', $id)->value('checkin');
        $checkout= checkin_sign::where('id', $id)->value('checkout');
        $checkindata['upcheckworkinstsname']='';
        $checkindata['checkinsts']='';
        $checkindata['upcheckworkoutstsname']='';
        $checkindata['checkoutsts']='';
        $checkindata['worktimein']='';
        $checkindata['worktimeout']='';
        $checkindata['checkin']='';
        $checkindata['checkout']='';
        checkin::where('id',$checkinid)->update($checkindata);//將已經寫入的資料復原
        checkin_sign::where('id', $id)->update(['sign' => 'D']);
        //******刪除sign裡面資料並丟進signlog裡面
        $checkdata = checkin_sign::where('id', $id)->get();
        $checkdata['delsignid']=$id;
        checkin_signlog::create($checkdata->toArray()[0]);
        checkin_sign::where('id', $id)->delete();//將簽核表刪除
        $checklist = $this->CheckinServices->showchecksign(session::get('empid'));
        Session::put('check', count($checklist));//設定簽核數量
        return view("sign.checkinsign", ['checklist' => $checklist]);
    }
    /*****************************************************************************/
}

