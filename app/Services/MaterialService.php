<?php

namespace App\Services;
use App\Model\partdata;
use Mail;
use DB;
use Session;
use Carbon\Carbon;

class MaterialService
{
    function partlist($page)
    {//分頁
        return partdata::paginate($page);
    }
    function takedate(){
        return partdata::where('id',1)->value('creatdate');
    }

}
