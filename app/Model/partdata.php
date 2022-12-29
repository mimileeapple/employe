<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class partdata extends Model
{
    protected $table ='partdata';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps =true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';}
