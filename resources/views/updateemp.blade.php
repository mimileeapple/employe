<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");?><!DOCTYPE html>
    <!DOCTYPE html>
    <html lang="zh-TW">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
        <title>員工資料新增</title>
        <style>
            td{width: 200px;}

        </style>
    </head>
    <body style="text-align: center">
    <img src="{{ URL::asset('img/logo.png') }}">
    <h2 class="title-m ">修改個人資料</h2>

    <form action="{{route('personalinfor.update',$data->empid)}}" method="post">
        {{ csrf_field() }}
        {{method_field('PUT')}}
        <table border="1" class="tbl" style="margin: auto">
            <tr><td>密碼</td><td><input value="{{$data->pwd}}" type="text" name="pwd"></td>
                <td>手機</td><td><input value="{{$data->cellphone}}" type="text" name="cellphone"></td></tr>
            <tr><td>電話</td><td><input value="{{$data->phone}}" type="text" name="phone"></td>
                <td>地址</td><td><input value="{{$data->adress}}" type="text" name="adress"></td></tr>
            <tr><td>學歷</td><td><select  name="edu">
                        <option value="1" {{$data->edu ==1? 'selected':''}}>小學</option>
                        <option value="2" {{$data->edu ==2? 'selected':''}}>國中</option>
                        <option value="3" {{$data->edu ==3? 'selected':''}}>高中職</option>
                        <option value="4" {{$data->edu ==4? 'selected':''}}>大學</option>
                        <option value="5" {{$data->edu ==5? 'selected':''}}>碩士</option>
                        <option value="6" {{$data->edu ==6? 'selected':''}}>博士</option>
                    </select>
{{--                    <input value="<slect></seclt>--}}
{{--            {{$data->edu}}" type="text" name="edu">--}}
                </td>
                <td>職務代理人</td><td><select name="agentemp">
                        @foreach($emp_list as  $emp)
                            <option value="{{$emp->empid}}" {{$data->agentemp == $emp->empid? 'selected':''}}>{{$emp->name}}</option>
                        @endforeach
                    </select>
                </td></tr>

           <input type="hidden" name="<?php echo date("Y-m-d")?>">

           <input type="hidden" name="<?php //echo $_SESSION['$idno']?>">

         <tr><td colspan="4"> @if(isset($error))
                     <font color="red" font-size="12px;">{{$error}}</font>
                 @endif</td></tr>
        </table><br><input type="submit" class="bt-send" value="修改">
        <input type="button" class="bt-gray" value="返回" onclick="javascript:location.href='{{url()->previous()}}'" ><br><br> </form>
    </body>
    </html><?php
