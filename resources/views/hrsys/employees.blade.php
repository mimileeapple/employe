<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="員工資料管理";
?>
    <!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link  href="{{ URL::asset('css/style.css') }}"  rel="stylesheet" type="text/css">
    <link  href="{{ URL::asset('css/employeesstyle.css') }}"  rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title?></title>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">
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
<table width="95%" border="0"  style="margin: auto"><tr>
        <td style="text-align:left; ">
<input type="button" class="bt-add" onclick="window.open('employees/create','newemp','width=650px;height=650px')" value="新增員工">
            </td><td></td>


         <td>
             <form method="post" id="form1" action="{{route('search')}}">
                 {{ csrf_field() }}
                <select  name="empid">
                    @foreach($emp_list1 as  $emp)
                        <option value="{{$emp->empid}}" >{{$emp->name}}</option>
                    @endforeach
                </select>
                <input type="submit" value="員工查詢" class="bt-send ">
             </form>
         </td>
    </tr>
</table><br><br>

<table width="95%" border="1" class="tbl" style="margin: auto">
    <tr style="width: 30px;">
        <td>修改</td>

        <td>員工姓名</td><td>英文名</td>
        <td>性別</td><td>生日</td>
        <td>職稱</td><td>到職日</td>
        <td>部門</td><td>部門所在地</td>
        <td>QQ</td><td>電子郵件</td>
        <td>手機</td><td>電話</td>
        <td>職務代理人</td><td>在職狀態</td>
 </tr>
@foreach($emp_list as  $emp)
    <tr >
        <td> <input class="bg-blue bor-blue" style="width: 50px;" type="button" name="{{$emp->empid}}" value="{{$emp->empid}}" onclick="window.open('{{route('employees.edit',$emp->empid)}}','udateemp','width=800px;height=800px')"> </td>

        <td> {{$emp->name}}</td>
        <td>{{$emp->ename}}</td>
        <td>{{$emp->sex}}</td>
        <td>{{$emp->birth}}</td>
        <td>{{$emp->title}}</td>
        <td>{{$emp->achievedate}}</td>
        <td>{{$emp->dep}}</td>
        <td>{{$emp->deparea}}</td>
        <td>{{$emp->qq}}</td>
        <td>{{$emp->mail}}</td>
        <td>{{$emp->cellphone}}</td>
        <td>{{$emp->phone}}</td>
        <td>{{$emp->agentemp}}</td>
        <td>{{$emp->jobsts}}</td>

        @endforeach
    </tr>

</table>
@if($emp_list->count()>2)
{{$emp_list->links()}}
            @endif
        </div>
    </div>
</div>

</body>
</html><?php
