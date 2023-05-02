<?php

namespace App\Model\invoice\packlist;

use Illuminate\Database\Eloquent\Model;

class packlistorder extends Model
{
    protected $table ='packlistorder';
    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
