<?php

namespace App\Http\Controllers;

use App\Services\HumanResourceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Model\empinfo;
use Illuminate\Support\Facades\Storage;
use Session;
use DB;
use  App\Services\empinforservices;

class HumanResourceController extends Controller
{
    private $HumanResourceServices;
    private $empinforservices;

    public function __construct()
    {
        $this->HumanResourceServices = new HumanResourceServices();
        $this->empinforservices = new empinforservices();
    }

    public function index()
    {
        $emp_list = $this->HumanResourceServices->emp_list(10);
        $emp_list1 = $this->HumanResourceServices->select_emp();
        return view('hrsys.employees', ['emp_list' => $emp_list, 'emp_list1' => $emp_list1]);
    }


    public function create(Request $request)//
    {
        $status = '';
        $emp_list1 = $this->HumanResourceServices->select_emp();

        return view('hrsys.newemp', ['status' => $status], ['emp_list1' => $emp_list1]);
    }

    public function store(Request $request)//新增員工
    {
        $sdepid = '';
        $depareaid="";
        $ddep = $request->dep;
        $depareaid=$request->input('depareaid');
        $deparea="";
        if ($ddep == "管理部") {
            $sdepid = '1';
        }
        if ($ddep == "產品研發部") {
            $sdepid = '2';
        }
        if ($ddep == "產品工程部") {
            $sdepid = '3';
        }
        if ($ddep == "PM業務部") {
            $sdepid = '4';
        }
        if ($ddep == "資材部") {
            $sdepid = '5';
        }
        if ($ddep == "財務部") {
            $sdepid = '6';
        }
        if ($ddep == "資訊部") {
            $sdepid = '7';
        }
        if($depareaid=="T"){
            $deparea="台北";
        }
        if($depareaid=="S"){
            $deparea="深圳";
        }
        if($depareaid=="D"){
            $deparea="東莞";
        }

        $data=$request->input();
        $emp_list1 = empinfo::all();
        $mail1 = $this->empinforservices->empdata($request->input('manage1id'), 3);//取1階主管mail
        $mail2 = $this->empinforservices->empdata($request->input('manage2id'), 3);//取2階主管mail
        $name1 = $this->empinforservices->empdata($request->input('manage1id'), 1);//取1階主管name
        $name2 = $this->empinforservices->empdata($request->input('manage2id'),1);//取2階主管name
        $a = explode("@", $request->input('mail'));
        $accout = $a[0];

        $data['manage1mail'] =  $mail1;
        $data['manage2mail'] =  $mail2;
        $data['accout']=$accout;
        $data['agentempename']=$this->empinforservices->empdata($request->agentemp, 18);
        $data['manage1name']=$name1;
        $data['manage2name']=$name2;
        $data['depid'] = $sdepid;
        $data['deparea'] = $deparea;
        $data['agentempename']=$this->empinforservices->empdata($request->agentemp, 18);
     //取得主管mail
        $data = array_merge($data, array_except($request->input(), '_token'));
        $status = empinfo::create($data);
        if ($status != false) {
            $status = true;
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


        return view('hrsys.newemp', ['status' => $status], ['emp_list1' => $emp_list1]);

    }

    public function show($id)
    {
        $emp_list1 = $this->HumanResourceServices->select_emp();
        $data = $this->HumanResourceServices->selectemp($id);
        // $data =  DB::select('SELECT * FROM empinfo where empid = ?', array($id));
        return view('hrsys.employees', ['emp_list' => $data, 'emp_list1' => $emp_list1]);


    }

    public function edit($id)
    {
        $emp_list = $this->HumanResourceServices->select_emp();
        $data = $this->HumanResourceServices->selectemp($id);
        $status = '';
        $emp_list1 = $this->HumanResourceServices->select_emp();
        return view('hrsys.hrupdateemp', ['data' => $data, 'emp_list' => $emp_list, 'status' => $status,'emp_list1'=>$emp_list1]);


    }

    public function update(Request $request, $id)//修改員工資料
    {



        $sdepid = '';
        $depareaid="";
        $ddep = $request->dep;
        $deparea=$request->deparea;

        if ($ddep == "管理部") {
            $sdepid = '1';
        }
        if ($ddep == "產品研發部") {
            $sdepid = '2';
        }
        if ($ddep == "產品工程部") {
            $sdepid = '3';
        }
        if ($ddep == "PM業務部") {
            $sdepid = '4';
        }
        if ($ddep == "資材部") {
            $sdepid = '5';
        }
        if ($ddep == "財務部") {
            $sdepid = '6';
        }
        if ($ddep == "資訊部") {
            $sdepid = '7';
        }
        if($deparea=="台北"){
            $depareaid="T";
        }
        if($deparea=="深圳"){
            $depareaid="S";
        }
        if($deparea=="東莞"){
            $depareaid="D";
        }


        try {
            $data=$request->input();
            $emp_list1 = empinfo::all();
            $mail1 = $this->empinforservices->empdata($request->input('manage1id'), 3);//取1階主管mail
            $mail2 = $this->empinforservices->empdata($request->input('manage2id'), 3);//取2階主管mail
            $name1 = $this->empinforservices->empdata($request->input('manage1id'), 1);//取1階主管name
            $name2 = $this->empinforservices->empdata($request->input('manage2id'),1);//取2階主管name
            $a = explode("@", $request->input('mail'));
            $accout = $a[0];

            $data['manage1mail'] =  $mail1;
            $data['manage2mail'] =  $mail2;
            $data['accout']=$accout;
            $data['agentempename']=$this->empinforservices->empdata($request->agentemp, 18);
            $data['manage1name']=$name1;
            $data['manage2name']=$name2;
            $data['depid'] = $sdepid;
            $data['depareaid'] = $depareaid;
            $data['agentempename']=$this->empinforservices->empdata($request->agentemp, 18);
            $res = empinfo::find($id)->update($data);

//            $res = DB::update('update empinfo set
//            pwd = ?,name = ?,ename = ?,identity = ?,sex = ?,
//            birth = ?,marry = ?,title = ?,grade = ?,emprank = ?,
//            achievedate = ?,depid = ?,dep = ?,deparea = ?,mail = ?,
//            cellphone = ?,phone = ?,adress = ?,edu = ?,syslimit = ?,
//            agentemp = ?,jobsts = ?,creatdate = ?,createmp = ?,updatedate = ?,
//            updateemp = ? where empid =?',
//                [
//                    $request->pwd,
//                    $request->name,
//                    $request->ename,
//                    $request->identity,
//                    $request->sex,
//                    $request->birth,
//                    $request->marry,
//                    $request->title,
//                    $request->grade,
//                    $request->emprank,
//                    $request->achievedate,
//                    $sdepid,
//                    $request->dep,
//                    $request->deparea,
//                    $request->mail,
//                    $request->cellphone,
//                    $request->phone,
//                    $request->adress,
//                    $request->edu,
//                    $request->syslimit,
//                    $request->agentemp,
//                    $request->jobsts,
//                    $request->creatdate,
//                    $request->createmp,
//                    $request->updatedate,
//                    $request->updateemp,$id
//                ]);
            //職務代理人
            $emp_list = $this->HumanResourceServices->select_emp();
            //錯誤時返回的員工資料
            $data = $this->HumanResourceServices->selectemp($id);
            if ($res) {
                //更新成功
                // Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['data' => $data, 'emp_list' => $emp_list, 'status' => true]);
            } else {
                //更新失敗
                // Session::put('empid', $data[0]->empid);
                return view('hrsys.hrupdateemp', ['data' => $data, 'emp_list' => $emp_list, 'status' => false]);
            }
        } catch (Exception $e) {
            //錯誤

        }

    }


    public function destroy($id)
    {
        //
    }

    public function search_empid(Request $request)//搜尋單一員工資料
    {
        $id = $request->empid;
        $emp_list1 = $this->HumanResourceServices->select_emp();
        $data = $this->HumanResourceServices->selectempary($id);
        return view('hrsys.employees', ['emp_list' => $data, 'emp_list1' => $emp_list1]);


    }
    public function showpicsign(Request $request){

        return view("attendance.uploadpmysign");
    }
    public function uploadpicsign(Request $request){
        if (isset($request->uploadfile)) {
            //檔名
            $image = $request->file('uploadfile');
            $filename = $image->getClientOriginalName();
            //套用哪個模組 模組位置 config/filesystems.php -> disks
//        Storage::disk('設定好的模組')->put('檔名','要上船的檔案'); 上傳成功會回傳true 失敗false
            $newfilename=Session::get('empdata')->ename;
            $arr = explode(".", $filename);
            $myfilename=$newfilename.".".$arr[1];

            $uploadPic = Storage::disk('empsign')->put($myfilename, file_get_contents($image->getRealPath()));

            //取得存好檔案的URL
            $photoURL = Storage::disk('empsign')->url($myfilename);

            $data = array('mysign' => $photoURL);
            $data = array_merge(array_except($request->input(), '_token'), $data);
        } else {
            $data = array_except($request->input(), '_token');
        }
        empinfo::where('empid', $request->input('empid'))->update($data);
        echo " <script>alert('上傳成功'); self.opener.location.reload();window.close(); </script>";
        return view("attendance.uploadpmysign");
    }
}
