<?php

namespace App\Http\Controllers;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use App\Model\customer;
use App\Model\piheade;
use App\Model\pidata;
use Session;
class custPIController extends Controller
{
    private $CustomerService;
    public function __construct()
    {

        $this->CustomerService=new CustomerService();
    }
    public function index()
    {

        $custalllist=customer::all();
        $id=Session::get('custid');

        if($id!=""){
            $maxno=piheade::where('companyid','like',$id)->max('piitem');

            if($maxno==null){
                $maxno="01";
            }
            else{
                $maxno=$maxno+1;
                $maxno=str_pad($maxno,2,'0',STR_PAD_LEFT);
            }
            $data=customer::where('companyid','like',$id)->get();
            Session::forget('custid');
            return view("customer.PI.newPI",['custalllist'=>$custalllist,'custlist'=>$data,'cid'=>$id,'maxno'=>$maxno]);
        }
        else{
            $data="";
            $id="";
            $maxno="";
            return view("customer.PI.newPI",['custalllist'=>$custalllist,'custlist'=>$data,'cid'=>$id,'maxno'=>$maxno]);
        }




    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //dd( $request->input());
        try {

                $inp = $request->input();
                $inp['orderdate'] = $request->input()['orderdate'];
                $inp['pino'] = $request->input()['pino'];
                $inp['pipm'] = $request->input()['pipm'];
                $inp['companyid'] = $request->input()['companyid'];
                $inp['pipayarea'] = $request->input()['pipayarea'];
                $inp['piselect'] = $request->input()['piselect'];
                $inp['pidate'] = $request->input()['pidate'];
                $inp['piitem'] = $request->input()['piitem'];
                $inp['billcompanyname'] = $request->input()['billcompanyname'];
                $inp['billaddress'] = $request->input()['billaddress'];
                $inp['billtel'] = $request->input()['billtel'];
                $inp['shipcompanyname'] = $request->input()['shipcompanyname'];
                $inp['shipaddress'] = $request->input()['shipaddress'];
                $inp['shiptel'] = $request->input()['shiptel'];
                $inp['sts'] = $request->input()['sts'];
                $inp['creatdate'] = $request->input()['creatdate'];
                $inp['updatedate'] = $request->input()['updatedate'];
                $inp['createmp'] = $request->input()['createmp'];
                $inp['updateemp'] = $request->input()['updateemp'];
                $inp = array_except($inp, ['modelname', 'description', 'quantity', 'unitprice', 'total']);
                piheade::create($inp);
                $status = true;
        } catch (\Exception $e) {
                dd($e);
        }
        try {
            foreach ($request->input('modelname') as $i => $v) {
                $data[] = array('modelname' => $request->input('modelname')[$i],
                    'description' => $request->input('description')[$i],
                    'quantity' => $request->input('quantity')[$i],
                    'unitprice' => $request->input('unitprice')[$i],
                    'total' => $request->input('total')[$i]
                );
            }
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $d = $request->input();
            $d['data'] = $data;
            $d['pino'] = $request->input()['pino'];
            $d['total_all'] = $request->input()['total_all'];
            $d['deliveryterm'] = $request->input()['deliveryterm'];
            $d['depayposit'] = $request->input()['depayposit'];
            $d['depositamount'] = $request->input()['depositamount'];
            $d['depositmethod'] = $request->input()['depositmethod'];

            $d['finalpay'] = $request->input()['finalpay'];
            $d['finalamount'] = $request->input()['finalamount'];
            $d['finalmethod'] = $request->input()['finalmethod'];

            $d['shipdate'] = $request->input()['shipdate'];
            $d['acname'] =$request->input()['acname'];
            $d['addressofbank'] = $request->input()['addressofbank'];
            $d['bankname'] = $request->input()['bankname'];
            $d['acountno'] = $request->input()['acountno'];
            $d['swiftcode'] = $request->input()['swiftcode'];
            $d['note'] = $request->input()['note'];
            $d['creatdate'] = $request->input()['creatdate'];
            $d['createmp'] = $request->input()['createmp'];
            $d['updatedate'] = $request->input()['updatedate'];
            $d['updateemp'] =$request->input()['updateemp'];
            pidata::create($d);

        } catch (\Exception $e) {
            dd($e);
        }

    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
    public function searchcust(Request $request){

        $custid=$request->input('custid');

        $data=customer::where('companyid','like',$custid)->get();
        $maxno=piheade::where('companyid','like',$custid)->max('piitem');

        if($maxno==null){
            $maxno="01";
        }
        else{
            $maxno=$maxno+1;
            $maxno=str_pad($maxno,2,'0',STR_PAD_LEFT);
        }
        $custalllist=customer::all();
        Session::put('custid',$custid);
        return redirect()->route('custPI.index',['custalllist'=>$custalllist,'custlist'=>$data,'cid'=>$custid,'maxno'=>$maxno]);
    }
}
