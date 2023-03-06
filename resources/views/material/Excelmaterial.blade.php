<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "XLS轉BOM表";
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
            <p style="color: red;text-align: left;">※上傳格式為xls/xlsx,且<b>只能有一個工作表(sheet)</b>※</p>
            <form action="{{route('material.store')}}" method="post" enctype='multipart/form-data' id="form1">

                {{ csrf_field() }}

                <table width="50%" border="0" style="text-align:left;">
                    <tr>
                        <td style="text-align: right;">
                            <input type="file" name="file1" id="file1"></td>
                        <td><input type="button" class="bt-add" value="匯入xls" onclick="submitfile()">

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br><br></td>
                    </tr>
                    @if($issetxls>0)
                        <tr>
                            <td style="text-align: right;">匯入成功</td>
                            <td><a href="{{route('materialExport')}}" class="bt-export">下載xls</a></td>
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: right;"><font color="red"> 請上傳xls或xlxs檔案</font></td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2"><br><br></td>
                    </tr>

                    @if($issetxls>0)
                        <tr>
                            <td style="text-align: right;"><font color="red"> 使用完畢請清空資料，以防資料重複</font>
                            </td>
                            <td>
                                <a href="#" class="bt-del delete_execel">清空資料</a>
                            </td>
                        </tr>
                    @else
                    @endif
                </table>
            </form>
            <form action="{{ route('material.destroy',2) }}" method="post" id="delete_execel">
                {{ method_field('delete') }}
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
<script>

    $(function () {

        $('.delete_execel').click(function () {
            $('#delete_execel').submit()
        })
    })

    function submitfile() {
        var fileInput = $('#file1').get(0).files[0];
        var file = $("input[name='file1']").val();//獲得檔名
        var point = file.lastIndexOf(".");// 以.分割檔案名稱
        var type = file.substr(point);// 抽取字符串，得到.xls
        if (fileInput) {
            if (type == '.xls' || type == '.xlsx') {
                $("#form1").submit();
            } else {
                alert("請上傳xls/xlsx檔案");
            }
        } else {
            alert("請選擇上傳的文件！");
        }
    }
</script>
</body>
</html><?php
