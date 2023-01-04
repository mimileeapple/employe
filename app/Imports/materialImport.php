<?php

namespace App\Imports;
use App\Model\d_material;
use App\Model\product;
use App\Model\product_head;//抬頭的兩個
use App\Model\partdata;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
class materialImport implements ToCollection
{

    //當你CONTROLLER 用套件去做編譯EXCEL的時候 他會回傳資料到這裡
    private $data ;
    public function collection(Collection $rows)
    {
        $g="";
        $gcode=explode(':',$rows[1][4]);//分割了
        foreach ($gcode as $i=>$v){
            if($i == 1){
                $g =trim($v);
                break;
            }
        }
         $r =$rows[0][0];
        $gcodename= substr($rows[0][0],0,11);
        product_head::create([
                    'g_codename' => $r,
                    'g_code' =>$g,
                    ]);
        //-----------------------------------------//
        product::create([
                'bomcode'=>"",
                'b_code'=> $g,
                'b_materialname'=>$gcodename,
                'b_space'=>$rows[0][0],
                'b_unit'=>'PCS',
                'b_num'=>'1',
                'finished'=>'100',
                'version'=>'',
                'usests'=>'使用',
                'usetype'=>'0',
                'craft'=>'',
                'reviewsts'=>'审核',
                'remark'=>'',
                'isconfigsource'=>'否',
                'layerjump'=>'否'
            ]) ;
        //-------------------------------------//

        foreach ($rows as $row =>$v)
        {
            $title='';
            if(is_int($v[0])){
                //記住下面的格式 欄位名 => 你的資料
                //這樣的資料格式才能給orm去做動作
                if($v[1]=='PCBA'){
                    $title='PCBA';
                }
                else if($v[1]=='Manual'||$v[1]=='Packing'||$v[1]=='Label'){
                    $title='Packing';
                }
                else{
                    $title='Assy';
                }
                $pno=trim($v[3]);
                $headname=partdata::where('partnumber','like',$pno)->value('headname');
                if($headname==""){
                    $headname="";
                }
                $description=partdata::where('partnumber','like',$pno)->value('description');
                if($description==""){
                    $description="";
                }
                $num=(string)$v[6];

                $this->data[] = [

                    'partnumber' => $pno,
                    'materialname'=>$headname,
                    'description' =>$description,
                    'num'=>$num,
                    'location'=>$v[7],
                    'unit'=>"PCS",
                    'lossrate'=>"0",
                    'bad_materialsize'=>'',
                    'bad_num'=>'',
                    'station'=>$title,
                    'serialnum'=>'',
                    'serial'=>'',
                    'backflush'=>'否',
                    'setattribute'=>'通用',
                    'bias'=>'0',
                    'planpercent'=>'100',
                    'takeeffectdate'=>'1900-01-01',
                    'losedate'=>'2100-01-01',
                    'depot_position'=>'*',
                    'depot'=>'',
                    'subtype'=>'普通件',
                    'remark'=>'',
                    'remark1'=>'',
                    'remark2'=>'',
                    'remark3'=>'',
                    'isfeature'=>'否'
                ];

            }
        }
        d_material::insert($this->data);


//        DB::transaction(function () {
//
//        });
        //transaction 他這個是裡面包了一個Function 如果在裡面 你有一百個不同的DB新增資料
        //例如 如果再d的時候新增失敗 那在他之前的abc 會全部取消 如果沒用這個方式  會變成 abc新增好了
        //因為資料帶不進去  所以你要再另外寫一個$this給他用
//        d_material::transaction(function () {
//            a::insert($data);
//            b::insert($data);
//            c::insert($data);
//            d::insert($data);
//        });

        //transaction 他這個是裡面包了一個Function 如果在裡面 你有一百個不同的DB新增資料
        //例如 如果再d的時候新增失敗 那在他之前的abc 會全部取消 如果沒用這個方式  會變成 abc新增好了
        //因為資料帶不進去  所以你要再另外寫一個$this給他用
//        d_material::transaction(function () {
//            a::insert($data);
//            b::insert($data);
//            c::insert($data);
//            d::insert($data);
//        });




    }
}
