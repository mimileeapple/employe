<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8"); ?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <title>員工資料修改</title>
    <style>
        td {
            width: 200px;
        }

        select {
            width: 120px;
        }
    </style>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">
<h2 class="title-m ">員工資料修改</h2>
<script>

    if ({{$status}}) {
        alert('修改成功');
        self.opener.location.reload();
        window.close();
    } else {
        alert('修改失敗');
    }


</script>
<form action="{{route('employees.update',$data->empid)}}" method="post" name="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table border="1" class="tbl" style="margin: auto">
        <tr>
            <td>工號</td>
            <td><input type="text" name="empid" value="{{$data->empid}}" disabled></td>
            <td>密碼</td>
            <td><input type="text" name="pwd" value="{{$data->pwd}}"></td>
        <tr>
            <td>員工姓名</td>
            <td><input type="text" name="name" value="{{$data->name}}"></td>
            <td>英文名</td>
            <td><input type="text" name="ename" value="{{$data->ename}}"></td>
        </tr>
        <tr>
            <td>身分證字號</td>
            <td><input type="text" name="identity" value="{{$data->identity}}"></td>
            <td>性別</td>
            <td>
                <select name="sex" required>
                    <option value="M" {{$data->sex =="M"? 'selected':''}}>男</option>
                    <option value="F" {{$data->sex =="F"? 'selected':''}}>女</option>
                </select></td>
        </tr>
        <tr>
            <td>生日</td>
            <td><input type="date" name="birth" value="{{$data->birth}}"></td>
            <td>婚姻</td>
            <td>
                <select name="marry">
                    <option value="" {{$data->marry ==""? 'selected':''}}></option>
                    <option value="Y" {{$data->marry =='Y'? 'selected':''}}>已婚</option>
                    <option value="N" {{$data->marry =='N'? 'selected':''}}>未婚</option>
                </select></td>
        </tr>
        <tr>
            <td>職稱</td>
            <td><input type="text" name="title" value="{{$data->title}}"></td>
            <td>職等</td>
            <td><input type="text" name="grade" value="{{$data->grade}}"></td>
        </tr>
        <tr>
            <td>地址</td>
            <td colspan="3" style="text-align: left;padding-left:15px;">
                <input type="text" style="width:400px;" name="adress" value="{{$data->adress}}"></td>
        </tr>
        <tr>
            <td>部門</td>
            <td><select id="dep" name="dep">
                    <option value="" {{$data->dep ==""? 'selected':''}}></option>
                    <option value="管理部" {{$data->dep =="管理部"? 'selected':''}}>管理部</option>
                    <option value="產品研發部" {{$data->dep =="產品研發部"? 'selected':''}}>產品研發部</option>
                    <option value="產品工程部" {{$data->dep =="產品工程部"? 'selected':''}}>產品工程部</option>
                    <option value="PM業務部" {{$data->dep =="PM業務部"? 'selected':''}}>PM業務部</option>
                    <option value="資材部" {{$data->dep =="資材部"? 'selected':''}}>資材部</option>
                    <option value="財務部" {{$data->dep =="財務部"? 'selected':''}}>財務部</option>
                    <option value="資訊部" {{$data->dep =="資訊部"? 'selected':''}}>資訊部</option>
                </select>
            </td>
            <td>部門所在地</td>
            <td>
                <select name="deparea">
                    <option value="" {{$data->deparea ==""? 'selected':''}}></option>
                    <option value="台北" {{$data->deparea =="台北"? 'selected':''}} >台北</option>
                    <option value="深圳" {{$data->deparea =="深圳"? 'selected':''}} >深圳</option>
                    <option value="東莞" {{$data->deparea =="東莞"? 'selected':''}} >東莞</option>
                </select></td>
        </tr>
        <tr>
            <td>電子郵件</td>
            <td><input type="text" name="mail" value="{{$data->mail}}"></td>
            <td>手機</td>
            <td><input type="text" name="cellphone" value="{{$data->cellphone}}"></td>
        </tr>
        <tr>
            <td>電話</td>
            <td><input type="text" name="phone" value="{{$data->phone}}"></td>
            <td>到職日</td>
            <td><input type="text" name="achievedate" value="{{$data->achievedate}}"></td>
        </tr>
        <tr>
            <td>學歷</td>
            <td><select name="edu">
                    <option value="" {{$data->edu ==""? 'selected':''}}></option>
                    <option value="小學" {{$data->edu =='小學'? 'selected':''}}>小學</option>
                    <option value="國中" {{$data->edu =='國中'? 'selected':''}}>國中</option>
                    <option value="高中職" {{$data->edu =='高中職'? 'selected':''}}>高中職</option>
                    <option value="大學" {{$data->edu =='大學'? 'selected':''}}>大學</option>
                    <option value="碩士" {{$data->edu =='碩士'? 'selected':''}}>碩士</option>
                    <option value="博士" {{$data->edu =='博士'? 'selected':''}}>博士</option>
                </select></td>
            <td>權限</td>
            <td><input type="text" name="syslimit" value="{{$data->syslimit}}"></td>
        </tr>
        <tr>
            <td>職務代理人</td>
            <td><select name="agentemp">
                    <option value="" {{$data->agentemp ==""? 'selected':''}}></option>
                    @foreach($emp_list as $v)
                        <option
                            value="{{$v->empid}}" {{$data->agentemp ==$v->empid? 'selected':''}}>{{$v->name}}</option>
                    @endforeach
                </select></td>
            <td>在職狀態</td>
            <td><select name="jobsts">
                    <option value="" {{$data->jobsts ==""? 'selected':''}}></option>
                    <option value="Y" {{$data->jobsts =="Y"? 'selected':''}}>在職</option>
                    <option value="N" {{$data->jobsts =="N"? 'selected':''}}>離職</option>
                    <option value="F" {{$data->jobsts =="F"? 'selected':''}}>留職停薪</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>建檔日期</td>
            <td><input style="background:#F0F0F0;" type="text" name="creatdate" value="{{$data->creatdate}}" readonly>
            </td>
            <td>建檔人員</td>
            <td><input style="background:#F0F0F0;" type="text" name="createmp" value="{{$data->createmp}}" readonly>
            </td>
        </tr>
        <tr>
            <td>最後修改日期</td>
            <td><input style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo date("Y-m-d");?>"
                       readonly></td>
            <td>最後修改人員</td>
            <td>
                <input type="text" style="background:#F0F0F0;" name="updateemp" value="{{Session::get('name')}}"
                readonly>
            </td>
        </tr>


    </table>
    <br><input type="submit" class="bt-send" value="修改員工資料"><br><br></form>
</body>
</html><?php
