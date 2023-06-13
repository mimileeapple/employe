<?php

namespace App\Imports;

use App\Model\checkin;
use App\Model\empinfo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Session;
class CheckinImport implements ToCollection
{

    private $data ;

    public function collection(Collection $rows)
    {  date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        unset($rows[0]);
        $ename=$rows[1][0];
        $yearmonths=$rows[1][1];
        //dd($yearmonths);
        $empid= empinfo::where('ename','like',$ename)->value('empid');
        $empname= empinfo::where('ename','like',$ename)->value('name');
        foreach ($rows as $k => $v) {
            //記住下面的格式 欄位名 => 你的資料
            //這樣的資料格式才能給orm去做動作
            if($v[2]!=""){
            $date = date('Y-m-d', ($v[2] - 25569) * 24 * 3600);
            $this->data[$k] = [
                'empid'=>$empid,
                'empname'=>$empname,
                'yearmonths'=>$yearmonths,
                'checkdate'=>$date,

                'worktimein'=>$v[3],
                'worktimeout'=>$v[4],
                'creatdate'=>$today,
                'updatedate'=>$today,
                'createemp'=>Session::get('name'),
                'updateemp'=>Session::get('name'),
                'insertsts'=>"Y"
            ];

            if($v[3]!=""){
                $this->data[$k] = [
                    'empid'=>$empid,
                    'empname'=>$empname,
                    'yearmonths'=>$yearmonths,
                    'checkdate'=>$date,
                    'checkin'=>$date." ".$v[3],
                    'checkout'=>$date." ".$v[4],
                    'worktimein'=>$v[3],
                    'worktimeout'=>$v[4],
                    'creatdate'=>$today,
                    'updatedate'=>$today,
                    'createemp'=>Session::get('name'),
                    'updateemp'=>Session::get('name'),
                    'insertsts'=>"Y"

                   ]; }
            checkin::create($this->data[$k]);}
        }

    }


}
