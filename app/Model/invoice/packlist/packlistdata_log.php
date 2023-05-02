<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class packlistdata_log extends Model
{
    protected $table ='packlistdata_log';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'delid';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
