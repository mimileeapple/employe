<?php

namespace App\Http\Controllers;

use App\Model\log\partdata_log;
use App\Model\partdata;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\partdataImport;
use App\Services\MaterialService;
use Session;
use DB;
class PartDataController extends Controller
{
    private $MaterialService;
    public function __construct()
    {
        $this->MaterialService = new MaterialService();

    }
    public function index()
    {
        //
    }

    public function create()
    {
        $id=Session::get('partdataid');
        //dd($id);

        if($id!=""){
            $data= partdata::where('partnumber',$id)->get();
            Session::forget('partdataid');
        }
        else{
            $data= $this->MaterialService->partlist(10);
            $id="";
        }
         $partdatalist=partdata::all();
         $date=$this->MaterialService->takedate();
        if(count($data)>0){
            Session::put('partdatasts',true);

            return view("material.partdata",['partlist'=>$data,'partdatalist'=>$partdatalist,'pnoid'=>$id,'date'=>$date]);
        }
        else{
            Session::put('partdatasts',false);
            return view("material.partdata",['partlist'=>$data,'partdatalist'=>$partdatalist,'pnoid'=>$id,'date'=>$date]);
        }


    }


    public function store(Request $request)
    {
        $partdatasts=false;
        try{
            Excel::import(new partdataImport,$request->file('file1'));
            Session::put('partdatasts',true);

        }
        catch (\Exception $e){
            dd($e);
        }
        return redirect()->route('partdata.create');
    }


    public function show($id)
    {

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
        $data=partdata::all();
        foreach ($data as $key=>$val){
            $data[$key]['action']="delet";

            partdata_log::create($data[$key]->toArray());
        }

        DB::table('partdata')->truncate();
        Session::put('partdatasts',false);
        return redirect()->route('partdata.create');
    }
    public function showpartdata(Request $request){
        $id=$request->input('partnumberlist');

        $partdatalist=partdata::all();
        $data=partdata::where('partnumber',$id)->get();
        Session::put('partdataid',$id);
        return redirect()->route('partdata.create',['partlist'=>$data,'partdatalist'=>$partdatalist]);
    }
}
