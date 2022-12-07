<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增公佈欄";
date_default_timezone_set('Asia/Taipei');
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <title><?php echo $title ?></title>
    <script>

        if ({{$status}}) {
            alert('新增成功');
            self.opener.location.reload();
            window.close();
        } else {
            alert('新增失敗');
        }

    </script>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m"><?php echo $title ?></h2>
<form action="{{route('creatboard.store')}}" method="post">
    {{ csrf_field() }}
    <table border="2" width="88%" class="tbl " style="text-align: center;" align="center">
        <tr class="bg-blue">
            <td>類別</td>
            <td>標題</td>
            <td>內容</td>
        </tr>
        <tr>
            <td><input type="text" name="type" required></td>
            <td><input type="text" name="title" required></td>
            <td><textarea name="content" id="editor1" rows="1" cols="1" required></textarea></td>
        </tr>
        <tr>
            <td colspan="3"><input type="submit" class="bt-send" value="送出"></td>
        </tr>
    </table>
    <input type="hidden" name="dep" value="{{Session::get('empdata')->dep}}">
    <input type="hidden" name="createmp" value="{{Session::get('empdata')->ename}}">
    <input type="hidden" name="launch" value="Y">
    <input type="hidden" name="updatteemp" value="{{Session::get('name')}}">
    <input type="hidden" name="boarddate" value="{{date("Y-m-d H:i:s")}}">
</form>
<script>
    CKEDITOR.replace('editor1');
</script>
