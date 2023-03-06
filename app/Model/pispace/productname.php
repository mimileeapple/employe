<?php

namespace App\Model\pispace;

use Illuminate\Database\Eloquent\Model;

class productname extends Model
{
    protected $table ='productname';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps =true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';}
