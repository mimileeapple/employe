<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "員工出勤表";
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
    <script>

     /*   if () {
            alert('新增成功');
            self.opener.location.reload();
            window.close();
        } else {
            alert('新增失敗');
        }*/
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
            <form action="{{route("search_checkemp")}}" method="post">
                {{ csrf_field() }}

                <select name="empid" id="empid" style="width: 200px;">
                    @foreach($emp_list1 as  $emp)
                        <option {{ isset($empid)&&$empid ==$emp->empid?'selected ' :''  }}  value="{{$emp->empid}}">{{$emp->name}}&nbsp;&nbsp;{{$emp->ename}}</option>
                    @endforeach
                </select>
                    <select name="months" style="width: 150px;text-align: center">
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -3 month'))?'selected ' :''  }} value="<?php echo date('Ym',strtotime('last day of -3 month')); ?>" ><?php echo  date('Y-m',strtotime('last day of -3 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -2 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of -2 month')); ?>" ><?php echo  date('Y-m',strtotime('last day of -2 month'));; ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of -1 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of -1 month')); ?>" ><?php echo date('Y-m',strtotime('last day of -1 month')); ?></option>

                        <option {{ isset($months)&&$months == date('Ym')?'selected ' :''  }}value="<?php echo date('Ym'); ?>" ><?php echo date('Y-m'); ?></option>
                        <option {{ isset($months)&&$months == date('Ym',strtotime('last day of 1 month'))?'selected ' :''  }}value="<?php echo date('Ym',strtotime('last day of 1 month')); ?>" ><?php echo date('Y-m',strtotime('last day of 1 month')); ?></option>



                        <input type="submit" value="查詢" class="bt-search">
                    </select>
            </form></td><td>
             </table>
<br><br>
            @if(isset($latelist)&&count($latelist)>0)

                <table border="1" align="center" class="bor-blue tbl" width="90%" >
                    <thead>
                    <tr class="bg-blue">
                        <th><b>日期</b></th>
                        <th><b>上班打卡時間</b></th>
                        <th><b>下班打卡時間</b></th>
                        <th><b>遲到(分)</b></th>
                        <th><b>請假(分)</b></th>
                        <th><b>備註</b></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php  $tempkey=""; $tempdate="";$weekarray=array("日","一","二","三","四","五","六");@endphp
                    @foreach($latelist as $key=> $empno)
                        @if($tempdate!=$key)
                            <tr>
                                <td>{{$key}}@php echo "(".$weekarray[date("w",strtotime("$key"))].")" @endphp</td>

                                @endif
                                @foreach($empno as $i=>$time)
                                    @if($tempdate!=$key)
                                        <td>{{$empno['worktimein']}}</td>
                                        <td>{{$empno['worktimeout']}}</td>
                                        <td>@if((int)$empno['latemin']!=0&&$empno['latemin']!="-")
                                                @if((int)$empno['latemin']<0)
                                                    <font color="red"> {{(int)$empno['latemin']}}</font>

                                                @elseif((int)$empno['latemin']>0){{(int)$empno['latemin']}}
                                                @endif
                                            @else {{(int)$empno['latemin']}}
                                            @endif</td>
                                        <td>{{$empno['leavetime']}}</td>
                                        <td>
                                            @if($empno['leavetime']!="0分"&&$empno['leavetime']!="-")
                                                <a href="{{route("leaveorderdatilday", ['day'=>$key,'empid'=>Session::get('empid')])}}"
                                                   target="_blank">{{$empno['leavetime']}}</a>

                                            @endif
                                        </td>
                                    @endif
                                    @if($tempdate==$key)
                            </tr>
                        @endif

                        @php $tempdate=$key; @endphp

                    @endforeach
                    @endforeach
                    </tbody>
                    <tr><td colspan="3" style="text-align: right;">不足分鐘數小計:</td><td>{{$total}}分鐘-30分鐘<br>
                            <font color="red"> 本月遲到總計:{{$total+30}}分鐘</font></td><td></td></tr>
                </table>
            @else <font color="red">沒有資料</font>
@endif
            <br><br><br>
        </div>
    </div>
</div>
</body>

</html>
