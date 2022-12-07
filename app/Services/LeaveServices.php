<?php

namespace App\Services;
use App\Model\leaveorder;
class LeaveServices
{
    function findpersonalleave($empid,$leavefakeid,$months,$days){
   return leaveorder::where('leavefakeid',$leavefakeid)->where('leavestart' >= '$months' and 'leaveend' <= '$days')->where('empid',$empid);
    }

}
