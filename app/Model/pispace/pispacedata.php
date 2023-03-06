<?php

namespace App\Model\pispace;

use Illuminate\Database\Eloquent\Model;

class pispacedata extends Model
{
    protected $table ='pispacedata';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
