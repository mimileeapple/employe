<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="客戶資料新增";
date_default_timezone_set('Asia/Taipei');
$today = date('Y-m-d H:i:s');
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

<form action="{{ route('customer.store') }}" method="post" name="form1">
    {{ csrf_field() }}
    <table border="1" class="tbl" style="margin: auto">

        <tr>
            <td>公司編號</td><td ><input type="text" name="companyid" ></td>
            <td>公司名稱</td><td ><input type="text" name="companyname"></td></tr>
        <tr> <td>公司英文名</td><td><input type="text" name="companyname_en" ></td>
            <td>公司簡稱</td><td><input type="text" name="abbreviation" ></td></tr>
        <tr><td>國家</td><td><input type="text" name="country" ></td>
            <td>國碼</td><td> <input type="text" name="countrycode" ></td></tr>
        <tr>
            <td>公司帳單名稱</td><td>
                <input type="text" name="billcompanyname" ></td>
            <td>公司帳單地址</td><td><input type="text" name="billingcompanyaddress"  style="width:400px;"></td></tr>
        <tr><td>交貨公司名稱</td><td><input type="text" name="shipcompanyname" ></td>
            <td>交貨公司地址</td><td><input type="text" name="shipcompanyaddress" style="width:400px;"></td></tr>
        <tr><td>交易方式</td><td><input type="text" name="transaction" ></td>
            <td>交易幣別</td><td><input type="text" name="transactioncurrency" ></td></tr>
        <tr><td>付款條件</td><td>
                <input type="text" name="payterm"></td>
            <td>聯絡人1</td><td>
                <input type="text" name="contactperson1" >
              職稱: <input type="text" name="contactposition" >
                   </td></tr>
        <tr><td>聯絡人2</td><td>
                <input type="text" name="contactperson2"></td>
            <td>聯絡人3</td><td>
                <input type="text" name="contactperson3" >

            </td></tr>
        <tr><td>聯絡人電子郵件</td><td><input type="text" name="contactemail" ></td>
            <td>聯絡人手機</td><td><input type="text" name="contactcellphone" ></td></tr>
        <tr><td>客戶電話</td><td><input type="text" name="customerphone"></td>
            <td>客戶傳真</td><td><input type="text" name="customerfax" ></td></tr>
        <tr>

            <td>收款注意事項</td><td><input type="text" name="receiptnotes"></td>
       <td>出貨注意事項</td><td>
                <input type="text" name="shippingnotes">
            </td></tr>


        <tr><td>建檔日期</td><td><input style="background:#F0F0F0;" type="text" name="creatdate" value="<?php echo $today;?>" readonly ></td>
            <td>建檔人員</td><td><input  style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}" readonly ></td></tr>
        <tr><td>最後修改日期</td><td><input  style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo $today;?>" readonly ></td>
            <td>最後修改人員</td><td><input  style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}">
               </td></tr>


    </table><br><input type="submit" class="bt-send" value="新增客戶"><br><br> </form>
    </body>
    </html><?php
