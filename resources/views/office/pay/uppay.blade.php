<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="修改付款申請書";
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
           .pre-text {
               white-space: pre-wrap;
           }
        </style>
        <script>
            function fixText(text) {
                var replaceRegex = /(\n\r|\r\n|\r|\n)/g;

                text = text || '';

                return text.replace(replaceRegex, "<br/>");
            }
        </script>
    </head>
    <body style="text-align: center">
    <img src="{{ URL::asset('img/logo.png') }}">

    <h2 class="title-m "><?php echo $title?></h2>
<br>
    @foreach($paylist as $pay)
<form action="{{ route('payoffice.update',$pay->id) }}" method="post" name="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table border="1" class="tbl bor-blue" style="margin: auto;text-align: center;" width="95%">

        <tr><td class="bg-blue" >申請日期:</td>
            <td colspan="2" style="text-align: left;">
                <input type="text" name="orderdate" value="{{$pay->orderdate}}" style="width:380px;"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            <td class="bg-blue">分類</td><td  style="text-align: left;">
                <select style="width:250px;" name="feeid">
                    @foreach($fee as $f)
                        <option value="{{$f->id}}" {{$pay->feeid==$f->id?'selected':""}}>{{$f->feetype}}-{{$f->feename}}</option>
                    @endforeach
                </select>
            </td>
            <td class="bg-blue">付款原因/備註</td>
        </tr>
        <tr><td class="bg-blue">收款單位(戶名)</td>
            <td style="text-align: left;" colspan="2">
                <input type="text" name="accountname" style="width:380px;" value="{{$pay->accountname}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
            </td>
            <td class="bg-blue">是否已付款</td>
            <td style="text-align: left;">
                <select name="sts" style="width:250px;">
                    <option value="N"{{$pay->sts=='N'?'selected':""}}>未付款</option>
                    <option value="Y" {{$pay->sts=='Y'?'selected':""}}>已付款</option>
                </select>
            </td>
            <td rowspan="8">
                <textarea cols="30" rows="20" name="paynote" class="pre-text"
                          onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">{{$pay->paynote}}</textarea>
            </td>
        </tr>
        <tr><td class="bg-blue">收款帳號</td><td colspan="4" style="text-align: left;" >
                <input type="text" name="accountno" style="width:380px;" value="{{$pay->accountno}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
            </td></tr>
        <tr><td class="bg-blue">收款銀行</td><td  colspan="4" style="text-align: left;">
                <input type="text" name="accountbank" style="width:380px;" value="{{$pay->accountbank}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
            </td></tr>
        <tr><td class="bg-blue">銀行代號</td><td colspan="4" style="text-align: left;">
                <input type="text" name="bankcode" style="width:380px;" value="{{$pay->bankcode}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
            </td></tr>
        <tr>
            <td class="bg-blue">金額</td>
            <td colspan="4" style="text-align: left;">
                <select name="currency" class="currency">
                    <option value="USD$" {{$pay->currency=='USD$'?'selected':""}}>USD$</option>
                    <option value="NTD$"  {{$pay->currency=='NTD$'?'selected':""}}>NTD$</option>
                    <option value="CNY￥"  {{$pay->currency=='CNY￥'?'selected':""}}>CNY￥</option>
                    <option value="EUR€"  {{$pay->currency=='EUR€'?'selected':""}}>EUR€</option>
                </select>
                <input type="text" name="total" style="width:350px;" value="{{$pay->total}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
        <tr><td style="height:100px;" class="bg-blue">審批</td><td colspan="2" style="text-align: left;">
                <textarea cols="50" rows="8" class="pre-text" name="approval"
                          onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">{{$pay->approval}}</textarea></td>

            <td style="height:100px;"class="bg-blue" >財務</td><td>
                 <textarea cols="30" rows="8" class="pre-text" name="finance"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">{{$pay->finance}}</textarea>
            </td></tr>


        <tr><td class="bg-blue">建檔日期</td>
            <td><input style="background:#F0F0F0;" type="text" name="creatdate" value="{{$pay->creatdate}}" readonly ></td>
            <td class="bg-blue">申請人員</td>
            <td colspan="2"><input  style="background:#F0F0F0;" type="text" name="createmp" value="{{$pay->createmp}}" readonly ></td></tr>
        <tr><td class="bg-blue">最後修改日期</td>
            <td><input  style="background:#F0F0F0;" type="text" name="updatedate" value="{{$today}}" readonly ></td>
            <td class="bg-blue">最後修改人員</td>
            <td colspan="2"><input  style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}">
               </td></tr>


    </table><br><input type="submit" class="bt-send" value="{{$title}}"><br><br> </form>
    @endforeach
    </body>
    </html><?php
