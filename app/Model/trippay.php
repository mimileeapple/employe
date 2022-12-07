<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class trippay extends Model
{
    protected $table ='trippay';
    protected $fillable =['orderid','empid','name','title','data','name','createmp','updateemp'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'orderid';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}

