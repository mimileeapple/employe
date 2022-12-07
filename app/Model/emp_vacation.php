<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class emp_vacation extends Model
{
    protected $table ='emp_vacation';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
