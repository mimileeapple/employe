<?php

namespace App\Services;
use App\Model\empinfo;
use App\Model\leaveorder;
class ChinaServices
{

      function emp_list_china($page)
         {//大陸員工//分頁
             return empinfo::where('jobsts','like','Y')->where('depareaid','not like','T')->paginate($page);
         }
    function select_emp_china()
    {//抓全部
        return empinfo::where('jobsts','like','Y')->where('depareaid','not like','T')->get();
    }
    function finshsign_china($page)
    {//搜尋需要結案的單子
        //
        return leaveorder::where('signsts', '=', '2')->where('ordersts', '<>','D')->where('depareaid','not like','T')->paginate($page);
    }
    function historysignfinshchina($page)
    {
        return leaveorder::where('signsts', '=', 3)->where('ordersts', '=', 'Y')->where('area','not like','T')->paginate($page);
    }
    function finshsignchina($page)
    {//搜尋需要結案的單子
        //
        return leaveorder::where('signsts', '=', '2')->where('ordersts', '<>','D')->where('area','not like','T')->paginate($page);
    }
}
