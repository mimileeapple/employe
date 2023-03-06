<?php

namespace App\Model\pispace;

use Illuminate\Database\Eloquent\Model;

class pispaceorder extends Model
{
    protected $table ='pispaceorder';
    protected $fillable  =['id','orderid','pino','orderdate','spacedata',
        'buyer','seller','createmp','creatdate','updateemp','updatedate'];
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;

    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}








