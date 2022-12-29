<?php

namespace App\Http\Controllers;

use App\Model\leaveorder;
use App\Services\HumanResourceServices;
use  App\Services\empinforservices;
use  App\Services\PayServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Model\empinfo;
use App\Model\tripsign;
use App\Model\tripdata;
use App\Model\trippay;
use App\Model\triptotal;
use App\Model\log\tripsign_log;
use App\Model\log\tripdata_log;
use App\Model\log\trippay_log;
use App\Model\log\triptotal_log;
use Session;
use DB;



class PayController extends Controller
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

    public function index(Request $orderid)
    {
        $id = $orderid->input('id');
        return view('pay.reimburse');
    }


    public function create(Request $request)//跳轉至申請出差表
    {
        $status = '';
        $orderid = $request->input('orderid');
        $data = $this->empinforservices->orderdetail($orderid);
        $ordeapay[0] = array('summary' => '', 'details' => '', 'currency' => '', 'amount' => '', 'rate' => '', 'convert_T' => '', 'remark' => '');
        $ordeapay = json_decode(json_encode($ordeapay));

        return view('pay.applyreimburse', ['order_list' => $data, 'ordeapay' => $ordeapay, 'status' => $status]);
    }


    public function store(Request $request)//儲存出差資料
    {
        date_default_timezone_set('Asia/Taipei');
        $today = date("Y-m-d H:i:s");
        $a = (count($request->input('summary')));
        $status = "";
        try {
            $leavedata = $request->input();
            $leavedata['createmp'] = $request->input()['name'];
            $leavedata['updateemp'] = $request->input()['name'];
            tripdata::create($leavedata);
            $status = true;

        } catch (\Exception $e) {
            dd($e);
        }
        //*******pay
        try {
            foreach ($request->input('summary') as $i => $v) {
                $data[] = array('summary' => $request->input('summary')[$i],
                    'details' => $request->input('details')[$i],
                    'currency' => $request->input('currency')[$i],
                    'amount' => $request->input('amount')[$i],
                    'rate' => $request->input('rate')[$i],
                    'convert_T' => $request->input('convert_T')[$i],
                    'remark' => $request->input('remark')[$i],
                );
            }
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $inp = $request->input();
            $inp['data'] = $data;
            $inp['createmp'] = $request->input()['name'];
            $inp['updateemp'] = $request->input()['name'];
            $inp = array_except($inp, ['summary', 'details', 'currency', 'amount', 'rate', 'convert_T', 'remark']);
            trippay::create($inp);
            $status = true;
        } catch (\Exception $e) {
            dd($e);
        }
        //寫入簽核表
        try {
            $emplist = $this->HumanResourceServices->selectemp(Session::get('empid'));
//你資料送到這 不是$request->input() 他是一個陣列 你就對這個陣列做 增加資料的動作 $request->input()['newdate'] = $empinfo->data 這樣
            //然後 因為你這樣加進來 你的MODEL 會一口氣都丟過去資料表 可是有些資料你資料庫沒有欄位 他就會失敗 你要用model的白名單 設定要新增的欄位 這樣就可以了
            $d = $request->input();
            $d['supervisorid'] = $emplist->manage1id;
            $d['managerid'] = $emplist->manage2id;
            $d['financeid'] = 2;
            $d['supervisorname'] = $emplist->manage1name;
            $d['managername'] = $emplist->manage2name;
            $d['financename'] = '陳雅琴';
            $d['supervisorsign'] = 'N';
            $d['managersign'] = 'N';
            $d['financesign'] = 'N';
            $d['supervisormail'] = $emplist->manage1mail;
            $d['managermail'] = $emplist->manage2mail;
            $d['financemail'] = 'Zing.Chen@hibertek.com';
            $d['signsts'] = 0;
            $d['ordersts'] = 'N';
            $d['createmp'] = $request->name;
            $d['updateemp'] = $request->name;
            tripsign::create($d);
        } catch (\Exception $e) {
            dd($e);
        }
        try {
            $data = $request->input();
            triptotal::create($data);
            $status = true;
        } catch (\Exception $e) {

            dd($e);
        }

           /* $title = "簽核通知-" . $request->name . "-出差申請單簽核";
            $tomail = $emplist->manage1mail;
            $towho = $emplist->manage1name;
            $content = "你有出差申請單尚未簽核，請至人資系統簽核";
            $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/

        $status = true;

        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
        return view('pay.applyreimburse', ['order_list' => json_decode($data), 'status' => $status]);

    }


    public function show($id)//秀出所有我需要填寫的出差表
    {

        $orderdata = $this->PayServices->findmytrip($id,10);//取出所有資料

        foreach ($orderdata as $i => $e) {
            $sts = $this->PayServices->findordersts($e->orderid);

            if (count($sts) > 0) {//有申請過
                $orderdata[$i]['status'] = true;

            } else {
                $orderdata[$i]['status'] = false;
            }

        }

        return view('pay.tripapplytotal', ['orderdata' => $orderdata]);

    }

    public function edit($id)//秀出單張出差表
    {
        $order_list = $this->PayServices->findtripdata($id);//資料
        $ordeapay = $this->PayServices->findtrippay($id);//費用

        $ordersign = $this->PayServices->findtripsign($id);
        $ordertotal = $this->PayServices->triptotal($id);

        foreach ($order_list as $i => $e) {
            $sts = $this->PayServices->findordersts($e->orderid);
            if (count($sts) > 0) {
                $order_list[$i]['status'] = true;
            } else {
                $order_list[$i]['status'] = false;
            }
        }
        $ordeapay = json_decode($ordeapay[0]['data']);
        return view('pay.reimburse', ['order_list' => $order_list, 'ordeapay' => $ordeapay, 'ordersign' => $ordersign, 'ordertotal' => $ordertotal]);
    }


    public function update(Request $request, $id)
    {
        //簽核
        date_default_timezone_set('Asia/Taipei');
        $today = date('Y-m-d H:i:s');

        $tripsign = new  tripsign();
        foreach ($request->Checkbox as $i => $v) {
            $upda = explode(',', $v);
            $upda_data['orderid'] = $upda[0];
            $upda_data['signsts'] = $upda[1];
            if ($upda_data['signsts'] == 0) {//申請中
                $upda_data['supervisorsign'] = 'Y';
                $upda_data['signsts'] = '1';
                $upda_data['managersign'] = 'N';
                $upda_data['financesign'] = 'N';
                $upda_data['supervisor_signdate'] = $today;
                $upda_data['updateemp'] = Session::get('name');
                $upda_data['updatedate'] = $today;
                $empid = $this->empinforservices->orderdetailmyid($upda_data['orderid']);
                //寄信
                $name = $this->empinforservices->empdata($empid, 1);
                $mail = $this->empinforservices->empdata($empid, 15);

                  /*  $title = "簽核通知-" . $name . "-請假單簽核";
                    $tomail = $mail;
                    $towho = $this->empinforservices->empdata($empid, 12);//取name
                    $content = "你有請假單尚未簽核，請至人資系統簽核";
                    $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/


            } else if ($upda_data['signsts'] == 1) {//一階主管已簽核 二階主管作業
                $upda_data['signsts'] = '2';
                $upda_data['supervisorsign'] = 'Y';//1簽過了
                $upda_data['managersign'] = $upda[2];
                $upda_data['financesign'] = 'N';
                $upda_data['manager_signdate'] = $today;
                $upda_data['updateemp'] = Session::get('name');
                $upda_data['updatedate'] = $today;
                $empid = $this->empinforservices->orderdetailmyid($upda_data['orderid']);
                $name = $this->empinforservices->empdata($empid, 1);

                  /*  $title = "簽核通知-$name-請假單簽核";
                    $tomail = "Zing.Chen@hibertek.com";//結案人
                    $towho = "Zing.Chen";;
                    $content = "你有請假單尚未簽核，請至人資系統簽核";
                    $this->HumanResourceServices->send_mail($title, $tomail, $towho, $content);*/

            } else if ($upda_data['signsts'] == 2) {//2階主管已簽核 財務作業
                $upda_data['signsts'] = '3';
                $upda_data['supervisorsign'] = 'Y';//1簽過了
                $upda_data['managersign'] = 'Y';
                $upda_data['financesign'] = 'Y';
                $upda_data['finance_signdate'] = $today;
                $upda_data['updateemp'] = Session::get('name');
                $upda_data['updatedate'] = $today;
                $upda_data['ordersts'] = 'Y';


            }

            tripsign::where('orderid', $upda[0])->update($upda_data);


            $data = $this->PayServices->tripsign(Session::get('empid'));

            foreach ($data as $i => $e) {
                $empdata[$i]['title'] = $this->PayServices->tripdatatitle($e->orderid);
                $empdata[$i]['leavestart'] = $this->PayServices->tripdataleavestart($e->orderid);
                $empdata[$i]['leaveend'] = $this->PayServices->tripdataleaveend($e->orderid);
                $empdata[$i] = array_merge($empdata[$i], json_decode(json_encode($data[$i]), true));

            }
            if (count($data) > 0) {
                Session::put('pay', count($data));
            } else {
                Session::put('pay', 0);
            }
        }
        return redirect()->back();
    }


    public function destroy(Request $id)
    {
        $id = $id->input('id');

      // tripsign::where('orderid', $id)->update(['ordersts'=>'D']);
        $empdata = [];
        $data = $this->PayServices->tripsign(Session::get('empid'));
        foreach ($data as $i => $e) {
            $empdata[$i]['title'] = $this->PayServices->tripdatatitle($e->orderid);
            $empdata[$i]['leavestart'] = $this->PayServices->tripdataleavestart($e->orderid);
            $empdata[$i]['leaveend'] = $this->PayServices->tripdataleaveend($e->orderid);
            $empdata[$i] = array_merge($empdata[$i], json_decode(json_encode($data[$i]), true));

        }
        $empdata = json_decode(json_encode($empdata), FALSE);

        foreach ($data as $i => $v) {

            $empdata[$i]->order_data = $v->orderid . ',' . $v->signsts . ',' . $v->supervisorsign . ',' . $v->managersign . ',' . $v->financesign;
        }

        //將刪除的資料全部撈出後存入log
        $datasign= tripsign::where('orderid', $id)->get();
        $datasign[0]->action='delete';

         tripsign_log::create($datasign->toArray()[0]);

        $tripdata= tripdata::where('orderid', $id)->get();
        $tripdata[0]->action='delete';
        tripdata_log::create($tripdata->toArray()[0]);
        $paydata= trippay::where('orderid', $id)->get();
        $paydata[0]->action='delete';
        trippay_log::create($paydata->toArray()[0]);
        $totaldata= triptotal::where('orderid', $id)->get();
        $totaldata[0]->action='delete';
        triptotal_log::create($totaldata->toArray()[0]);
 //刪除
        tripsign::where('orderid', $id)->delete();
        tripdata::where('orderid', $id)->delete();
        trippay::where('orderid', $id)->delete();
        triptotal::where('orderid', $id)->delete();

        return view("sign.bosssigntrip", ['emplist' => $empdata]);
    }

    public function search_trip(Request $request)
    {//個人總表
        $orderdata = $this->PayServices->search_trip_month($request->month,10);

        foreach ($orderdata as $i => $e) {
            $sts = $this->PayServices->findordersts($e->orderid);
            if (count($sts) > 0) {
                $orderdata[$i]['status'] = true;
            } else {
                $orderdata[$i]['status'] = false;
            }
        }
        return view("pay.tripapplytotal", ['orderdata' => $orderdata, 'selected' => $request->month]);

    }

    public function showtripsign(Request $request)
    {//秀要簽核的資料
        $empdata = [];
        $data = $this->PayServices->tripsign($request->id);
        foreach ($data as $i => $e) {
            $empdata[$i]['title'] = $this->PayServices->tripdatatitle($e->orderid);
            $empdata[$i]['leavestart'] = $this->PayServices->tripdataleavestart($e->orderid);
            $empdata[$i]['leaveend'] = $this->PayServices->tripdataleaveend($e->orderid);
            $empdata[$i] = array_merge($empdata[$i], json_decode(json_encode($data[$i]), true));

        }
        $empdata = json_decode(json_encode($empdata), FALSE);

        foreach ($data as $i => $v) {

            $empdata[$i]->order_data = $v->orderid . ',' . $v->signsts . ',' . $v->supervisorsign . ',' . $v->managersign . ',' . $v->financesign;
        }
        return view("sign.bosssigntrip", ['emplist' => $empdata]);
    }

    public function historytrippay()
    {//歷史申請單資料
        $empdata = [];
        $data = $this->PayServices->historytrippay();
        foreach ($data as $i => $e) {
            $empdata[$i]['title'] = $this->PayServices->tripdatatitle($e->orderid);
            $empdata[$i]['leavestart'] = $this->PayServices->tripdataleavestart($e->orderid);
            $empdata[$i]['leaveend'] = $this->PayServices->tripdataleaveend($e->orderid);
            $empdata[$i] = array_merge($empdata[$i], json_decode(json_encode($data[$i]), true));

        }
        $empdata = json_decode(json_encode($empdata), FALSE);
        return view("sign.history_bosssigntrip", ['emplist' => $empdata]);
    }

}
