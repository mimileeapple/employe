<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "員工请假单/出差申請單";
date_default_timezone_set('Asia/Taipei');
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                dynamic: false, //是否顯示項目，使第一個項目按時間順序緊接在所選時間之後
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
        //中午休息時間
        var qk = pmHourStart - amHourEnd
        var middleTime = pmStart - amEnd;

        function calculate() {
            //計算請假時數

            var sstartTime = $(".leavestartdate").val() + ' ' + $(".leavestarttime").val();
            var sendTime = $(".leaveenddate").val() + ' ' + $(".leaveendtime").val();
            var startTime = new Date(sstartTime);
            var endTime = new Date(sendTime);
            var month=$(".leavestartdate").val().replace(/\//g,"-");
           month=month.substring(0, 7);
           $("#months").val(month);

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
            $("#leavestart").val(sstartTime);
            $("#leaveend").val(sendTime);
            if ($("#leavestart").val() == "" || $("#leaveend").val() == "") {
                alert("日期不得等於空");
                return 0;
            }

            var hours = getHours(startTime, endTime);//純計算扣掉六日
            if(hours<=8){
                $.get("workinfo", {leavestart: $(".leavestartdate").val()},//當天
                    function (time) {
                        var workinfo=time.data.workinfo;

                        //alert("workinfo="+workinfo);
                      if(workinfo==2){
                          alert("今天為休假日");
                          hours=0;
                      }
                      else if(workinfo==3||workinfo==0){
                          hours=hours;
                      }
                        if(hours<0){
                            hours=0;
                        }
                        $("#hours").val(hours);
                        var m = $("#hours").val() * 60;
                        $("#minit").val(m);
                });
            }
           // alert(hours);
            if(hours>8){//日期區間
            $.get("isholiday", {leavestart: $(".leavestartdate").val(), leaveend:$(".leaveenddate").val()},
                function (time) {
                    //這邊會返回100
                    var a = parseInt(time.data.holiday);//節日
                    var b = parseInt(time.data.makework);//補班
                    var holiday = a * 8;//如果用兩天 同一時間 則會錯誤變成16H
                    var makework = b * 8;
                    //將返回的數字*8 等於工時
                    hours = hours - holiday+makework ;
                    //alert(holiday);
                    //alert(makework);
                    if(hours<0){
                        hours=0;
                    }
                    $("#hours").val(hours);
                    var m = $("#hours").val() * 60;
                    $("#minit").val(m);
                });
            }

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
                        //遇到星期六 星期日
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

                }

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
            if($("#reason").val()==""){
                alert("請填寫事由");
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

                if (extname.toUpperCase() == "JPG" || extname.toUpperCase() == "PNG"||extname.toUpperCase() == "PDF") {
                    console.log(status)
                }
                else {
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
</head>
<body style="text-align: center">
@include("include.nav")

<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @include("include.menu")
        <div class="col-md-10">
            <form action="{{route('leavefake.store')}}" id="form1" name="form1" method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <br>
                <table border="1" align="center" class="bor-blue tbl" width="95%">
                    <tr align="center">
                        <td class="bg-blue">工號</td>
                        <td><input type="text" id="empid" name="empid" value="{{Session::get('empid')}}" readonly></td>
                        <td class="bg-blue">姓名</td>
                        <td><input type="text" id="name" name="name" value="{{Session::get('name')}}" readonly></td>
                        <td class="bg-blue">申请時間</td>
                        <td><input type="datetime-local" style="background:#F0F0F0; " id="orderdate" name="orderdate"
                                   value="<?php echo date('Y-m-d H:i:s');?>" readonly></td>
                    </tr>

                    <tr align="center">
                        <td class="bg-blue">部門</td>
                        <td><input type="text" id="depname" name="depname" value="{{Session::get('empdata')->dep}}"
                                   readonly>
                            <input type="hidden" id="depid" name="depid" value="{{Session::get('empdata')->depid}}"
                                   readonly>
                        </td>
                        <td class="bg-blue">職位</td>
                        <td><input type="text" id="title" name="title" value="{{Session::get('empdata')->title}}"
                                   readonly></td>
                        <td class="bg-blue">職務代理人</td>
                        <td><input type="text" id="agentemp" name="agentempename"
                                   value="{{Session::get('empdata')->agentempename}}" readonly>
                            <input type="hidden" id="achievedate" name="achievedate"
                                   value="{{Session::get('empdata')->achievedate}}"></td>
                    </tr>
                    <tr align="center">
                        <td class="bg-blue">假別</td>
                        <td>
                            <select id="leavefakeid" name="leavefakeid">

                                <option value="1">特休</option>
                                <option value="2">年休</option>
                                <option value="3">出差</option>
                                <option value="4">公假</option>
                                <option value="5">事假</option>
                                <option value="6">病假</option>
                                <option value="7">婚假</option>
                                <option value="8">喪假</option>
                                <option value="9">生理假</option>
                                <option value="10">其他</option>
                                <option value="11">補休</option>


                            </select>

                            <input type="hidden" id="leavefakename" name="leavefakename" value="特休"></td>
                        <td class="bg-blue">事由</td>
                        <td><input type="text" id="reason" name="reason" value="" required="required" ></td>
                        <td class="bg-blue">備註</td>
                        <td><input type="text" id="note" name="note" value=""></td>

                    </tr>
                    <tr>
                        <td class="bg-blue">请假天数</td>
                        <td colspan="5" style="text-align: left;font-size: 12px;">

                            起始日期 <label class="start_date">
                                <input type="text" class="leavestartdate"  id="datepicker"  autocomplete="off"></label>
                            起始時間 <label class="start_date">
                                <input type="text" class="leavestarttime" id="timepicker"  autocomplete="off"></label>
                            到
                            結束日期 <label class="start_date">
                                <input type="text" class="leaveenddate" id="datepicker1"  autocomplete="off"></label>
                            結束時間 <label class="start_date">
                                <input type="text" class="leaveendtime" id="timepicker1"  autocomplete="off"></label>
                            <input type="button" value="計算" onclick="calculate()" class="bt-print"><br><br>
                            <input type="text" id="hours" name="hours" value="" style="margin-left: 55px;"> 時
                            =<input type="text" id="minit" name="minit" value="">分
                            <input type="hidden" class="" id="leavestart" name="leavestart">
                            <input type="hidden" class="" id="leaveend" name="leaveend">
                        </td>
                    </tr>
                    @foreach($emp_vacation as $e)
                        <tr>
                            <td colspan="6"><font color="red">您還有特休{{$e->specialdate}}
                                    分，年休{{$e->years_date}}分，補休{{$e->comp_time}}分</font>

                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="bg-blue">附件</td>
                        <td colspan="5"><input type="file" id="uploadfile" name="uploadfile" value=""></td>

                        </td>
                    </tr>
                    <tr>
                        <td class="bg-blue">請假注意事項</td>
                        <td colspan="5"><font
                                color="red">請假請先設定起訖日期後點選計算確認天數/時數是否正確，病假或喪假請上傳JPG檔案</font>
                        </td>
                    </tr>

                    <input type="hidden" name="creatdate" value="<?php echo date("Y-m-d");?>">
                    <input type="hidden" name="createmp" value="{{Session::get('name')}}">
                    <input type="hidden" name="updatedate" value="<?php echo date("Y-m-d");?>">
                    <input type="hidden" name="updateemp" value="{{Session::get('name')}}">
                    <input type="hidden" class="months" id="months" name="months" value="<?php echo date("Y-m");?>">
                    <tr>
                        <td colspan="6" style="text-align: center;padding-left:30px; ">

                            一階主管：<input type="text" id="manage1" name="manage1"
                                            value="{{Session::get('empdata')->manage1name}}" readonly>
                            <input type="hidden" id="manage1mail" name="manage1mail"
                                   value="{{Session::get('empdata')->manage1mail}}" readonly>
                            二階主管：<input type="text" id="manage2" name="manage2"
                                            value="{{Session::get('empdata')->manage2name}}" readonly>
                            <input type="hidden" id="manage2mail" name="manage2mail"
                                   value="{{Session::get('empdata')->manage2mail}}" readonly>
                            簽核狀態：<input type="text" id="signsts" name="signsts" value="0" readonly>
                            單據狀態：<input type="text" id="ordersts" name="ordersts" value="N" readonly></td>
                        <input type="hidden" id="manage2id" name="manage2id"
                               value="{{Session::get('empdata')->manage2id}}">
                        <input type="hidden" id="manage1id" name="manage1id"
                               value="{{Session::get('empdata')->manage1id}}">

                        <input type="hidden" id="manage2sign" name="manage2empsign" value="N">
                        <input type="hidden" id="manage1sign" name="manage1empsign" value="N">
                    </tr>
                    <tr>
                        <td colspan="6"><input type="button" value="送出" class="bt-add" id="doicon" name="doicon"
                                               onclick="DoImport()">
                            <input type="hidden" id="doing" value="1"></td>
                    </tr>
                    <tr><td colspan="6"><font color="red"> 申請即送出簽核，若要修改或取消，需通知簽核人員刪除後再重新申請</font></td></tr>
                </table>

        </div>
    </div>


</div>
</form>
</body>

</html>
