<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\empinfo;
use Session;
use DB;
class HumanResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emp_list1 = empinfo::all();
//        dd($emp_list1);
//        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());
//        dd($emp_list1);
        //你剛剛用$emp_list[0] 他只會叫第0筆資料
        //這是分頁器 一頁顯示七筆
        $emp_list = empinfo::paginate(5);
//     $emp_list = DB::table('empinfo')->paginate(5);

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
//        $maxid=DB::select('SELECT max(empid) FROM empinfo');
//        $maxid=$maxid+1;
        $emp_list1 = empinfo::all();
//        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());
        return view('hrsys.newemp',['status'=>$status],['emp_list1'=>$emp_list1]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sdepname='';
        $ddepid=$request->dep;
        if($ddepid=="1"){$sdepname='管理部';}
        if($ddepid=="2"){$sdepname='產品研發部';}
        if($ddepid=="3"){$sdepname='產品工程部';}
        if($ddepid=="4"){$sdepname='PM業務部';}
        if($ddepid=="5"){$sdepname='資材部';}
        if($ddepid=="6"){$sdepname='財務部';}
        if($ddepid=="7"){$sdepname='資訊部';}

        $sdepareaid="";
        $sdepareaname=$request->deparea;
        if($sdepareaname=='T'){$sdepareaid="台北";}
        if($sdepareaname=='S'){$sdepareaid="深圳";}
        if($sdepareaname=='D'){$sdepareaid="東莞";}
        $emp_list1 = empinfo::all();
//        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());
        $data = array('dep'=>$sdepname,'depareaid'=>$sdepareaid);
        $data =array_merge($data ,array_except($request->input(),'_token'));
        $status = empinfo::create($data);
        if($status != false){
            $status =true;
        }
//        $status =  DB::insert('insert into empinfo (
//                     pwd,qq,name,ename,identity,
//                     sex,birth,marry,title,grade,
//                     emprank,achievedate,depid,dep,depareaid,deparea,
//                     mail,cellphone,phone,adress,edu,
//                     syslimit,agentemp,jobsts,creatdate,createmp,
//                     updatedate,updateemp)
//        values (?,?,?,?,?,
//                ?,?,?,?,?,
//                ?,?,?,?,?,?,
//                ?,?,?,?,?,
//                ?,?,?,?,?,
//                ?,?)',
//            [$request->pwd,$request->qq,$request->name,$request->ename,$request->identity,
//                $request->sex,$request->birth,$request->marry,$request->title,$request->grade,
//                $request->emprank,$request->achievedate,$ddepid,$sdepname,$sdepareaid,$request->deparea,
//                $request->mail, $request->cellphone,$request->phone,$request->adress,$request->edu,
//                $request->syslimit,$request->agentemp,$request->jobsts,$request->creatdate,$request->createmp,
//                $request->updatedate,$request->updateemp]);

        return view('hrsys.newemp',['status'=>$status],['emp_list1'=>$emp_list1]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());
        $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
        return view('hrsys.employees',['emp_list'=>$data,'emp_list1'=>$emp_list1]);


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
        $emp_list = empinfo::all();
//        $emp_list =  DB::select('SELECT * FROM empinfo ', array());
        $data = empinfo::where('empid','=',$id)->first();
//        $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));

        $status ='';
        return view('hrsys.hrupdateemp',['data'=>$data,'emp_list'=>$emp_list,'status'=>$status]);


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


        $sdepid='';
        $ddep=$request->dep;
        if($ddep=="管理部"){$sdepid='1';}
        if($ddep=="產品研發部"){$sdepid='2';}
        if($ddep=="產品工程部"){$sdepid='3';}
        if($ddep=="PM業務部"){$sdepid='4';}
        if($ddep=="資材部"){$sdepid='5';}
        if($ddep=="財務部"){$sdepid='6';}
        if($ddep=="資訊部"){$sdepid='7';}

        try {
//            $data = array('dep'=>$sdepname,'depareaid'=>$sdepareaid);
//            $data =array_merge($data ,array_except($request->input(),'_token'));
//            $status = empinfo::create($data);
//            if($status != false){
//                $status =true;
//            }

            $res = DB::update('update empinfo set
            pwd = ?,name = ?,ename = ?,identity = ?,sex = ?,
            birth = ?,marry = ?,title = ?,grade = ?,emprank = ?,
            achievedate = ?,depid = ?,dep = ?,deparea = ?,mail = ?,
            cellphone = ?,phone = ?,adress = ?,edu = ?,syslimit = ?,
            agentemp = ?,jobsts = ?,creatdate = ?,createmp = ?,updatedate = ?,
            updateemp = ? where empid =?',
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
                    $sdepid,
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
                    $request->updateemp,$id
                ]);
            //職務代理人
            $emp_list =  DB::select('SELECT * FROM empinfo ', array());
            //錯誤時返回的員工資料
            $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
            if($res){
                //更新成功
            // Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['data'=>$data[0],'emp_list'=>$emp_list,'status'=>true]);
            }else{
                //更新失敗
           // Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['data'=>$data[0],'emp_list'=>$emp_list,'status'=>false]);
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
    public function search_empid(Request $request)
    {
        $id = $request->empid;
        $emp_list1 = empinfo::all();
//        $emp_list1 =  DB::select('SELECT * FROM empinfo ', array());
        $data = empinfo::where('empid','=',$id)->get();
//        $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));

        return view('hrsys.employees',['emp_list'=>$data,'emp_list1'=>$emp_list1]);


    }
}
