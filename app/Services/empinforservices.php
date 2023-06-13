<?php

namespace App\Services;

use App\Model\empinfo;
use App\Model\leaveorder;
use App\Model\isholiday;
use App\Model\jobyears;
use App\Model\emp_vacation;
use Mail;
use DB;
use Carbon\Carbon;

class empinforservices
{
    function empdata($id, $number)
    {
        $res = empinfo::where('empid', '=', $id)->value('name');
        if ($number == 1) {
            $res = empinfo::where('empid', '=', $id)->value('name');
        }
        if ($number == 2) {
            $res = empinfo::where('empid', '=', $id)->value('title');
        }
        if ($number == 3) {
            $res = empinfo::where('empid', '=', $id)->value('mail');
        }//取mail
        if ($number == 4) {
            $res = empinfo::where('empid', '=', $id)->value('cellphone');
        }
        if ($number == 5) {
            $res = empinfo::where('empid', '=', $id)->value('dep');
        }
        if ($number == 6) {
            $res = empinfo::where('empid', '=', $id)->value('deparea');
        }//
        if ($number == 7) {
            $res = empinfo::where('empid', '=', $id)->value('achievedate');
        }//
        if ($number == 8) {
            $res = empinfo::where('empid', '=', $id)->value('syslimit');
        }//
        if ($number == 9) {
            $res = empinfo::where('empid', '=', $id)->value('agentemp');
        }//
        if ($number == 10) {
            $res = empinfo::where('empid', '=', $id)->value('jobsts');
        }//
        if ($number == 11) {
            $res = empinfo::where('empid', '=', $id)->value('manage1name');
        }//
        if ($number == 12) {
            $res = empinfo::where('empid', '=', $id)->value('manage2name');
        }//
        if ($number == 13) {
            $res = empinfo::where('empid', '=', $id)->value('qq');
        }
        if ($number == 14) {
            $res = empinfo::where('empid', '=', $id)->value('manage1mail');
        }//
        if ($number == 15) {
            $res = empinfo::where('empid', '=', $id)->value('manage2mail');
        }//
        if ($number == 16) {
            $res = empinfo::where('empid', '=', $id)->value('manage1id');
        }//
        if ($number == 17) {
            $res = empinfo::where('empid', '=', $id)->value('manage2id');
        }//
        if ($number == 18) {
            $res = empinfo::where('empid', '=', $id)->value('ename');
        }//
        return $res;
    }

    function sumleavedate($empid, $month)
    {//假別
        $res = DB::select("select empid,
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
WHERE months='$month' and ordersts<>'D'
group by empid");
        return $res;
    }

    function sumjobyears($years)
    {//查詢特休

        return jobyears::where('definition_years', '=', $years)->get();
    }

    function showleaveorderall()
    {//嗅出全部請假單
        return leaveorder::all();

    }

    function years_vactation($months, $empid)
    {//抓取某人某月的假期表

        return emp_vacation::where('months', '=', $months)->where('empid', '=', $empid)->get();

    }

    function nextmonthdata($months)
    {//抓取某月份全部員工特休總數
        $res = emp_vacation::where('months', '=', $months)->count();

        return $res;
    }

    function emp_vacation_all($months)
    {//抓取某月份全部員工特休

        return emp_vacation::where('months', '=', $months)->get();

    }

    function orderdetail($orderid)
    {//以單號抓取某張請假單
        return leaveorder::where('orderid', '=', $orderid)->get();
    }

    function orderdetailmyid($orderid)
    {//抓取某張請假單的empid
        return leaveorder::where('orderid', '=', $orderid)->value('empid');
    }

    function leaveorderdatil($fakeid, $month, $empid)
    {
        $selectmonths =$month;

        return leaveorder::where('months','=',$month)->where('leavefakeid', '=', $fakeid)->
        where('empid', '=', $empid)->where('ordersts','<>','D')->get();
    }

    function historysignfinsh($page)
    {
        return leaveorder::where('signsts', '=', 3)->where('ordersts', '=', 'Y')->where('area','like','T')->paginate($page);
    }
    function leaveorderdatil_day($day,$empid){
        $res=leaveorder::where('leavestart', '>=', $day)->where('leaveend', '<=', $day)->
        where('empid', '=', $empid)->where('ordersts','<>','D')->get();
        return $res;
    }
}
