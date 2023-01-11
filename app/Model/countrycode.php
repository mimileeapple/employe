<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class countrycode extends Model
{
    protected $table ='countrycode';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
  
}
