<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class leaveorder_log extends Model
{
    protected $table ='leaveorder_log';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
