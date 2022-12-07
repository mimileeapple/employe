<?php


namespace App\Http\Controllers;
use App\Services\HumanResourceServices;
use App\Services\empinforservices;
use App\Model\PayController;
use App\Services\PayServices;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Model\empinfo;
use App\Model\leaveorder;
use App\Model\isholiday;
use App\Model\jobyears;
use App\Model\tripsign;
use App\Model\board;
use Session;
use DB;

class loginController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;
    private $PayServices;
    public function __construct()
    {
        $this->HumanResourceServices =new HumanResourceServices();
        $this->empinforservices =new empinforservices();
        $this->PayServices=new PayServices();
    }
    public function index()
    {
        //跳轉公佈欄
        $boardlist=$this->HumanResourceServices->board();
       return view('login',['boardlist'=>$boardlist]);
    }


    public function create()
    {


    }


    public function store(Request $request)
    {

    }


    public function show($id)//秀出所有"Y"的公告管理頁面
    {


    }

    public function edit($id)
    {



    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {
        //
    }
    public function  logout(){
        Session::flush();
        return redirect()->action('loginController@index');
    }


    public function verifya(Request $request){

        try {
            //first就是抓第一筆條件符合的資料
            //empinfo 這個是我剛剛做好的model
            $data =  empinfo::where('accout','=',$request->accout)->first();

            //session的函數
            if(Session::has('empid')){
                $boardlist=$this->HumanResourceServices->board();
                return view('empindex',['boardlist'=>$boardlist]);
            }

            if(!empty($data)){
                if($data->pwd==$request->pwd){
                    //在登入成功後 我把員工資料送到 empindex
                    Session::put('empid', $data->empid);
                    Session::put('name', $data->name);
                    Session::put('empdata', $data);
                    $data=$this->HumanResourceServices->bosssignall(Session::get('empid'));
                    //因為你勾選 他要處理一堆資料 最後在一開始就處理好 會方便很多

                    Session::put('j',count($data));
                    $paydata=$this->PayServices->tripsign(Session::get('empid'));
                    Session::put('pay',count($paydata));
                    $boardlist=$this->HumanResourceServices->board();

                    return view('empindex',['boardlist'=>$boardlist]);
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
