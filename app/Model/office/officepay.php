<?php

namespace App\Model\office;

use Illuminate\Database\Eloquent\Model;

class officepay extends Model
{
    protected $table ='officepay';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';

}
