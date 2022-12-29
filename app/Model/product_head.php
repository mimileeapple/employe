<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class product_head extends Model
{
    protected $table ='product_head';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = false;
}
