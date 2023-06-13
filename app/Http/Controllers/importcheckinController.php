<?php

namespace App\Http\Controllers;

use App\Model\empinfo;
use App\Model\checkin;
use Illuminate\Http\Request;
use App\Services\MaterialService;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CheckinImport;
class importcheckinController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        $status="";
        $emplist=empinfo::where('jobsts', 'like', 'Y')->where('depareaid', 'like', 'T')->where('depid', '<>', 1)->get();
       return view('attendance.checkin',['status'=>$status]);
    }


    public function store(Request $request)
    {
        try{
            Excel::import(new CheckinImport,$request->file('file1'));
            $status = true;
            return view('attendance.checkin',['status'=>$status]);
        }
        catch (\Exception $e){
            dd($e);
        }
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
        //
    }
}
