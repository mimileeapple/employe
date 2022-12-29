<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class triptotal_log extends Model
{
    protected $table ='triptotal_log';

    protected $fillable =['orderid','triptotal','advancedetails','advancecurrency','advanceamount','advancerate','advanceconvert_T',
        'advanceremark','advancereturndetails','advancereturncurrency','advancereturnamount','advancereturnrate','advancereturnconvert_T'
        ,'advancereturncurrency','advancereturnremark','copeemptotal','action'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    //$timestamps 這是自動更新時間 你沒有欄位的話  你要把它關閉
    public $timestamps = false;

}
