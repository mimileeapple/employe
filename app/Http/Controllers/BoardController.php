<?php

namespace App\Http\Controllers;

use App\Model\board;
use App\Services\empinforservices;
use App\Services\HumanResourceServices;
use App\Services\PayServices;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;
    private $PayServices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
        $this->PayServices = new PayServices();
    }
    public function index()
    {
        //
    }


    public function create()
    {//跳轉至公佈欄管理頁面
        $boardlist=$this->HumanResourceServices->board();
        return view('hrsys.boardmanage',['boardlist'=>$boardlist]);
    }


    public function store(Request $request)//新增公佈欄
    {

        $data=$request->input();
        $status = board::create($data);
        if($status != false){
            $status =true;
        }
        return view('hrsys.creatboard',['status'=>$status]);
    }


    public function show($id)
    {
        $boardlist=$this->HumanResourceServices->board();
        return view('hrsys.boardmanage',['boardlist'=>$boardlist]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)//更新公佈欄
    {
        $data=$request->input();
        $res = board::find($id)->update($data);
        $boardlist=$this->HumanResourceServices->board();
        return view('hrsys.boardmanage',['boardlist'=>$boardlist]);
    }


    public function destroy($id)
    {
        //
    }

    public function showboard(Request $request){//首頁連結內容
        $id = $request->input()['id'];
        $boardlist=$this->HumanResourceServices->showboard($id);
        return view('hrsys.board',['boardlist'=>$boardlist]);
    }
    Public function newboard(){//跳轉至新增頁面
        $status="";
        return view('hrsys.creatboard',['status'=>$status]);
    }
}
