
<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "首頁";
?>

    <!DOCTYPE html>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="img/pageicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title ?></title>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-size: 10pt;
            font-family: 微軟正黑體, Arial, Helvetica, sans-serif;
        }

        .content {
            display: flex;
            height: 100%;
            padding: 0;
        }

        .content > div {
            border: px solid gray;
            padding: 6px;
            /* 設定 border-box，width 要內含 padding 與 border */
            box-sizing: border-box;
        }

        .col1 {
            /* flex-basis 優先於 width 或 height */
            flex-basis: 250px;
            flex-grow: 0;
            flex-shrink: 0;
        }

        .col2 {
            /* 以下寫法相當於 flex-grow: 1; flex-shrink: 2; flex-basis: 400px; */
            flex: 1 2 400px;
        }

        div {
            padding: 6px;
        }

        /* .disp { background-color:teal; color: yellow; height: 1em; }*/


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

            <img src="{{ URL::asset('img/post1.jpg') }}" width="1200px;">


            <table border="1" width="88%" class="tbl  " style="text-align: center;" align="center">

                <tr class="bg-blue">
                    <td>編號</td>
                    <td> 時間</td>
                    <td>類別</td>
                    <td>標題</td>
                    <td>發佈人</td>
                </tr>
                @foreach($boardlist as $k=> $e)
                    <tr>
                        <td> {{$k+1}}</td>
                        <td>{{$e->boarddate}}</td>
                        <td>{{$e->type}}</td>
                        <td><a href="{{route('showboard',['id'=>$e->id])}}" target="_blank">{{$e->title}}</a></td>
                        <td>{{$e->dep}}{{$e->createmp}}</td>
                    </tr>
                @endforeach

            </table>
            <br>
            <img src="{{ URL::asset('img/post3.jpg') }}" width="1200px;" style="margin-top: -2px;margin-left: -5px;">

        </div>
    </div>
</div>


</body>
</html><?php
