<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="員工資料新增";
?>
    <!DOCTYPE html>
    <html lang="zh-TW">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link  href="{{ URL::asset('css/style.css') }}"  rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <title><?php echo $title?></title>
        <style>
           td{width: 200px;}
            select{width:120px;}
        </style>
        <script>
           $(function(){
            $("#manage1id").change(function() {

                $("#manage1name").val($("#manage1id :selected").text());
            })

            $("#manage2id").change(function() {
                $("#manage2name").val($("#manage2id :selected").text());
            })
               $("#depid").change(function() {
                   $("#dep").val($("#depid :selected").text());
               })
               $("#depareaid").change(function() {
                   $("#deparea").val($("#depid :selected").text());
               })

            })


         </script>
        <script>

            if ({{$status}}) {
                alert('新增成功');
                self.opener.location.reload();
                window.close();
            } else {
                alert('新增失敗');
            }

        </script>
    </head>
    <body style="text-align: center">
    <img src="{{ URL::asset('img/logo.png') }}">

    <h2 class="title-m "><?php echo $title?></h2>

<form action="{{ route('employees.store') }}" method="post" name="form1">
    {{ csrf_field() }}
    <table border="1" class="tbl" style="margin: auto">
       <!-- <tr>
            <td>工號</td><td colspan="3" style="text-align: left;padding: 15px;"><input type="text" name="empid" value=""></td>
           </tr>-->
        <tr>
            <td>密碼</td><td ><input type="text" name="pwd" ></td>
            <td>QQ</td><td ><input type="text" name="qq"></td></tr>
        <tr><td>員工姓名</td><td><input type="text" name="name" ></td>
            <td>英文名</td><td><input type="text" name="ename" ></td></tr>
        <tr><td>身分證字號</td><td><input type="text" name="identity" ></td>
            <td>性別</td><td>
                <select name="sex" >
                    <option value="M">男</option>
                    <option value="F">女</option>
                </select></td></tr>
        <tr><td>生日</td><td><input type="date" name="birth" ></td>
            <td>婚姻</td><td>
                <select name="marry">
                    <option value="Y">已婚</option>
                    <option value="N">未婚</option>
                </select></td></tr>
        <tr><td>職稱</td><td><input type="text" name="title" ></td>
            <td>職等</td><td><input type="text" name="grade" ></td></tr>
        <tr><td>職級</td><td><input type="text" name="emprank" ></td>
            <td>到職日</td><td><input type="date" name="achievedate" ></td></tr>
        <tr><td>部門</td><td>
                <input type="hidden" name="dep" id="dep">
                <select name="depid" id="depid">
                    <option value="1">管理部</option>
                    <option value="2">產品研發部</option>
                    <option value="3">產品工程部</option>
                    <option value="4">PM業務部</option>
                    <option value="5" >資材部</option>
                    <option value="6">財務部</option>
                    <option value="7">資訊部</option>
                </select>

            </td>
            <td>部門所在地</td><td>
                <input type="hidden" name="deparea" id="deparea">
                <select name="depareaid" id="depareaid">
                    <option value="T">台北</option>
                    <option value="S">深圳</option>
                    <option value="D">東莞</option>
                </select></td></tr>
        <tr><td>電子郵件</td><td><input type="text" name="mail" ></td>
            <td>手機</td><td><input type="text" name="cellphone" ></td></tr>
        <tr><td>電話</td><td><input type="text" name="phone"></td>
            <td>地址</td><td><input type="text" name="adress" style="width:400px;"></td></tr>
        <tr><td>學歷</td><td><select  name="edu">
                    <option value="小學">小學</option>
                    <option value="國中">國中</option>
                    <option value="高中職">高中職</option>
                    <option value="大學">大學</option>
                    <option value="碩士">碩士</option>
                    <option value="博士">博士</option>
                </select></td>
            <td>權限</td><td><input type="text" name="syslimit"></td></tr>
        <tr><td>職務代理人</td><td>
                <select name="agentemp">
                    @foreach($emp_list1 as $v)
                    <option value="{{$v->empid}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </td><td>在職狀態</td><td>
                <select name="jobsts">
                    <option value="Y">在職</option>
                    <option value="N">離職</option>
                    <option value="F">留職停薪</option></select>
                </td></tr>
        <tr><td>一階主管</td><td>
                <select id="manage1id" name="manage1id">
                    <option value=""></option>
                    @foreach($emp_list1 as $v)
                        <option value="{{$v->empid}}">{{$v->name}}</option>

                    @endforeach
                </select>
                <input type="hidden" id="manage1name" name="manage1name" value="">
            </td>
            <td>二階主管</td><td>
                <select id="manage2id" name="manage2id">
                    <option value=""></option>
                @foreach($emp_list1 as $v)
                    <option value="{{$v->empid}}">{{$v->name}}</option>
                @endforeach</select><input type="hidden" id="manage2name" name="manage2name" value=""></td></tr>

        <tr><td>建檔日期</td><td><input style="background:#F0F0F0;" type="text" name="creatdate" value="<?php echo date("Y-m-d");?>" readonly ></td>
            <td>建檔人員</td><td><input  style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}" readonly ></td></tr>
        <tr><td>最後修改日期</td><td><input  style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo date("Y-m-d");?>" readonly ></td>
            <td>最後修改人員</td><td><input   type="hidden" name="updateemp" value="{{Session::get('name')}}">
                <input type="text" style="background:#F0F0F0;" value="{{Session::get('name')}}" readonly></td></tr>


    </table><br><input type="submit" class="bt-send" value="新增員工"><br><br> </form>
    </body>
    </html><?php
