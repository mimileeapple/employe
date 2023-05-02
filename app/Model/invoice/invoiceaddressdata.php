<?php

namespace App\Model\invoice;

use Illuminate\Database\Eloquent\Model;

class invoiceaddressdata extends Model
{
    protected $table ='invoiceaddressdata';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
