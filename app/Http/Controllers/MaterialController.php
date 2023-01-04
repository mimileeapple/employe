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
        $issetxls=product_head::all()->count();
        return view("material.Excelmaterial",['issetxls'=>$issetxls]);
    }

    public function store(Request $request)
    {
        $sts=false;
//        Excel::import(new materialImport, $request->file('file1'));
        //把EXCEL轉換成ARRAY
//        $array = Excel::toArray(new materialImport,  $request->file('file1'));
        try{
        Excel::import(new materialImport,$request->file('file1'));
            $issetxls=product_head::all()->count();
        }
        catch (\Exception $e){
            dd($e);
        }
        //因為你的這張表格 A欄的正是資料第一筆都是INT 所以我們用它來判斷 如果是int就留著 不是就刪除
        //這是會影響效能的  如果是很多筆資料會很慢 要跟USER溝通

        return redirect()->route('material.create',['issetxls'=>$issetxls]);

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
        $issetxls=product_head::all()->count();
        return redirect()->route('material.create',['issetxls'=>$issetxls]);
    }
    public function materialExport(Request $request){
        date_default_timezone_set('Asia/Taipei');
        $today = date("Ymd");
        $filename='BOM_'.$today;
        $filename=$filename.".xlsx";
        return Excel::download(new materialExport,$filename);

    }
}
