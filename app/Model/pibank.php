<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class pibank extends Model
{
    protected $table ='pibank';
    protected $guarded = [];
    protected $primaryKey = 'bankid';
    public $timestamps = false;

}
