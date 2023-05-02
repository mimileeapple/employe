<?php

namespace App\Http\Controllers\invoice;

use App\Model\invoice\invoiceorder;
use App\Model\invoice\packlist\packlistdata;
use App\Model\invoice\packlist\packlistorder;
use App\Model\invoice\packlist\packlistlog;
use App\Model\invoice\packlist\packlistlog2;
use Illuminate\Http\Request;
use Session;

class PacklistController
{

    public function index()
    {
        //跳轉至挑選(勾選頁面)
        $invoice = packlistdata::where('sts','not like','D')->orderBy('orderid', 'asc')->get();
        // dd($invoice);
        //如果要秀出 就直接把原本的位置讓新的資料蓋過去
        foreach ($invoice as $i => $in) {
            $invoice[$i]['data'] = json_decode($invoice[$i]['data'], true);
        }

        return view("customer.packinglist.packlistindex", ['invoice' => $invoice]);
    }

    public function packlistall(Request $request)
    {
        //PL單主頁
        $packlistdata = packlistorder::where('sts','not like','D') ->orderBy('id', 'desc')->get();
        return view('customer.packinglist.packlist', ['packlistdata' => $packlistdata]);
    }

    public function showmodelname(Request $request)//新增PL單.使用更新
    {
        //勾選單頁面確認
        $orderidall = $request->input('orderid');
        $maxorderid = $orderidall[0];//最小的(最小的單)

        $model = $request->input('data');
        $today=date("Y-m-d H:i:s");

//這是要的資料 這邊是兩個資料 放在裡面跑即可八
        //這邊取得畫面勾選的資料

        foreach ($request->input('orderid') as $j => $orderid) {
            $olddata = packlistdata::where('orderid', $orderid)->value('data');
            $olddata = json_decode($olddata, true);
            foreach ($olddata as $i => $v) {//抓舊資料
                $old[] = array(
                    'orderid' => $v['orderid'],
                    'no' => $v['no'],
                    'modelname' => $v['modelname'],
                    'description' => $v['description'],
                    'quantity' => $v['quantity'],
                    'plsts' => $v['plsts']);

                $logdata[$orderid][]=array(
                    'orderid' => $v['orderid'],
                    'no' => $v['no'],
                    'modelname' => $v['modelname'],
                    'description' => $v['description'],
                    'quantity' => $v['quantity'],
                    'plsts' => $v['plsts']);

            }

        }
        foreach ($model as $k => $va) {
            $product = explode(",", $va);//model部分
            $newdata[] = array(//新資料
                'orderid' => $product[0],
                'no' => $product[1],
                'modelname' => $product[2],
                'description' => $product[3],
                'quantity' => $product[4],
                'plsts' => 'Y');

        }

       // $orderidall=json_encode($orderidall, true);
        $plid=packlistorder::max('id');
        if($plid==""||$plid==null){
            $plid=1;
        }
        else{
            $plid=$plid+1;
        }
        foreach ($logdata as $key =>$d){//將資料放入log 暫存區
            $logdata[$key]=json_encode($d, JSON_UNESCAPED_UNICODE);

           $log['orderid']=$key;
            $log['plno']=$plid;
            $log['data']=$logdata[$key];
            $log['creatdate']=$today;
            $log['createemp']=$request->input('createemp');
            $log['updatedate']=$today;
            $log['updateemp']=$request->input('updateemp');

           packlistlog::create($log);

        }

        foreach ($old as $k => $val) {//將舊資料狀態改為新資料(與新資料比對)
            foreach ($newdata as $i => $n) {
                if ($val['orderid'] == $n['orderid'] && $val['no'] == $n['no']) {

                    $old[$k]['plsts'] = 'Y';
                }
            }

        }

        foreach ($request->input('orderid') as $j => $orderid) {
            $i = 0;
            foreach ($old as $k => $val) {//將新資料拆成單號與底下的資料.變成二微陣列(第一維是單號.第二維是底下的data

                if ($val['orderid'] == $orderid) {
                    $changedata[$orderid][$i] = $val;
                    $i++;
                }

            }

        }
        foreach ($changedata as $k => $val) {//將新資料轉換成json並更新資料庫
            $changedata[$k] = json_encode($val, JSON_UNESCAPED_UNICODE);

            packlistdata::where('orderid', $k)->update(['data' => $changedata[$k]]);
        }

        return  redirect()->route('newpacklist', ['maxorderid' => $maxorderid, 'newdata' => $newdata]);


    }

    public function create()
    {

    }

    public function newpacklist(Request $request)
    {
        //從勾選單頁面->跳轉到新增頁
        $maxorderid=$request->maxorderid;
        $listdata = packlistdata::where('orderid', $maxorderid)->get();
        $newdata=$request->newdata;


        return  view('customer.packinglist.newpacklist', ['listdata' => $listdata, 'newdata' => $newdata]);
    }

    public function store(Request $request)
    {

        //儲存PL單
        $packlistdata = $request->input();
        $packlistdata = array_except($packlistdata, ['orderid','modelname', 'description', 'quantity', 'ctns', 'pallets', 'nw', 'gw', 'cbm']);
        foreach ($request->input('modelname') as $i => $v) {
            $data[] = array(
                'orderid'=>$request->input('orderid')[$i],
                'modelname' => $request->input('modelname')[$i],
                'description' => $request->input('description')[$i],
                'quantity' => $request->input('quantity')[$i],
                'ctns' => $request->input('ctns')[$i],
                'pallets' => $request->input('pallets')[$i],
                'nw' => $request->input('nw')[$i],
                'gw' => $request->input('gw')[$i],
                'cbm' => $request->input('cbm')[$i]);
        }
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $packlistdata['data'] = $data;
        if($request->input('shippingdate')!=""||$request->input('shippingdate')!=null){
            $packlistdata['sts']='Y';
        }

        packlistorder::create($packlistdata);
        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";

    }


    public function show($id)
    {
        //列印PDF
        $listdata = packlistorder::where('id', $id)->get();
        $data = json_decode($listdata[0]['data']);
        //dd($data);
        return view('customer.packinglist.printpacklist', ['listdata' => $listdata, 'data' => $data]);
    }


    public function edit($id)
    {
        $listdata = packlistorder::where('id', $id)->get();
        $data = json_decode($listdata[0]['data']);
        return view('customer.packinglist.uppacklist', ['listdata' => $listdata, 'data' => $data]);
    }


    public function update(Request $request, $id)
    {
        $pldata = $request->input();
        $pldata = array_except($pldata, ['modelname', 'description', 'quantity', 'ctns', 'pallets', 'nw', 'gw', 'cbm','_token','_method']);
        foreach ($request->input('modelname') as $i => $v) {
            $data[] = array('modelname' => $request->input('modelname')[$i],
                'description' => $request->input('description')[$i],
                'quantity' => $request->input('quantity')[$i],
                'ctns' => $request->input('ctns')[$i],
                'pallets' => $request->input('pallets')[$i],
                'nw' => $request->input('nw')[$i],
                'gw' => $request->input('gw')[$i],
                'cbm' => $request->input('cbm')[$i]);
        }
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $pldata['data'] = $data;
        if($request->input('shippingdate')!=""||$request->input('shippingdate')!=null){
            $pldata['sts']='Y';
        }
        packlistorder::where('id', $id)->update($pldata);
        echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
    }


    public function destroy(Request $id)
    {
        //重置invoice的那段.狀態改為D
        //將log資料塞回packlistdata的 data裡面
        $id = $id->input('id');

        $deldata=packlistlog::where('plno',$id)->get();
        //dd($deldata);
        $tempid='';
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


        packlistorder::where('id',$id)->update(['sts'=>'D']);//單據先取消
        $packlistdata = packlistorder::where('sts','not like','D') ->orderBy('id', 'desc')->get();
        return view('customer.packinglist.packlist', ['packlistdata' => $packlistdata]);

    }

    public function showinvoice($id)
    {
        $invoiceid=$id;
        $invoiceorder = invoiceorder::where('ivnum','like', $id)->get();
        $ivnum = invoiceorder::where('ivnum','like', $id)->value('ivnum');
        $pipay = json_decode($invoiceorder[0]['data']);
        foreach ($pipay as $i => $pay) {
            $unit = $pay->currency;
            $unit = "(" . substr($unit, 0, 3) . ")";
        }
        return view("customer.invoice.printinvoice", ['invoiceorder' => $invoiceorder, 'ivnum' => $ivnum, 'pipay' => $pipay, 'currency' => $unit]);
    }
}
