<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class empinfo extends Model
{
    //這個變數內定就是表的名字
    protected $table ='empinfo';
    protected $guarded = [];
    protected $primaryKey = 'empid';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';


}
