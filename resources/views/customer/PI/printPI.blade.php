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
    <title>{{$pino}}</title>
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
@foreach($custhead as $data)
    @if($data->item==2)
<p style="text-align: right;padding-right:30px;">page 1/2</p>
    @else
    @endif
    @php
        $orderdate=$data->orderdate;
    @endphp
    <table width="95%">
        <tr>
            <td style="text-align: left;"><img src="{{URL::asset('img/PIimg.png')}}"></td>

            <td colspan="2" style="text-align:right;font-size:26px;font-family: Calibri"><font color='#8EA9DB'><b>PROFORMA
                        INVOICE</b></font></td>
        </tr>
        <tr>
            <td style="text-align: left;font-size: 6px;width: 350px;">{{$data->ouraddress}}
            </td>


            <td colspan="2" style="text-align:right;">
                <table class="bor-black" width="70%" style="margin-right: 0px;">
                    <tr>
                        <td style="text-align: center;font-size: 10px;"><b>Order Date:</b></td>
                        <td style="text-align: center;font-size: 8px;background:#D6DCE4">{{$data->orderdate}}</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;font-size: 10px;"><b>PI No.:</b></td>
                        <td style="text-align: center;font-size: 8px;background:#D6DCE4">{{$data->pino}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class=" tbl" width="95%" style="font-size:6pt;">
        <tr style="background:#305496;height: 25px;">
            <th colspan="2" style="text-align: left;margin: 3px;"><font color="white" style="margin: 5px;">BILL
                    TO</font></th>
            <th colspan="3" style="text-align: left;"><font color="white">SHIP TO</font></th>
        </tr>
        <tr>
            <td  style="text-align: left;">Company Name:</td>
            <td style="text-align: left;font-size:6px;">{{$data->billcompanyname}}</td>
            <td style="text-align: left;">Company Name:</td>
            <td colspan="2" style="text-align: left;font-size:8px;">{{$data->shipcompanyname}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Address:</td>
            <td style="text-align: left;font-size:6px;">{{$data->billaddress}}</td>
            <td style="text-align: left;">Address:</td>
            <td colspan="2" style="text-align: left;font-size:6px;">{{$data->shipaddress}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Tel:</td>
            <td style="text-align: left;font-size:6px;">{{$data->billtel}}</td>
            <td style="text-align: left;">Tel:</td>
            <td colspan="2" style="text-align: left;font-size:6px;">{{$data->shiptel}}</td>

        </tr>
        @if($data->taxid!="")
        <tr>
            <td style="text-align: left;">Tax ID</td>
            <td colspan="4" style="text-align: left">{{$data->taxid}}</td>
        </tr>
            @endif
    </table>
@endforeach

<table class=" tbl" width="95%" style="margin: auto;font-size:6px;">
    <tr style="background:#305496;">
        <th><font color="white">Model Name</font></th>
        <th><font color="white">Description</font></th>
        <th><font color="white">Quantity<br>(PCS)</font></th>
        <th><font color="white">Unit Price<br>{{$currency}} </font></th>
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
            <td>{{$pay->description}}</td>
            <td>{{$pay->quantity}}</td>
            <td><?php
                    if ($pay->unitprice == "0") {
                        echo "${$unitprice}0";
                    } else {
                        echo "${$unitprice}$price";
                    } ?></td>
            <td style="background:#D6DCE4"><?php if ($pay->total == "0") {
                    echo "F.O.C";
                } else {
                    echo "${$unittotal}$total";
                } ?>

            </td>

        </tr>
    @endforeach

    </tbody>

    @foreach($custdata as $cust)
        @php
            $total_all=number_format($cust->total_all,2);
              $$total_all="$unit";


        @endphp
        <tr>
            <td colspan="4" style="text-align: right;">TOTAL:</td>
            <td colspan="2" style="text-align: center;background:#D6DCE4"><?php echo "${$total_all}$total_all"; ?></td>
        </tr>
</table>


<table class=" tbl" width="95%" style="margin: auto;font-size: 4px;">
    <tr>
        <td colspan="4" class="bg-black" style="text-align: left;font-size: 10px;"><font color="white">Terms and
                Condition</font></td>
    </tr>
    <tr>
        <td>1. Delivery Term:</td>
        <td colspan="3" style="text-align: left;">{{$cust->deliveryterm}}<br></td>
    </tr>
    <tr>
        <td>2. Payment Term:</td>
        <td colspan="3">
            @if($payment>0)
                <table class=" tbl" width="100%">
                    @foreach($payment as $ment)
                        <tr>
                            <td style="text-align: left;width: 70px;">{{$ment->payposit}}</td>
                            <td style="text-align: left;width:200px;">{{$ment->amount}}</td>
                            <td style="text-align: left;">{{$ment->method}}</td>
                        </tr>
                    @endforeach

                </table>
            @else
            @endif
        </td>

    </tr>
    <tr>
        <td>3.Shipdate:</td>
        <td colspan="3" style="text-align: left;font-size: 10px;">{{$cust->shipdate}} 2) National Holidays or Local
            Custom Clearnace (both buyer and seller
            sides) might impact the delivery date 3) In case there is an unexpected event that could delay the
            production and/ or
            shipment, the Seller shall promptly notify the Buyer to determine a new delivery date.
        </td>
    </tr>
    <tr>
        <td>4. Warehouse fee:</td>
        <td colspan="3" style="text-align: left;">The Seller offers 7 days free of charge of warehouse costs. If the
            Buyer delays the shipment more than 7 days, the Buyer
            should pay USD $5 per pallet per day.
        </td>
    </tr>
    <tr>
        <td>5. Quotation Term:</td>
        <td colspan="3" style="text-align: left;">Price effective period: Within 15 days</td>
    </tr>
    <tr>


    <tr>
        <td rowspan="5">6. Bank Information:</td>
        <td style="text-align: left;">A/C Name:</td>
        <td colspan="2" style="text-align: left;">{{$cust->acname}}</td>
    </tr>
    <tr>
        <td style="text-align: left;">ADDRESS OF BANK:</td>
        <td colspan="2" style="text-align: left;">{{$cust->addressofbank}}</td>
    </tr>
    <tr>
        <td style="text-align: left;">Bank Name:</td>
        <td colspan="2" style="text-align: left;">{{$cust->bankname}}</td>
    </tr>
    <tr>
        <td style="text-align: left;">Acount No.:</td>
        <td colspan="2" style="text-align: left;">{{$cust->acountno}}</td>
    </tr>
    <tr>
        <td style="text-align: left;">Swift Code:</td>
        <td colspan="2" style="text-align: left;">{{$cust->swiftcode}}</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center;color: red;">{{$cust->note}}</td>
    </tr>
    @endforeach
    <tr>
        <td colspan="4" style="text-align: left;color: white;background: #aaaaaa"> Additional Details</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left;">
            <p style="font-size: 4pt;">
                1.This order is irrevocable.<br>
                2.This Proforma Invoice is equivalent to Sales Contract with legal effect.<br>
                3.Partial shipment is allowed.<br>
                4.The delivery time shall be in accordance with the Proforma Invoice and counted from the date of
                receipt of payment.<br>
                5. The ownership of the goods and the deposit shall belong to the Sellers if the Buyer failss to
                complete the balance payment within 1 month after the due date of rest payment.<br>
                6. The Buyer and the Seller shall resolve amicably all disputes. If the Buyer and Seller fail to settle
                disputes within 30 days, such disputes shall be referred to the Shenzhen Court of International
                Arbitration in People's Republic of China.<br>
                7. The sellers shall not be held liable for failure or delay in delivery of the entire lot or a portion
                of the goods in consequence of any incidents.<br>
                8. This PI (contract) becomes effective on the date it is signed by the Buyer and the Seller.
            </p></td>
    </tr>
</table>
<table width="95%" style="text-align: left;font-size:8px;">
    <tr>
        <td style="width:300px;">The Buyer:</td>
        <td>Date:</td>
        <td style="width:300px;"></td>
        <td style="width:300px;">The Seller:<img style="width:100px;height:50px;" src="../{{$mysign}}"></td>
        <td style="text-align:right;width:300px;">Date:</td>
        <td style="width:200px;text-align: left;"><?php echo $orderdate; ?></td>
    </tr>

</table>
@if($data->item==2)
<P style='page-break-after:always'></P>


<p style="text-align: right;padding-right:30px;">page 2/2</p>
<table class="" width="95%">
    <tr>

        <td><p style="color:#8EA9DB;font-size: 26px;margin-top:8px;text-align: left;"><b>All in One Specification</b>
            </p></td>
    </tr>
</table>

<table class="" width="95%" style="text-align: left;">
    @foreach($spacelist as $space)
        <tr>
            <td><b style="font-size: 14px;width: 300px;">PI Number</b></td>
            <td style="font-size: 10px;padding-left: 5px;">{{$space->pino}}</td>
        </tr>
        <tr>
            <td><b style="font-size: 14px;;width: 300px;">Date</b></td>
            <td style="font-size: 10px;padding-left: 5px;">{{$space->orderdate}}</td>
        </tr>

        @foreach($spacedata as $key=>$data)

            @if($key!=""&&$data!=""&&$key!=null&&$data!=null)




                    @if( !stripos($key,'_'))  <tr><td><b style="font-size: 14px;width: 300px;">{{$key}}</b></td>
{{--                                @elseif((is_array($data))&&$data[0][preg_replace('/\s(?=)/', '', mb_strtolower($key))] ==null)--}}
                                @else  <tr><td><b style="font-size: 14px;width: 300px;"> </b></td>
                                @endif



                @if($key=="Back IO"||$key=="Remark")
                        @php
                            if($key=="Back IO") {$word="backio";}
                            if($key=="Remark"){$word="remark";}
                        @endphp

                        @foreach($data as $i=>$d)
                            @if($i==0&&$d[$word]!=null)
                                <td style="font-size: 10px;padding-left: 5px;">{{$d[$word]}}</td> </tr>
                            @elseif($i>0)
                <tr>
                    <td></td>
                    <td style="font-size: 10px;padding-left: 5px;"> {{$d[$word]}}</td>
                </tr>
                <tr>
                    @endif

                    @endforeach

                    @else
                        <td style="font-size: 10px;padding-left: 5px;">{{$data}}</td></tr>
                    @endif


            @else
            @endif

        @endforeach
        <tr>
            <td><b style="font-size: 14px;width: 300px;">Buyer Date:</b></td>
            <td style="font-size: 10px;padding-left: 5px;">{{$space->buyer}}</td>
        </tr>
        <tr>
            <td><b style="font-size: 14px;width: 300px;">Seller Date:</b></td>
            <td style="font-size: 10px;padding-left: 5px;">{{$space->seller}}</td>
        </tr>
    @endforeach

</table>
@else
    @endif
<br><br><br>
</body>
</html><?php
