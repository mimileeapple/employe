<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="客戶資料修改";
date_default_timezone_set('Asia/Taipei');
$today = date('Y-m-d H:i:s');
?>
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
    <title><?php echo $title?></title>
    <style>
        td {
            width: 200px;
        }
        input{
            width: 200px;
        }
        select {
            width: 120px;
        }
    </style>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">
<h2 class="title-m "><?php echo $title?></h2>
<script>

    if ({{$status}}) {
        alert('修改成功');
        self.opener.location.reload();
        window.close();
    } else {
        alert('修改失敗');
    }


</script>

<form action="{{route('customer.update',$data->id)}}" method="post" name="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table border="1" class="tbl" style="margin: auto" width="100%">
        <tr>
        <tr>
            <td>公司編號</td><td ><input type="text" name="companyid" value="{{$data->companyid}}"></td>
            <td>公司名稱</td><td ><input type="text" name="companyname" value="{{$data->companyname}}"></td></tr>
        <tr> <td>公司英文名</td><td><input type="text" name="companyname_en" value="{{$data->companyname_en}}"></td>
            <td>公司簡稱</td><td><input type="text" name="abbreviation" value="{{$data->abbreviation}}"></td></tr>
        <tr><td>國家</td><td><input type="text" name="country" value="{{$data->country}}"></td>
            <td>國碼</td><td> <input type="text" name="countrycode" value="{{$data->countrycode}}"></td></tr>
        <tr>
            <td>公司帳單名稱</td><td>
                <input type="text" name="billcompanyname" value="{{$data->billcompanyname}}"></td>
            <td>公司帳單地址</td><td><input type="text" name="billingcompanyaddress"  style="width:700px;" value="{{$data->billingcompanyaddress}}"></td></tr>
        <tr><td>交貨公司名稱</td><td><input type="text" name="shipcompanyname" value="{{$data->shipcompanyname}}"></td>
            <td>交貨公司地址</td><td><input type="text" name="shipcompanyaddress" style="width:700px;" value="{{$data->shipcompanyaddress}}"></td></tr>
        <tr><td>交易方式</td><td><input type="text" name="transaction" value="{{$data->transaction}}"></td>
            <td>交易幣別</td><td><input type="text" name="transactioncurrency" value="{{$data->transactioncurrency}}"></td></tr>
        <tr><td>付款條件</td><td>
                <input type="text" name="payterm" value="{{$data->payterm}}"></td>
            <td>聯絡人1</td><td>
                <input type="text" name="contactperson1" value="{{$data->contactperson1}}">
                職稱: <input type="text" name="contactposition" value="{{$data->contactposition}}">
            </td></tr>
        <tr><td>聯絡人2</td><td>
                <input type="text" name="contactperson2" value="{{$data->contactperson2}}"></td>
            <td>聯絡人3</td><td>
                <input type="text" name="contactperson3" value="{{$data->contactperson3}}">

            </td></tr>
        <tr><td>聯絡人電子郵件</td><td><input type="text" name="contactemail" value="{{$data->contactemail}}"></td>
            <td>聯絡人手機</td><td><input type="text" name="contactcellphone" value="{{$data->contactcellphone}}"></td></tr>
        <tr><td>客戶電話</td><td><input type="text" name="customerphone" value="{{$data->customerphone}}"></td>
            <td>客戶傳真</td><td><input type="text" name="customerfax" value="{{$data->customerfax}}"></td></tr>
        <tr>

            <td>收款注意事項</td><td><input type="text" name="receiptnotes" value="{{$data->receiptnotes}}"></td>
            <td>出貨注意事項</td><td>
                <input type="text" name="shippingnotes" value="{{$data->receiptnotes}}">
            </td></tr>


        <tr><td>建檔日期</td><td><input style="background:#F0F0F0;" type="text" name="creatdate" value="{{$data->creatdate}}" readonly ></td>
            <td>建檔人員</td><td><input  style="background:#F0F0F0;" type="text" name="createmp" value="{{$data->createmp}}" readonly ></td></tr>
        <tr><td>最後修改日期</td><td><input  style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo $today;?>" readonly ></td>
            <td>最後修改人員</td><td><input  style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}">
            </td></tr>



    </table>
    <br><input type="submit" class="bt-send" value="修改客戶資料"><br><br></form>
</body>
</html><?php
