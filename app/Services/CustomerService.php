<?php

namespace App\Services;

use App\Model\customer;
use Carbon\Carbon;

class CustomerService
{

function customerlist($page){

    return  customer::paginate($page);
}
function cust($id){
    //以ID抓取資料
    return customer::where('id',$id)->first();
}



}
