<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "客戶Packing List單";
date_default_timezone_set("Asia/Taipei");
?>
        <!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title><?php echo $title ?></title>
    <style>
        table{
            margin-left:auto;
            margin-right:auto;
        }
    </style>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>
            <br>
            <form action="{{route('showmodelname')}}" method="post" name="form1">
                {{ csrf_field() }}

            <table width="100%"  align="left" class="tbl bor-blue" style="margin: auto;">
                <tr>
                    <td class="bg-blue">勾選</td>
                    <td class="bg-blue">invoice號</td>
                    <td class="bg-blue">客戶名稱</td>
                    <td class="bg-blue">modelname</td>
                </tr>
                @foreach($invoice as $k=> $in)
<tr>

                <td>{{$in->orderid}}<input type="checkbox" name='orderid[]' value="{{$in->orderid}}"></td>
                <td>IV{{$in->pino}}</td>
                <td>{{$in->billcompanyname}}</td>
                <td> <table class="tbl" width="90%">
                        <tr><td>勾選</td><td>modelname</td><td>description</td><td>quantity</td><td>sts</td></tr>

                    @foreach($in['data'] as $i=>$d)

                            <tr><td>
                     @if($d['plsts']=="Y")
                         <input type="checkbox" name='data[]' disabled ></td>
                    @else
                         <input type="checkbox" name='data[]' value="{{$in->orderid}},{{$d['no']}},{{$d['modelname']}},{{$d['description']}},{{$d['quantity']}},Y"></td>
                    @endif
                                <td>{{$d['modelname']}}
                                </td>
                                <td>{{$d['description']}}</td>
                                <td>{{$d['quantity']}}</td>
                                <td>@if($d['plsts']=="Y")
                                    <font color="red">{{$d['plsts']}}</font>
                                    @else
                                    {{$d['plsts']}}
                                    @endif

                  </td></tr>
                        @endforeach

                    </table>
                </td>
            </tr>@endforeach

                    <input type="hidden" name="createemp" value="{{Session::get('name')}}">
                    <input type="hidden" name="updateemp" value="{{Session::get('name')}}">
                <tr><td colspan="4"><input type="submit" class="bt-add" value="新增packlist單">
                        </td></tr>

            </table>

            </form>
<br><br><br><br><br><br>
        </div>
    </div>
</div>
<br><br><br><br><br><br>
</body>
</html><?php
