<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "員工請假單/出差申請單";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    {{--    <script src="{{ URL::asset('myjs/leaveorder.js')}}"></script>--}}
    <title><?php echo $title ?></title>
    <style>
        input[type="text"] {
            width: 120px;
        }

        input[type="text"]:read-only {
            background: #F0F0F0;
        }

        select {
            width: 120px;
        }

        .start_date:before {
            font-family: "FontAwesome";
            content: "\f073";
        }

        .start_date {
            position: relative;
        }

        .start_date:before {
            font-family: "FontAwesome";
            font-size: 14px;
            content: "\f073";
            position: absolute;
            left: 4px;
            top: 50%;
            transform: translateY(-50%);
        }

        .start_date input {
            text-indent: 18px;
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
                dateFormat: 'yy/mm/dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'
            };
            $.datepicker.setDefaults($.datepicker.regional['zh-TW']);
        });

        function datepicker_sttus() {
            $(".leavestartdate,.leaveenddate").datepicker({
                format: 'yy-mm-dd', //修改顯示順序
                minDate: new Date('today')

            });

            $(".leavestarttime,.leaveendtime").timepicker({
                timeFormat: "HH:mm ", // 時間隔式
                interval: 30, //時間間隔
                minTime: "09", //最小時間
                maxTime: "18:00pm", //最大時間
                defaultTime: "09", //預設起始時間
                startTime: "09:00", // 開始時間
                dynamic: true, //是否顯示項目，使第一個項目按時間順序緊接在所選時間之後
                dropdown: true, //是否顯示時間條目的下拉列表
                scrollbar: true //是否顯示捲軸
            });


        }

        $(function () {

            $("#leavefakeid").change(function () {
                $("#leavefakename").val($("#leavefakeid :selected").text());
            })

            datepicker_sttus()

        })

        //8小时工时
        var hoursCountOfDay = 8;
        //上午工作开始小时
        var amHourStart = 9;
        //上午工作开始分钟
        var amMinutesStart = 0;

        //上午下班开始小时
        var amHourEnd = 12;
        //上午下班开始分钟
        var amMinutesEnd = 0;
        //下午上班开始小时
        var pmHourStart = 13;
        //下午上班开始分钟
        var pmMinutesStart = 0;
        //下午下班开始小时
        var pmHourEnd = 18;
        //下午下班开始分钟
        var pmMinutesEnd = 0;

        var amStart = amHourStart + amMinutesStart / 60;
        //上午下班
        var amEnd = amHourEnd + amMinutesEnd / 60;
        //下午上班
        var pmStart = pmHourStart + pmMinutesStart / 60;
        var pmEnd = pmHourEnd + pmMinutesEnd / 60;

        var qk = pmHourStart - amHourEnd
        var middleTime = pmStart - amEnd;

        function calculate() {
            //計算請假時數

            var sstartTime = $(".leavestartdate").val() + ' ' + $(".leavestarttime").val();
            var sendTime = $(".leaveenddate").val() + ' ' + $(".leaveendtime").val();

            // alert(startTime)
            // alert(endTime)
            var startTime = new Date(sstartTime);
            var endTime = new Date(sendTime);
            if (startTime == "") {
                alert("請填入開始日期");
                return 0;
            }
            if (endTime == "") {
                alert("請填入結束日期");
                return 0;
            }

            if (startTime >= endTime) {
                alert("請假開始日期不得大於結束日期");
                $("#hours").val("");
                return 0;
            }

            var hours = getHours(startTime, endTime);
            $("#leavestart").val(sstartTime);
            $("#leaveend").val(sendTime);

            if ($("#leavestart").val() == "" || $("#leaveend").val() == "") {
                alert("日期不得等於空");
                return 0;
            }
            //hours-節日

            $.get("isholiday", {leavestart: $(".leavestartdate").val(), leaveend: $(".leaveenddate").val()},
                function (time) {
                    //這邊會返回100
                    var a = parseInt(time.data.holiday);//節日
                    var b = parseInt(time.data.makework);//補班
                    var holiday = a * 8;
                    var makework = b * 8;
                    //將返回的數字*8 等於工時

                    hours = hours - holiday + makework;

                    $("#hours").val(hours);
                    var m = $("#hours").val() * 60;
                    $("#minit").val(m);
                });


        }

        function getHours(startTime, endTime) {
            var startDate = new Date(startTime.getFullYear(), startTime.getMonth(), startTime.getDate(), 0);
            var endDate = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate(), 0);
            var tmpStart = new Date(startTime.getFullYear(), startTime.getMonth(), startTime.getDate(), 0);
            var hours = 0;

            // 大于一天
            if (endDate - startDate > 1) {
                for (var date = tmpStart; endDate - date >= 0; date = addDay(date, 1)) {
                    // 请假当天
                    if (date - startDate == 0) {
                        if (startDate.getDay() == 6 || startDate.getDay() == 0) {
                            continue;
                        }
                        var hour = startTime.getHours();
                        var minutes = startTime.getMinutes();
                        var time = hour + minutes / 60;
                        if (time < amStart) {
                            time = amStart;
                        }
                        if (time <= amEnd) {
                            hours += pmEnd - time - middleTime;
                        } else {
                            hours += pmEnd - time;
                        }

                    } else if (endDate - date == 0) {
                        //最后一天
                        if (endDate.getDay() == 6 || endDate.getDay() == 0) {
                            continue;
                        }
                        var hour = endTime.getHours();
                        var minutes = endTime.getMinutes();
                        var time = hour + minutes / 60;
                        if (time > pmEnd) {
                            time = pmEnd;
                        }
                        if (time <= amEnd) {
                            hours += time - amStart;
                        } else {
                            hours += (time - amStart - middleTime);
                        }

                    } else {
                        // 中间日期

                        if (date.getDay() == 6 || date.getDay() == 0) {
                            continue;
                        }
                        hours += hoursCountOfDay;
                    }
                }
                return hours;
            } else {
                var startHour = startTime.getHours();
                var startMinutes = startTime.getMinutes();
                var endHour = endTime.getHours();
                var endMinutes = endTime.getMinutes();
                if (startHour == amHourStart && endHour == pmHourEnd && endMinutes == pmMinutesEnd) {
                    return hoursCountOfDay;
                }
                var tmpStartTime = startHour + startMinutes / 60;
                var tmpEndTime = endHour + endMinutes / 60;
                if (tmpStartTime < amStart) {
                    tmpStartTime = amStart;
                }
                if (tmpEndTime > pmEnd) {
                    tmpEndTime = pmEnd;
                }


                var timeLong = tmpEndTime - tmpStartTime
                //開始請假時間< 開始中五開始休息時間 結束請假時間>開始中午上班時間
                // 9 < 12 && 13 >= 13
                //console.log(timeLong)
                if (tmpStartTime < amEnd && tmpEndTime >= pmStart) {
                    timeLong -= middleTime;

                }//這邊寫了

                return timeLong;
            }
        }

        function addDay(date, days) {
            date.setTime(date.getTime() + 24 * 60 * 60 * 1000 * days);
            return date;
        }
    </script>


    <script type="text/JavaScript">

        function DoImport() {

            var obj = document.form1;
            // document.getElementById('doicon').disabled=false;
            var MSG = "";
            var status = true;
            uploadfile = obj.uploadfile.value;
            if ($(".leavestartdate").val() == "") {
                alert("請填寫開始日期");
                return 0;
            }
            if ($(".leaveenddate").val() == "") {
                alert("請填寫結束日期");
                return 0;
            }
            if ($("#hours").val() == "") {
                alert("請按下計算按鈕確認時數是否正確");
                return 0;
            }
            //  if(uploadfile.length==0)
            /*  {//********更改
                  status =false;
                  MSG+="請選擇要匯入之檔案！\n";

              }
              else
              {
  */
            if (uploadfile.length > 0) {
                str = new Array();
                str = uploadfile.split(".");
                extname = str[str.length - 1];
                console.log(extname.toUpperCase());

                if (extname.toUpperCase() == "JPG" || extname.toUpperCase() == "PNG") {
                    console.log(status)
                } else {
                    status = false;
                    MSG += "匯入之檔案必須是JPG/PNG/PDF！\n";
                }

            }
            if (MSG != '') {
                status = false
            }
            if (status) {
                document.getElementById('doicon').disabled = true;
                obj.action = '{{route('leavefake.store')}}';
                obj.target = '_self';
                obj.submit();
            } else {
                alert(MSG);
                return
            }
        }

    </script>
    <script>

        @isset($res)
        if ({{$res}}) {
            alert('新增成功');
            // location.reload();//
        } else {
            alert('新增失敗');
        }
        @endisset
    </script>
    <style>
        table {
            margin-left: 50px;
        }
    </style>
</head>
<body style="text-align: center">


<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-10">

            <br>
            @foreach($emp_list as $emp)

                <table border="1" align="center" class="bor-blue tbl" width="100%">
                    <tr align="center">
                        <td class="bg-blue">工號</td>
                        <td>{{$emp->empid}}</td>
                        <td class="bg-blue">姓名</td>
                        <td>{{$emp->name}}</td>
                        <td class="bg-blue">申请時間</td>
                        <td>{{$emp->orderdate}}</td>
                    </tr>

                    <tr align="center">
                        <td class="bg-blue">部門</td>
                        <td>{{$emp->depname}}

                        </td>
                        <td class="bg-blue">職位</td>
                        <td>{{$emp->title}}</td>
                        <td class="bg-blue">職務代理人</td>
                        <td>{{$emp->agentemp}}

                    </tr>
                    <tr align="center">
                        <td class="bg-blue">假別</td>
                        <td>{{$emp->leavefakename}}</td>
                        <td class="bg-blue">事由</td>
                        <td>{{$emp->reason}}</td>
                        <td class="bg-blue">到職日</td>
                        <td>{{$emp->achievedate}}</td>

                    </tr>
                    <tr>
                        <td class="bg-blue">请假天数</td>
                        <td colspan="5" style="text-align: left;font-size: 14px;">
                            起始日期:
                            <b>{{$emp->leavestart}}</b>
                            到
                            結束日期:
                            <b>{{$emp->leaveend}}</b>
                            共<b>{{$emp->hours}}</b>時<b>({{$emp->minit}}分鐘)</b>
                        </td>
                    </tr>
                    @foreach($emp_list1 as $e)
                        <tr>
                            <td colspan="6">
                                截至上月為止，您還有特休<b>{{$e->specialdate}}</b>天，年休<b>{{$e->years_date}}</b>
                                天，補休<b>{{$e->comp_time}}</b>天
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="bg-blue">附件</td>
                        <td colspan="5">
                            @if($emp->uploadfile!='')
                                <a target="_blank" href="{{url('../'.$emp->uploadfile)}}">附件</a></td>
                        @else</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="bg-blue">備註</td>
                        <td colspan="3">{{$emp->note}}</td>
                        <td class="bg-blue"> 單據狀態：</td>
                        <td>{{$emp->ordersts}}</td>
                    </tr>
                    <tr>
                        <td class="bg-blue"> 一階主管：</td>
                        <td>{{$emp->manage1}}<br>{{$emp->manage1empsigndate}}</td>
                        <td class="bg-blue"> 二階主管：</td>
                        <td>{{$emp->manage2}}<br>{{$emp->manage2empsigndate}}</td>
                        <td class="bg-blue"> 簽核狀態：</td>
                        <td>{{$emp->signsts}}<br>{{$emp->signfinshdate}}</td>
                    </tr>
                </table>
            @endforeach
        </div>
    </div>
</div>

</body>

</html>
