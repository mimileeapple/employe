<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tripdata extends Model
{
    protected $table ='tripdata';
    protected $fillable  =['orderid','empid','name','title','leavestart',
        'leaveend','createmp','updateemp','trip_reason','startarea','endarea','worknote'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'orderid';
    public $timestamps = true;

    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
