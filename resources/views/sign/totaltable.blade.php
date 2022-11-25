<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title="請假單總表";
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
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title?></title>
    <script>

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

            <br><form action="showleaveall" method="post">
                {{ csrf_field() }}
                <div style="text-align: left;">
                    <input type="hidden" name="empid" value="{{session("empid")}}">
                    <select name="sreachdateorder" style="width: 150px;text-align: center">
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-3 month'))?'selected ' :''  }} value="<?php echo date('Y-m',strtotime('-3 month')); ?>" ><?php echo  date('Y-m',strtotime('-3 month'));; ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-2 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-2 month')); ?>" ><?php echo  date('Y-m',strtotime('-2 month'));; ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('-1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('-1 month')); ?>" ><?php echo date('Y-m',strtotime('-1 month')); ?></option>

                        <option {{ isset($selected)&&$selected == date('Y-m')?'selected ' :''  }}value="<?php echo date('Y-m'); ?>" ><?php echo date('Y-m'); ?></option>
                        <option {{ isset($selected)&&$selected == date('Y-m',strtotime('+1 month'))?'selected ' :''  }}value="<?php echo date('Y-m',strtotime('+1 month')); ?>" ><?php echo date('Y-m',strtotime('+1 month')); ?></option>

                        <input type="submit" value="查詢" class="bt-search">

                        <input type="button" value="特休管理" onclick="window.open('vacation/create','newdate','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">

                    </select></div> <br>
            <font color="red">年資、特休與年休計算到當月底為準</font>
            <table border="1" align="center" class="bor-blue tbl" width="100%">
                <tr >
                    <td class="bg-blue" colspan="8">尚未使用(累積) </td>
                    <td class="bg-red" colspan="12">當月休假 </td>
                    <td class="bg-green" colspan="3">剩餘休假 </td>
                </tr>
                <tr>
                    <td class="bg-blue"><b>姓名</b> </td>
                    <td class="bg-blue"><b>到職日</b></td>
                    <td class="bg-blue"><b>年資</b></td>
                    <td class="bg-blue"><b>特休</b></td>
                    <td class="bg-blue"> <b>年休</b></td>
                    <td class="bg-blue"><b>累積特休</b></td>
                    <td class="bg-blue"> <b>累積年休</b></td>
                    <td class="bg-blue"><b>補休</b></td>

                    <td class="bg-red"><b>特休</b></td>
                    <td class="bg-red"><b>年休</b></td>
                    <td class="bg-red"><b>遲到</b></td>
                    <td class="bg-red"><b>出差</b></td>
                    <td class="bg-red"><b>公假</b></td>
                    <td class="bg-red"><b>事假</b></td>
                    <td class="bg-red"><b>病假</b></td>
                    <td class="bg-red"><b>生理假</b></td>
                    <td class="bg-red"> <b>婚假</b></td>
                    <td class="bg-red"><b>喪假</b></td>
                    <td class="bg-red"><b>補休</b></td>
                    <td class="bg-red"><b>其他</b> </td>
                    <td class="bg-green"><b>特休</b></td>
                    <td class="bg-green"><b>年休</b> </td>
                    <td class="bg-green"><b>補休</b> </td>
                </tr>

                @foreach($emp_list1 as  $emp)
                    <tr>

                        <td>{{$emp->name}}<br>{{$emp->ename}}</td>

                        <td>{{$emp->achievedate}}</td>
                        <td>{{$emp->personlyears}}</td>
                        <td>{{$emp->specialdate*1}}</td>
                        <td>{{$emp->years_date*1}}</td>
                        <td>{{$emp->specialdate_m}}</td>
                        <td>{{$emp->years_date_m}}</td>
                        <td>{{$emp->comp_time_m}}</td>

                        <td>{{$emp->a1*8}}</td>
                        <td>{{$emp->a2*8}}</td>
                        <td></td>
                        <td>{{$emp->a3*8}}</td>
                        <td>{{$emp->a4*8}}</td>
                        <td>{{$emp->a5*8}}</td>
                        <td>{{$emp->a6*8}}</td>
                        <td>{{$emp->a7*8}}</td>
                        <td>{{$emp->a8*8}}</td>
                        <td>{{$emp->a9*8}}</td>
                        <td>{{$emp->a11*8}}</td>
                        <td>{{$emp->a10*8}}</td>
                        <td> {{$emp->remain_specialdate}} </td>
                        <td>{{$emp->remain_years_date}}</td>
                        <td>  {{$emp->remain_comp_time}}</td>
                        @endforeach


                    </tr>

            </form>

            </table>
            <br><br><br>
        </div>
    </div></div>

</body>

</html>
