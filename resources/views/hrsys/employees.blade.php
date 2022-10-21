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
    <title>員工資料管理</title>
    <style>
        td{width: 30px;}
        input [type="text"]{width:30px;}
    </style>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">
<img src="{{ URL::asset('img/logo.png') }}">
<h2 class="title-m ">員工資料管理</h2>
<table width="90%" border="0"  style="margin: auto"><tr>
        <td style="text-align: left;padding-left:5px; ">
<input type="button" class="bt-add" onclick="window.open('employees/create','newemp','width=450px;height=450px')" value="新增">
            </td><td></td>


        <form action="" method="post" name="form1"> <td>
                <select name="searchemp">
                    @foreach($emp_list1 as  $emp)
                        <option value="{{$emp->name}}" >{{$emp->name}}</option>
                    @endforeach
                </select>
                <input type="button" value="員工查詢" class="bt-send"></td></form></tr>
</table><br><br>

<table width="80%" border="1" class="tbl" style="margin: auto">
    <tr style="width: 30px;">
        <td>修改</td>
        <td >工號</td><td>密碼</td></td>
        <td>員工姓名</td><td>英文名</td>
        <td>身分證字號</td><td>性別</td>
        <td>生日</td><td>婚姻</td>
        <td>職稱</td><td>職等</td>
        <td>職級</td><td>到職日</td>
        <td>部門</td><td>部門所在地</td>
        <td>電子郵件</td><td>手機</td>
        <td>電話</td><td>地址</td>
        <td>學歷</td><td>權限</td>
        <td>職務代理人</td><td>在職狀態</td>
        <td>建檔日期</td><td>建檔人員</td>
        <td>最後修改日期</td><td>最後修改人員</td>
        </tr>

@foreach($emp_list as  $emp)
    <tr style="width: 30px;">
        <td> <input style="width: 50px;" type="button" name="{{$emp->empid}}" value="修改" onclick="window.open('{{route('employees.edit',$emp->empid)}}','udateemp','width=450px;height=450px')"> </td>
        <td><input style="width: 30px;" type="text "name="empid" value="{{$emp->empid}}"> </td>
        <td><input style="width: 30px;" type="text" name="pwd" value="{{$emp->pwd}}">
        <td><input style="width: 30px;" type="text "name="name" value="{{$emp->name}}"></td>
        <td><input style="width: 30px;" type="text "name="ename" value="{{$emp->ename}}"></td>
        <td><input  style="width: 30px;"type="text "name="identity" value="{{$emp->identity}}"></td>
        <td><input style="width: 30px;"type="text "name="sex" value="{{$emp->sex}}"></td>
        <td><input style="width: 30px;"type="text "name="birth" value="{{$emp->birth}}"></td>
        <td><input style="width: 30px;"type="text "name="marry" value="{{$emp->marry}}"></td>
        <td><input style="width: 30px;"type="text "name="title" value="{{$emp->title}}"></td>
        <td><input style="width: 30px;"type="text "name="grade" value="{{$emp->grade}}"></td>
        <td><input style="width: 30px;"type="text "name="emprank" value="{{$emp->emprank}}"></td>
        <td><input style="width: 30px;" type="text "name="achievedate" value="{{$emp->achievedate}}"></td>
        <td><input style="width: 30px;" type="text "name="dep" value="{{$emp->dep}}"></td>
        <td><input style="width: 30px;"type="text "name="deparea" value="{{$emp->deparea}}"></td>
        <td><input style="width: 30px;"type="text "name="mail" value="{{$emp->mail}}"></td>
        <td><input style="width: 30px;"type="text "name="cellphone" value="{{$emp->cellphone}}"></td>
        <td><input style="width: 30px;"type="text "name="phone" value="{{$emp->phone}}"></td>
        <td><input style="width: 30px;"type="text "name="adress" value="{{$emp->adress}}"></td>
        <td><input style="width: 30px;"type="text "name="edu" value="{{$emp->edu}}"></td>
        <td><input style="width: 30px;"type="text "name="syslimit" value="{{$emp->syslimit}}"></td>
        <td><input style="width: 30px;"type="text "name="agentemp" value="{{$emp->agentemp}}"></td>
        <td><input style="width: 30px;"type="text "name="jobsts" value="{{$emp->jobsts}}"></td>
        <td><input style="width: 30px;"type="text "name="creatdate" value="{{$emp->creatdate}}"></td>
        <td><input style="width: 30px;"type="text "name="createmp" value="{{$emp->createmp}}"></td>
        <td><input style="width: 30px;"type="text "name="updatedate" value="{{$emp->updatedate}}"></td>
        <td><input style="width: 30px;"type="text "name="updateemp" value="{{$emp->updateemp}}"></td>
        @endforeach
    </tr>


</table>
{{$emp_list->links()}}

</body>
<style>
    #pull_right{
        text-align:center;
    }
    .pull-right {
        /*float: left!important;*/
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #428bca;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
        color: #2a6496;
        background-color: #eee;
        border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #428bca;
        border-color: #428bca;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .clear{
        clear: both;
    }
</style>
</html><?php
