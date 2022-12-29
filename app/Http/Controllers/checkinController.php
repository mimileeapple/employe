<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use App\Services\CheckinServices;
use App\Services\HumanResourceServices;
use Illuminate\Http\Request;
use App\Model\checkin;
use App\Model\log\checkin_log;
use Session;
class checkinController extends Controller
{
    private $HumanResourceServices;
    private $CheckinServices;
    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->CheckinServices=new CheckinServices();

    }
    public function index()
    {
        $status='';
        return view('attendance.checkin',['status'=>$status]);
    }


    public function create()
    {
        //跳轉至upcheckin補卡頁面
        $status='';
        return view('attendance.upcheckin',['status'=>$status]);
    }


    public function store(Request $request)
    {
        //儲存上下班打卡資訊
        try {
            foreach ($request->input()['data'] as $i=>$v){
                $data[$v['name']] =$v['value'];
            }
/*unset($data['_token']);
     $res=checkin::where('empid','=',$data['empid'])->
     where('checkdate','=',$data['checkdate'])->
     where('btnactionid','=',$data['btnactionid'])->update($data);*/
            $res=checkin::create($data);
            return response()->json(['status' => 'true']);
        }
        catch (\Exception $e) {

            return response()->json(['status' => 'false']);
        }

    }


    public function show($id)
    {//秀出所有自己的出勤
        $checklist=$this->CheckinServices->showcheck($id);

        return view("attendance.persolwork",['checklist'=>$checklist]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {//補卡

        try {
            $data=$request->input();

            $res=checkin::create($data);
            $checklist=$this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡成功'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin",['checklist'=>$checklist]);
        }
        catch (\Exception $e) {
            $checklist=$this->CheckinServices->showcheck($id);
            echo " <script>alert('補卡失敗'); self.opener.location.reload();window.close(); </script>";
            return view("attendance.upcheckin",['checklist'=>$checklist]);
        }
    }


    public function destroy(Request  $id)
    {
        $id = $id->input('id');
        //dd($id);
        checkin::where('id', $id)->update(['sign'=>'D']);

        $checkdata= checkin::where('id', $id)->get();
        $checkdata[0]->action='delete';
        checkin_log::create($checkdata->toArray()[0]);
        checkin::where('id', $id)->delete();//
        $checklist=$this->CheckinServices->showchecksign(session::get('empid'));
        Session::put('check', count($checklist));//設定簽核數量
        return view("sign.checkinsign",['checklist'=>$checklist]);
    }
    public function search_checkin(Request $request){//查詢自己的月份出勤表
       $empid= $request->input('empid');
       $months=$request->input('months');
        $checklist=$this->CheckinServices->showmonthcheckin($months,$empid);

        return view("attendance.persolwork",['checklist'=>$checklist,'months'=>$months]);
    }
    public function showchecksign(Request $request){//秀出簽核頁面
        $id=$request->input(' id');
        $checklist=$this->CheckinServices->showchecksign(session::get('empid'));

        Session::put('check', count($checklist));//設定簽核數量
        return view("sign.checkinsign",['checklist'=>$checklist]);
    }
    public function signcheckin(Request $request){//簽核
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');
        //從陣列中刪除Checkbox _token PS;如果懶得做白名單或者怕model發生衝突 用這種方式最保險
        $data=array_except($request->input(),['_token','Checkbox']);
        //用in一次修改多個不同ID的資料
        checkin::whereIn('id',$request->Checkbox)->update($data);

        $id=session::get('empid');
        $checklist=$this->CheckinServices->showchecksign($id);
        Session::put('check', count($checklist));//重新整理簽核數量
        return view("sign.checkinsign",['checklist'=>$checklist]);
    }
    public function showallemplist(Request $request){//秀出所有員工出勤表頁面
        $empid= $request->input('empid');
        $months=$request->input('months');
        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
        return view("attendance.showallemplist",['emp_list1'=>$emp_list1,'empid'=>$empid,'months'=>$months]);

    }
    public function search_checkemp(Request $request){//查詢所有員工每月出勤表
        $emp_list1 = $this->HumanResourceServices->select_emp();//所有的員工表
        $empid= $request->input('empid');
        $months=$request->input('months');
        //dd($request->input());
        $checklist=$this->CheckinServices->showmonthcheckin($months,$empid);
        return view("attendance.showallemplist",['emp_list1'=>$emp_list1,'checklist'=>$checklist,'empid'=>$empid,'months'=>$months]);
    }
    public function historysign(Request $request){
        $checklist=$this->CheckinServices-> historyshowchecksign();
        return view("sign.history_checkinsign",['checklist'=>$checklist]);
    }
}

