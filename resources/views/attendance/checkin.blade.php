<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "打卡系統";
date_default_timezone_set('Asia/Taipei');
$date = date("Y-m-d H:i:s");

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
        tr{
            height:80px;
        }
    </style>
    <script>
        function paddingLeft(str,lenght){
            if(str.length >= lenght)
                return str;
            else
                return paddingLeft("0" +str,lenght);
        }
        function ShowTime(){
            var NowDate=new Date();
            var y=NowDate.getFullYear();
            var mo=NowDate.getMonth()+1;
            var d=NowDate.getDate();
            var h=NowDate.getHours();
            var m=NowDate.getMinutes();
            var s=NowDate.getSeconds();
        var month=paddingLeft(mo,2);
        var day=paddingLeft(d,2);
            document.getElementById('showbox').innerHTML =y+'年'+month+'月'+day+'日'+ h+'時'+m+'分'+s+'秒';
            setTimeout('ShowTime()',1000);
        }

    </script>

</head>
<body style="text-align: center" onload="ShowTime()">
@include("include.nav")
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m"><?php echo $title ?></h2>
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

<form action="{{route('checkin.store')}}" method="post" id="form1">

    {{ csrf_field() }}
            <table   align="center" class=" tbl" width="70%" >

                    <tr>
                        <td><b class="title-s">目前時間</b></td>
                    </tr>
                    <tr>
                        <td><b class="title-m" style="color: black"><div id="showbox"></div></b></td>
                    </tr>
                <tr>
                    <td>
                        <input type="button" id="checkin" value="上班打卡" class="bt-send" style="width: 120px;height: 40px;" >
                        <input type="button" id="checkout" value="下班打卡" class="bt-search" style="width: 120px;height: 40px;">
         </td>
                    <input type="hidden" name="empid" value="{{Session::get('empid')}}">
                    <input type="hidden" name="empname" value="{{Session::get('name')}}">
                    <input type="hidden" name="worktimein" id="worktimein" value="{{$date}}">
                    <input type="hidden" name="worktime" id="worktime" value="{{$date}}">
                    <input type="hidden" name="yearmonths" value="{{date("Ym")}}">
                    <input type="hidden" name="checkdate" value="{{date("Y-m-d")}}">
                    <input type="hidden" id="btnactionin" name="btnactionin" value="">
                    <input type="hidden" id="btnactionout" name="btnactionout" value="">
                    <input type="hidden" id="btnactionid" name="btnactionid" value="">
                </tr>
            </table></form>

            <br><br><br>
        </div>
    </div>
</div>
</body>

</html>
<script>
    $(document).ready(function() {
        $("#checkin").click(function(){
            $("#btnactionid").val(0);
            $("#btnactionin").val("上班");
            $("#worktime").val('');

            data = $('#form1').serializeArray()
          // console.log(data)
            $.ajax({
                type: "post",
                dataType: "JSON",
                url: '{{route('checkin.store')}}',
                data: {_token: "{{ csrf_token() }}",data:data},
                success: function (response) {
                    if(response.status){
                        alert('打卡成功')
                    }else {
                        alert('打卡失敗')
                    }

                },
                error: function (thrownError) {
                   alert('error')
                }
            });
        });
        $("#checkout").click(function(){
            $("#btnactionid").val(1);
            $("#btnactionout").val("下班");
            data = $('#form1').serializeArray();
            $("#worktimein").val('');
            $.ajax({
                type: "post",
                dataType: "JSON",
                url: '{{route('checkin.store')}}',
                data: {_token: "{{ csrf_token() }}",data:data},
                success: function (response) {
                    if(response.status){
                        alert('打卡成功')
                    }else {
                        alert('打卡失敗')
                    }

                },
                error: function (thrownError) {
                    alert('error')
                }
            });
        });

    });

</script>
