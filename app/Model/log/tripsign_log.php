<?php

namespace App\Model\log;

use Illuminate\Database\Eloquent\Model;

class tripsign_log extends Model
{
    protected $table ='tripsign_log';
//    protected $fillable =['orderid','empid','name','title','data','name','createmp'];
    protected $fillable =['orderid','empid','name','supervisorid','managerid',
        'financeid','supervisorname','managername','financename','supervisorsign',
        'managersign','financesign','supervisormail','managermail','financemail',
        'signsts','ordersts','createmp','updateemp','action'];
//    protected $guarded = [];
    //PK要改
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}
