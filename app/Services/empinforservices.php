<?php
namespace App\Services;
use App\empinfo;
use App\leaveorder;
use App\isholiday;
use App\jobyears;
use App\emp_vacation;
use Mail;
use DB;
use Carbon\Carbon;
class empinforservices{
    function empdata($id,$number)
    {
        $res = empinfo::where('empid', '=', $id)->get('name');
        if ($number == 1) {
            $res = empinfo::where('empid', '=', $id)->get('name');
        }
        if ($number == 2) {
            $res = empinfo::where('empid', '=', $id)->get('title');
        }
        if ($number == 3) {
            $res = empinfo::where('empid', '=', $id)->get('mail');
        }//取mail
        if ($number == 4) {
            $res = empinfo::where('empid', '=', $id)->get('cellphone');
        }
        if ($number == 5) {
            $res = empinfo::where('empid', '=', $id)->get('dep');
        }
        if ($number == 6) {
            $res = empinfo::where('empid', '=', $id)->get('deparea');
        }//
        if ($number == 7) {
            $res = empinfo::where('empid', '=', $id)->get('achievedate');
        }//
        if ($number == 8) {
            $res = empinfo::where('empid', '=', $id)->get('syslimit');
        }//
        if ($number == 9) {
            $res = empinfo::where('empid', '=', $id)->get('agentemp');
        }//
        if ($number == 10) {
            $res = empinfo::where('empid', '=', $id)->get('jobsts');
        }//
        if ($number == 11) {
            $res = empinfo::where('empid', '=', $id)->get('manage1name');
        }//
        if ($number == 12) {
            $res = empinfo::where('empid', '=', $id)->get('manage2name');
        }//
        if ($number == 13) {
            $res = empinfo::where('empid', '=', $id)->get('qq');
        }//

        return $res;
    }
        function sumleavedate($empid,$leavestart,$leaveend){//假別
 $res =DB::select("select empid,
SUM(CASE  leavefakeid WHEN   '1'  THEN  hours  else 0 END)'a1',
SUM(CASE  leavefakeid WHEN   '2'  THEN  hours  else 0 END)'a2',
SUM(CASE  leavefakeid WHEN   '3'  THEN  hours  else 0 END)'a3',
SUM(CASE  leavefakeid WHEN   '4'  THEN  hours  else 0 END)'a4',
SUM(CASE  leavefakeid WHEN   '5'  THEN  hours  else 0 END)'a5',
SUM(CASE   leavefakeid WHEN  '6'  THEN  hours  else 0 END) 'a6',
SUM(CASE   leavefakeid WHEN  '7'  THEN  hours  else 0 END) 'a7',
SUM(CASE   leavefakeid WHEN  '8'  THEN  hours  else 0 END) 'a8',
SUM(CASE   leavefakeid WHEN  '9'  THEN  hours  else 0 END) 'a9',
SUM(CASE  leavefakeid WHEN  '10'  THEN  hours  else 0  END) 'a10',
SUM(CASE  leavefakeid WHEN  '11'  THEN  hours  else 0  END) 'a11'
from leaveorder
WHERE (leavestart >= '$leavestart' and leaveend <= '$leaveend')
group by empid");;
            return $res;
        }
        function sumjobyears($years){//查詢特休

            return jobyears::where('definition_years','=',$years)->get() ;
        }
        function showleaveorderall(){//嗅出全部請假單
            return leaveorder::all();

        }
        function years_vactation($months,$empid){//抓取某人某月的假期表


            $re=emp_vacation::where( 'months','=',$months) ->where('empid','=',$empid)->get();

            return $re;

        }
        function nextmonthdata($months){//抓取某月份總數
            $res = emp_vacation::where('months','=',$months)->count();

            return $res;
        }
        function emp_vacation_all($months){//抓取某月份假期全部員工

            return emp_vacation::where('months','=',$months)->get();

        }
        function orderdetail($orderid){//抓取某張請假單
            return leaveorder::where('orderid','=',$orderid)->get();
        }
    function orderdetailmyid($orderid){//抓取某張請假單的empid
        return leaveorder::where('orderid','=',$orderid)->value('empid');
    }
    function myvacation($id,$months){//抓取某人某月的假期

        return emp_vacation::where('empid',$id and 'months',$months)->get();
    }
}
