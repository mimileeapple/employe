jQuery(function($){
    $.datepicker.regional['zh-TW'] = {
        closeText: '關閉',
        prevText: '&#x3C;上月',
        nextText: '下月&#x3E;',
        currentText: '今天',
        monthNames: ['一月','二月','三月','四月','五月','六月',
            '七月','八月','九月','十月','十一月','十二月'],
        monthNamesShort: ['一月','二月','三月','四月','五月','六月',
            '七月','八月','九月','十月','十一月','十二月'],
        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
        dayNamesMin: ['日','一','二','三','四','五','六'],
        weekHeader: '周',
        dateFormat: 'yy/mm/dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: '年'};
    $.datepicker.setDefaults($.datepicker.regional['zh-TW']);
});
function datepicker_sttus(){
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
$(function(){

    $("#leavefakeid").change(function() {
        $("#leavefakename").val($("#leavefakeid :selected").text());
    })

    datepicker_sttus()

})

//8小时工时
var hoursCountOfDay = 8;
//上午工作开始小时
var amHourStart = 9;
//上午工作开始分钟
var amMinutesStart =0;

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

    var sstartTime=$(".leavestartdate").val()+' '+$(".leavestarttime").val();
    var sendTime=$(".leaveenddate").val()+' '+$(".leaveendtime").val();

    // alert(startTime)
    // alert(endTime)
    var startTime = new Date(sstartTime);
    var endTime = new Date(sendTime);

    if (startTime >= endTime) {
        alert("請假開始日期不得大於結束日期");
        $("#hours").val("");
        return 0;
    }
    var hours = getHours(startTime, endTime);
    $("#leavestart").val(sstartTime);
    $("#leaveend").val(sendTime);

    if( $("#leavestart").val()==""|| $("#leaveend").val()==""){alert("日期不得等於空")}
//hours-節日

    $.get("isholiday", { leavestart:$(".leavestartdate").val(), leaveend:$(".leaveenddate").val() },
        function(time){
        //這邊會返回100
            var a=parseInt(time.data.holiday);//節日
            var b=parseInt(time.data.makework);//補班
            var holiday=a*8;
            var makework=b*8;
            //將返回的數字*8 等於工時

            hours=hours-holiday+makework;

            $("#hours").val(hours);

        });


}

function getHours(startTime, endTime) {
    var startDate = new Date(startTime.getFullYear(), startTime.getMonth(), startTime.getDate(), 0);
    var endDate = new Date(endTime.getFullYear(), endTime.getMonth(), endTime.getDate(), 0);
    var tmpStart = new Date(startTime.getFullYear(), startTime.getMonth(), startTime.getDate(), 0);
    var hours = 0;

    // 大于一天
    if (endDate - startDate > 1) {
        for (var date = tmpStart; endDate - date >= 0; date = addDay(date,1)) {
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
    }
    else {
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


