<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增客戶PI單";

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
            margin:10px;
            width:200px;
        }
        select{
            margin:10px;
            width:200px;
        }
    </style>
    <script>
        $(function () {

            $('#btn2').click(function () {
                // $("#rownum").val(num+1);
                $("#test tbody").eq(1).append("<tr><td><input type='text' name='modelname[]' value=''></td>" +
                    "<td><input type='text' name='description[]' value=''></td>" +
                    "<td><input type='text' name='quantity[]' value=''></td>" +
                    "<td><input type='text' name='unitprice[]' class='unitprice' value=''></td>"+
                    "<td class='convert'><input type='text' name='total[]' value='' class='total'></td>" +
                    "<td> <button class='bt-del jq-delete'>刪除</button></td></tr>");

            });

            $(document).on('click', '#creatpino', function () {
                // $("#rownum").val(num-1);

            var pipm=$("#pipm").val();
            var companyid=$("#companyid").val();
            var pipayarea=$("#pipayarea").val();
            var piselect=$("#piselect").val();
            var pidate=$("#pidate").val();
           var piitem=$("#piitem").val();
           var pino=pipm+'-'+companyid+'-'+pipayarea+piselect+pidate+piitem;
           $("#pino").val(pino)


            });




            $(document).on('click', '.jq-delete', function () {
                // $("#rownum").val(num-1);

                price=$(this).parent().parent().find('.total').val()
                $(this).parent().parent().remove();
                $('.total_all').val ($('.total_all').val ()-price);

            });


        });
    </script>
</head>
<body style="text-align: center" onUnload="opener.location.reload()">
@include("include.nav")
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        @include("include.menu")
        <div class="col-md-10">
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>
            <br><br>

            @php $pm=Session::get('empdata')->ename;$pm=substr($pm,0,2) @endphp
            <table  class="" width="100%">
                <tr>
                    <td><img src="{{URL::asset('img/PIimg.png')}}"></td>
                    <td colspan="3" style="text-align:right;font-size: 36px;font-family: Calibri"><font color='#8EA9DB'><b>PROFORMA
                                INVOICE</b></font></td>
                </tr>
               </table>
            <table class="" width="100%" style="text-align: left;" >
                <tr><td style="text-align: right;">Custno:</td>
                    <td>
                        <form method="post" id="form1" name="form1" action="{{route('searchcust')}}">
                            {{ csrf_field() }}
                            <input list="custid" id="cid" name="custid" placeholder="搜尋公司編號" value="{{$cid}}" autocomplete="off">
                            <datalist id="custid">
                                @foreach($custalllist as  $country)
                                    <option value="{{$country->companyid}}"></option>
                                @endforeach
                            </datalist>
                            <input type="submit" value="客戶查詢" class="bt-send" >
                        </form>
                    </td>
                </tr>
            </table>
            <form action="{{ route('custPI.store') }}" method="post" id="form2" name="form2">
                {{ csrf_field() }}
                <table  class="bor-blue" width="100%" style="text-align:center;">
                    <tr>
                        <td> Order Date:</td>
                        <td><input type="text" name="orderdate" value="<?php echo date('Y/m/d') ?>"></td>
                    </tr>
                    <tr>
                        <td rowspan="8">PI No.:</td>
                        <td>PM:</td><td style="text-align: left;"><input type="text" id="pipm" name="pipm" value='<?php echo strtoupper($pm) ?>'></td></tr>
                    <tr> <td> 收款地點:</td>
                        <td style="text-align: left;">
                            <select id="pipayarea" name="pipayarea" >
                                <option value="T">台灣</option>
                                <option value="S">境外</option>
                            </select></td></tr>
                    <tr> <td> 產品選擇:</td>
                        <td style="text-align: left;">
                            <select id="piselect" name="piselect">
                                <option value="P">量產</option>
                                <option value="S">樣品</option>
                            </select></td></tr>
                    <tr> <td> 公司編號:</td><td style="text-align: left;"><input type='text' id="companyid" name='companyid' value='{{$cid}}'></td></tr>
                    <tr> <td> PI日期:</td><td style="text-align: left;"><input type='text' id="pidate" name='pidate' value='<?php echo date("ymd")?>'></td></tr>
                    <tr> <td> PI序號:</td><td style="text-align: left;"><input type='text' id="piitem" name='piitem' value='{{$maxno}}'></td></tr>
                    <tr> <td> PINO:</td><td style="text-align: left;"><input type='text' id="pino" name='pino' value=''>
                            <input type="button" id="creatpino" value="創建單號" class="bt-edit"></td></tr>

                </table>
                <br>
                @if($custlist!="")
                    <table  class="bor-blue" width="100%">
                        <tr style="background:#305496;">
                            <th colspan="2" style="text-align: left;"><font color="white">BILL TO</font></th>
                            <th colspan="3"><font color="white">SHIP TO</font></th>
                        </tr>
                        <tr>
                            @foreach($custlist as $cust)
                                <td>Company Name:</td>
                                <td><input type="text" id="billcompanyname" name="billcompanyname" value="{{$cust->billcompanyname}}"></td>
                                <td>Company Name:</td>
                                <td colspan="2"><input type="text" name="shipcompanyname" value="{{$cust->shipcompanyname}}"></td></tr>
                        <tr>
                            <td>Address:</td>
                            <td><input type="text" id="billaddress" name="billaddress" style="width:400px;" value="{{$cust->billingcompanyaddress}}"></td>
                            <td>Address:</td>
                            <td colspan="2"><input type="text" name="shipaddress" style="width:400px;" value="{{$cust->shipcompanyaddress}}"></td>
                        </tr>
                        <tr>
                            <td>Tel:</td>
                            <td><input type="text" name="billtel" value="{{$cust->customerphone}}"></td>
                            <td>Tel:</td>
                            <td colspan="2"><input type="text" name="shiptel" value="{{$cust->customerphone}}"></td>
                            @endforeach
                        </tr>

                    </table>
                <table id="test" class="bor-blue tbl" width="100%" style="margin: auto">
                   <tr style="background:#305496;">
                       <th ><font color="white">Model Name</font></th>
                    <th><font color="white">Description</font></th>
                    <th><font color="white">Quantity<br>(PCS)</font></th>
                    <th><font color="white">Unit Price <br>(USD)</font></th>
                    <th><font color="white">Total Amount<br>(USD)</font></th>
                    <th><font color="white">刪除</font></th>
                    </tr>
                    <tbody>
                    <tr>
                        <td><input type="text" name="modelname[]" value=""></td>
                        <td><input type="text" name="description[]"  value=""></td>
                        <td><input type="text" name="quantity[]" class="quantity" value=""></td>
                        <td><input type="text" name="unitprice[]" class="unitprice" value=""></td>
                        <td class="convert"><input type="text" name="total[]" value="" class="total"></td>
                        <td><button class="bt-del jq-delete ">刪除</button></td>
                    </tr>
                    </tbody>
                    <tr><td colspan="4" style="text-align: right;">TOTAL:</td><td colspan="2" style="text-align: left;">
                            <input type="text" id="total_all" name="total_all" value="" class="total_all"></td></tr>
                    <tr><td colspan="6"> <input type="button" id="btn2" value="增加欄位" class="bt-add"></td></tr>
                </table>
                        <br>
               <table class="bor-blue tbl" width="100%" style="margin: auto" >
                   <tr><td>Delivery Term:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="deliveryterm" value="" style="width:400px;"></td></tr>
                   <tr>
                       <td rowspan="2">Payment Term:</td>
                       <td>訂金</td>
                       <td ><input type="text" name="depayposit" value="" placeholder="訂金%數"></td>
                       <td><input type="text" name="depositamount" value="" placeholder="金額ex:$10000"></td>
                       <td colspan="4" style="text-align: left;"><input type="text" name="depositmethod" value="" placeholder="ex:Deposit T/T"></td>

                   </tr>
                   <tr>
                       <td>尾款</td>
                       <td><input type="text" name="finalpay" value="" placeholder="尾款%數"></td>
                       <td><input type="text" name="finalamount" value="" placeholder="金額ex:$10000"></td>
                       <td colspan="4" style="text-align: left;"><input type="text" name="finalmethod" value="" style="width:500px;" placeholder="ex:OA30 balance payment from the factory shipping date"></td>

                   </tr>
                   <tr>
                       <td>shipdate:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="shipdate" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>A/C Name:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="acname" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>ADDRESS OF BANK:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="addressofbank" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>Bank Name:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="bankname" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>Acount No.:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="acountno" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>Swift Code:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="swiftcode" value="" style="width:500px;"></td>
                   </tr>
                   <tr>
                       <td>Note:</td>
                       <td colspan="7" style="text-align: left;"><input type="text" name="note" value="" style="width:800px;"></td>
                   </tr>

                <tr>
                    <td colspan="2">建檔日期<br>
                        <input style="background:#F0F0F0;" type="text" name="creatdate" value="<?php echo date("Y-m-d");?>" readonly></td>
                    <td colspan="2">建檔人員<br>
                        <input style="background:#F0F0F0;" type="text" name="createmp" value="{{Session::get('name')}}" readonly></td>
                    <td colspan="2">最後修改日期<br>
                        <input style="background:#F0F0F0;" type="text" name="updatedate" value="<?php echo date("Y-m-d");?>" readonly></td>
                    <td colspan="2">最後修改人員<br>
                        <input style="background:#F0F0F0;" type="text" name="updateemp" value="{{Session::get('name')}}"></td>
                    <input type="hidden" name="sts" value="N">
                </tr>

               </table>
                    <br><input type="submit" class="bt-send" value="新增客戶PI單" ><br><br>
            </form>


            @endif
        </div>
    </div>
</div>
<script>
    function total_(a,b){
        n = parseFloat(a) * parseFloat(b).toFixed(5);
        return  Math.round(n)
    }
    $(function () {
        $(document).on('input propertychange', '.quantity,.unitprice', function () {
            clas = $(this).attr('class')
            if (clas == 'quantity') {
                quantity = $(this).val();
                if (isNaN(quantity)) {
                    alert("請輸入數字");
                    $(this).val("");
                    $(this).focus();
                }
                unitprice = $(this).parent().next().children().val();
                if (isNaN(unitprice)) {
                    alert("請輸入數字");
                    $(this).parent().next().children().val(""); $(this).parent().next().children().val("").focus();
                }
                if (quantity != "" && unitprice != "") {
                    res = total_(quantity,unitprice)
                }
            }
            else {
                unitprice = $(this).val();
                if (isNaN(unitprice)) {
                    alert("請輸入數字");
                    $(this).val("");
                    $(this).focus();
                }
                quantity = $(this).parent().prev().children().val();
                if (isNaN(quantity)) {
                    alert("請輸入數字");
                    $(this).parent().prev().children().val(""); $(this).parent().prev().children().focus();
                }
                if (quantity != "" && unitprice != "") {
                    res = total_(quantity,unitprice)
                }
            }

            $(this).parent().parent().find('.convert').children().val(res)
            total = 0

            $('.total').each(function (i, v) {
                console.log(v)
                total += parseFloat($(this).val())
            })

            $('.total_all').val (total);
        });
        });
</script>
</body>
</html><?php
