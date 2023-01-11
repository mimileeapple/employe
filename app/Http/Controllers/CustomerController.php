<?php

namespace App\Http\Controllers;
use App\Model\countrycode;
use App\Model\customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Session;
class CustomerController extends Controller
{
    private $CustomerService;
    public function __construct()
    {

        $this->CustomerService=new CustomerService();
    }

    public function index()
    {

        $custlist=customer::all();
        $id=Session::get('custtitle');
        if($id!=""){

            $data=$this->CustomerService->sreachcust($id);
            Session::forget('custtitle');
            return view("customer.customerlist",['customerlist'=>$data,'custlist'=>$custlist,'cnoid'=>$id]);
        }
        else{
            $data=$this->CustomerService->customerlist(10);
            $id="";
            return view("customer.customerlist",['customerlist'=>$data,'custlist'=>$custlist,'cnoid'=>$id]);
        }
//        $data=$this->CustomerService->customerlist(10);
//        $custlist=customer::all();
//        return view("customer.customerlist",['customerlist'=>$data,'custlist'=>$custlist]);

    }


    public function create()
    {
        $status = '';
        $custlist=countrycode::all();
        return view("customer.newcustomer", ['status' => $status,'custlist'=>$custlist]);
    }


    public function store(Request $request)
    {

        $data=$request->input();
        $status = customer::create($data);
        $customerlist = $this->CustomerService->customerlist(10);
        $countrynum=$request->input('countrynum');
        $countrycode=$request->input('countrycode');
        countrycode::where('country_code','like',$countrycode)->update(['codeno' => $countrynum]);
        $custlist=countrycode::all();
        if ($status != false) {
            $status = true;
        }
        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
        return view('customer.newcustomer',  ['customerlist'=>$data,'custlist'=>$custlist]);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $data = $this->CustomerService->cust($id);
        $status = '';
        return view('customer.updateCostomer', ['data' => $data, 'status' => $status]);
    }


    public function update(Request $request, $id)
    {
        try {

            $data = $request->input();
            $res = customer::find($id)->update($data);
            $customerlist = $this->CustomerService->customerlist(10);
            if ($res) {
                //更新成功
                echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
                return view('customer.updateCostomer', ['data' => $data, 'customerlist' => $customerlist, 'status' => true]);
            } else {
                //更新失敗
                echo " <script>alert('修改失敗'); self.opener.location.reload();window.close(); </script>";
                return view('customer.updateCostomer', ['data' => $data, 'customerlist' => $customerlist, 'status' => false]);
            }
        }
        catch (Exception $e){
            dd($e);
    }
    }


    public function destroy($id)
    {
        //
    }
    public function searchcustomer(Request $request){
        $custtitle=$request->input('abbreviation');
        $customerlist=customer::all();
        $data=$this->CustomerService->sreachcust($custtitle);
        Session::put('custtitle',$custtitle);
        return redirect()->route('customer.index',['customerlist'=>$customerlist,'custlist'=>$data]);
    }

}
