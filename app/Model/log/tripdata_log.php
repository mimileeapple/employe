<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class tripdata_log extends Model
{
    protected $table ='tripdata_log';
    protected $fillable  =['orderid','empid','name','title','leavestart','leaveend','createmp','updateemp','trip_reason',
        'startarea','endarea','worknote','action'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;

    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
