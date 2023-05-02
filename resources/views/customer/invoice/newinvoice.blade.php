<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增客戶Invoice單";
date_default_timezone_set("Asia/Taipei");
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title><?php echo $title ?></title>
    <style>
        input {
            margin: 10px;
            width: 200px;
        }

        select {
            margin: 10px;
            width: 200px;
        }

        table {
            margin: auto;
        }

        #test tr td input {
            width: 200px;
        }

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

<h2 class="title-m "><?php echo $title ?></h2>

<a id="gotop">
    <font size="20px"> ^</font>
</a>
<br><br>
<form action="{{ route('invoice.store') }}" method="post" id="form1" name="form1">
    {{ csrf_field() }}
<table class="" width="90%">
    <tr>
        <td><img src="{{URL::asset('img/PIimg.png')}}"></td>
        <td colspan="3" style="text-align:right;font-size: 36px;font-family: Calibri"><font color='#8EA9DB'><b>
                    INVOICE</b></font></td>
    </tr>

    @foreach($invoicehead as $head)
    <tr>
        <td style="text-align: left;font-size: 6px;width: 350px;">
        </td>


        <td colspan="2" style="text-align:right;">
            <table class="bor-black" width="70%" style="margin-right: 0px;">
                <tr>
                    <td style="text-align: center;font-size: 10px;"><b>Order Date:</b></td>
                    <td style="text-align: center;font-size: 8px;background:#D6DCE4">
                        <input type="text" name="orderdate" value="{{$head->orderdate}}">
                        <input type="hidden" name="orderid" value="{{$head->id}}">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;font-size: 10px;"><b>IV No.:</b></td>
                    <td style="text-align: center;font-size: 8px;background:#D6DCE4"><input type="text" name="ivnum" value="IV{{$head->nonumber}}">
                        <input type="hidden" name="pino" value="{{$head->nonumber}}">
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>



    <br>

    <table class="bor-blue" width="90%">

        <tr style="background:#305496;">
            <th colspan="2" style="text-align: left;"><font color="white">BILL TO</font></th>
            <th colspan="3" style="text-align: left;"><font color="white">SHIP TO</font></th>
        </tr>

            <tr>
                <td>Company Name:</td>
                <td><input type="text" id="billcompanyname" name="billcompanyname" style="width:400px;"
                           value="{{$head->billcompanyname}}"></td>
                <td>Company Name:</td>
                <td colspan="2"><input type="text" name="shipcompanyname" style="width:400px;"
                                       value="{{$head->shipcompanyname}}"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" id="billaddress" name="billaddress" style="width:400px;"
                           value="{{$head->billingcompanyaddress}}"></td>
                <td>Address:</td>
                <td colspan="2"><input type="text" name="shipaddress" style="width:400px;"
                                       value="{{$head->shipcompanyaddress}}"></td>
            </tr>
            <tr>
                <td>Tel:</td>
                <td><input type="text" name="billtel" style="width:400px;" value="{{$head->customerphone}}"></td>
                <td>Tel:</td>
                <td colspan="2"><input type="text" name="shiptel" style="width:400px;"
                                       value="{{$head->customerphone}}"></td>
            </tr>

        <tr>
            <td>Tax ID</td>
            <td colspan="4" style="text-align: left;padding-left: 50px;"><input type="text" style="width:400px;"  name="taxid" value="{{$head->taxid}}"
                                                                                onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
        </tr>
        @endforeach
    </table>

    <table id="test" class="bor-blue tbl" width="90%" style="margin: auto">
        <tr style="background:#305496;">
            <th><font color="white">Model Name</font></th>
            <th><font color="white">Description</font></th>
            <th><font color="white">Quantity<br>(PCS)</font></th>
            <th><font color="white">Unit Price </font></th>
            <th><font color="white">Total Amount</font></th>

        </tr>
        <tbody>
        @foreach($pipay as $pay)
        <tr>
            <td><input type="text" name="modelname[]" value="{{$pay->modelname}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            <td><textarea style="text-align: left;vertical-align:top" name="description[]" rows="3" cols="30" class="pre-text">{{$pay->description}}</textarea></td>
            <td>
                <input type="hidden" name="plsts[]" value="N">
                <input type="hidden" name="currency[]" value="{{$pay->currency}}">
                <input type="text" name="quantity[]" required min='1' class="quantity" value="{{$pay->quantity}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            <td><input type="text" name="unitprice[]" required class="unitprice" value="{{$pay->unitprice}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            <td class="convert"><input type="text" name="total[]" value="{{$pay->total}}" class="total" max="0"
                                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>

        </tr>
        @endforeach
        </tbody>
        <tr>
            @foreach($invoicedata as $data)
            <td colspan="4" style="text-align: right;">TOTAL:</td>
            <td colspan="2">
                <input type="text" id="total_all" name="total_all"  class="total_all" value="{{$data->total_all}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" readonly></td>
        </tr>

    </table>
    <br>

    <table class="bor-blue tbl" width="90%" style="margin: auto">
        <tr>
            <td>Ouraddress</td>
            <td style="text-align: left;">
                <select name="ourarea">
                    <option value="1">台灣</option>
                    <option value="2">大陸</option>
                </select></td>
        </tr>

            <tr>
                <td>A/C Name:</td>
                <td style="text-align: left;">
                    <input type="text" id="acname" name="acname" style="width:800px;background: rgba(211,214,206,0.55)"
                           value="HIBERTEK INTERNATIONAL LIMITED" readonly></td>
            </tr>
            <tr>
                <td>ADDRESS OF BANK:</td>
                <td style="text-align: left;">
                    <input type="text" id="addressofbank" style="width:800px;background: rgba(211,214,206,0.55)"
                           name="addressofbank" value="{{$data->addressofbank}}" readonly>
                </td>
            </tr>
            <tr>
                <td>Bank Name:</td>
                <td style="text-align: left;">
                    <input type="text" id="bankname" name="bankname"
                           style="width:800px;background: rgba(211,214,206,0.55)" value="{{$data->bankname}}" readonly>
                </td>
            </tr>
            <tr>
                <td>Acount No.:</td>
                <td style="text-align: left;">
                    <input type="text" id="acountno" name="acountno"
                           style="width:800px;background: rgba(211,214,206,0.55)" value="{{$data->acountno}}" readonly>
                </td>
            </tr>
            <tr>
                <td>Swift Code:</td>
                <td style="text-align: left;">
                    <input type="text" id="swiftcode" name="swiftcode"
                           style="width:800px;background: rgba(211,214,206,0.55)" value="{{$data->swiftcode}}" readonly>
                </td>
            </tr>
            <tr>
                <td>建檔日期</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="creatdate"
                           value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
            </tr>
            <tr>
                <td>建檔人員</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}"
                           readonly></td>
            </tr>
            <tr>
                <td>最後修改日期</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="updatedate"
                           value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
            </tr>
            <tr>
                <td>最後修改人員</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}">
                </td>
                <input type="hidden" name="sts" value="N">
            </tr>
        @endforeach
    </table>
    <br><input type="submit" class="bt-send" value="新增客戶Invoice單"><br><br>
</form>

</body>
</html><?php
