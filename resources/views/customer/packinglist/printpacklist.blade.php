<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "列印客戶Packing List單";
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

        table {
            margin: auto;
        }


        .pre-text {
            white-space: pre-wrap;
        }
        #leftfloat{
            float: left;
        }
        #rightfloat{
            float: left;
            margin-left: 60px;
            font-size: 16px;
        }
        #rightfloat td{
            height:50px;
        }
        #create{
            clear: both;
        }
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
            }

            .noBreak {
                break-inside: avoid;
            }
        }

        @page {
            size: A4 portrait;
            margin-top: 1cm;
        }

        @page :first {
            margin-left: 1cm;
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
<table class="" width="90%">
    <tr>
        <td style="text-align:left;font-size:20px;font-family: Calibri;width:120px;padding-left: 10px;"><b>Hibertek International Limited</b></td >
        <td colspan="2" style="text-align:right;font-size:30px;font-family: Calibri;"><font color='#8EA9DB'><b>
                    PACKING LIST</b></font></td>
    </tr>

@foreach($listdata as $val)
    <tr>
        <td style="text-align: left;font-size: 6px;width: 350px;padding-left: 10px;">
            {{$val->ouraddress}} <br>
            TEL: {{$val->ourtel}}<br>
            FAX: {{$val->ourfax}}
        </td>

        <td colspan="2" style="text-align:right;">
            <table class="tbl" width="100%" style="margin-right: 0px;font-size: 8px;">
                <tr>
                    <td style="text-align: center;font-size: 6px;"><b>Shipping Date:</b></td>
                    <td style="text-align: center;font-size: 6px;background:#D6DCE4">
                        {{$val->shippingdate}}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;font-size: 6px;"><b>PL No.:</b></td>
                    <td style="text-align: center;font-size: 6px;background:#D6DCE4">{{$val->plno}}

                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>



    <br>

    <table class="tbl" width="90%">

        <tr style="background:#305496;">
            <th colspan="2" style="text-align: left;"><font color="white">BILL TO</font></th>
            <th colspan="3" style="text-align: left;"><font color="white">SHIP TO</font></th>
        </tr>

            <tr style="font-size: 8px;">
                <td>Company Name:</td>
                <td>{{$val->billcompanyname}}</td>
                <td>Company Name:</td>
                <td colspan="2">{{$val->shipcompanyname}}</td>
            </tr>
            <tr style="font-size: 8px;">
                <td>Address:</td>
                <td>{{$val->billingcompanyaddress}}</td>
                <td>Address:</td>
                <td colspan="2">{{$val->shipcompanyaddress}}</td>
            </tr>
            <tr style="font-size: 8px;">
                <td>Tel:</td>
                <td>{{$val->customerphone}}</td>
                <td>Tel:</td>
                <td colspan="2">{{$val->customerphone}}</td>
            </tr>


    </table>
@endforeach
    <table id="test" class=" tbl" width="90%" style="margin: auto">
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

        @foreach($data as $i=>$d)

        <tr style="font-size: 8px;">
            <td>{{$d->modelname}}</td>
            <td><pre>{{$d->description}}</pre></td>
            <td>{{$d->quantity}}</td>
            <td>{{$d->ctns}}</td>
            <td>@if($d->pallets==0) *
                 @else {{$d->pallets}}
                    @endif
            </td>
            <td>{{$d->nw}}</td>
            <td>{{$d->gw}}</td>
            <td>{{$d->cbm}}</td>

        </tr>
        @endforeach

        @foreach($listdata as $val)
        <tr>

            <th colspan="2" style="text-align: right;">TOTAL:</th>
            <th>{{$val->qtytotal}}</th>
            <th>{{$val->ctnstotal}}</th>
            <th>{{$val->palletstotal}}</th>
            <th>{{$val->nwtotal}}</th>
            <th>{{$val->gwtotal}}</th>
            <th>{{$val->cbmtotal}}</th>
        </tr>

    </table>
    <br>

    <table id="leftfloat" class="" width="30%" style="margin-left:30px;text-align: left;border:2px black groove;font-size: 8px;">

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
    <table id="rightfloat" class="">
       <tr><td> HIBERTEK INTERNATIONAL LIMITED</td></tr>
        <tr><td ></td></tr>
        <tr ><td style="border-bottom: 2px black solid;"></td></tr>
        <tr><td><font style="font-size: 16px;">(AUTHORIZED SIGNATURE)</font></td></tr>
    </table>
@endforeach

</body>
</html><?php
