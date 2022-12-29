<?php

namespace App\Services;

use App\Http\Controllers\leavefakeController;
use App\Model\empinfo;
use App\Model\leaveorder;
use App\Model\isholiday;
use App\Model\jobyears;
use App\Model\emp_vacation;
use App\Model\tripsign;
use App\Model\tripdata;
use App\Model\trippay;
use App\Model\triptotal;
use Mail;
use DB;
use Session;
use Carbon\Carbon;

class PayServices
{
    function findmytrip($id,$page)
    {//找請假單的
        return leaveorder::where('leavefakeid', 3)->where('empid', $id)->paginate($page);
    }

    function findtripdata($orderid)
    {//用單號取出差資料
        return tripdata::where('orderid', '=', $orderid)->get();

    }

    function findtrippay($orderid)
    {//用單號取出差費用
        return trippay::where('orderid', '=', $orderid)->get();

    }

    function findtripsign($orderid)
    {//用單號取出差費用
        return tripsign::where('orderid', '=', $orderid)->get();

    }

    function findordersts($orderid)
    {
        return tripsign::where('orderid', '=', $orderid)->get();

    }

    function search_trip_month($month,$page)
    {
        $months = date($month);
        $res=leaveorder::where('leavefakeid', 3)->where('empid', Session::get('empid'))
            ->where('months', $months)->paginate($page);

        return $res;

    }

    function tripsign($id)
    {

        return DB::select("SELECT * FROM `tripsign` where ordersts<>'D' and (signsts in(0,1,2,3) and (supervisorid=$id
               and supervisorsign='N') or ( managerid=$id and managersign='N' and supervisorsign='Y') or (financeid=$id and
               financesign='N' and supervisorsign='Y' and  managersign='Y'))");
    }

    function tripdataall()
    {
        return tripdata::all();
    }

    function trippayall()
    {
        return trippay::all();
    }

    function tripdatatitle($orderid)
    {
        return tripdata::where('orderid', '=', $orderid)->value('title');
    }

    function tripdataleavestart($orderid)
    {
        return tripdata::where('orderid', '=', $orderid)->value('leavestart');
    }

    function tripdataleaveend($orderid)
    {
        return tripdata::where('orderid', '=', $orderid)->value('leaveend');
    }

    function triptotal($orderid)
    {
        return triptotal::where('orderid', '=', $orderid)->get();
    }

    function historytrippay()
    {
        return tripsign::where('signsts', '=', 3)->get();
    }

}
