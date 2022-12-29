<?php

namespace App\Imports;
use App\Model\partdata;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Session;

class partdataImport implements ToCollection
{

    //當你CONTROLLER 用套件去做編譯EXCEL的時候 他會回傳資料到這裡
    private $data ;
    public function collection(Collection $rows)
    {


        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        //然後在這邊把資料整理成你需要的格式

        unset($rows[0]);



        foreach ($rows as $k => $v) {
                //記住下面的格式 欄位名 => 你的資料
                //這樣的資料格式才能給orm去做動作

                $this->data[$k] = [

                    'partnumber' => $v[0],
                    'headname' => $v[1],
                    'fullname' => $v[2],
                    'vendorpn' => $v[3],
                    'description' => $v[4],
                    'usests' => $v[5],
                    'unit' => $v[6],
                    'valuationmethod' => $v[7],
                    'priceaccuracy' => $v[8],
                    'inventorycode' => $v[9],
                    'salesrevenuecode' => $v[10],
                    'costofsalescode' => $v[11],
                    'costdifferencecode' => $v[12],
                    'taxrate' => $v[13],
                    'costitem' => $v[14],
                    'reviewer' => $v[15],
                    'appendix' => $v[16],
                    'pic' => $v[17],
                    'creatdate' => $today,
                    'createmp' => Session::get("name"),
                    'updatedate' => $today
                ];

            partdata::insert($this->data[$k]);
        }

    }
}
