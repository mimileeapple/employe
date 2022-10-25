<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\empinfo;
use Session;
class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('login');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function  logout(){
        Session::flush();
        return redirect()->action('loginController@index');
    }

    //Request $request 這個是前端from送來的資料
    public function verifya(Request $request){
        //這邊會把送來的資料把它陣列
//       $data = $request->input();
//       $a= empinfo::where('accout', $request->accout)->get();
//       dd($a);
        try {
            //first就是抓第一筆條件符合的資料
            //empinfo 這個是我剛剛做好的model
            $data =  empinfo::where('accout','=',$request->accout)->first();
//            $data =  DB::select('SELECT * FROM empinfo where accout = ?', array($request->accout));
//            $data =  DB::select('SELECT * FROM empinfo where accout = ? and qq =?', array($request->accout,3164874945)); 兩個以上
            //session的函數
            if(Session::has('empid')){
                return view('empindex');
            }

            if(!empty($data)){
                if($data->pwd==$request->pwd){
                    //在登入成功後 我把員工資料送到 empindex
                    Session::put('empid', $data->empid);
                    Session::put('name', $data->name);
                    return view('empindex');
                }
                else{
                return view('login',['error'=>'密碼錯誤,請重新輸入']);}
            }
            else {
                return view('login', ['error' => '帳號不存在']);
            }
        } catch (Exception $e) {
            return view('login',['error'=>'登入失敗，請洽資訊人員']);
        }




    }
}
