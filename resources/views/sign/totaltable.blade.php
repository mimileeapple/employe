<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "請假單總表";
date_default_timezone_set('Asia/Taipei');
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title ?></title>
<style>
    table{
    table-layout: fixed;
    }
</style>
    <script>

    </script>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">
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
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>

            <br>
            <form action="showleaveall" method="post" >
                {{ csrf_field() }}
                <div style="text-align: left;">
                    <input type="hidden" name="empid" value="{{session("empid")}}">
                    <select name="sreachdateorder" style="width: 150px;text-align: center">
                        <option
                            {{ isset($selected)&&$selected == date('Y-m',strtotime('-3 month'))?'selected ' :''  }} value="<?php echo date('Y-m',strtotime('-3 month')); ?>"><?php echo date('Y-m', strtotime('-3 month'));; ?></option>
                        <option
                            {{ isset($selected)&&$selected == date('Y-m',strtotime('-2 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-2 month')); ?>"><?php echo date('Y-m', strtotime('-2 month'));; ?></option>
                        <option
                            {{ isset($selected)&&$selected == date('Y-m',strtotime('-1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-1 month')); ?>"><?php echo date('Y-m', strtotime('-1 month')); ?></option>

                        <option
                            {{ isset($selected)&&$selected == date('Y-m')?'selected ' :''  }}value="<?php echo date('Y-m'); ?>"><?php echo date('Y-m'); ?></option>
                        <option
                            {{ isset($selected)&&$selected == date('Y-m',strtotime('+1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('+1 month')); ?>"><?php echo date('Y-m', strtotime('+1 month')); ?></option>
                    </select>
                        <input type="submit" value="查詢" class="bt-search">

                        <input type="button" value="特休管理"
                               onclick="window.open('vacation/create','newdate','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')"
                               class="bt-export">

                    </div>
                <br>

                <font color="red">年資、特休與年休計算到當月底為準</font>
                <table border="1" align="center" class="bor-blue tbl" width="100%" style="font-size: 10px;">
                    <tr>
                        <th class="bg-orange" colspan="7">(本月新增)</th>
                        <th class="bg-blue" colspan="4">尚未使用(累積)</th>
                        <th class="bg-red" colspan="12">當月休假</th>
                        <th class="bg-green" colspan="4">剩餘休假</th>
                    </tr>
                    <tr>
                        <th class="bg-orange"><b>姓名</b></th>
                        <th class="bg-orange"><b>到職日</b></th>
                        <th class="bg-orange"><b>年資</b></th>
                        <th class="bg-orange"><b>新增特休(分)</b></th>
                        <th class="bg-orange"><b>新增年休(分)</b></th>
                        <th class="bg-orange"><b>新增補休(分)</b></th>
                        <th class="bg-orange"><b>新增病假(分)</b></th>
                        <th class="bg-blue"><b>累積特休(分)</b></th>
                        <th class="bg-blue"><b>累積年休(分)</b></th>
                        <th class="bg-blue"><b>補休(分)</b></th>
                        <th class="bg-blue"><b>累積病假(分)</b></th>

                        <th class="bg-red"><b>特休(分)</b></th>
                        <th class="bg-red"><b>年休(分)</b></th>
                        <th class="bg-red"><b>遲到(分)</b></th>
                        <th class="bg-red"><b>出差(分)</b></th>
                        <th class="bg-red"><b>公假(分)</b></th>
                        <th class="bg-red"><b>事假(分)</b></th>
                        <th class="bg-red"><b>病假(分)</b></th>
                        <th class="bg-red"><b>生理假(分)</b></th>
                        <th class="bg-red"><b>婚假(分)</b></th>
                        <th class="bg-red"><b>喪假(分)</b></th>
                        <th class="bg-red"><b>補休(分)</b></th>
                        <th class="bg-red"><b>其他(分)</b></th>
                        <th class="bg-green"><b>特休(分)</b></th>
                        <th class="bg-green"><b>年休(分)</b></th>
                        <th class="bg-green"><b>補休(分)</b></th>
                        <th class="bg-green"><b>剩餘病假(分)</b></th>
                    </tr>

                    @foreach($emp_list1 as  $emp)
                        <tr>

                            <td>{{$emp->name}}<br>{{$emp->ename}}</td>

                            <td>{{$emp->achievedate}}</td>
                            <td>{{$emp->personlyears}}</td>
                            <td>{{$emp->add_specialdate}}</td>
                            <td>{{$emp->add_years_date}}</td>
                            <td>{{$emp->add_comp_time}}</td>
                            <td>{{$emp->add_sickday}}</td>
                            <td>{{$emp->specialdate_m}}</td>
                            <td>{{$emp->years_date_m}}</td>
                            <td>{{$emp->comp_time_m}}</td>
                            <td>{{$emp->sickday}}</td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>1])}}"
                                   target="_blank">{{$emp->a1*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>2])}}"
                                   target="_blank"> {{$emp->a2*60}}</a></td>
                            <td>@if($emp->total<0)<font color="red">{{$emp->total}}</font>
                                @else {{$emp->total}}
                                    @endif
                            </td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>3])}}"
                                   target="_blank">{{$emp->a3*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>4])}}"
                                   target="_blank">{{$emp->a4*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>5])}}"
                                   target="_blank">{{$emp->a5*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>6])}}"
                                   target="_blank">{{$emp->a6*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>7])}}"
                                   target="_blank">{{$emp->a7*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>8])}}"
                                   target="_blank">{{$emp->a8*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>9])}}"
                                   target="_blank">{{$emp->a9*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>11])}}"
                                   target="_blank">{{$emp->a11*60}}</a></td>
                            <td>
                                <a href="{{route("showleaveorder", ['empid'=>$emp->empid,'month'=>$selected,'fakeid'=>10])}}"
                                   target="_blank">{{$emp->a10*60}}</a></td>
                            <td> {{$emp->remain_specialdate}} </td>
                            <td>{{$emp->remain_years_date}}</td>
                            <td>  {{$emp->remain_comp_time}}</td>
                            <td>{{$emp->remain_sickday}}</td>
                            @endforeach


                        </tr>



            </table> </form>
            <br><br><br>
        </div>
    </div>
</div>

</body>

</html>
