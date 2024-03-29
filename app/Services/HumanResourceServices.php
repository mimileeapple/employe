<?php

namespace App\Services;

use App\Model\empinfo;
use App\Model\leaveorder;
use App\Model\isholiday;
use App\Model\board;
use Mail;
use DB;

class HumanResourceServices
{
    private $title;
    private $tomail;
    private $towho;
    private $content;

    function emp_list($page)
    {//分頁
        return empinfo::where('jobsts','like','Y')->where('depareaid','like','T')->paginate($page);
    }

    function select_emp()
    {//抓全部
        return empinfo::where('jobsts','like','Y')->where('depareaid','like','T')->where('depid','<>',1)->get();
    }

    function selectemp($id)
    {//抓個人單筆資料 沒數組 a->name
        return empinfo::where('empid', '=', $id)->first();
    }

    function selectempary($id)
    {//抓回會是單筆資料例如 A[1]->name
        return empinfo::where('empid', '=', $id)->get();
    }

    function selectmyleave($id,$page)
    {//抓自己全部請假資料

        return leaveorder::where('empid', '=', $id)->where('ordersts', '<>','D')->orderBy('orderdate', 'DESC')->paginate($page);
    }

    function selectmyleaveall()
    {//抓全部請假資料
        return leaveorder::all();
    }

    function isholiday($datestart, $dateend)
    {//判斷是否為節日予補班日
        $datestart = date("Y-m-d", strtotime($datestart));
        $dateend = date("Y-m-d", strtotime($dateend));
        //抓期間中狀態為2的資料
        $holidaynum = isholiday::whereBetween('date', [$datestart, $dateend])->where('isholiday', '=', '2')->whereNotIn('week', ["六","日"])->get();//節日
//->whereNotIn('week', ["六","日"])
        $workday=isholiday::whereBetween('date', [$datestart, $dateend])->where('isholiday', '=', '0')->get();//上班日

        $makeworknum = isholiday::whereBetween('date', [$datestart, $dateend])->where('isholiday', '=', '3')->get();//補班日

        $workday=count($workday);
        $holiday = count($holidaynum);
        $makework = count($makeworknum);
        return array('holiday' => $holiday, 'makework' => $makework,'workday' => $workday);
    }
    function workinfo($date){
        $workinfo=isholiday::where('date',$date)->value('isholiday');
        return  array('workinfo'=>$workinfo);
    }

    function send_mail($title, $tomail, $towho, $content)
    {//寄信

        $this->title = $title;
        //你再用send_mail這個函數前 要直接船這個tomail=$tomail[0]->mail 等到這個函數開始執行的時候 就都是字串了
        $this->tomail = $tomail;//<-----陣列裡面包物件
        $this->towho = $towho;
        $this->content = $content;
        Mail::raw($this->content, function ($message) {
            $message->from("hello@example.com", 'system');
            $message->to($this->tomail, $this->towho)->subject($this->title);
        });
    }

    function bosssign1($id)
    {//跑到主管1
        //
        return leaveorder::where('signsts', '=', '0')->where('manage1id', '=', $id)->where('manage1empsign', 'N')->where('ordersts', '<>','D')->get();
    }

    function bosssign2($id)
    {//跑到主管2
        //
        return leaveorder::where('signsts', '=', '1')->where('manage2id', '=', $id)->where('manage2empsign', 'N')->where('ordersts', '<>','D')->get();
    }

    function bosssignall($id)
    {//1.2接都看到自己ㄉ簽核
        //$ID 舊友欄位阿
//        return leaveorder::where(function ($query) use ($id) {
//            $query->where('manage1id', '=',$id)
//                ->orWhere('manage2id', '=', $id);
//        })->where(function ($query) {
//            $query->where('manage1empsign', '=', 'N')
//                ->orWhere('manage2empsign', '=', 'N'))}->get();

        return DB::select("SELECT * FROM `leaveorder` where ordersts<>'D'  and (signsts in(0,1) and (manage1id=$id
and manage1empsign='N') or (manage2id=$id and manage2empsign='N' and manage1empsign='Y'))");
    }
    /*leaveorder::whereIn('signsts', array('0', '1'))->where('manage1id','=',$id)->orWhere('manage2id','=',$id)->
    where('manage1empsign','=','N')->orWhere('manage2empsign','=','N')->get();*/
    /*DB::select("SELECT * FROM `leaveorder` where signsts in(0,1) and (manage1id=$id
or manage2id=$id) and manage1empsign='N' and manage2empsign='N'");*/


    function sreachdate($sreachdateorder, $id,$page)
    {//以月分搜尋某人請價單
        $enddate = date('Y-m-t', strtotime($sreachdateorder));

        return leaveorder::where('empid', '=', $id)->where('ordersts', '<>','D')->whereBetween('startdate', [$sreachdateorder, $enddate])->paginate($page);;
    }

    function finshsign($page)
    {//搜尋需要結案的單子
        //
        return leaveorder::where('signsts', '=', '2')->where('ordersts', '<>','D')->where('area','like','T')->paginate($page);
    }

    function board()
    {
        return board::where('launch', '=', 'Y')->orderby('boarddate','desc')->get();
    }

    function showboard($id)
    {
        return board::where('id', '=', $id)->get();
    }

}

