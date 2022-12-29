<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class checkin_log extends Model
{
    protected $table ='checkin_log';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
