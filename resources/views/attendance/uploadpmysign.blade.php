<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "上傳個人電子簽名";

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
        tr{height: 35px;}
    </style>

</head>
<body style="text-align: center" >
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title?></h2>

<a id="gotop">
    <font size="20px"> ^</font>
</a>
<br><br>
<table width="50%"  style="margin: auto" class="tbl bor-blue">

<form method="post"  action="{{route('uploadpicsign')}}" enctype='multipart/form-data' id="form1" class="form1">
    {{ csrf_field() }}

    <tr><td  class="bg-blue">員工編號</td><td>{{Session::get("empid")}}</td></tr>
    <tr><td class="bg-blue">姓名</td><td>{{Session::get("name")}}</td></tr>
    @php $mysign=Session::get('empdata')->mysign;
    if($mysign!=""){
        echo "<tr><td colspan='2'><font color='red'>你已有上傳的圖片，再次上傳會覆蓋原本檔案</font><td></tr>";
    }
    @endphp
{{$mysign}}
    <tr>
    <td colspan="2">
        <input type="file" id="uploadfile" name="uploadfile" class="upl">

        <input type="hidden" name="empid" value="{{Session::get("empid")}}"></td></tr>
        <tr><td colspan="2">
        <input type="submit" value="確定上傳" class="bt-send" id="filesend">
                <br><font color="red">請上傳JPG/PNG檔案</font>
    </td>
</tr>

    </form>

</table>
</body>
</html>
