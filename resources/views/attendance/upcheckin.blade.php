<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Taipei');
$title = "我要補卡";
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <title><?php echo $title ?></title>
    <style>
        td {
            width: 200px;
        }

        select {
            width: 120px;
        }
    </style>
    <script>
        jQuery(function ($) {
            $.datepicker.regional['zh-TW'] = {
                closeText: '關閉',
                prevText: '&#x3C;上月',
                nextText: '下月&#x3E;',
                currentText: '今天',
                monthNames: ['一月', '二月', '三月', '四月', '五月', '六月',
                    '七月', '八月', '九月', '十月', '十一月', '十二月'],
                monthNamesShort: ['一月', '二月', '三月', '四月', '五月', '六月',
                    '七月', '八月', '九月', '十月', '十一月', '十二月'],
                dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
                dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
                weekHeader: '周',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'
            };
            $.datepicker.setDefaults($.datepicker.regional['zh-TW']);
        });

        function datepicker_sttus() {
            $(".leavestartdate").datepicker({
                format: 'yy-mm-dd', //修改顯示順序
                minDate: new Date('today')

            });

            $(".leavestarttime").timepicker({
                timeFormat: "HH:mm ", // 時間隔式
                interval: 30, //時間間隔
                minTime: "09", //最小時間
                maxTime: "18:00pm", //最大時間
                defaultTime: "09", //預設起始時間
                startTime: "09:00", // 開始時間
                dynamic: false, //是否顯示項目，使第一個項目按時間順序緊接在所選時間之後
                dropdown: true, //是否顯示時間條目的下拉列表
                scrollbar: true //是否顯示捲軸
            });


        }

        $(document).ready(function () {
            datepicker_sttus()


        })

        function getTodayDate() {
            var fullDate = new Date();
            var yyyy = fullDate.getFullYear();
            var MM = (fullDate.getMonth() + 1) >= 10 ? (fullDate.getMonth() + 1) : ("0" + (fullDate.getMonth() + 1));
            var dd = fullDate.getDate() < 10 ? ("0" + fullDate.getDate()) : fullDate.getDate();
            var today = yyyy + "-" + MM + "-" + dd;
            return today;
        }

        function getdate() {
            var NowDate = new Date();
            var yyyy = (NowDate.getFullYear()).toString();
            var MM = (NowDate.getMonth() + 1).toString();
            var day = yyyy + MM;
            return day;
        }

        function sendcheck() {
            var a = $("#btnactionid :selected").val();
            if ($(".leavestartdate").val() > Today) {
                alert("補卡日期不得大於今天日期");
                $("#datepicker").val("");
                $("#datepicker").focus();
                return false;
            }
            if ($(".leavestartdate").val() == "") {
                alert("日期不得為空")
                $(".leavestartdate").focus();
                return false;
            }
            if ($(".reason").val() == "") {
                alert("原因不得為空");
                $(".reason").focus();
                return false;
            } else {
                var sTime = $(".leavestartdate").val() + ' ' + $(".leavestarttime").val();
                var Today = getTodayDate();
                var day = $(".leavestartdate").val();
                var aday = getdate();
                if (a == 0) {
                    $("#btnactionin").val('上班');
                    $("#worktimein").val(sTime);
                }
                if (a == 1) {
                    $("#btnactionin").val('下班');
                    $('#worktime').val(sTime);
                }
                $("#checkdate").val(day);
                $("#yearmonths").val(aday);
                $("#form1").submit();


            }
        }
    </script>

</head>
<body style="text-align: center">
<br><br>
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title ?></h2>
<br><br>
<form action="{{route('checkin.update',Session::get('empid'))}}" method="post" name="form1" id="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table border="1" class="tbl" style="margin: auto">

        <tr>
            <td>申請日期</td>
            <td>
                <input type="text" name="creatdate" value="{{date("Y-m-d H:i:s")}}">
                <input type="hidden" name="updatedate" value="{{date("Y-m-d H:i:s")}}"></td>
            <td>補卡事項</td>
            <td><select style="width:170px;" id="btnactionid" name="btnactionid">
                    <option value="0">上班</option>
                    <option value="1">下班</option>
                </select></td>
        </tr>
        <tr>
            <td>補卡日期</td>
            <td><label class="start_date">
                    <input type="text" class="leavestartdate" id="datepicker"></label>
            </td>
            <td>補卡時間</td>
            <td><label class="start_date">
                    <input type="text" class="leavestarttime" id="timepicker"></label></td>
        </tr>
        <tr>
            <td>補卡原因</td>
            <td colspan="3" style="text-align: left"><input type="text" name="reason"
                                                            style="width: 400px;text-align: left" class="reason"></td>
        </tr>
            <input type="hidden" name="empid" value="{{Session::get('empid')}}">
            <input type="hidden" name="empname" value="{{Session::get('name')}}">
            <input type="hidden" name="checkdate" id="checkdate" value="">
            <input type="hidden" name="yearmonths" id="yearmonths" value="">
            <input type="hidden" name="worktime" value="" id="worktime">
            <input type="hidden" name="worktimein" value="" id="worktimein">
            <input type="hidden" name="btnactionin" value="" class="btnaction" id="btnactionin">
            <input type="hidden" name="btnactionout" value="" class="btnaction" id="btnactionout">
            <input type="hidden" name="sign" value="N">
            <input type="hidden" name="signemp" value="1">
        <tr>
            <td colspan="4"><input type="button" class="bt-send" value="送出" onclick="sendcheck()"></td>
        </tr>
    </table>
    <br><br><br></form>
</body>
</html><?php
