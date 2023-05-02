<?php

namespace App\Http\Controllers\invoice;

use App\Model\invoice\invoiceaddressdata;
use App\Model\invoice\invoiceorder;
use App\Model\pidata;
use App\Model\piheade;
use App\Model\invoice\packlist\packlistdata;
use Illuminate\Http\Request;

class invoiceController
{

    public function index()
    {

    }


    public function create()
    {
        //
    }
    public function newinvoice($id){
        //導入IV單
       $invoicehead= piheade::where('id',$id)->get();
       $invoicedata=pidata::where('id',$id)->get();

        $pipay = json_decode($invoicedata[0]['data']);
       return view('customer.invoice.newinvoice',['invoicehead'=>$invoicehead,'invoicedata'=>$invoicedata,'pipay'=>$pipay,'orderid'=>$id]);

    }

    public function store(Request $request)
    {
        //新增IV單
     $ourarea=$request->input("ourarea");
     $ourdata=invoiceaddressdata::where('id',$ourarea)->get();

     $invoicedata=$request->input();
     $pldata=$request->input();
    try{
        foreach ($ourdata as $our){
           $invoicedata['ouraddress']=$our->address;
           $pldata['ouraddress']=$our->address;
           $invoicedata['ourtel']=$our->tel;
           $pldata['ourtel']=$our->tel;
           $invoicedata['ourfax']=$our->fax;
           $pldata['ourfax']=$our->fax;
        }
        $invoicedata = array_except($invoicedata, ['modelname', 'description','plsts', 'quantity','currency', 'unitprice', 'total']);
        foreach ($request->input('modelname') as $i => $v) {
            $data[] = array(
                'modelname' => $request->input('modelname')[$i],
                'description' => $request->input('description')[$i],
                'currency'=>$request->input('currency')[$i],
                'quantity' => $request->input('quantity')[$i],
                'unitprice' => $request->input('unitprice')[$i],
                'total' => $request->input('total')[$i]
            );
        }
        $pldata=array_except($invoicedata, ['modelname', 'description','plsts', 'quantity','currency', 'unitprice', 'total']);
        foreach ($request->input('modelname') as $i => $v) {
            $plofdata[] = array(
                'orderid'=>$request->input('orderid'),
                'no'=>$i,
                'modelname' => $request->input('modelname')[$i],
                'description' => $request->input('description')[$i],
                'quantity' => $request->input('quantity')[$i],
                'plsts'=>$request->input('plsts')[$i]

            );
        }
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $plofdata=json_encode($plofdata, JSON_UNESCAPED_UNICODE);
        $invoicedata['data']=$data;
        $pldata['data']=$plofdata;
       invoiceorder::create($invoicedata);

       //新增存入packlistdata=當正式invoice單成立時.packlistdata則有資料可供選擇出貨

        packlistdata::create($pldata);


        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
    }
    catch (\Exception $e){
        dd($e);
    }
    }


    public function show($id)
    {
        //列印正式invoice單
        $invoiceorder=invoiceorder::where('orderid',$id)->get();
        $ivnum=invoiceorder::where('id',$id)->value('ivnum');
        $pipay=json_decode($invoiceorder[0]['data']);
        foreach ($pipay as $i => $pay) {
            $unit = $pay->currency;
            $unit = "(" . substr($unit, 0, 3) . ")";
        }
        return view("customer.invoice.printinvoice",['invoiceorder'=>$invoiceorder,'ivnum'=>$ivnum,'pipay'=>$pipay, 'currency' => $unit]);
    }


    public function edit($id)
    {
        //進入編輯頁面(從PI單撈出資料
        $invoicehead= piheade::where('id',$id)->get();
        $invoicedata=pidata::where('id',$id)->get();

        $pipay = json_decode($invoicedata[0]['data']);
        $ouraddress=invoiceorder::where('orderid',$id);
       return view("customer.invoice.upinvoice",['invoicehead'=>$invoicehead,'invoicedata'=>$invoicedata,'pipay'=>$pipay,'orderid'=>$id
       ,'ouraddress'=>$ouraddress]);
    }


    public function update(Request $request, $id)
    {
        //0320修改存入packlist的
        $ourarea=$request->input("ourarea");
        $ourdata=invoiceaddressdata::where('id',$ourarea)->get();

        $upinvoice=$request->input();
        $pldata=$request->input();
        try{
            foreach ($ourdata as $our){
            $upinvoice['ouraddress']=$our->address;
            $pldata['ouraddress']=$our->address;
            $upinvoice['ourtel']=$our->tel;
            $pldata['ourtel']=$our->tel;
            $upinvoice['ourfax']=$our->fax;
            $pldata['ourfax']=$our->fax;
        }
            $upinvoice = array_except($upinvoice, ['modelname', 'description','plsts', 'quantity', 'currency','unitprice', 'total'
            ,'_token','_method']);
            $pldata = array_except($upinvoice, ['orderdate','ivnum','modelname', 'description','plsts','taxid','total_all',
                'quantity', 'currency','unitprice', 'total','_token','_method','acname','addressofbank','bankname','acountno','swiftcode'
                ,'_token','_method']);
            foreach ($request->input('modelname') as $i => $v) {
                $data[] = array(
                    'modelname' => $request->input('modelname')[$i],
                    'description' => $request->input('description')[$i],
                    'quantity' => $request->input('quantity')[$i],
                    'currency'=>$request->input('currency')[$i],
                    'unitprice' => $request->input('unitprice')[$i],
                    'total' => $request->input('total')[$i]
                );
            }
            foreach ($request->input('modelname') as $i => $v) {
                $plofdata[] = array(
                    'orderid'=>$request->input('orderid'),
                    'no'=>$i,
                    'modelname' => $request->input('modelname')[$i],
                    'description' => $request->input('description')[$i],
                    'quantity' => $request->input('quantity')[$i],
                    'plsts'=>$request->input('plsts')[$i]
                );
            }
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $plofdata= json_encode($plofdata, JSON_UNESCAPED_UNICODE);
            $upinvoice['data']=$data;
            $pldata['data']=$plofdata;
            invoiceorder::where('orderid',$id)->update($upinvoice);
            //更新存入packlistdata
           packlistdata::where('orderid',$id)->update($pldata);

            echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
        }
        catch (\Exception $e){
            dd($e);
        }

    }


    public function destroy($id)
    {
        //
    }
}
