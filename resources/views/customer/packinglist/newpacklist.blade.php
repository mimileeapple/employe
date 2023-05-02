<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增客戶Packing List單";
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
    <script type="text/javascript" src="{{ URL::asset('myjs/gotop.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
            width: 150px;
        }

        #test {
            zoom:70%
        }
        .pre-text {
            white-space: pre-wrap;
        }
        #leftfloat{
            float: left;
        }
        #rightfloat{
            float: left;
            margin-left: 300px;
            font-size: 22px;
        }
        #rightfloat td{
            height:50px;
        }
        #create{
            clear: both;
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
<form action="{{ route('packlist.store') }}" method="post" id="form1" name="form1">
    {{ csrf_field() }}
<table class="" width="90%">
    <tr>
        <td style="text-align:left;font-size: 36px;font-family: Calibri;width:500px;padding-left: 10px;"><b>Hibertek International Limited</b></td>
        <td colspan="3" style="text-align:right;font-size: 42px;font-family: Calibri;"><font color='#8EA9DB'><b>
                    PACKING LIST</b></font></td>
    </tr>

@foreach($listdata as $val)
    <tr>
        <td style="text-align: left;font-size: 6px;width: 350px;padding-left: 10px;">
            {{$val->ouraddress}} <input type="hidden" name="ouraddress" value="{{$val->ouraddress}}"><br>
            TEL: {{$val->ourtel}}<input type="hidden" name="ourtel" value="{{$val->ourtel}}"><br>
            FAX: {{$val->ourfax}}<input type="hidden" name="ourfax" value="{{$val->ourfax}}">
        </td>


        <td colspan="2" style="text-align:right;">
            <table class="bor-black" width="70%" style="margin-right: 0px;">
                <tr>
                    <td style="text-align: center;font-size: 10px;"><b>Shipping Date:</b></td>
                    <td style="text-align: center;font-size: 8px;background:#D6DCE4">
                        <input type="date" name="shippingdate" value=""
                               onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;font-size: 10px;"><b>PL No.:</b></td>
                    <td style="text-align: center;font-size: 8px;background:#D6DCE4"><input type="text" name="plno" value="PL{{$val->pino}}"
                          onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                        <input type="hidden" name="pino" value="{{$val->pino}}">
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
                <td><input type="text" id="billcompanyname" name="billcompanyname" style="width:400px;" value="{{$val->billcompanyname}}"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td>Company Name:</td>
                <td colspan="2"><input type="text" name="shipcompanyname" style="width:400px;" value="{{$val->shipcompanyname}}"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" id="billaddress" name="billaddress" style="width:400px;" value="{{$val->billingcompanyaddress}}"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td>Address:</td>
                <td colspan="2"><input type="text" name="shipaddress" style="width:400px;" value="{{$val->shipcompanyaddress}}"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            </tr>
            <tr>
                <td>Tel:</td>
                <td><input type="text" name="billtel" style="width:400px;" value="{{$val->customerphone}}"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td>Tel:</td>
                <td colspan="2"><input type="text" name="shiptel" style="width:400px;" value="{{$val->customerphone}}"
                             onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            </tr>
        @endforeach

    </table>

    <table id="test" class="bor-blue tbl" style="width:90%" style="margin: auto">
        <tr style="background:#305496;">
            <th><font color="white">Model Name</font></th>
            <th><font color="white">Description</font></th>
            <th><font color="white">Qty<br>(PCS)</font></th>
            <th><font color="white">CTNS</font></th>
            <th><font color="white">Pallets</font></th>
            <th><font color="white">N.W<br>(KGS)</font></th>
            <th><font color="white">G.W<br>(KGS)</font></th>
            <th><font color="white">MEAS/CTN<br>(CBM)</font></th>

        </tr>

        @foreach($newdata as $i=>$d)

        <tr>
            <td><input type="hidden" name="orderid[]" value="{{$d['orderid']}}">
                <input type="text" name="modelname[]" value="{{$d['modelname']}}" style="width:70px;"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            <td><textarea style="text-align: left;vertical-align:top" name="description[]" rows="3" cols="30" class="pre-text"
                          onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">{{$d['description']}}</textarea></td>
            <td>
                <input type="text" name="quantity[]"  class="quantity" value="{{$d['quantity']}}"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>
            <td><input type="text" name="ctns[]" class="ctns"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>
            <td><input type="text" name="pallets[]"  class="pallets"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>
            <td><input type="text" name="nw[]"  class="nw"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>
            <td><input type="text" name="gw[]"  class="gw"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>
            <td><input type="text" name="cbm[]"  class="cbm"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" required></td>

        </tr>
        @endforeach
        <tr>

            <th colspan="2" style="text-align: right;">TOTAL:</th>
            <th>
                <input type="text" name="qtytotal"   value=""
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" class="qtytotal"></th>
            <th><input type="text" name="ctnstotal" class="ctnstotal"  o
                       nkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></th>
            <th><input type="text" name="palletstotal" class="palletstotal"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></th>
            <th><input type="text" name="nwtotal" class="nwtotal"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></th>
            <th><input type="text" name="gwtotal" class="gwtotal"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></th>
            <th><input type="text" name="cbmtotal" class="cbmtotal"
                       onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></th>
        </tr>

    </table>
    <br>

    <table id="leftfloat" class="" width="30%" style="margin-left:80px;text-align: left;border:2px black groove;">

        <tr><td style="background:#305496;"><font color="white"> SHIPPING MARK:</font></td></tr>
        <tr><td>Model Name:</td></tr>
        <tr><td>QTY.: 1 Unit</td></tr>
        <tr><td>N.W.: &nbsp;&nbsp;&nbsp;&nbsp;  KGS</td></tr>
        <tr><td>G.W.: &nbsp;&nbsp;&nbsp;&nbsp;  KGS</td></tr>
        <tr><td>Part No:</td></tr>
        <tr><td>Serial No:</td></tr>
        <tr><td>EAN number</td></tr>
        <tr><td>Made in China</td></tr>

    </table>
    <br>
    <p style="color:red">※Pallet若無，請打 '0' ※</p>


<table id="create">
            <tr>
                <td>建檔日期</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="creatdate"
                           value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>

                <td>建檔人員</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}"
                           readonly></td>

                <td>最後修改日期</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="updatedate"
                           value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>

                <td>最後修改人員</td>
                <td style="text-align: left;">
                    <input style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}">
                </td>
                <input type="hidden" name="sts" value="N">

            </tr>

    </table>
    <br><input type="submit" class="bt-send" value="{{$title}}"><br><br>
</form>
<script>
    $(function () {
        $(document).ready(function(){

            quantitytotal = 0
            $('.quantity').each(function (i, v) {
                quantitytotal += parseFloat($(this).val())

            })
            $('.qtytotal').val(quantitytotal);

        })



        $(document).on('input propertychange', '.quantity,.ctns,.pallets,.nw,.gw,.cbm', function () {
            clas = $(this).attr('class')
            quantitytotal = 0
            ctnstotal = 0
            palletstotal=0
            nwtotal=0
            gwtotal=0
            cbmtotal=0
            $('.quantity').each(function (i, v) {
                quantitytotal += parseFloat($(this).val())

            })

            $('.qtytotal').val(quantitytotal);

            $('.ctns').each(function (i, v) {
             ctnstotal += parseFloat($(this).val())

            })
            $('.ctnstotal').val(ctnstotal);

            $('.pallets').each(function (i, v) {

                palletstotal += parseFloat($(this).val())
            })
            $('.palletstotal').val(palletstotal);

            $('.nw').each(function (i, v) {

                nwtotal += parseFloat($(this).val())
            })
            $('.nwtotal').val(nwtotal);

            $('.gw').each(function (i, v) {

                gwtotal += parseFloat($(this).val())
            })
            $('.gwtotal').val(gwtotal);

            $('.cbm').each(function (i, v) {

                cbmtotal += parseFloat($(this).val())
            })
            $('.cbmtotal').val(cbmtotal);




        });

    });
</script>
</body>
</html><?php
