<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "個人出勤表";
date_default_timezone_set('Asia/Taipei');
$date = date("Y-M-D");

?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title ?></title>
    <style>
        input [type="text"] {
            width: 80px;
        }
    </style>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.5/css/theme.blue.min.css"></link>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.30.5/js/jquery.tablesorter.min.js"></script>   <script>
        $("#myTable").tablesorter({
            theme: "blue",
            widgets: ['zebra']
        });
    </script>

</head>
<body style="text-align: center" onUnload="opener.location.reload()">
@include("include.nav")
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @include("include.menu")
        <div class="col-md-10">
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>
            <br>
                <table><tr><td>
            <form action="{{route("search_checkin")}}" method="post">
                {{ csrf_field() }}

                    <input type="hidden" name="empid" value="{{Session::get('empid')}}">
                    <select name="months" style="width: 150px;text-align: center">
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -3 month'))?'selected ' :''  }} value="<?php echo date('Ym',strtotime('last day of -3 month')); ?>" ><?php echo  date('Y-m',strtotime('last day of -3 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -2 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of -2 month')); ?>" ><?php echo  date('Y-m',strtotime('last day of -2 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -1 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of -1 month')); ?>" ><?php echo date('Y-m',strtotime('last day of -1 month')); ?></option>

                        <option {{ isset($months)&&$months == date('Ym')?'selected ' :''  }}value="<?php echo date('Ym'); ?>" ><?php echo date('Y-m'); ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of 1 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of 1 month')); ?>" ><?php echo date('Y-m',strtotime('last day of 1 month')); ?></option>


                        <input type="submit" value="查詢" class="bt-search">
                    </select>
            </form></td><td>
            <input type="button" value="我要補卡" class="bt-add" onclick="window.open('{{route("checkin.create")}}','upcheckin',config='width=1000;height=600')"></td></tr>
                </table>
<br><br>


            <table border="1" align="center" class="bor-blue tbl tablesorter" width="80%" id="myTable">
                <thead>
                    <tr class="bg-blue">
                        <th><b>序號</b></th>
                        <th><b>日期</b></th>
                        <th><b>上班打卡時間</b></th>
                        <th><b>下班打卡時間</b></th>
                        <th><b>今日上班時間</b></th>
                        <th><b>備註</b></th>
                    </tr>
                </thead>
                <tbody>
                @php $alllatetime="";@endphp
                @foreach($checklist as $i=>$in)

                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$in->checkdate}}
                            @php $weekarray=array("日","一","二","三","四","五","六");
                            echo "(星期".$weekarray[date("w",strtotime($in->checkdate))].")";
                             $day=date("w",strtotime($in->checkdate));
                            @endphp
                        </td>
                        <td>@if($in->checkintime!=null){{$in->checkintime}}
                            @elseif($day==0||$day==6)
                            @else<font color='red'>無資料</font>
                            @endif
                        </td>
                        <td>@if($in->checkouttime!=null){{$in->checkouttime}}
                            @elseif($day==0||$day==6)
                            @else<font color='red'>無資料</font>
                            @endif
                        </td>
                        <td>
                            @if($in->checkintime!=null&&$in->checkouttime!=null)

                                @php $worktimes=floor(((strtotime($in->checkouttime) - strtotime($in->checkintime))/60));
                                        echo $worktimes @endphp 分鐘
                                <br> @php $reltime=540-(int)$worktimes; @endphp
                                @if($reltime>0)
                                    (<font color="red">不足{{$reltime}}分鐘)</font>
                                    @php $alllatetime=+$reltime; @endphp
                                @endif
                            @else
                            @endif
                        </td>
                        <td>
                            @if($in->leaveorder=="Y")
                            <a href="{{route("leaveorderdatilday", ['day'=>$in->checkdate,'empid'=>$in->empid])}}"
                               target="_blank">已請假</a>
                            @elseif($in->leaveorder=="N"&&($day==0||$day==6))
                            @elseif($in->leaveorder=="N"&&($day!=0||$day!=6))<font color="red">尚未請假</font>
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
                <tr><td colspan="4" style="text-align: right;">不足分鐘數小計:</td><td>{{$alllatetime}}分鐘</td><td></td></tr>
            </table>
            <br><br><br>
        </div>
    </div>
</div>
</body>

</html>
