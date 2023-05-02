<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pidata extends Model
{
    protected $table ='pidata';
    protected $fillable  =['pino','data','total_all','deliveryterm','depayposit','payment',
        'depositamount','depositmethod','finalpay','finalamount','finalmethod','shipdate','ouraddress',
        'acname','addressofbank','bankname','acountno','swiftcode','sts','note','creatdate','createmp','updatedate','updateemp'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}











