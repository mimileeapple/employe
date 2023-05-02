<?php

namespace App\Http\Controllers;

use App\Model\empinfo;
use App\Model\invoice\invoiceorder;
use App\Model\invoice\packlist\packlistdata;
use App\Model\invoice\packlist\packlistorder;
use App\Model\invoice\packlist\packlistlog;
use App\Model\invoice\packlist\packlistlog2;
use App\Model\pibank;
use App\Model\pispace\pispaceorder;
use App\Model\pispace\productname;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use App\Model\customer;
use App\Model\piheade;
use App\Model\pidata;

use Illuminate\Support\Facades\Storage;
use Session;

class custPIController extends Controller
{
    private $CustomerService;

    public function __construct()
    {
        date_default_timezone_set("Asia/Taipei");
        $this->CustomerService = new CustomerService();
    }

    public function index()
    {

        $custcompanyidall = piheade::where('sts', 'not like', 'D')->groupBy('companyid')->get();
        $id = Session::get('companyid');
        if ($id != "") {

            $data = piheade::where('companyid', 'like', $id)->where('sts', 'not like', 'D')->orderby('id', 'desc')->get();
            Session::forget('companyid');
            foreach ($data as $i => $d) {
                $spacecount = pispaceorder::where('orderid', $d->id)->count();//每個都要count看是幾個
                $data[$i]['spacecount'] = $spacecount;
                $invocie = invoiceorder::where('orderid', $d->id)->count();
                $data[$i]['invocie'] = $invocie;
            }

            return view("customer.PI.PIlist", ['customerlist' => $data, 'custcompanyidall' => $custcompanyidall, 'cnoid' => $id]);
        } else {
            $data = piheade::where('sts', '<>', 'D')->orderby('id', 'desc')->get();
            $id = "";
            foreach ($data as $i => $d) {
                $spacecount = pispaceorder::where('orderid', $d->id)->count();//每個都要count看是幾個
                $data[$i]['spacecount'] = $spacecount;
                $invocie = invoiceorder::where('orderid', $d->id)->count();
                $data[$i]['invocie'] = $invocie;
            }

            return view("customer.PI.PIlist", ['customerlist' => $data, 'custcompanyidall' => $custcompanyidall, 'cnoid' => $id]);
        }

    }

    public function create()
    {
        //創建單號
        $custalllist = customer::all();
        $id = Session::get('custid');

        if ($id != "") {
            $maxno = piheade::where('companyid', 'like', $id)->max('piitem');

            if ($maxno == null) {
                $maxno = "01";
            } else {
                $maxno = $maxno + 1;
                $maxno = str_pad($maxno, 2, '0', STR_PAD_LEFT);
            }
            $data = customer::where('companyid', 'like', $id)->get();
            Session::forget('custid');
            return view("customer.PI.newPI", ['custalllist' => $custalllist, 'custlist' => $data, 'cid' => $id, 'maxno' => $maxno]);
        } else {
            $data = "";
            $id = "";
            $maxno = "";
            return view("customer.PI.newPI", ['custalllist' => $custalllist, 'custlist' => $data, 'cid' => $id, 'maxno' => $maxno]);
        }


    }

    public function store(Request $request)
    {
        //dd( $request->input());
        try {
            $inp = $request->input();
            $inp = array_except($inp, ['modelname', 'description', 'quantity', 'unitprice', 'total']);
            piheade::create($inp);
            $status = true;
        } catch (\Exception $e) {
            dd($e);
        }
        try {
            $d = $request->input();
            foreach ($request->input('modelname') as $i => $v) {
                $data[] = array('modelname' => $request->input('modelname')[$i],
                    'description' => $request->input('description')[$i],
                    'currency' => $request->input('currency')[$i],
                    'quantity' => $request->input('quantity')[$i],
                    'unitprice' => $request->input('unitprice')[$i],
                    'total' => $request->input('total')[$i]
                );
            }
            if ($request->input('payposit') != "") {
                foreach ($request->input('payposit') as $i => $v) {
                    $payment[] = array('payposit' => $request->input('payposit')[$i],
                        'amount' => $request->input('amount')[$i],
                        'method' => $request->input('method')[$i]);
                }
                $payment = json_encode($payment, JSON_UNESCAPED_UNICODE);
                $d['payment'] = $payment;
            }
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $d['data'] = $data;
            pidata::create($d);

        } catch (\Exception $e) {
            dd($e);
        }
        Session::forget('custid');
        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
    }


    public function show($id)
    {
        //列印PI與規格表
        $custcompanyidall = piheade::all();
        $custhead = piheade::where('id', '=', $id)->get();
        $custdata = pidata::where('id', '=', $id)->get();
        $pipayshow = pidata::where('id', '=', $id)->get();
        $pino = piheade::where('id', '=', $id)->value('pino');
        $pipay = json_decode($pipayshow[0]['data']);
        $payment = json_decode($pipayshow[0]['payment']);
        $orderpm = piheade::where('id', '=', $id)->value('createmp');
        $mysign = empinfo::where('name', 'like', $orderpm)->value('mysign');
        foreach ($pipay as $i => $pay) {
            $unit = $pay->currency;
            $unit = "(" . substr($unit, 0, 3) . ")";
        }

        $spacelist = pispaceorder::where('orderid', $id)->get();
        $spacedata = pispaceorder::where('orderid', $id)->value('spacedata');
        $spacedata = json_decode($spacedata, true);

//dd($spacedata);
        return view("customer.PI.printPI", ['custhead' => $custhead, 'custdata' => $custdata, 'pipay' => $pipay, 'custcompanyidall' => $custcompanyidall, 'currency' => $unit, 'pino' => $pino,
            'mysign' => $mysign, 'payment' => $payment, 'spacelist' => $spacelist, 'spacedata' => $spacedata]);
    }

    public function edit($id)
    {
        $custhead = piheade::where('id', '=', $id)->get();
        $custdata = pidata::where('id', '=', $id)->get();
        $pipayshow = pidata::where('id', '=', $id)->get();
        $pipay = json_decode($pipayshow[0]['data']);
        $payment = json_decode($pipayshow[0]['payment']);
        return view("customer.PI.updatePI", ['custhead' => $custhead, 'custdata' => $custdata, 'pipay' => $pipay, 'payment' => $payment]);
    }

    public function update(Request $request, $id)
    {

        try {
            $pilist = $request->input();
//-------
            piheade::find($id)->update($pilist);
            $d = $request->input();

            foreach ($request->input('modelname') as $i => $v) {
                $data[] = array('modelname' => $request->input('modelname')[$i],
                    'description' => $request->input('description')[$i],
                    'currency' => $request->input('currency')[$i],
                    'quantity' => $request->input('quantity')[$i],
                    'unitprice' => $request->input('unitprice')[$i],
                    'total' => $request->input('total')[$i]
                );
            }

            if ($request->input('payposit') != "") {
                foreach ($request->input('payposit') as $i => $v) {
                    $payment[] = array('payposit' => $request->input('payposit')[$i],
                        'amount' => $request->input('amount')[$i],
                        'method' => $request->input('method')[$i]);
                }
                $payment = json_encode($payment, JSON_UNESCAPED_UNICODE);
                $d['payment'] = $payment;
            }
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $d['data'] = $data;

            pidata::find($id)->update($d);
            echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
        } catch (Exception $e) {
            dd($e);
        }
    }


    public function destroy(Request $id)
    {
        $id = $id->input('id');
        $pino= piheade::where('id',$id)->value('nonumber');

       pidata::where('id', $id)->update(['sts' => 'D']);
        piheade::where('id', $id)->update(['sts' => 'D']);

        //-----寫space跟invoice狀態改變 要先判斷是否存在**3/31
        productname::where('orderid', $id)->update(['sts' => 'D']);
        pispaceorder::where('orderid', $id)->update(['sts' => 'D']);
        invoiceorder::where('orderid', $id)->update(['sts' => 'D']);
        //刪除pl單(order/data/log)packlistdata log丟入log2裡面 packlist


        $deldata=packlistlog::where('plno',$id)->get();
        //dd($deldata);
        $tempid='';
        if(count($deldata)>0){
        foreach ($deldata as $k=>$val){//要還原的資料

            $orderid=$val['orderid'];

            if($tempid!=$orderid){
                $pldata=packlistlog::where('orderid',$orderid)->value('data');//抓出該單號要還原的資料(整個data)
                packlistdata::where('orderid',$orderid)->update(['data'=>$pldata]);

                $log2=packlistlog::where('orderid',$orderid)->get();


                packlistlog2::create($log2->toArray()[0]);//將要刪除的資料丟入垃圾桶log2裡面(log備份之後才可查找刪除的資料
                packlistlog::where('orderid',$orderid)->delete();//將暫存區資料刪除
            }
            $tempid=$orderid;
        }


        //LOG 將存data資料存入後刪除
            //4/12確認是否需要刪除 若需要則開新的log表
       $datapllist= packlistdata::where('orderid',$id)->get();
            packlistdata_log::create($datapllist);
        $plorder=packlistorder::where('pino',$pino)->get();//單據先取消
            packlistorder_log::create($plorder);
            packlistdata::where('orderid',$id)->delet();
            packlistorder::where('pino',$pino)->delet();
        }


       //-----------------------------------------
        $data = piheade::where('sts', 'not like', 'D')->orderby('id', 'desc')->get();
        $custcompanyidall = piheade::where('sts', 'not like', 'D')->groupBy('companyid')->get();

        return view("customer.PI.PIlist", ['customerlist' => $data, 'custcompanyidall' => $custcompanyidall]);

    }

    public function searchcust(Request $request)
    {
        //創建客戶使用--抓取cust的資料
        $custid = $request->input('custid');
        $data = customer::where('companyid', 'like', $custid)->get();
        $maxno = piheade::where('companyid', 'like', $custid)->max('piitem');

        if ($maxno == null) {
            $maxno = "01";
        } else {
            $maxno = $maxno + 1;
            $maxno = str_pad($maxno, 2, '0', STR_PAD_LEFT);
        }
        $custalllist = customer::all();
        Session::put('custid', $custid);
        return redirect()->route('custPI.create', ['custalllist' => $custalllist, '' => $data, 'cid' => $custid, 'maxno' => $maxno]);
    }

    public function searchcompanyid(Request $request)
    {
//查找資料
        $custcompanyidall = piheade::where('sts', 'not like', 'D')->groupBy('companyid')->get();
        $companyid = $request->input('companyid');
        if ($companyid == "") {
            $data = piheade::where('sts', 'not like', 'D')->get();
        } else {
            $data = piheade::where('companyid', 'like', $companyid)->where('sts', 'not like', 'D')->get();
            Session::put('companyid', $companyid);
        }
        return redirect()->route('custPI.index', ['customerlist' => $data, 'custcompanyidall' => $custcompanyidall, 'cnoid' => $companyid]);
    }

    public function findbankdata(Request $request)
    {
        $addressofbank = $request->input("addressofbank");
        $backdata = pibank::where('bankid', '=', $addressofbank)->get();
        return response()->json($backdata);

    }

    public function uploadpi(Request $request)
    {
//dd($request->file('uploadfile'));
        //上傳PI單
        if (isset($request->uploadfile)) {
            //檔名
            $image = $request->file('uploadfile');
            $filename = $image->getClientOriginalName();
            //套用哪個模組 模組位置 config/filesystems.php -> disks
//        Storage::disk('設定好的模組')->put('檔名','要上船的檔案'); 上傳成功會回傳true 失敗false
     $uploadPic = Storage::disk('PI')->put($filename, file_get_contents($image->getRealPath()));
            //取得存好檔案的URL
            $photoURL = Storage::disk('PI')->url($filename);

            $data = array('uploadpi' => $photoURL);
            $data = array_merge(array_except($request->input(), '_token'), $data);
        } else {
            $data = array_except($request->input(), '_token');
        }
        piheade::where('id', $request->input('id'))->update($data);
        pidata::where('id', $request->input('id'))->update(['sts' => 'Y']);
        piheade::where('id', $request->input('id'))->update(['sts' => 'Y']);
        echo " <script>alert('上傳成功'); self.opener.location.reload();window.close(); </script>";
    }

    public function signpi($id)//跳轉至上傳PI單畫面
    {

        $data = pidata::where('id', '=', $id)->get();
        return view('customer.PI.uploadpi', ['id' => $id, 'data' => $data]);
    }
}
