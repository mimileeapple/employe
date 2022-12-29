<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");

?><!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="img/pageicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <title>員工登入</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <style>
        td {
            height: 40px;
            width: 150px;
        }

        input {
            margin: 10px;
        }
    </style>
    <script>
        function mydoing() {

            if ($("#accout").val() == "" || $("#pwd").val() == "") {
                alert("帳號密碼不能為空，請重新輸入");
                return false;
            } else {

                $("#form1").submit();
            }
        }

    </script>
</head>
<body style="text-align: center">
<img src="img/logo.png">

<h2 class="title-m ">員工登入</h2>
<form id="form1" action="verify" method="post" name="form1">
    {{ csrf_field() }}
    <table width="600px;" border="0" class="tbl-result" style="margin: auto">
        <tr>
            <td style="text-align: right">員工帳號:</td>
            <td style="text-align: left"><input type="text" id="accout" name="accout" placeholder="預設郵件開頭英文名"
                                                value=""></td>
        </tr>
        <tr>
            <td style="text-align: right">員工密碼:</td>
            <td style="text-align: left"><input type="text" id="pwd" name="pwd" placeholder="預設個人QQ號" value="">
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <input type="hidden" id="doing" name="doing" value="1">
                <input type="button" value="登入" class="bt-send" onclick="mydoing()"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-size: 10px;">忘記密碼請洽資訊人員</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;font-size: 10px;">本系統建議使用Google chrome瀏覽器</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;color: red;"> @if(isset($error))
                    <font color="red" font-size="12px;">{{$error}}</font>
                @endif</td>
        </tr>

    </table>
</form>

</body>
</html>
