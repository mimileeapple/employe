<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class partdata_log extends Model
{
    protected $table ='partdata_log';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps =true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';}

