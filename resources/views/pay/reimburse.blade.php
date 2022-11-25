<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title="國外出差旅費報告表";
date_default_timezone_set('Asia/Taipei');
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link  href="{{ URL::asset('css/style.css') }}"  rel="stylesheet" type="text/css">
    <link  href="{{ URL::asset('css/employeesstyle.css') }}"  rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <title><?php echo $title?></title>
    <style>
        input [type="text"]{width: 80px;}
    </style>
    <script type="text/javascript">
        $(function() {
            /* 按下GoTop按鈕時的事件 */
            $('#gotop').click(function(){
                $('html,body').animate({ scrollTop: 0 }, 'fast');   /* 返回到最頂上 */
                return false;
            });

            /* 偵測卷軸滑動時，往下滑超過400px就讓GoTop按鈕出現 */
            $(window).scroll(function() {
                if ( $(this).scrollTop() > 100){
                    $('#gotop').fadeIn();
                } else {
                    $('#gotop').fadeOut();
                }
            });
        });

    </script>
</head>
<body style="text-align: center">
@include("include.nav")
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @include("include.menu")
        <div class="col-md-10">
            <a  id="gotop" >
                <font size="20px"> ^</font>
            </a>
            <br>
            <table border="2" style="text-align: left" class="bor-blue tbl" width="95%">
                <tr><td colspan="2"> Name</td><td colspan="2"><input type="text" name="name"></td>
                    <td colspan="2">職稱</td><td colspan="3"><input type="text" name="title"></td>
                </tr>

                <tr>
                    <td>出差事由</td><td colspan="8"><input type="text" name="reson"></td></tr>
                <tr><td >出差日期起迄</td>
                    <td colspan="2">起:<input type="date" name="startdate"></td>
                    <td colspan="5">迄:<input type="date" name="enddate"></td></tr>
                <tr>   <td>起訖地點</td>
                    <td colspan="8"><input type="text" name="area" style="width:300px;padding-left:20px;"></td><tr>
                    <td>工作記要</td>
                    <td colspan="8"><input type="text" name="note"></td></tr>

                <tr><td colspan="2">幣別</td><td>NTD</td><td>RMB</td><td>USD</td><td>GBP</td><td>EUR</td><td></td> </tr>

                <tr><td rowspan="9">交通費</td><td>台北美國西雅圖機票</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>西雅圖德州機票</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>美國內陸行李費用</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>美國簽證費用</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>西雅圖住宿</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>德州住宿</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>

                <tr><td>小計</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>匯率</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>換算台幣</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td colspan="2">幣別</td><td>NTD</td><td>RMB</td><td>USD</td><td>GBP</td><td>EUR</td><td></td> </tr>
                <tr><td rowspan="8">辦公費</td>
                <tr><td>客戶誤餐費</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>日支費(每日US20)</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>額外行李托運費</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>小計</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>匯率</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>換算台幣</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>

                <tr><td>辦公費共</td><td></td><td></td><td></td><td></td><td></td><td></td> </tr>
                <tr><td>出差費總計</td><td colspan="7">NT$</td> </tr>
                <tr><td>應付員工費用</td><td colspan="7">NT$</td></tr>
                <tr><td>總經理</td><td></td><td>單位主管</td><td></td><td>財務</td><td></td><td>申請人</td><td></td> </tr>
            </table>

            <br><br><br>
        </div>
    </div></div>
</body>

</html>
