<?php

namespace App\Http\Controllers\office;
use App\Model\office\feetype;
use App\Model\office\officepay;
use Illuminate\Http\Request;

class PayofficeController
{

    public function index()
    {
        $paylist=officepay::where('sts','not like','D')->orderBy('id', 'desc')->get();
        //分類查詢
        $fee=feetype::all();

        return view('office.pay.officepay',['paylist'=>$paylist,'fee'=>$fee]);

    }


    public function create()

    {
        //跳至新增頁面
       $fee= feetype::all();
       return view('office.pay.newpay',['fee'=>$fee]);
    }


    public function store(Request $request)
    {
        //新增
        $pay=$request->input();
        $feeid=$request->input('feeid');
        $fee=feetype::where('id',$feeid)->get();
        foreach ($fee as $f){
         $pay['feetype']=$f->feetype;
         $pay['feename']=$f->feename;
        }
        officepay::create($pay);
        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
    }


    public function show($id)
    {
        //列印

        $paylist=officepay::where('id',$id)->get();
        return view('office.pay.printpay',['paylist'=>$paylist]);
    }


    public function edit($id)
    {
    //跳轉至update頁面
        $fee= feetype::all();
        $paylist=officepay::where('id',$id)->get();
        return view('office.pay.uppay',['paylist'=>$paylist,'fee'=>$fee]);
    }


    public function update(Request $request, $id)
    {
        $today = date('Y-m-d H:i:s');
        $pay=$request->input();
        $feeid=$request->input('feeid');
        $fee=feetype::where('id',$feeid)->get();
        foreach ($fee as $f){
            $pay['feetype']=$f->feetype;
            $pay['feename']=$f->feename;
        }
        $paydate=officepay::where('id',$id)->value('paydate');
        if($request->input('sts')=='Y'&&($paydate==''||$paydate==null)){
            $pay['paydate']=$today;
        }
        officepay::find($id)->update($pay);
        echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
    }


    public function destroy(Request $id)
    {
        //軟刪除
        $id = $id->input('id');
        officepay::where('id',$id)->update(['sts'=>'D']);

    }
    public function searchpaytype(Request $request){
        $fee=feetype::all();
        $feeid= $request->input('feename');

       $paylist= officepay::where('feeid',$feeid)->where('sts','not like','D')->get();
        return view('office.pay.officepay',['paylist'=>$paylist,'fee'=>$fee]);
    }
}
