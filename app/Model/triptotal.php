<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class triptotal extends Model
{
    protected $table ='triptotal';

    protected $fillable =['orderid','triptotal','advancedetails','advancecurrency','advanceamount','advancerate','advanceconvert_T',
        'advanceremark','advancereturndetails','advancereturncurrency','advancereturnamount','advancereturnrate','advancereturnconvert_T'
        ,'advancereturncurrency','advancereturnremark','copeemptotal'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'orderid';
    //$timestamps 這是自動更新時間 你沒有欄位的話  你要把它關閉
    public $timestamps = false;

}
