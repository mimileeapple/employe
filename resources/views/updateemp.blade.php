<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "修改個人資料";
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>

    <title><?php echo $title ?></title>
    <style>
        td {
            width: 200px;
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
            @php $limit=Session::get('empdata')->syslimit @endphp

            <div style="text-align: left;">
            <input  type="button" value="新增個人簽名檔" onclick="window.open('{{route('showpicsign')}}','newsign',config='width=500px;height=300px')" class="bt-add">
            </div>
            <form action="{{route('personalinfor.update',$data->empid)}}" method="post">
                {{ csrf_field() }}
                {{method_field('PUT')}}

                <table border="1" class="tbl" width="90%">
                    <tr>
                        <td class="bg-blue">密碼</td>
                        <td><input value="{{$data->pwd}}" type="text" name="pwd"></td>
                        <td class="bg-blue">手機</td>
                        <td><input value="{{$data->cellphone}}" type="text" name="cellphone"></td>
                    </tr>
                    <tr>
                        <td class="bg-blue">電話</td>
                        <td><input value="{{$data->phone}}" type="text" name="phone"></td>
                        <td class="bg-blue">地址</td>
                        <td><input value="{{$data->adress}}" type="text" name="adress" style="width:250px;"></td>
                    </tr>
                    <tr>
                        <td class="bg-blue">學歷</td>
                        <td><select name="edu">
                                <option value="小學" {{$data->edu =="小學"? 'selected':''}}>小學</option>
                                <option value="國中" {{$data->edu =="國中"? 'selected':''}}>國中</option>
                                <option value="高中職" {{$data->edu =="高中職"? 'selected':''}}>高中職</option>
                                <option value="大學" {{$data->edu =="大學"? 'selected':''}}>大學</option>
                                <option value="碩士" {{$data->edu =="碩士"? 'selected':''}}>碩士</option>
                                <option value="博士" {{$data->edu =="博士"? 'selected':''}}>博士</option>
                            </select>
                            {{--                    <input value="<slect></seclt>--}}
                            {{--            {{$data->edu}}" type="text" name="edu">--}}
                        </td>
                        <td class="bg-blue">職務代理人</td>
                        <td><select name="agentemp">
                                @foreach($emp_list as  $emp)
                                    <option
                                        value="{{$emp->empid}}" {{$data->agentemp == $emp->empid? 'selected':''}}>{{$emp->name}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <input type="hidden" name="updatedate" value="<?php echo date("Y-m-d")?>">

                    <input type="hidden" name="updateemp" value="{{Session::get('name')}}">

                    @if(isset($error))
                        <tr>
                            <td colspan="4">
                                <font color="red" font-size="12px;">{{$error}}</font>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="4"><input type="submit" class="bt-send" value="修改">
                        </td>
                    </tr>
                    <br><br></table>
            </form>
        </div>
    </div>
</div>

</body>
</html><?php
