<?php

namespace App\Http\Controllers;

use App\Model\board;
use App\Services\empinforservices;
use App\Services\HumanResourceServices;
use App\Services\PayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
   public function showpic(Request $request){

   /*    if (isset($request->uploadfile)) {
           //檔名
           $image = $request->file('uploadfile');
           $filename = $image->getClientOriginalName();
           //套用哪個模組 模組位置 config/filesystems.php -> disks
//        Storage::disk('設定好的模組')->put('檔名','要上船的檔案'); 上傳成功會回傳true 失敗false

           $uploadPic = Storage::disk('Leave')->put($filename, file_get_contents($image->getRealPath()));

           //取得存好檔案的URL
           $photoURL = Storage::disk('Leave')->url($filename);


           $data = array('uploadfile' => $photoURL);
           $data = array_merge(array_except($request->input(), '_token'), $data);
       } else {
           $data = array_except($request->input(), '_token');
       }
*/

   }

}
