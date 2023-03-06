<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "出差旅費申請與報告";
date_default_timezone_set('Asia/Taipei');
$date = date("Y-M-D");

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
        input [type="text"] {
            width: 80px;
        }
    </style>

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


            <form action="{{route("search_trip")}}" method="post">
                {{ csrf_field() }}
                <div style="text-align: left;">
                    <input type="hidden" name="empid" value="{{Session::get('empid')}}">
                    <select name="month" style="width: 150px;text-align: center">
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-3 month'))?'selected ' :''  }} value="<?php echo date('Y-m',strtotime('-3 month')); ?>" ><?php echo  date('Y-m',strtotime('-3 month'));; ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-2 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-2 month')); ?>" ><?php echo  date('Y-m',strtotime('-2 month'));; ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-1 month')); ?>" ><?php echo date('Y-m',strtotime('-1 month')); ?></option>

                        <option {{ isset($selected)&&$selected == date('Y-m')?'selected ' :''  }}value="<?php echo date('Y-m'); ?>" ><?php echo date('Y-m'); ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('last day of 1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('last day of 1 month')); ?>" ><?php echo date('Y-m',strtotime('last day of 1 month')); ?></option>

                        <input type="submit" value="查詢" class="bt-search">
                    </select></div>
            </form>
            @if(count($orderdata) !=0)
                <br>
                <table border="1" align="center" class="bor-blue tbl" width="100%">
                    <tr><td colspan="10"><font color="red"> 申請即送出簽核，若要修改或取消，需通知簽核人員刪除後再重新申請</font></td></tr>
                    <tr class="bg-blue">
                        <td><b>填寫出差旅費報告表</b></td>
                        <td><b>申请時間</b></td>
                        <td><b>單號</b></td>
                        <td><b>假別</b></td>
                        <td><b>姓名</b></td>
                        <td><b>起始時間</b></td>
                        <td><b>結束時間</b></td>
                        <td><b>總計時間</b></td>
                        <td><b>單據狀態</b></td>
                        <td><b>請假明細</b></td>

                    </tr>
                    @else
                        <font color="red">您所查詢的資料為空!</font>
                    @endif

                    @foreach($orderdata as  $emp)
                        <tr>

                            @if(!$emp->status)
                                <td><input type="button" value="申請" class="bt-add"
                                           onclick="window.open('{{route('Pay.create',['orderid'=>$emp->orderid])}}','newemp','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                </td>
                            @else
{{--                                如果用到resource路由 他帶參數的方式跟你自訂的路由是稍微不一樣的--}}
                                <td><input type="button" value="查看" class="bt-search"

                                           onclick="window.open('{{route('Pay.edit',$emp->orderid)}}','newemp','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                </td>
                            @endif
                            <td>{{$emp->ordersts}}{{$emp->orderdate}}</td>
                            <td>{{$emp->orderid}}</td>
                            <td>{{$emp->leavefakename}}</td>
                            <td>{{$emp->name}}</td>
                            <td>{{$emp->leavestart}}</td>
                            <td>{{$emp->leaveend}}</td>
                            <td>{{$emp->hours}}時</td>
                            <td>{{$emp->signsts}}</td>
                            <td><input type="button" value="明細" class="bt-export"
      onclick="window.open('{{route('orderdetail',['p'=>$emp->orderid])}}','newemp','width=500px;height=500px')">
                            </td>


                        </tr>
                    @endforeach

                </table>
                @if($orderdata->count()>0)
                    {{$orderdata->links()}}
                @endif
                <br><br><br>
        </div>
    </div>
</div>
</body>

</html>
