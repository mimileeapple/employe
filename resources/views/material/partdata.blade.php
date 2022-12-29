<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "PartData管理";
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
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
                <table  width="70%" border="0" style="text-align:left;" >
                    <form action="{{route('partdata.store')}}" method="post" enctype='multipart/form-data' id="form1">
                        {{ csrf_field() }}
                    <tr>
                        <td >
                            <input type="file" name="file1" id="file1">
                            <input type="button" class="bt-add" id="add" value="匯入xls" onclick="submitfile()">
                    @if(Session::get('partdatasts')==true)
                               {{$date}} 匯入成功!<br></td></tr>
                    @else <tr><td ><font color="red"> 請上傳xls或xlxs檔案<br></font></td></tr>
                    @endif
                    </form>
                    <tr><td ><br></td></tr>
                    @if(Session::get('partdatasts')==true) <tr><td>
                       <a href="#" class="bt-del delete_execel">清空資料</a><font color="red"> 若要重新匯入請先清空資料</font></td>
                       </tr>
                    @else
                    @endif
                    <tr><td ><br></td></tr>

                    @if(count($partlist)>0)
                    <form method="post" id="form2" action="{{route('showpartdata')}}">
                        {{ csrf_field() }}
                    <tr><td>
                            <input list="partnumber" id="pno"  name="partnumberlist"  placeholder="搜尋partnumber" value="{{$pnoid}}" autocomplete="off" >
                          <datalist id="partnumber">
                                @foreach($partdatalist as $v)
                                <option value="{{$v->partnumber}}"></option>
                                @endforeach
                            </datalist>
                            <input type="submit" value="搜尋"  class="bt-search">
                        </td></tr>
                    </form>
                    @endif

                </table>
                <br>
                @if(count($partlist)>0)
                <table class="bor-blue" width="100%" style="font-size:6px;">
                   <tr class="bg-blue"><td>序號</td>
                       <td>partnumber</td>
                       <td>名稱</td>
                       <td>全名</td>
                       <td>廠商代碼</td>
                       <td>規格型號</td>
                       <td>使用狀態</td>
                       <td>生產計量單位</td>
                       <td>計價方法</td>
                       <td>單價精度</td>
                       <td>存貨科目代碼</td>
                       <td>銷售收入代碼</td>
                       <td>銷售成本科目代碼</td>
                       <td>成本差異科目代碼</td>
                       <td>稅率(%)</td>

                   </tr>

@foreach($partlist as $key=>$val)
                   <tr><td>{{$val->id}}</td>
                       <td>{{$val->partnumber}}</td>
                       <td>{{$val->headname}}</td>
                       <td>{{$val->fullname}}</td>
                       <td>{{$val->vendorpn}}</td>
                       <td>{{$val->description}}</td>
                       <td>{{$val->usests}}</td>
                       <td>{{$val->unit}}</td>
                       <td>{{$val->valuationmethod}}</td>
                       <td>{{$val->priceaccuracy}}</td>
                       <td>{{$val->inventorycode}}</td>
                       <td>{{$val->salesrevenuecode}}</td>
                       <td>{{$val->costofsalescode}}</td>
                       <td>{{$val->costdifferencecode}}</td>
                       <td>{{$val->taxrate}}</td>

                       </tr>

@endforeach
                        @endif
                </table>
            @if($partlist->count()>2)
                    {{$partlist->links()}}
            @endif
            <form action="{{ route('partdata.destroy',2) }}" method="post" id="delete_execel">
                {{ method_field('delete') }}
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>
<script>

    $(function(){
        $('.delete_execel').click(function (){
            $('#delete_execel').submit();
        })
    })
    function submitfile(){
        var fileInput = $('#file1').get(0).files[0];
        var file=$("input[name='file1']").val();//獲得檔名
        var point = file.lastIndexOf(".");// 以.分割檔案名稱
        var type = file.substr(point);// 抽取字符串，得到.xls
        if(fileInput){
            if(type=='.xls'||type=='.xlsx'){
            $("#form1").submit();
            }
            else{
                alert("請上傳xls/xlsx檔案");
            }
        }
        else{
            alert("請選擇上傳的文件！");
        }
    }
</script>
</body>
</html><?php
