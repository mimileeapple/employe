<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "請假單簽核已結案(歷史資料)";
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
    <style>
        input [type="text"] {
            width: 80px;
        }
    </style>

</head>
<body style="text-align: center">
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
            @if(count($emp_list)>0)
            <table border="1" align="center" class="bor-blue tbl" width="100%">
                <tr class="bg-blue">

                    <td><b>單號</b></td>
                    <td><b>明細</b></td>
                    <td><b>申请時間</b></td>
                    <td><b>假別</b></td>
                    <td><b>姓名</b></td>
                    <td><b>事由</b></td>
                    <td><b>備註</b></td>
                    <td><b>部門</b></td>
                    <td><b>職位</b></td>
                    <td><b>職務代理人</b></td>
                    <td><b>起始時間</b></td>
                    <td><b>結束時間</b></td>
                    <td><b>總計時間</b></td>
                    <td><b>訂單狀態</b></td>
                    <td><b>附件</b></td>
                </tr>
                {{--                放在foreach 會導致ID重複 submit只會送出第一個--}}

                    @foreach($emp_list as  $emp)
                        <tr>

                            <td>{{$emp->orderid}}</td>
                            <td><input type="button" value="明細" class="bt-admit"
                                       onclick="window.open('{{route('orderdetail',['p'=>$emp->orderid])}}','newemp','width=500px;height=500px')">
                            </td>
                            <td>{{$emp->orderdate}}</td>
                            <td>{{$emp->leavefakename}}</td>
                            <td>{{$emp->name}}</td>
                            <td> {{$emp->reason}}</td>
                            <td>{{$emp->note}}</td>
                            <td>{{$emp->pname}}</td>
                            <td>{{$emp->title}}</td>
                            <td>{{$emp->agentemp}}</td>
                            <td>{{$emp->leavestart}}</td>
                            <td>{{$emp->leaveend}}</td>
                            <td>{{$emp->hours}}時</td>
                            <td> {{$emp->signsts}} </td>
                            @if($emp->uploadfile!='')
                                <td><a target="_blank" href="{{url('../'.$emp->uploadfile)}}">附件</a></td>
                            @else
                                <td></td>
                            @endif

                        </tr>
                @endforeach

            </table>
                @if($emp_list->count()>2)
                {{$emp_list->links()}}
                  @endif
            @else <font color="red">沒有資料</font>
        @endif
            <br><br><br>
        </div>
    </div>
</div>

</body>

</html>
