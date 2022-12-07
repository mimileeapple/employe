<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "公佈欄管理";
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

            <br>

            <table width="95%" border="1" class="tbl" style="margin: auto">
                <tr>
                    <td colspan="8" style="text-align: left">
                        <input type="button" class="bt-add"
                               onclick="window.open('{{route('newboard')}}','newemp','width='+(window.screen.availWidth-10)+',height='+(window.screen.availHeight-30)+',top=0,left=0,resizable=yes,status=yes,menubar=no,scrollbars=yes')"
                               value="新增公告">
                    </td>
                </tr>
                <tr style="width: 30px;" class="bg-blue">

                    <td>時間</td>
                    <td>類別</td>
                    <td>標題</td>
                    <td>內容</td>
                    <td>發布人部門</td>
                    <td>發布人</td>
                    <td>上架狀態</td>
                    <td>修改</td>

                </tr>

                @foreach($boardlist as  $e)
                    <form action="{{route('creatboard.update',$e->id)}}" method="post">
                        {{ csrf_field() }}
                        {{method_field('PUT')}}
                        <tr>

                            <td>{{$e->boarddate}}<input type="hidden" name="id" value="{{$e->id}}"></td>
                            <td><input type="text" value="{{$e->type}}" name="type"></td>
                            <td><input type="text" value="{{$e->title}}" name="title"></td>
                            <td><textarea name="content">{!!$e->content !!}</textarea></td>
                            <td><input type="text" value="{{$e->dep}}" name="dep"></td>
                            <td>{{$e->createmp}}</td>
                            <td><select name="launch">
                                    <option value="Y" {{$e->launch =='Y'? 'selected':''}}>Y</option>
                                    <option value="N" {{$e->launch =='N'? 'selected':''}}>N</option>
                                </select></td>
                            <td><input type="submit" value="修改"></td>
                        </tr>

                    </form>
                @endforeach


            </table>

        </div>
    </div>
</div>
<br><br><br>
</body>
</html>
