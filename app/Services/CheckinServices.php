<?php

namespace App\Services;
use App\Model\checkin;
use App\Model\checkin_sign;
use App\Model\leaveorder;
use DB;
use Session;
class CheckinServices
{
    function showcheck($empid){//上班

     $res=DB::select("SELECT empid,checkdate,worktimein,worktimeout FROM `checkin` WHERE empid=$empid and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y'))  GROUP BY empid,checkdate ORDER BY checkdate asc");
//dd($res);
    return $res;
    }
    function showcheckday($day,$empid){//上班

        $res=DB::select("SELECT worktimein,worktimeout FROM `checkin` WHERE empid=$empid and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y')) and checkdate='$day' GROUP BY empid,checkdate ORDER BY checkdate asc");
//dd($res);
        return $res;
    }
    function showcheckout($day,$empid){//上班

        $res=DB::select("SELECT worktimeout FROM `checkin` WHERE empid=$empid and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y')) and checkdate='$day' GROUP BY empid,checkdate ORDER BY checkdate asc");
//dd($res);
        return $res;
    }
    function showmonthcheckin($months,$empid){
     $res=DB::select("SELECT empid,checkdate,worktimein,worktimeout FROM `checkin` WHERE empid=$empid and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y'))  and yearmonths='$months'  GROUP BY empid,checkdate ORDER BY checkdate asc");

      return $res;
    }
    function showmonth($months,$empid){
        $res=DB::select("SELECT worktimein,worktimeout FROM `checkin` WHERE empid=$empid and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y'))  and yearmonths='$months'  GROUP BY empid,checkdate ORDER BY checkdate asc");

        return $res;
    }
    function showchecksign($id){
        $res = DB::table('checkin_sign')
            ->where(function ($query) {
                $query->where('checkinsts', 'LIKE', 'N')
                    ->orWhere('checkoutsts', 'LIKE', 'N');
            })
            ->where('signemp', '=', $id)
            ->get();
        return $res;
    }
    function historyshowchecksign(){
        $res = DB::table('checkin_sign')
            ->where(function ($query) {
                $query->where('checkinsts', 'LIKE', 'Y')
                    ->orWhere('checkoutsts', 'LIKE', 'Y');
            })
            ->get();

        return $res;
    }
    function showleaveorder($id,$date){
        $res=  DB:: select("select * from leaveorder where empid=$id and left(leavestart,10)<='$date' and left(leaveend,10)>='$date'");
        return $res;
    }
    function leaveorderdatilday($day,$empid){//是否請假
        $res= DB:: select("select * from leaveorder where startdate>='$day' and enddate<= '$day' AND
        empid=$empid");

//
//            leaveorder::where('leavestart', '>=', $day)->where('leaveend', '<=', $day)->
//        where('empid', '=', $empid)->where('ordersts','<>','D')->get();
        return $res;
    }
    function sumworktime($day,$empid){
        //計算每日不足的數量
        $tempworkin=$day.' '.'09:05';
        $tempworkout=$day.' '.'18:00';
        $workin="";$workout="";
        $sql1=checkin::where('checkdate','like',$day)->where('empid','=',$empid)->value('checkin');
        $sql2=checkin::where('checkdate','like',$day)->where('empid','=',$empid)->value('checkout');
        $sql1=json_encode($sql1);
        $sql2=json_encode($sql2);
        $tempworkin=json_encode($tempworkin);
        $tempworkout=json_encode($tempworkout);
        if($sql1!=""&&$sql1!=null){
        if($sql1<=$tempworkin){$workin=$tempworkin;}
        elseif ($sql1>$tempworkin){$workin=$sql1;}
        }
        if($sql2!=""&&$sql2!=null){
        if($sql2>=$tempworkout){$workout=$tempworkout;}
        elseif ($sql2<$tempworkout){$workout=$sql2;}
        }

        $res=DB::select("select (TIMESTAMPDIFF(MINUTE,$workin, $workout))-535 as worktimes   FROM `checkin` where checkdate='$day' and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y')) and empid='$empid'" );

        return $res;
    }
    function showmontheveryday($month){
        $res=DB::select("select checkdate from checkin where yearmonths='$month' GROUP BY checkdate");
        return $res;
    }

    function showmonthlatesum($month,$empid){
        $res=DB::select("SELECT SUM(a.worktimes)as summonthlate FROM
(select (TIMESTAMPDIFF(MINUTE,min(checkin), max(checkout)))-535 as worktimes,checkdate    FROM `checkin` where yearmonths='$month' and ((checkinsts is null or checkinsts='Y')or(checkoutsts is null or checkoutsts='Y')) and empid='$empid' GROUP BY checkdate)as a where a.worktimes<0");
        return $res;
    }
    function isleave($day,$empid){
         $res=DB::select("select leavefakename from leaveorder where startdate='$day' or startdate='$day' and empid='$empid'");

         return $res;
    }
}
