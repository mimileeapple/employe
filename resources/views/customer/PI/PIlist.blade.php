<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "客戶PI單";

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

        $(document).on('click', 'th', function () {
            var table = $(this).parents('table').eq(0);
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
            this.asc = !this.asc;
            if (!this.asc) {
                rows = rows.reverse();
            }
            table.children('tbody').empty().html(rows);
        });

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
                        <input type="button" value="新增PI單"
                             onclick="window.open('custPI/create','newpi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')"
                              class="bt-mail">

                            <a href="{{route('packlistall')}}" class="bt-mail" style="width:200px;text-decoration:none;color:white;">Packinglist管理</a>

                    </td>
                    <td>
                        <form method="post" id="form1" action="{{route('searchcompanyid')}}">
                            {{ csrf_field() }}
                            <input list="companyid" name="companyid" placeholder="搜尋客戶編號" value="{{$cnoid}}"
                                   autocomplete="off" style="width: 200px;">
                            <datalist id="companyid">
                                @foreach($custcompanyidall as  $c)
                                    <option value="{{$c->companyid}}"></option>
                                @endforeach
                            </datalist>
                            <input type="submit" value="客戶查詢" class="bt-send ">
                        </form>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;color: red;" colspan="3">*查看列印建議使用Google Chrome瀏覽器使用*</td>
                </tr>

            </table>
            <br>
            @if(count($customerlist)>0)
                <table width="100%" style="margin: auto;font-size: 10px;" border="0" class="bor-blue tablesorter">
                    <thead>
                    <tr class="bg-blue bor-blue" style="height: 50px;">
                        <th>序號</th>
                        <th>修改PI單</th>
                        <th>填寫規格表</th>
                        <th>查看列印PI單</th>
                        <th>客戶<br>編號</th>
                        <th>單號<br>日期</th>
                        <th>PI號碼</th>
                        <th>帳單公司名稱</th>
                        <th>上傳歸檔</th>
                        <th>正式Invoice(新增/修改)<br>查看列印</th>

                        <td>刪除</td>
                    </tr>
                    </thead>
                    @else
                        <font color="red">目前尚無資料</font>
                    @endif
                    <tbody>
                    @foreach($customerlist as $d)
                        <tr>
                            <td>{{$d->id}}</td>
                            <td><input class="bt-search bor-blue" style="width: 60px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="修改PI單"
                                 onclick="window.open('{{route('custPI.edit',$d->id)}}','udatepi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                            </td>
                            <td>
                                @if($d->spacecount>0)
                                    <input class="bt-search bor-blue" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="修改規格表"
                                           onclick="window.open('{{route('pispace.edit',$d->id)}}','newspace','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                @else
                                    <input class="bt-mail" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="新增規格表"
                                           onclick="window.open('{{route('showpispace',$d->id)}}','newspace','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                @endif
                            </td>
                            <td>
                                <input class="bt-print bor-blue" style="width: 80px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="查看列印"
                                       onclick="window.open('{{route('custPI.show',$d->id)}}','printpi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                            </td>
                            <td>{{$d->companyid}}</td>
                            <td>{{$d->orderdate}}</td>
                            <td>{{$d->pino}}</td>
                            <td>{{$d->billcompanyname}}</td>
                            <td>
                                @if(isset($d->uploadpi))
                                    <a target="_blank" href="{{url($d->uploadpi)}}">PI單</a>
                                @else
                                    <input type="button" class="bt-export" value="上傳PI單"
                                           onclick="window.open('{{route("signpi",$d->id)}}','uploadpi',config='width=500;height=500')">
                                @endif
                            </td>
                            <td>
                                @if($d->invocie>0)
                                    <input class="bt-search bor-blue" style="width: 130px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="修改Invoice表"
                                           onclick="window.open('{{route('invoice.edit',$d->id)}}','updateinvoice','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                    <br><br>
                                    <input class="bt-print bor-blue" style="width: 130px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="查看列印Invoice表"
                                           onclick="window.open('{{route('invoice.show',$d->id)}}','printpi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                @else
                                    <input class="bt-mail" style="width: 130px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}" value="新增Invoice表"
                                           onclick="window.open('{{route('newinvoice',$d->id)}}','newinvoice','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')">
                                @endif
                            </td>


                            <td><input data-del="{{$d->id}}" type="button" value="刪除" class="bt-del" style="width: 60px;font-size: 10px;height:35px;"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>

<script>
    $(".bt-del").on("click", function () {
        var yes = confirm('你確定刪除此筆PI單嗎？');
        if (yes) {

            ID = $(this).data('del')

            $.ajax({
                type: 'DELETE',
                url: '{{route('custPI.destroy','')}}' + '/' + ID,
                data: {
                    'id': ID,
                    "_token": "{{ csrf_token() }}",
                },

                success: function (msg) {

                    //location.reload();
                    alert('刪除成功');
                }
            });

        } else {
            alert('取消');
            return false;
        }
    });


</script>
<br><br><br>
</body>
</html><?php
