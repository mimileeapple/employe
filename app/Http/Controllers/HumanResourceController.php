<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use Session;
class HumanResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());

        //你剛剛用$emp_list[0] 他只會叫第0筆資料
        //這是分頁器 一頁顯示七筆
//        $emp_list = $emp_list->paginate(5);
     $emp_list = DB::table('empinfo')->paginate(7);

//        $data =  DB::select('SELECT * FROM empinfo ', array());
        //因為你的頁面 是放在 views/hrsys下面
        return view('hrsys.employees', ['emp_list' => $emp_list,'emp_list1' => $emp_list1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $status='';
//       $data =  DB::select('SELECT * FROM empinfo where accout = ?', array($request->accout));


          /*$sql = DB::table('users')->insertGetId(
              ['email' => 'john@example.com', 'votes' => 0]
          );
      }
          */
        return view('hrsys.newemp',['status'=>$status]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $status =  DB::insert('insert into empinfo (
        pwd,name,ename,identity,sex,birth,marry,title,grade,emprank,achievedate,dep,deparea,mail,cellphone,phone,adress,edu,syslimit,agentemp,jobsts,creatdate,createmp,updatedate,updateemp)values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',[$request->pwd,$request->name,$request->ename,$request->identity,$request->sex,$request->birth,$request->marry,$request->title,$request->grade,$request->emprank,$request->achievedate,$request->dep,$request->deparea,$request->mail,$request->cellphone,$request->phone,$request->adress,$request->edu,$request->syslimit,$request->agentemp,$request->jobsts,$request->creatdate,$request->createmp,$request->updatedate,$request->updateemp]);

        return view('hrsys.newemp',['status'=>$status]);

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
        $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
        Session::put('empid', $data[0]->empid);
        $status ='';
        return view('hrsys.hrupdateemp',['data'=>$data[0],'emp_list'=>$emp_list,'status'=>$status]);


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
        $emp_list =  DB::select('SELECT * FROM empinfo ', array());
        $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
        Session::put('empid', $data[0]->empid);
        $status ='';
        return view('hrsys.hrupdateemp',['data'=>$data[0],'emp_list'=>$emp_list,'status'=>$status]);


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
        try {
            $res = DB::update('update empinfo set
            pwd = ?,name = ?,ename = ?,identity = ?,sex = ?,
            birth = ?,marry = ?,title = ?,grade = ?,emprank = ?,
            achievedate = ?,dep = ?,deparea = ?,mail = ?,cellphone = ?,
            phone = ?,adress = ?,edu = ?,syslimit = ?,agentemp = ?,
            jobsts = ?,creatdate = ?,createmp = ?,updatedate = ?,updateemp = ? where empid =?',
                [
                    $request->pwd,
                    $request->name,
                    $request->ename,
                    $request->identity,
                    $request->sex,
                    $request->birth,
                    $request->marry,
                    $request->title,
                    $request->grade,
                    $request->emprank,
                    $request->achievedate,
                    $request->dep,
                    $request->deparea,
                    $request->mail,
                    $request->cellphone,
                    $request->phone,
                    $request->adress,
                    $request->edu,
                    $request->syslimit,
                    $request->agentemp,
                    $request->jobsts,
                    $request->creatdate,
                    $request->createmp,
                    $request->updatedate,
                    $request->updateemp,$request->empid
                ]);
            $emp_list =  DB::select('SELECT * FROM empinfo ', array());
            $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($request->empid));

            if($res){
                //更新成功
                Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['error' => '更新成功','data'=>$data[0],'emp_list'=>$emp_list,'status'=>true]);
            }else{
                //更新失敗
                Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['error' => '更新失敗','data'=>$data[0],'emp_list'=>$emp_list,'status'=>false]);
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
