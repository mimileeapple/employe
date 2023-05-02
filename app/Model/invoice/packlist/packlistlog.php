<?php

namespace App\Model\invoice\packlist;

use Illuminate\Database\Eloquent\Model;

class packlistlog extends Model
{
    protected $table ='packlistlog';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
