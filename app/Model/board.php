<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class board extends Model
{
    protected $table ='board';
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';

}
