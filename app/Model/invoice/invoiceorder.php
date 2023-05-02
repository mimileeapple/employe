<?php

namespace App\Model\invoice;

use Illuminate\Database\Eloquent\Model;

class invoiceorder extends Model
{
    protected $table ='invoiceorder';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
