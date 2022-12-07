<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "特休管理-新增時數";
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
        input {
            width: 80px;
        }

        table {
            margin-left: 50px;
        }

        tr td {
            width: 110px;
        }
    </style>
    <script>
        if ({{$status}}) {
            alert('修改成功');
            self.opener.location.reload();
            window.close();
        } else {
            alert('修改失敗');
        }
    </script>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">

<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?>{{Session::get('thismonth')}}</h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-10">
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>
            <br>
            <form action="{{route('vacation.store')}}" id="form1" name="form1" method="post">
                {{ csrf_field() }}
                <table border="1" align="center" class="bor-blue tbl" width="100%" style="text-align: center;">
                    <tr>
                        <td colspan="7" class="bg-blue">新增時數</td>
                        <td colspan="3" class="bg-orange">累積時數</td>
                        <td colspan="3" class="bg-pink">本月請假時數</td>
                        <td colspan="3" class="bg-green">剩餘時數</td>
                    </tr>
                    <tr>
                        <td>編號</td>
                        <td>姓名</td>
                        <td>到職日</td>
                        <td>年資</td>
                        <td>特休</td>
                        <td>年休</td>
                        <td>補休</td>
                        <td>特休</td>
                        <td>年休</td>
                        <td>補休</td>
                        <td>特休</td>
                        <td>年休</td>
                        <td>補休</td>
                        <td>特休</td>
                        <td>年休</td>
                        <td>補休</td>
                    </tr>
                    @foreach($emp_list as  $emp)
                        <tr>
                            <td>
                                <input type="hidden" name="months" value="{{date('Y-m')}}">
                                <input type="hidden" name="empid[{{$emp->empid}}]" value="{{$emp->empid}}">
                                <input type="hidden" name="name[{{$emp->empid}}]" value="{{$emp->name}}">
                                <input type="hidden" name="achievedate[{{$emp->empid}}]" value="{{$emp->achievedate}}">
                                <input type="hidden" name="ename[{{$emp->empid}}]" value="{{$emp->ename}}">
                                <input type="hidden" name="createmp[{{$emp->empid}}]" value="{{Session::get('name')}}">
                                <input type="hidden" name="updateemp[{{$emp->empid}}]" value="{{Session::get('name')}}">
                                {{$emp->empid}}</td>
                            <td>{{$emp->name}}<br>{{$emp->ename}}</td>
                            <td>{{$emp->achievedate}}</td>
                            <td>{{$emp->jobyears}}</td>
                            <td><input type="text" name="add_specialdate[{{$emp->empid}}]"
                                       value="{{$emp->add_specialdate}}"></td>
                            <td><input type="text" name="add_years_date[{{$emp->empid}}]"
                                       value="{{$emp->add_years_date}}"></td>
                            <td><input type="text" name="add_comp_time[{{$emp->empid}}]"
                                       value="{{$emp->add_comp_time}}"></td>
                            <td><input type="hidden" name="specialdate[{{$emp->empid}}]"
                                       value="{{$emp->specialdate_m}}">{{$emp->specialdate_m}}</td>
                            <td><input type="hidden" name="years_date[{{$emp->empid}}]"
                                       value="{{$emp->years_date_m}}">{{$emp->years_date_m}}</td>
                            <td><input type="hidden" name="comp_time[{{$emp->empid}}]"
                                       value="{{$emp->comp_time_m}}">{{$emp->comp_time_m}}</td>
                            <td><input type="hidden" name="sub_specialdate[{{$emp->empid}}]"
                                       value="{{$emp->a1}}">{{$emp->a1}}</td>
                            <td><input type="hidden" name="sub_years_date[{{$emp->empid}}]"
                                       value="{{$emp->a2}}">{{$emp->a2}}</td>
                            <td><input type="hidden" name="sub_comp_time[{{$emp->empid}}]"
                                       value="{{$emp->a11}}">{{$emp->a11}}</td>

                            <td><input type="hidden" name="remain_specialdate[{{$emp->empid}}]"
                                       value="{{$emp->remain_specialdate}}">
                                {{$emp->remain_specialdate}}</td>
                            <td><input type="hidden" name="remain_years_date[{{$emp->empid}}]"
                                       value="{{$emp->remain_years_date}}">
                                {{$emp->remain_years_date}}</td>
                            <td><input type="hidden" name="remain_comp_time[{{$emp->empid}}]"
                                       value="{{$emp->remain_comp_time}}">
                                {{$emp->remain_comp_time}}  </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><input type="submit" value="確認送出" class="bt-send"></td>
                        </tr>
                </table>
            </form>


            <br><br><br>
        </div>
    </div>
</div>

</body>

</html>
