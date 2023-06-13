<?php

namespace App\Http\Controllers\china;
use App\Services\ChinaServices;
use Illuminate\Http\Request;

class EmpchinaController
{
    private $ChinaServices;
    public function __construct()
    {
        $this->ChinaServices=new ChinaServices();
    }
    public function index()
    {
        $emp_list = $this->ChinaServices->emp_list_china(10);
        $emp_list1=$this->ChinaServices->select_emp_china();
        return view('china.empmanage.hrsys.employees',['emp_list'=>$emp_list,'emp_list1'=>$emp_list1]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

    }


    public function show($id)
    {

          }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {
        //
    }
}
