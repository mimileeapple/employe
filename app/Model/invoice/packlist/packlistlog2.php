<?php

namespace App\Model\invoice\packlist;

use Illuminate\Database\Eloquent\Model;

class packlistlog2 extends Model
{
    protected $table ='packlistlog2';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'delid';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
