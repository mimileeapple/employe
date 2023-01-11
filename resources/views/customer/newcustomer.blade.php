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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

        <title><?php echo $title?></title>
        <style>
           td{width: 250px;}
            select{width:120px;}
            input{width: 230px;}
        </style>

        <script>
            $(document).ready(function () {
                $("#nation").hide();

                   if($("#companyname_en").val()==""){
                       alert("請先輸入客戶英文名稱");
                       $("#companyname_en").focus();
                   }
                   $("#companyname_en").change(function(){
                       $("#nation").show();
                       $("#nation").change(function(){
                   let en= $("#companyname_en").val();
                   let enno=left(en,1);
                   const val = verifiDatalist('nation');
                   let val1=val+enno;
                   let countrycode=left(val,2);
                     let num=val.substring(2,);
           if(val!==false&&$("#companyname_en").val()!=""){

                   $('#countrycode').val(countrycode);
                   $("#companyid").val(val1);
               $("#countrynum").val(num);
                   //$('#msg3').css('color', '#328c32').text('送出成功 (●´ω｀●)ゞ，送出值為：'+ $('#input3').val());
               }
           else {
               $('#countrycode').val('');
               $("#companyid").val('');
               alert("請輸入客戶英文名或選擇國家")
               //$('#msg3').css('color', 'red').text('請輸入內建選項文字！ヽ(ﾟQ Д Q)ﾉﾟ');

           }
               })
                   })
            })

            // 驗證方法
            // 傳入參數：
            // inputId：欲驗證之input的id
            // 回傳：
            // 若輸入選項內文字則回傳其data-value值
            // 若輸入非選項內文字則回傳false
            function verifiDatalist(inputId){
                const $input = $('#'+inputId),
                    $options = $('#' + $input.attr('list') + ' option'),
                    inputVal = $input.val();
                let verification = false;
                for(let i = 0; i < $options.length; i++) {
                    const $option = $options.eq(i),
                        dataVal = $option.data('value'),
                        showWord = $option.text(),
                        val =  $option.val();
                    if(showWord == inputVal){
                        verification = dataVal;
                    }
                }
                return verification;
            }
           function left(str, num)
           {
               return str.substring(0,num)
           }



        </script>
    </head>
    <body style="text-align: center">
    <img src="{{ URL::asset('img/logo.png') }}">

    <h2 class="title-m "><?php echo $title?></h2>

<form action="{{ route('customer.store') }}" method="post" name="form1">
    {{ csrf_field() }}
    <table border="1" class="tbl" style="margin: auto" width="95%">

        <tr>
            <td>公司編號</td><td ><input type="text" id="companyid" name="companyid" ></td>
            <td>公司名稱</td><td ><input type="text" name="companyname"></td></tr>
        <tr> <td>公司英文名</td><td><input type="text" id="companyname_en" name="companyname_en" ></td>
            <td>公司簡稱</td><td><input type="text" name="abbreviation" ></td></tr>
        <tr><td>國家</td><td>

                <input list="country" id="nation"  name="country"  placeholder="搜尋國家" value="" autocomplete="off">

                    <datalist id="country">
                        @foreach($custlist as  $c)
                          @php
                            if($c->codeno==""){
                                $code="01"; }
                            else{
                                $code=$c->codeno+1;
                                $code= str_pad($code,2,'0',STR_PAD_LEFT);}

                                @endphp
                       <option id="coutryoption" data-value="{{$c->country_code}}{{$code}}">{{$c->country_Englishname}}</option>
                        @endforeach
                    </datalist>

<input type="hidden" id="countrynum" name="countrynum" value="">
                    </td>
            <td>國碼</td><td> <input type="text" id="countrycode" name="countrycode"  readonly></td></tr>
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
             <br> 職稱: <input type="text" name="contactposition" >
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
