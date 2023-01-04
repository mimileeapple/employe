<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $table ='customer';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
