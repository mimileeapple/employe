<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");

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
    <title>{{$ivnum}}</title>
    <style>

        table {
            margin: auto;
            padding: 10px;
        }

        td {
            height: 25px;
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
</head>
<body style="text-align: center;zoom:80%" onload="window.print()">

@foreach($invoiceorder as $data)

    <table width="95%">
        <tr>
            <td style="text-align: left;"><img src="{{URL::asset('img/PIimg.png')}}"></td>

            <td colspan="2" style="text-align:right;font-size:32px;padding-right:20px"><font color='#8EA9DB'><b>
                        INVOICE</b></font></td>
        </tr>
        <tr>
            <td style="text-align: left;font-size: 6px;width: 350px;">{{$data->ouraddress}}<br>
                {{$data->ourtel}}&nbsp;&nbsp;&nbsp;&nbsp; {{$data->ourfax}}
            </td>


            <td colspan="2" style="text-align:right;">
                <table class="bor-black" width="70%" style="margin-right: 0px;">
                    <tr>
                        <td style="text-align: center;font-size: 10px;"><b>Order Date:</b></td>
                        <td style="text-align: center;font-size: 8px;background:#D6DCE4">{{$data->orderdate}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;font-size: 10px;"><b>IV No.:</b></td>
                        <td style="text-align: center;font-size: 8px;background:#D6DCE4">{{$ivnum}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class=" tbl" width="95%" style="font-size:6pt">
        <tr style="background:#305496;height: 35px;">
            <th colspan="2" style="text-align: left;margin: 3px;"><font color="white" style="margin: 5px;">BILL
                    TO</font></th>
            <th colspan="2" style="text-align: left;"><font color="white">SHIP TO</font></th>
        </tr>
        <tr>
            <td style="text-align: left;width:120px;"><b>Company Name:</b></td>
            <td style="text-align: left;font-size:6px;padding:5px;">{{$data->billcompanyname}}</td>
            <td style="text-align: left;width:120px;"><b>Company Name:</b></td>
            <td  style="text-align: left;font-size:8px;padding:5px;">{{$data->shipcompanyname}}</td>
        </tr>
        <tr>
            <td style="text-align: left;width:120px;"><b>Address:</b></td>
            <td style="text-align: left;font-size:6px;padding:5px;">{{$data->billaddress}}</td>
            <td style="text-align: left;width:120px;"><b>Address:</b></td>
            <td  style="text-align: left;font-size:6px;padding:5px;">{{$data->shipaddress}}</td>
        </tr>
        <tr>
            <td style="text-align: left;width:120px;"><b>Tel:</b></td>
            <td style="text-align: left;font-size:6px;padding:5px;">{{$data->billtel}}</td>
            <td style="text-align: left;width:120px;"><b>Tel:</b></td>
            <td  style="text-align: left;font-size:6px;padding:5px;">{{$data->shiptel}}</td>

        </tr>
        @if($data->taxid!="")
        <tr>
            <td style="text-align: left;"><b>Tax ID</b></td>
            <td colspan="3" style="text-align: left">{{$data->taxid}}</td>
        </tr>
            @endif
    </table>


<table class=" tbl" width="95%" style="margin: auto;font-size:6px;">
    <tr style="background:#305496;height:50px;">
        <th><font color="white">Model Name</font></th>
        <th><font color="white">Description</font></th>
        <th><font color="white">Quantity<br>(PCS)</font></th>
        <th><font color="white">Unit Price<br>{{$currency}}</font></th>
        <th><font color="white">Total Amount <br>{{$currency}}</font></th>

    </tr>
    <tbody>
    @foreach($pipay as $pay)
        <tr class="bor-black tbl" style="font-size:4px;">
            @php

                $unitprice=abs($pay->unitprice);//單價
                $unit=$pay->currency;//貨幣單位
                if($pay->currency=="USD$"){
                    $unit="US$";
                }


                if($pay->unitprice>0){
                $$unitprice=$unit;}
                elseif($pay->unitprice<0){
                 $$unitprice="-".$unit;
                }
                elseif($pay->unitprice==0){
                   $$unitprice=$unit;
                }
          $price= number_format($unitprice,2);
               $unittotal=abs($pay->total);
                if($pay->total>0){
                $$unittotal=$unit;}
                elseif($pay->total<0){
                 $$unittotal="-".$unit;

                }

                 $total=number_format($unittotal,2);

            @endphp
            <td>{{$pay->modelname}}</td>
            <td style="text-align: left;"> <pre>{{$pay->description}}</pre></td>
            <td>{{$pay->quantity}}</td>
            <td>

                    <?php
                    if ($pay->unitprice == "0") {
                        echo "${$unitprice}0";
                    } else {
                        echo "${$unitprice}$price";
                    }  ?>

            </td>
            <td style="background:#D6DCE4">

                    <?php  if ($pay->total == "0") {
                    echo "F.O.C";
                } else {
                    echo "${$unittotal}$total";
                } ?>

            </td>

        </tr>
    @endforeach

    </tbody>
    @php
        $total_all=number_format($data->total_all,2);
          $$total_all="$unit";


    @endphp

        <tr>
            <td colspan="4" style="text-align: right;">TOTAL:</td>
            <td colspan="2" style="text-align: center;background:#D6DCE4"><?php echo "${$total_all}$total_all"; ?></td>
        </tr>
</table>


<table class=" tbl" width="95%" style="margin: auto;font-size: 4px;text-align: left;">
    <tr style="background:#305496;height: 35px;">
        <th colspan="2" style="text-align: left;margin: 3px;">
            <font color="white" style="margin: 5px;">Terms and Condition</font></th>

    </tr>

    <tr>
        <td>A/C Name:</td>
        <td>{{$data->acname}}</td>
    </tr>
    <tr>
        <td >ADDRESS OF BANK:</td>
        <td>{{$data->addressofbank}}</td>
    </tr>
    <tr>
        <td>Bank Name:</td>
        <td>{{$data->bankname}}</td>
    </tr>
    <tr>
        <td>Acount No.:</td>
        <td>{{$data->acountno}}</td>
    </tr>
    <tr>
        <td>Swift Code:</td>
        <td>{{$data->swiftcode}}</td>
    </tr>
</table>
    @endforeach
<br>
<table width="90%" style="text-align: center;margin: auto;" >
   <tr> <td style="width:50%"></td><td style="width:50%"><b style="font-size:16px">HIBERTEK INTERNATIONAL LIMITED</b></td></tr>
    <tr>  <td></td><td style="border-bottom:solid 1px;height:70px; "></td></tr>
    <tr> <td></td><td><font font-size="4px">(AUTHORIZED SIGNATURE)</font></td></tr>
</table>

<br>
</body>
</html><?php
