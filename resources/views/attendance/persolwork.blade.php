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
                        <option {{ isset($months)&&$months == date('Ym',strtotime('-3 month'))?'selected ' :''  }} value="<?php echo date('Ym',strtotime('-3 month')); ?>" ><?php echo  date('Y-m',strtotime('-3 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('-2 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('-2 month')); ?>" ><?php echo  date('Y-m',strtotime('-2 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('-1 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('-1 month')); ?>" ><?php echo date('Y-m',strtotime('-1 month')); ?></option>

                        <option {{ isset($months)&&$months == date('Ym')?'selected ' :''  }}value="<?php echo date('Ym'); ?>" ><?php echo date('Y-m'); ?></option>


                        <input type="submit" value="查詢" class="bt-search">
                    </select>
            </form></td><td>
            <input type="button" value="我要補卡" class="bt-add" onclick="window.open('{{route("checkin.create")}}','upcheckin',config='width=1000;height=600')"></td></tr>
                </table>
<br><br>
            <table border="1" align="center" class="bor-blue tbl" width="80%" >

                    <tr class="bg-blue">
                        <td><b>日期</b></td>
                        <td><b>日期</b></td>
                        <td><b>上班打卡時間</b></td>
                        <td><b>下班打卡時間</b></td>
                        <td><b>今日上班時間</b></td>
                    </tr>

                @foreach($checklist as $i=>$in)

                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$in->checkdate}}
                            @php $weekarray=array("日","一","二","三","四","五","六");
                            echo "(星期".$weekarray[date("w",strtotime($in->checkdate))].")";
                            @endphp
                        </td>
                        <td>@if($in->checkintime!=null){{$in->checkintime}}
                            @else<font color='red'>無資料</font>
                            @endif
                        </td>
                        <td>@if($in->checkouttime!=null){{$in->checkouttime}}
                            @else<font color='red'>無資料</font>
                            @endif
                        </td>
                        <td>
                            @if($in->checkintime!=null&&$in->checkouttime!=null)

                                    <?php echo floor(((strtotime($in->checkouttime) - strtotime($in->checkintime))/60));?>分鐘
                            @else
                            @endif
                        </td>

                    </tr>

                @endforeach
            </table>
            <br><br><br>
        </div>
    </div>
</div>
</body>

</html>
