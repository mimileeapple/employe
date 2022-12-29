<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class checkin extends Model
{
    protected $table ='checkin';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';

}
