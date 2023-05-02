<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "Packing List資料管理";

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
                        <input type="button" class="bt-add" value="新增packinglist"
                               onclick="window.open('{{route('packlist.index')}}','newpl','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">

                    </td>
                    <td></td>
                    <td>
                    </td>
                </tr>
            </table>
            <br><br>
            @if(count($packlistdata)>0)
            <table  class="tbl" style="margin: auto" width="95%" border="1">
                <thead>  <tr style="width: 30px;" class="bg-blue">
                    <td>單號</td>
                    <td>修改</td>

                    <td>PL編號</td>
                    <td>invoice</td>
                    <td>公司名稱</td>
                    <td>出貨日期</td>
                    <td>列印</td>
                   <td>刪除</td>

                </tr>


               </thead>
               <tbody>
               @foreach($packlistdata as $val)

                    <tr>
                        <td>{{$val->id}}</td>
                        <td><input class="bt-search bor-blue" style="width: 50px;" type="button" name="{{$val->id}}"
                                   value="修改"
                                   onclick="window.open('{{route('packlist.edit',$val->id)}}','udatepl','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">
                        </td>

                        <td>{{$val->plno}}</td>
                        <td><a href="{{route('showinvoice','IV'.$val->pino)}}" target="_blank">IV{{$val->pino}}</a></td>
                        <td>{{$val->billcompanyname}}</td>
                        <td>@if($val->shippingdate==""||$val->shippingdate==null)N
                              @else  {{$val->shippingdate}}
                                @endif
                        </td>
                        <td><input class="bt-print bor-blue"  type="button" name="{{$val->id}}"
                                   value="列印PL單"
                                   onclick="window.open('{{route('packlist.show',$val->id)}}','printpl','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-export">
                        </td>

                        <td><input data-del="{{$val->id}}" type="button" value="刪除" class="bt-del" style="width: 60px;font-size: 10px;height:35px;"></td>

                    </tr>
               @endforeach
               </tbody>
            </table>
            @endif
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
                url: '{{route('packlist.destroy','')}}' + '/' + ID,
                data: {
                    'id': ID,
                    "_token": "{{ csrf_token() }}",
                },

                success: function (msg) {
                    location.reload();
                    alert('刪除成功');

                }
            });

        } else {
            alert('取消');
            return false;
        }
    });


</script>
</body>
</html><?php
