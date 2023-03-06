<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class piheade extends Model
{
    protected $table ='piheade';
    protected $fillable  =['orderdate','pino','pipm','companyid','pipayarea','ouraddress','taxid','receiptnotes','shippingnotes',
        'piselect','pidate','piitem','billcompanyname','billaddress','billtel',
        'shipcompanyname','shipaddress','shiptel','sts','creatdate','createmp','updatedate','updateemp'];
    protected $guarded = [];
    protected $primaryKey = 'id';
    public $timestamps = true;
    const CREATED_AT = 'creatdate';
    const UPDATED_AT = 'updatedate';
}










