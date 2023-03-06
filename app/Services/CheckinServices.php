<?php

namespace App\Services;
use App\Model\checkin;
use App\Model\leaveorder;
use DB;
use Session;
class CheckinServices
{
    function showcheck($empid){//上班

     $res=DB::select("SELECT empid,checkdate,min(worktimein)as checkintime,max(worktime)as checkouttime,sign,signemp,btnactionid,btnactionin,btnactionout  FROM `checkin` WHERE empid=$empid and (sign is null or sign='Y')  GROUP BY empid,checkdate ORDER BY checkdate asc");
//dd($res);
    return $res;
    }

    function showmonthcheckin($months,$empid){
     $res=DB::select("SELECT empid,checkdate,min(worktimein)as checkintime,max(worktime)as checkouttime,sign,signemp,btnactionid,btnactionin,btnactionout  FROM `checkin` WHERE empid=$empid and (sign is null or sign='Y')  and yearmonths='$months'  GROUP BY empid,checkdate ORDER BY checkdate asc");

      return $res;
    }
    function showchecksign($id){
        $res=checkin::where('sign','N')->where('signemp',$id)->get();
        return $res;}
    function historyshowchecksign(){
        $res=checkin::where('sign','Y')->get();
        return $res;}
    function showleaveorder($id,$date){
        $res=  DB:: select("select * from leaveorder where empid=$id and left(leavestart,10)<='$date' and left(leaveend,10)>='$date'");
        return $res;
    }
    function leaveorderdatilday($day,$empid){
        $res= DB:: select("select * from leaveorder where left(leavestart,10)>='$day' and left(leaveend,10)<= '$day' AND
        empid=$empid");

//
//            leaveorder::where('leavestart', '>=', $day)->where('leaveend', '<=', $day)->
//        where('empid', '=', $empid)->where('ordersts','<>','D')->get();
        return $res;
    }
}
