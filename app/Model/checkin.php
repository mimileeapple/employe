<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class checkin extends Model
{
    protected $table ='checkin';
    protected $fillable =['id','empid','empname','yearmonths','checkdate','worktimein',
        'worktimeout','checkin','checkout','insertsts','upcheckworkinstsname','checkinsts','upcheckworkoutstsname',
        'checkoutsts','creatdate','createemp','updatedate','updateemp'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';

}
