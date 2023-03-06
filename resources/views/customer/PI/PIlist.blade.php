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

            width:120px;
        }
        td{
            margin:10px;
            padding: 10px;
        }
        select{
            margin:10px;
            width:200px;
        }
        label{
            position: relative;
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

            <table width="95%"  style="margin: auto">
                <tr><td style="text-align: left;"><input  type="button" value="新增PI單" onclick="window.open('custPI/create','newpi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" class="bt-add">
                    </td>

                        <td>
                        <form method="post" id="form1" action="{{route('searchcompanyid')}}">
                            {{ csrf_field() }}
                            <input list="companyid" name="companyid"  placeholder="搜尋客戶編號" value="{{$cnoid}}" autocomplete="off" style="width: 200px;">
                            <datalist id="companyid">
                                @foreach($custcompanyidall as  $c)
                                    <option value="{{$c->companyid}}"></option>
                                @endforeach
                            </datalist>
                            <input type="submit" value="客戶查詢" class="bt-send ">
                        </form>
                    </td>

                </tr>
                <tr><td style="text-align: left;color: red;" colspan="3">*查看列印建議使用Google Chrome瀏覽器使用*</td>
                </tr>

            </table>
            <br>
            @if(count($customerlist)>0)
            <table width="95%"  style="margin: auto;font-size: 10px;" border="0" class="bor-blue">
                <tr class="bg-blue"><td>序號</td><td>修改PI單</td><td>查看</td><td>填寫規格表</td><td>客戶編號</td><td>單號日期</td>
                    <td>PI號碼</td><td>帳單公司名稱</td><td>帳單公司電話</td><td>上傳歸檔</td><td>刪除</td></tr>
                @else <font color="red">目前尚無資料</font>
                    @endif
                @foreach($customerlist as $d)

                <tr>
                    <td>{{$d->id}}</td>
                    <td><input class="bt-search bor-blue" style="width: 60px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}"
                               value="修改PI單"
                               onclick="window.open('{{route('custPI.edit',$d->id)}}','udatepi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" >
                    </td>
                    <td>


                        <input class="bt-print bor-blue" style="width: 80px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}"
                               value="查看列印"
                               onclick="window.open('{{route('custPI.show',$d->id)}}','printpi','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" >

                    </td>
                    <td>


                       @if($d->spacecount>0)
                        <input class="bt-edit" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}"
                               value="修改規格表"
                               onclick="window.open('{{route('pispace.edit',$d->id)}}','newspace','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" >

                      @else
                          <input class="bt-add" style="width: 100px;font-size: 10px;height:35px;" type="button" name="{{$d->id}}"
                               value="新增規格表"
                               onclick="window.open('{{route('showpispace',$d->id)}}','newspace','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')" >
                        @endif
                    </td>
                    <td>{{$d->companyid}}</td><td>{{$d->orderdate}}</td>
                    <td>{{$d->pino}}</td>
                    <td>{{$d->billcompanyname}}</td><td>{{$d->billtel}}</td>
                   <td>

                           @if(isset($d->uploadpi))<a target="_blank" href="{{url($d->uploadpi)}}">PI單</a>

                               @else <input type="button" class="bt-export"
                              onclick="window.open('{{route("signpi",$d->id)}}','uploadpi',config='width=500;height=500')"
                              value="上傳PI單">
                              @endif

                        </td>
                    <td> <input data-del="{{$d->id}}" type="button" value="刪除" class="bt-del" style="width: 60px;font-size: 10px;height:35px;"></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<script>
    $(".bt-del").on("click",function(){
        var yes = confirm('你確定刪除此筆PI單嗎？');
        if (yes) {

            ID = $(this).data('del')

            $.ajax({
                type: 'DELETE',
                url: '{{route('custPI.destroy','')}}'+'/'+ID,
                data: {
                    'id':ID,
                    "_token": "{{ csrf_token() }}",
                },

                success: function(msg) {


                }
            });
            location.reload();
            alert('刪除成功');
        }
        else {
            alert('取消');
            return false;
        }
    });


</script>
<br><br><br>
</body>
</html><?php
