<?php

namespace App\Http\Controllers;
use App\Imports\materialImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\materialExport;
use Session;
use App\Model\product_head;
use App\Model\product;
use App\Model\d_material;
use DB;
class MaterialController extends Controller
{
   //物料管理
    public function index()
    {
        //
    }

    public function create()
    {

        return view("material.Excelmaterial");
    }

    public function store(Request $request)
    {
        $sts=false;
//        Excel::import(new materialImport, $request->file('file1'));
        //把EXCEL轉換成ARRAY
//        $array = Excel::toArray(new materialImport,  $request->file('file1'));
        try{
        Excel::import(new materialImport,$request->file('file1'));
        Session::put('sts',true);
        }
        catch (\Exception $e){
            dd($e);
        }
        //因為你的這張表格 A欄的正是資料第一筆都是INT 所以我們用它來判斷 如果是int就留著 不是就刪除
        //這是會影響效能的  如果是很多筆資料會很慢 要跟USER溝通
//        foreach ($array[0] as $i=>$v){
//            if(!is_int($v[0])){
//                unset($array[0][$i]);
//            }
//        }
//        dd($array[0]);
//$collection = Excel::toCollection(new materialImport,  $request->file('file1'));
        return redirect()->route('material.create');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {


        DB::table('d_material')->truncate();
            //::query()->delete();
        DB::table('product')->truncate();
        DB::table('product_head')->truncate();
        Session::put('sts',false);
        return redirect()->route('material.create');
    }
    public function materialExport(Request $request){
        date_default_timezone_set('Asia/Taipei');
        $today = date("Ymd");
        $filename='BOM_'.$today;
        $filename=$filename.".xlsx";
        return Excel::download(new materialExport,$filename);

    }
}
