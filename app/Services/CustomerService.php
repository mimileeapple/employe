<?php

namespace App\Services;

use App\Model\customer;
use App\Model\pispace\pispacedata;
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
function findspaceid($id){
    return pispacedata::where('id',$id)->value('spacecode');
}
function findspacesales($id)
{
    return pispacedata::where('id',$id)->value('oderspacdescript');
}
    function usetitlefindall($id)
    {
        return pispacedata::where('id',$id)->value('oderspactype');
    }
}
