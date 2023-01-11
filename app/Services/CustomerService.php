<?php

namespace App\Services;

use App\Model\customer;

class CustomerService
{

function customerlist($page){

    return  customer::paginate($page);
}
function cust($id){
    //以ID抓取資料
    return customer::where('id',$id)->first();
}
function custall(){
    return customer::all();
}
function sreachcust($abbreviation){
    return customer::where('abbreviation','like',$abbreviation)->get();
}
function findcountrymaxnum($code){

}

}
