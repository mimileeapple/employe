<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
class personalinforController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('updateemp',['data'=>]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    //這邊會把傳來的工號拿去搜尋員工的資料
        $emp_list =  DB::select('SELECT * FROM empinfo ', array());
     $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
        Session::put('empid', $data[0]->empid);
     return view('updateemp',['data'=>$data[0],'emp_list'=>$emp_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try {
            $res = DB::update('update empinfo set pwd = ? ,
                cellphone = ?,
                phone = ?,
                adress = ?,
                edu = ?,
                agentemp = ? where empid = ?',
                [
                    $request->pwd,
                    $request->cellphone,
                    $request->phone,
                    $request->adress,
                    $request->edu,
                    $request->agentemp,
                    $id
                ]);
            $emp_list =  DB::select('SELECT * FROM empinfo ', array());
            $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
            if($res){
                //更新成功
                Session::put('empid', $data[0]->empid);
                return view('updateemp', ['error' => '更新成功','data'=>$data[0],'emp_list'=>$emp_list]);
            }else{
                //更新失敗
                Session::put('empid', $data[0]->empid);
                return view('updateemp', ['error' => '更新失敗','data'=>$data[0],'emp_list'=>$emp_list]);
            }
        }catch (Exception $e){
            //錯誤
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
