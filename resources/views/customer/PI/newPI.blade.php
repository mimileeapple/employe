<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增客戶PI單";
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
#test tr td input{width: 120px;}
        #test tr td select{width:100px;}
    </style>
    <script>
        $(function () {


            $(document).on('click', '#creatpino', function () {
                // $("#rownum").val(num-1);

                var pipm = $("#pipm").val();
                var companyid = $("#companyid").val();
                var pipayarea = $("#pipayarea").val();
                var piselect = $("#piselect").val();
                var pidate = $("#pidate").val();
                var piitem = $("#piitem").val();
                var pino = pipm + '-' + companyid + '-' + pipayarea + piselect + pidate + piitem;
                $("#pino").val(pino)


            });
            $('#btn2').click(function () {
                // $("#rownum").val(num+1);
                $("#test tbody").eq(1).append("<tr><td><input type='text' name='modelname[]' value='' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td><textarea style='ext-align: left;vertical-align:top' name='description[]'  rows='6' cols='40' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'> </textarea></td>" +
                    "<td><select name='currency[]' class='currency'><option value='USD$'>USD$</option><option value='NTD$'>NTD$</option> <option value='CNY￥'>CNY￥</option> <option value='EUR€'>EUR€</option> </select></td>" +
                    "<td><input type='text' name='quantity[]' required min='1' class='quantity' value='' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td><input type='text' name='unitprice[]'  required class='unitprice' value='' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td class='convert'><input type='text' name='total[]' value='' class='total' max='0' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td> <button class='bt-del jq-delete'>刪除</button></td></tr>");

            });
            $(document).on('click', '.jq-delete', function () {
                // $("#rownum").val(num-1);
                var yes = confirm('你確定刪除此列嗎？');
                if (yes) {
                    // $("#rownum").val(num-1);
                    price = $(this).parent().parent().find('.total').val()
                    $(this).parent().parent().remove();
                    $('.total_all').val($('.total_all').val() - price);
                    alert('刪除成功');}
                else {
                    alert('取消');
                    return false;
                }


            });
            $('#payadd').click(function () {
                // $("#rownum").val(num+1);
                $("#payaddrow tbody").eq(1).append("<tr><td><input type='text' name='payposit[]' value='' placeholder='付款%數' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td><input type='text' name='amount[]' value='' placeholder='金額ex:10000' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td style='text-align: left;'><input type='text' name='method[]' value='' placeholder='ex:Deposit T/T' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>" +
                    "<td><input type='button' class='bt-del' value='刪除' id='delpayment'></td></tr>");

            });
            $(document).on('click', '#delpayment', function () {
                var yes = confirm('你確定刪除此列嗎？');
                if (yes) {
                    // $("#rownum").val(num-1);
                    $(this).parent().parent().remove();
                    alert('刪除成功');}
                else {
                    alert('取消');
                    return false;
                }


            });
            $(document).on('change', '#addressofbank', function () {
                var a = $("#addressofbank").find(":selected").val();//取得值了
                //      $('.addressofbank').val(a);
                //  })
                $.ajax({
                    url: '{{route('findbankdata')}}',
                    method: 'post',
                    data: {
                        'addressofbank': $('#addressofbank').val(),
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (res) {

                        html = ''
                        $.each(res, function (i, v) {
                            $("#bankadd").val(v.addressofbank);
                            $(".addressofbank").val($("#addressofbank").text());
                            $("#bankname").val(v.bankname);
                            $("#acountno").val(v.acountno);
                            $("#swiftcode").val(v.swiftcode);
                            $("#ouraddress").val(v.ouraddress);
                        })
                        $("#addressofbank").val(a);
                    },
                    // error:function(err){console.log(err)},
                });
            });
        });
    </script>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title ?></h2>

<a id="gotop">
    <font size="20px"> ^</font>
</a>
<br><br>

@php $pm=Session::get('empdata')->ename;$pm=substr($pm,0,2) @endphp
<table class="" width="90%">
    <tr>
        <td><img src="{{URL::asset('img/PIimg.png')}}"></td>
        <td colspan="3" style="text-align:right;font-size: 36px;font-family: Calibri"><font color='#8EA9DB'><b>PROFORMA
                    INVOICE</b></font></td>
    </tr>
</table>
<table class="" width="90%" style="text-align: left;">
    <tr>
        <td style="text-align: right;">Custno:</td>
        <td>
            <form method="post" id="form1" name="form1" action="{{route('searchcust')}}">
                {{ csrf_field() }}
                <input list="custid" id="cid" name="custid" placeholder="搜尋公司編號" value="{{$cid}}" autocomplete="off">
                <datalist id="custid">
                    @foreach($custalllist as  $country)
                        <option value="{{$country->companyid}}"></option>
                    @endforeach
                </datalist>
                <input type="submit" value="客戶查詢" class="bt-send">
            </form>
        </td>
    </tr>
</table>

<form action="{{ route('custPI.store') }}" method="post" id="form2" name="form2">
    {{ csrf_field() }}
    <table class="bor-blue" width="90%" style="text-align:center;">
        <tr>
            <td> Order Date:</td>
            <td><input type="text" name="orderdate" value="<?php echo date('Y/m/d') ?>"></td>
        </tr>
        <tr>
            <td rowspan="8">PI No.:</td>
            <td>PM:</td>
            <td style="text-align: left;">
                <input type="text" id="pipm" name="pipm" value='<?php echo strtoupper($pm) ?>'></td>
        </tr>
        <tr>
            <td> 收款地點:</td>
            <td style="text-align: left;">
                <select id="pipayarea" name="pipayarea">
                    <option value="T">台灣</option>
                    <option value="S">境外</option>
                </select></td>
        </tr>
        <tr>
            <td> 產品選擇:</td>
            <td style="text-align: left;">
                <select id="piselect" name="piselect">
                    <option value="P">量產</option>
                    <option value="S">樣品</option>
                </select></td>
        </tr>
        <tr>
            <td> 公司編號:</td>
            <td style="text-align: left;"><input type='text' id="companyid" name='companyid' value='{{$cid}}' required></td>
        </tr>
        <tr>
            <td> PI日期:</td>
            <td style="text-align: left;"><input type='text' id="pidate" name='pidate' value='<?php echo date("ymd")?>'></td>
        </tr>
        <tr>
            <td> PI序號:</td>
            <td style="text-align: left;"><input type='text' id="piitem" name='piitem' value='{{$maxno}}'></td>
        </tr>
        <tr>
            <td> PINO:</td>
            <td style="text-align: left;"><input type='text' id="pino" name='pino' value='' required>
                <input type="button" id="creatpino" value="創建單號" class="bt-edit"></td>
        </tr>

    </table>
    <br>
    @if($custlist!="")

        <table class="bor-blue" width="90%">

            <tr style="background:#305496;">
                <th colspan="2" style="text-align: left;"><font color="white">BILL TO</font></th>
                <th colspan="3"><font color="white">SHIP TO</font></th>
            </tr>
            <tr class="bg-pink">
                <td>receiptnotes:</td>
                <td><input type="text" id="receiptnotes" name="receiptnotes" style="width:400px;" value=""></td>
                <td>shippingnotes:</td>
                <td colspan="2"><input type="text" name="shippingnotes" style="width:400px;" value=""></td>
            </tr>
            @foreach($custlist as $cust)
            <tr>
                <td>Company Name:</td>
                <td><input type="text" id="billcompanyname" name="billcompanyname" style="width:400px;" value="{{$cust->billcompanyname}}"></td>
                <td>Company Name:</td>
                <td colspan="2"><input type="text" name="shipcompanyname" style="width:400px;" value="{{$cust->shipcompanyname}}"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" id="billaddress" name="billaddress" style="width:400px;" value="{{$cust->billingcompanyaddress}}"></td>
                    <td>Address:</td>
                    <td colspan="2"><input type="text" name="shipaddress" style="width:400px;" value="{{$cust->shipcompanyaddress}}"></td>
            </tr>
            <tr>
                <td>Tel:</td>
                <td><input type="text" name="billtel" style="width:400px;" value="{{$cust->customerphone}}"></td>
                <td>Tel:</td>
                <td colspan="2"><input type="text" name="shiptel" style="width:400px;"
                                           value="{{$cust->customerphone}}"></td>
            </tr>
            @endforeach
            <tr>
                <td>Tax ID</td>
                <td colspan="4" style="text-align: left;"><input type="text" name="taxid" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            </tr>
        </table>
        <table id="test" class="bor-blue tbl" width="90%" style="margin: auto">
            <tr style="background:#305496;">
                <th><font color="white">Model Name</font></th>
                <th><font color="white">Description</font></th>
                <th><font color="white">Currency</font></th>
                <th><font color="white">Quantity<br>(PCS)</font></th>
                <th><font color="white">Unit Price </font></th>
                <th><font color="white">Total Amount</font></th>
                <th><font color="white">刪除</font></th>
            </tr>
            <tbody>
            <tr>
                <td><input type="text" name="modelname[]" value="" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td><textarea style="text-align: left;vertical-align:top" name="description[]" rows="8" cols="20" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                    </textarea></td>
                <td><select name="currency[]" class="currency">
                        <option value="USD$">USD$</option>
                        <option value="NTD$">NTD$</option>
                        <option value="CNY￥">CNY￥</option>
                        <option value="EUR€">EUR€</option>
                    </select></td>
                <td><input type="text" name="quantity[]" required min='1' class="quantity" value="" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td><input type="text" name="unitprice[]" required  class="unitprice" value="" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td class="convert"><input type="text" name="total[]" value="" class="total" max="0" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td><button class="bt-del jq-delete ">刪除</button></td>
            </tr>
            </tbody>
            <tr>
                <td colspan="5" style="text-align: right;">TOTAL:</td>
                <td colspan="2" style="text-align: left;">
                    <input type="text" id="total_all" name="total_all" value="" class="total_all" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" readonly></td>
            </tr>
            <tr>
                <td colspan="7"><input type="button" id="btn2" value="增加產品欄位" class="bt-add"></td>
            </tr>
        </table>
        <br>
        <table class="bor-blue tbl" width="90%" style="margin: auto">
            <tr>
                <td>Delivery Term:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" name="deliveryterm" value="" style="width:400px;" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
            </tr>
        </table>
        <table class="bor-blue tbl" width="90%" style="margin: auto" id="payaddrow">
            <tr style="background:#305496;">
                <th colspan="4"><font color="white">Payment Term:</font></th>
            </tr>
            <tr>
                <tbody>
                <td><input type="text" name="payposit[]" value="" placeholder="付款%數"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td><input type="text" name="amount[]" value="" placeholder="金額ex:10000"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td  style="text-align: left;">
                    <input type="text" name="method[]" value="" placeholder="ex:Deposit T/T"
                           onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                <td><input type="button" class="bt-del" value="刪除" id="delpayment"></td>
                </tbody>
            </tr>
            <tr>
                <td colspan="4"><input type="button" id="payadd" value="增加Payment Term欄位" class="bt-add"></td>
            </tr>
        </table>

        <table class="bor-blue tbl" width="90%" style="margin: auto">
            <tr>
                <td>shipdate:</td>
                <td colspan="7" style="text-align: left;">
                    <textarea name="shipdate" rows="6" cols="120" style="text-align: left;vertical-align:top"
                              onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                    </textarea></td>
            </tr>
            <tr>
                <td>A/C Name:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="acname" name="acname" style="width:800px;background: rgba(211,214,206,0.55)" value="HIBERTEK INTERNATIONAL LIMITED" readonly></td>
            </tr>
            <tr>
                <td>ADDRESS OF BANK:</td>
                <td colspan="7" style="text-align: left;">
                    <select id="addressofbank" class="addressofbank" style="width:800px;">
                        <option value=""></option>
                        <option value="1">65 CHULIA STREET, OCBC CENTRE, SINGAPORE 049513</option>
                        <option value="2">28th FLOOR, TOWER 6, THE GATEWAY, 9 CANTON ROAD, TSIMSHATSUI, KOWLOON, HONG KONG</option>
                        <option value="3">NO.90, SEC.2, WUNHUA RD., BANCIAO DIST., NEW TAIPEI CITY 220-41,TAIWAN(R.O.C)</option>
                    </select>
                    <input type="hidden" id="bankadd" name="addressofbank">
                </td>
            </tr>
            <tr>
                <td>Bank Name:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="bankname" name="bankname" style="width:800px;" readonly></td>
            </tr>
            <tr>
                <td>Acount No.:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="acountno" name="acountno" style="width:800px;" readonly></td>
            </tr>
            <tr>
                <td>Swift Code:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="swiftcode" name="swiftcode" style="width:800px;" readonly></td>
            </tr>
            <tr>
                <td>公司地址</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="ouraddress" name="ouraddress" style="width:800px;" readonly></td>
            </tr>
            <tr>
                <td>Note:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" name="note" value="Full payment on PI should arrive at seller's bank account (both buyer & seller's bank's charge)."
                           style="width:800px;" readonly></td></tr>

            <tr>
                <td colspan="2">建檔日期<br>
                    <input style="background:#F0F0F0;" type="text" name="creatdate" value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
                <td colspan="2">建檔人員<br>
                    <input style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}" readonly></td>
                <td colspan="2">最後修改日期<br>
                    <input style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
                <td colspan="2">最後修改人員<br>
                    <input style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}"></td>
                <input type="hidden" name="sts" value="N">
            </tr>

        </table>
        <br><input type="submit" class="bt-send" value="新增客戶PI單"><br><br>
</form>


@endif

<script>
    /*$(function () {
        // setup enter to next input element function
        setupEnterToNext();
    });


    // enter to next input element function
    function setupEnterToNext() {

        // add keydown event for all inputs
        $(':input').keydown(function (e) {

            if (e.keyCode == 13 /*Enter*/
    //) {

    // focus next input elements
    /* $(':input:visible:enabled:eq(' + ($(':input:visible:enabled').index(this) + 1) + ')').focus();
     e.preventDefault();
 }

});
}*/
    function total_(a, b) {
        n = parseFloat(a) * parseFloat(b).toFixed(5);
        return Math.round(n)
    }

    $(function () {
        $(document).on('input propertychange', '.quantity,.unitprice,.total', function () {
            clas = $(this).attr('class')
            if (clas == 'quantity') {
                quantity = $(this).val();
                if (isNaN(quantity)) {
                    alert("請輸入數字");
                    $(this).val("");
                    $(this).focus();
                }
                unitprice = $(this).parent().next().children().val();
                /* if (isNaN(unitprice)) {
                     alert("請輸入數字");
                     $(this).parent().next().children().val(""); $(this).parent().next().children().val("").focus();
                 }*/
                if (quantity != "" && unitprice != "") {
                    res = total_(quantity, unitprice)
                }
            } else {
                unitprice = $(this).val();
                /*if (isNaN(unitprice)) {
                    alert("請輸入數字");
                    $(this).val("");
                    $(this).focus();
                }*/
                quantity = $(this).parent().prev().children().val();
                if (isNaN(quantity)) {
                    alert("請輸入數字");
                    $(this).parent().prev().children().val("");
                    $(this).parent().prev().children().focus();
                }
                if (quantity != "" && unitprice != "") {
                    res = total_(quantity, unitprice)
                }
            }

            $(this).parent().parent().find('.convert').children().val(res)
            total = 0

            $('.total').each(function (i, v) {
                console.log(v)
                total += parseFloat($(this).val())
            })

            $('.total_all').val(total);
        });

    });
</script>
</body>
</html><?php
