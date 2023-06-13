<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "出勤單總表";
date_default_timezone_set('Asia/Taipei');
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

    <script>

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
            <form action="selectmonth" method="post">
                {{ csrf_field() }}
                <div style="text-align: left;">
                    <select name="sreachdateorder" style="width: 150px;text-align: center">

                        <option
                                {{ isset($selected)&&$selected == date('Y-m',strtotime('-3 month'))?'selected ' :''  }} value="<?php echo date('Y-m',strtotime('-3 month')); ?>"><?php echo date('Y-m', strtotime('-3 month'));; ?></option>
                        <option
                                {{ isset($selected)&&$selected == date('Y-m',strtotime('-2 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-2 month')); ?>"><?php echo date('Y-m', strtotime('-2 month'));; ?></option>
                        <option
                                {{ isset($selected)&&$selected == date('Y-m',strtotime('-1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-1 month')); ?>"><?php echo date('Y-m', strtotime('-1 month')); ?></option>

                        <option
                                {{ isset($selected)&&$selected == date('Y-m')?'selected ' :''  }}value="<?php echo date('Y-m'); ?>"><?php echo date('Y-m'); ?></option>
                        <option
                                {{ isset($selected)&&$selected == date('Y-m',strtotime('+1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('+1 month')); ?>"><?php echo date('Y-m', strtotime('+1 month')); ?></option>
                    </select>
                    <input type="submit" value="查詢" class="bt-search">

                </div>
            </form>
            <br>
            @isset($emp_list)
                <table border="1" align="center" class="bor-blue tbl styletable" width="100%"
                       id="myTable" style="font-size: 8px;">
                    <thead>

                    <tr class="bg-blue">
                        <td rowspan="2">日期/姓名</td>
                    @foreach($emp_list as  $k=>$emp)
                            <td colspan="4">{{$emp->name}}<br>{{$emp->ename}}</td>
                    @endforeach
                    </tr>
                    <tr class="bg-blue">
                        @foreach($emp_list as  $k=>$emp)
                        <td >上班</td><td>下班</td><td>遲到(分)</td><td>請假(分)</td>
                        @endforeach
                    </tr>

                    </thead>
                    @php  $tempkey=""; $tempdate="";$weekarray=array("日","一","二","三","四","五","六");@endphp
                    @foreach($latelist as $key=> $empno)
                        @if($tempdate!=$key)
                            <tr>
                                <td>{{$key}}@php echo "(".$weekarray[date("w",strtotime("$key"))].")" @endphp</td>
                        @endif

                                @foreach($empno as $i=>$time)
                                     <td>{{$time['worktimein']}}</td>
                                    <td>{{$time['worktimeout']}}</td>
                                    <td>{{$time['latemin']}}</td>
                                    <td>{{$time['leavetime']}}</td>
                    @if($tempdate==$key)
                            </tr>
                    @endif


                              @endforeach
                    @php $tempdate=$key; @endphp

                    @endforeach

                    <tr> <td>總共遲到(分)：</td>

                        @foreach($total as  $latetime)
                            <td colspan="4">
                                {{$latetime}}分
                            </td>
                    @endforeach
                    </tr>
                    <tr> <td>實際遲到：</td>

                        @foreach($total as  $latetime)
                            <td colspan="4">
                                @if($latetime<-30)
                                 {{$latetime}}分+30分(緩衝時間)<br>
                                   總計: <font color="red">{{$latetime+30}}分</font>
                                @elseif($latetime>-30)
                                總計:0分
                                    @endif
                            </td>

                        @endforeach
                    </tr>
                </table>
            @endisset

            <br><br><br>
        </div>
    </div>
</div>
<script>

</script>
</body>

</html>
