<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");?>
    <!DOCTYPE html>
    <html lang="zh-TW">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link  href="{{ URL::asset('css/style.css') }}"  rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <title>員工資料修改</title>
        <style>
           td{width: 200px;}

        </style>
    </head>
    <body style="text-align: center">
    <img src="{{ URL::asset('img/logo.png') }}">
    <h2 class="title-m ">員工資料修改</h2>
<script>

    if({{$status}}){
        alert('修改成功');
        self.opener.location.reload();
        window.close();
    }else {
        alert('修改失敗');
    }
</script>
<form action="{{route('employees.update',$data->empid)}}" method="post" name="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table border="1" class="tbl" style="margin: auto">
        <tr>
            <td>工號</td><td><input type="text "name="empid" value="{{$data->empid}}"></td>
            <td>密碼</td><td><input type="text "name="pwd" value="{{$data->pwd}}"></td>
        <tr><td>員工姓名</td><td><input type="text "name="name" value="{{$data->name}}"></td>
            <td>英文名</td><td><input type="text "name="ename" value="{{$data->ename}}"></td></tr>
        <tr><td>身分證字號</td><td><input type="text "name="identity" value="{{$data->identity}}"></td>
            <td>性別</td><td><input type="text "name="sex" value="{{$data->sex}}"></td></tr>
        <tr> <td>生日</td><td><input type="text "name="birth" value="{{$data->birth}}"></td>
            <td>婚姻</td><td><input type="text "name="marry" value="{{$data->marry}}"></td></tr>
        <tr><td>職稱</td><td><input type="text "name="title" value="{{$data->title}}"></td>
            <td>職等</td><td><input type="text "name="grade" value="{{$data->grade}}"></td></tr>
            <td>到職日</td><td><input type="text "name="achievedate" value="{{$data->achievedate}}"></td></tr>
        <tr><td>部門</td><td><input type="text" name="dep" value="{{$data->dep}}"></td>
            <td>部門所在地</td><td><input type="text "name="deparea" value="{{$data->deparea}}"></td></tr>
        <tr><td>電子郵件</td><td><input type="text "name="mail" value="{{$data->mail}}"></td>
            <td>手機</td><td><input type="text "name="cellphone" value="{{$data->cellphone}}"></td></tr>
        <tr><td>電話</td><td><input type="text "name="phone" value="{{$data->phone}}"></td>
            <td>地址</td><td><input type="text "name="adress" value="{{$data->adress}}"></td></tr>
        <tr><td>學歷</td><td><input type="text "name="edu" value="{{$data->edu}}"></td>
            <td>權限</td><td><input type="text "name="syslimit" value="{{$data->syslimit}}"></td></tr>
        <tr><td>職務代理人</td><td><input type="text "name="agentemp" value="{{$data->agentemp}}"></td>
            <td>在職狀態</td><td><input type="text "name="jobsts" value="{{$data->jobsts}}"></td></tr>
        <tr><td>建檔日期</td><td><input type="text "name="creatdate" value="{{$data->creatdate}}"></td>
            <td>建檔人員</td><td><input type="text "name="createmp" value="{{$data->createmp}}"></td></tr>
        <tr><td>最後修改日期</td><td><input type="text "name="updatedate" value="{{$data->updatedate}}"></td>
            <td>最後修改人員</td><td><input type="text "name="updateemp" value="{{$data->updateemp}}"></td></tr>


    </table><br><input type="submit" class="bt-send" value="修改員工資料"><br><br> </form>
    </body>
    </html><?php
