<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class trippay_log extends Model
{
    protected $table ='trippay_log';
    protected $fillable =['orderid','empid','name','title','data','name','createmp','updateemp','action'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
