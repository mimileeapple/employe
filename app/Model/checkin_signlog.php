<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class checkin_signlog extends Model
{
    protected $table ='checkin_signlog';
    protected $fillable  =['id','checkinid','empid','empname','yearmonths','checkdate','worktimein',
        'worktimeout','checkin','checkout','reason','checkworkinsts','checkworkoutsts','sign','signemp',
        'signdate','creatdate','createemp','updatedate','updateemp'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
