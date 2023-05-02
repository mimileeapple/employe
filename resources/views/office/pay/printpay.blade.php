<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title="新增付款申請書";
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
<body style="text-align: center" onload="window.print()">
<br>
@foreach($paylist as $pay)
    <table border="1" class="tbl " style="margin: auto;text-align: center;" width="95%">
        <tr><td colspan="5" ><h2>付款申請書</h2></td></tr>
        <tr><td>申請日期:</td>
            <td  style="text-align: left;">{{$pay->orderdate}}</td>
            <td style="text-align: left;width:80px;">分類</td>
            <td>{{$pay->feetype}}<br>-{{$pay->feename}}</td>
            <td>付款原因/備註</td>
        </tr>
        <tr><td>收款單位(戶名)</td><td colspan="3" style="text-align: left;">{{$pay->accountname}}
            </td>
            <td rowspan="6" style="text-align: left;vertical-align:top;">
                <pre>{{$pay->paynote}}</pre>
            </td>
        </tr>
        <tr><td>收款帳號</td><td colspan="4" style="text-align: left;">{{$pay->accountno}}</td></tr>
        <tr><td>收款銀行</td><td  colspan="4" style="text-align: left;">{{$pay->accountbank}}</td></tr>
        <tr><td>銀行代號</td><td colspan="4" style="text-align: left;">{{$pay->bankcode}}</td></tr>

        <tr><td>金額</td><td colspan="4" style="text-align: left;">
            {{$pay->currency}}{{$pay->total}}</td></tr>
        <tr><td style="height:60px;">審批</td>
            <td colspan="4" style="text-align: left;">{{$pay->approval}}</td></tr>
          <tr> <td style="height:60px;">財務</td>
            <td colspan="2" style="text-align: left;">{{$pay->finance}}</td>
              <td style="height:60px;">付款狀態</td>
              <td colspan="2" style="text-align: left;">
                  @if($pay->sts=="N")尚未付款
                  @elseif($pay->sts=="Y")已付款<br>{{$pay->paydate}}
                  @endif
                  </td>
          </tr>

        <td colspan="5" style="text-align: left;">
        會計:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           覆核:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            出納:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            申請人:{{$pay->createmp}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           領款人:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
@endforeach
    <br><br>

</body>
</html><?php
