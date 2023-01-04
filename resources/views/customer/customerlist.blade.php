<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "客戶資料管理";

?>
    <!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <title><?php echo $title ?></title>
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
            <table width="95%" border="0" style="margin: auto">
                <tr>
                    <td style="text-align:left; ">
                        <input type="button" class="bt-add" value="新增客戶資料"
                               onclick="window.open('customer/create','newcustomer','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">


                    </td>
                    <td></td>


                    <td>
{{--                        <form method="post" id="form1" action="{{route('searchcustomer')}}">--}}
{{--                            {{ csrf_field() }}--}}
{{--                            <input list="code">--}}
{{--                            <datalist name="code">--}}
{{--                                @foreach($country_list as  $country)--}}
{{--                                    <option value="{{$country->code}}">{{$country->country_English}}{{$country->country_chinese}}</option>--}}
{{--                                @endforeach--}}
{{--                            </datalist>--}}
{{--                            <input type="submit" value="客戶查詢" class="bt-send ">--}}
{{--                        </form>--}}
                    </td>
                </tr>
            </table>
            <br><br>

            <table width="95%" border="1" class="tbl" style="margin: auto">
                <tr style="width: 30px;" class="bg-blue">
                    <td>修改</td>

                    <td>客戶編號</td>
                    <td>公司名稱</td>
                    <td>公司簡稱</td>
                    <td>國家</td>
                    <td>國碼</td>
                    <td>聯絡人</td>
                    <td>聯絡人E-mail</td>
                    <td>連絡人手機</td>
                    <td>客戶電話</td>
                    <td>客戶傳真</td>

                </tr>
                @foreach($customerlist as  $customer)
                    <tr>
                        <td><input class="bt-search bor-blue" style="width: 50px;" type="button" name="{{$customer->id}}"
                                   value="{{$customer->id}}"
                                   onclick="window.open('{{route('customer.edit',$customer->id)}}','udatecustomer','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">
                        </td>

                        <td> {{$customer->companyid}}</td>
                        <td>{{$customer->companyname}}</td>
                        <td>{{$customer->abbreviation}}</td>
                        <td>{{$customer->country}}</td>
                        <td>{{$customer->countrycode}}</td>
                        <td>{{$customer->contactperson1}}</td>
                        <td>{{$customer->contactemail}}</td>
                        <td>{{$customer->contactcellphone}}</td>
                        <td>{{$customer->customerphone}}</td>
                        <td>{{$customer->customerfax}}</td>


                        @endforeach
                    </tr>

            </table>
            @if($customerlist->count()>2)
                {{$customerlist->links()}}
            @endif
        </div>
    </div>
</div>

</body>
</html><?php
