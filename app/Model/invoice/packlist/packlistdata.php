<?php

namespace App\Model\invoice\packlist;

use Illuminate\Database\Eloquent\Model;

class packlistdata extends Model
{
    protected $table ='packlistdata';
    protected $fillable =['orderid','pino','billcompanyname','shipcompanyname','billaddress',
        'shipaddress','billtel','shiptel','data','ourarea',
        'ouraddress','ourtel','ourfax','creatdate','createmp',
        'updatedate','updateemp','sts'];

    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
