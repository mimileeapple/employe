<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "上傳考勤表";
date_default_timezone_set('Asia/Taipei');
$today = date('Y-m-d H:i:s');
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
    if({{$status}}==true){
        alert('上傳成功');
    }
    </script>


</head>
<body style="text-align:center;">
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

            <form action="{{route('importcheckin.store')}}" method="post" id="form1" enctype="multipart/form-data">

                {{ csrf_field() }}
                <table align="center" class=" tbl" width="70%">

                    <tr class="bg-blue">

                        <td>選擇上傳檔案</td>
                    </tr>
                    <tr>

                        <td>
                            <input type="file" name="file1" id="file1">
                            <input type="hidden" name="createemp" value="{{Session::get('name')}}">
                            <input type="hidden" name="creatdate" value="{{$today}}">
                            <input type="hidden" name="updateemp" value="{{Session::get('name')}}">
                            <input type="hidden" name="updatedate" value="{{$today}}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" value="上傳" class="bt-add"></td>
                    </tr>

                </table>
            </form>


            <br><br><br>
        </div>
    </div>
</div>

</body>

</html>
