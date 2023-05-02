<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "行政-付款申請表";

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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <title><?php echo $title ?></title>
    <style>
        input {

            width: 120px;
        }

        td {
            margin: 10px;
            padding: 10px;
        }

        select {
            margin: 10px;
            width: 200px;
        }

        label {
            position: relative;
        }

        th:hover {
            cursor: pointer;
        }
    </style>
    <script>

     

        function comparer(index) {
            return function (a, b) {
                var valA = getCellValue(a, index),
                    valB = getCellValue(b, index);
                return $.isNumeric(valA) && $.isNumeric(valB) ?
                    valA - valB : valA.localeCompare(valB);
            };
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text();
        }
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

            <table width="100%" style="margin: auto">
                <tr>
                    <td style="text-align: left;">
                        <input type="button" value="新增付款單"
                             onclick="window.open('payoffice/create','newpay','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')"
                              class="bt-mail">
                    </td>
                    <td>
                        <form method="post" id="form1" action="{{route('searchpaytype')}}">
                            {{ csrf_field() }}

                            <select id="feename" name="feename">
                                @foreach($fee as  $f)
                                    <option value="{{$f->id}}">{{$f->feetype}}--{{$f->feename}}</option>
                                @endforeach
                            </select>
                            <input type="submit" value="分類查詢" class="bt-send ">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;color: red;" colspan="3">*查看列印建議使用Google Chrome瀏覽器使用*</td>
                </tr>
            </table>
            <br>
<table class="tbl bor-blue" width="100%">
    <tr class="bg-blue">
    <th>序號</th>
    <th>修改</th>
    <th>申請日期</th>
    <th>費用分類</th>
    <th>費用細項</th>
    <th>收款單位(戶名)</th>
    <th>金額</th>
    <th>是否付款</th>
    <th>列印</th>
    <th>刪除</th>
    </tr>
    <tbody>
@foreach($paylist as $pay)
<tr>
    <td>{{$pay->id}}</td>
    <td><input class="bt-edit" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$pay->id}}" value="修改付款單"
               onclick="window.open('{{route('payoffice.edit',$pay->id)}}','updatepay','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
    </td>
    <td>{{$pay->orderdate}}</td>
    <td>{{$pay->feetype}}</td>
    <td>{{$pay->feename}}</td>
    <td>{{$pay->accountname}}</td>
    <td>{{$pay->total}}</td>
    <td>{{$pay->sts}}</td>
    <td><input class="bt-print" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$pay->id}}" value="列印付款單"
               onclick="window.open('{{route('payoffice.show',$pay->id)}}','printpay','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
    </td>
    <td><input class="bt-del" style="font-size: 10px;height:35px;" data-del="{{$pay->id}}" type="button"  value="刪除付款單"></td>
</tr>
@endforeach
    </tbody>

</table>

        </div>
    </div>
</div>

<script>
    $(".bt-del").on("click", function () {
        var yes = confirm('你確定刪除此筆付款單嗎？');
        if (yes) {

            ID = $(this).data('del')
            $.ajax({
                type: 'DELETE',
                url: '{{route('payoffice.destroy','')}}' + '/' + ID,
                data: {
                    'id': ID,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (msg) {
                }
            });
            location.reload();
            alert('刪除成功');
        } else {
            alert('取消');
            return false;
        }
    });


</script>
<br><br><br>
</body>
</html><?php
