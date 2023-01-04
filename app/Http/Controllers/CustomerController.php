<?php

namespace App\Http\Controllers;
use App\Model\customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $CustomerService;
    public function __construct()
    {

        $this->CustomerService=new CustomerService();
    }

    public function index()
    {
       $data=$this->CustomerService->customerlist(10);
       return view("customer.customerlist",['customerlist'=>$data]);
    }


    public function create()
    {
        $status = '';
        return view("customer.newcustomer", ['status' => $status]);
    }


    public function store(Request $request)
    {

        $data=$request->input();
        $status = customer::create($data);
        $customerlist = $this->CustomerService->customerlist(10);
        if ($status != false) {
            $status = true;
        }
        return view('customer.newcustomer', ['status' => $status], ['customerlist'=>$data]);
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

                return view('customer.updateCostomer', ['data' => $data, 'customerlist' => $customerlist, 'status' => true]);
            } else {
                //更新失敗

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

    }

}
