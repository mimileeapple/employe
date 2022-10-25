<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="員工請假申請單";
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link  href="{{ URL::asset('css/style.css') }}"  rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <title><?php echo $title?></title>
    <style>
        table {
            width: 800px;
            height: 300px;
            background-color: pink;
        }
    </style>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title?></h2>
<table border="" align="center" cellspacing="0">
    <tr align="center">
        <th colspan="9"><?php echo $title?></th>
    </tr>
    <tr align="center">
        <td colspan="2">姓名</td><input type="text" name="name" value="">
        <td>&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td colspan="2">部門<input type="text" name="dep" value=""></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td colspan="2">工號<input type="text" name="empid" value=""></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>

    <tr align="center">
        <td colspan="2">職位<input type="text" name="title" value=""></td>
        <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td colspan="2">申请時間<input type="text" name="orderdate" value=""></td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr align="center">
        <td colspan="2">请假天数</td>
        <td colspan="7">從&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="leavestart" value="">到&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="leaveend" value="">,共&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            天&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;時</td>
    </tr>
    <tr align="center">
        <td colspan="2">代理人<input type="text" name="agentemp" value=""></td>
        <td colspan="3"></td>
        <td colspan="2"></td>
        <td colspan="2"></td>
    </tr>
    <tr align="center">
        <td colspan="2">備註<input type="text" name="note" value=""></td>
        <td colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr align="center">
        <td colspan="2" rowspan="3">事由<input type="text" name="reason" value=""></td>
        <td colspan="7" rowspan="3">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr align="center">
    </tr>
    <tr align="center">
    </tr>
    <tr>
        <td colspan="9">申请人：<input type="text" name="orderemp" value="">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            代理人：<input type="text" name="signagentemp" value="">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            直屬主管：<input type="text" name="sigmanageemp" value="">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            核准：<input type="text" name="ordersts" value="">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</table>
</body>

</html>
