<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table ='product';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
