<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "修改客戶PI單";

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
            width:120px;
        }
        table{
            margin: auto;
        }
        #test tr td input{width: 120px;}
        #test tr td select{width:100px;}
    </style>
    <script>
        $(function () {

            $('#btn2').click(function () {
                // $("#rownum").val(num+1);
                $("#test tbody").eq(1).append("<tr><td><input type='text' name='modelname[]' value=''></td>" +
                    "<td><textarea style='ext-align: left;vertical-align:top' name='description[]'  rows='6' cols='40' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'> </textarea></td>" +
                    "<td><select name='currency[]' class='currency'><option value='USD$'>USD$</option><option value='NTD$'>NTD$</option> <option value='CNY￥'>CNY￥</option> <option value='EUR€'>EUR€</option> </select></td>"+
                    "<td><input type='text' name='quantity[]' min='1' required class='quantity' value=''></td>" +
                    "<td><input type='text' name='unitprice[]'  required class='unitprice' value=''></td>"+
                    "<td class='convert'><input type='text' name='total[]' value='' class='total' max='0'></td>" +
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
                var yes = confirm('你確定刪除此列嗎？');
                if (yes) {
                    // $("#rownum").val(num-1);
                    price=$(this).parent().parent().find('.total').val()
                    $(this).parent().parent().remove();
                    if(price!=""){
                        $('.total_all').val ($('.total_all').val ()-price);}
                    alert('刪除成功');}
                else {
                    alert('取消');
                    return false;
                }



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
                // var a=$('#addressofbank').text();
                //      $('.addressofbank').val(a);
                //  })
                $.ajax({
                    url:'{{route('findbankdata')}}',
                    method:'post',
                    data: {
                        'addressofbank':$('#addressofbank').val(),
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(res){

                        html=''
                        $.each(res,function(i,v){
                            $("#bankadd").val(v.addressofbank);
                            $("#bankname").val(v.bankname);
                            $("#acountno").val(v.acountno);
                            $("#swiftcode").val(v.swiftcode);
                            $("#ouraddress").val(v.ouraddress);
                        })
                    },
                    // error:function(err){console.log(err)},
                });
            });

        });
    </script>
</head>
<body style="text-align: center" >
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title?></h2>

<a id="gotop">
    <font size="20px"> ^</font>
</a>
<br>
        <table  width="90%" style="text-align:center;">
            <tr>
                <td style="text-align:left;"><img src="{{URL::asset('img/PIimg.png')}}"></td>
                <td colspan="3" style="text-align:right;font-size: 36px;font-family: Calibri"><font color='#8EA9DB'><b>PROFORMA INVOICE</b></font></td>
            </tr>
        </table>
@foreach($custhead as $data)
    <form action="{{ route('custPI.update',$data->id) }}" method="post" id="form2" name="form2">
        {{ csrf_field() }}
        {{method_field('PUT')}}
        <table  class="bor-blue" width="90%" style="text-align:center;">
          <tr>
            <td class="bg-blue"> Order Date:</td>
            <td><input type="text" name="orderdate" value="{{$data->orderdate}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
          </tr>
          <tr>
            <td class="bg-blue" rowspan="8">PI No.:</td>
            <td class="bg-blue">PM:</td>
            <td style="text-align: left;">
               <input type="text" id="pipm" name="pipm" value='{{$data->pipm}}' onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
          </tr>
          <tr>
            <td class="bg-blue"> 收款地點:</td>
            <td style="text-align: left;">
              <select id="pipayarea" name="pipayarea" >
                 <option value="T" {{$data->pipayarea=='T'?'selected':""}}>台灣</option>
                  <option value="S" {{$data->pipayarea=='S'?'selected':""}}>境外</option>
              </select></td>
          </tr>
          <tr>
              <td class="bg-blue"> 產品選擇:</td>
              <td style="text-align: left;">
               <select id="piselect" name="piselect">
                   <option value="P"  {{$data->piselect=='P'?'selected':""}}>量產</option>
                   <option value="S"  {{$data->piselect=='S'?'selected':""}}>樣品</option>
               </select></td></tr>
          <tr>
              <td class="bg-blue"> 公司編號:</td>
              <td style="text-align: left;">
                <input type='text' id="companyid" name='companyid' value='{{$data->companyid}}' onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
          <tr>
              <td class="bg-blue"> PI日期:</td>
              <td style="text-align: left;">
                  <input type='text' id="pidate" name='pidate' value='{{$data->pidate}}' onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
          <tr>
              <td class="bg-blue"> PI序號:</td>
              <td style="text-align: left;">
                  <input type='text' id="piitem" name='piitem' value='{{$data->piitem}}' onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
          <tr>
              <td class="bg-blue"> PINO:</td>
              <td style="text-align: left;">
                   <input type='text' id="pino" name='pino' value='{{$data->pino}}' onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
        </table>
                <br>
        <table  class="bor-blue" width="90%">
           <tr style="background:#305496;">
               <th colspan="2" style="text-align: left;"><font color="white">BILL TO</font></th>
                <th colspan="3"><font color="white">SHIP TO</font></th>
           </tr>
           <tr class="bg-pink">
             <td>receiptnotes:</td>
              <td><input type="text" id="receiptnotes" name="receiptnotes" style="width:400px;" value="{{$data->receiptnotes}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
              <td>shippingnotes:</td>
              <td colspan="2"><input type="text" name="shippingnotes" style="width:400px;" value="{{$data->shippingnotes}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
           <tr>
              <td>Company Name:</td>
              <td><input type="text" id="billcompanyname" name="billcompanyname" style="width:400px;" value="{{$data->billcompanyname}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
              <td>Company Name:</td>
              <td colspan="2"><input type="text" name="shipcompanyname" style="width:400px;" value="{{$data->shipcompanyname}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
           <tr>
              <td>Address:</td>
              <td><input type="text" id="billaddress" name="billaddress" style="width:400px;" value="{{$data->billaddress}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
              <td>Address:</td>
              <td colspan="2"><input type="text" name="shipaddress" style="width:400px;" value="{{$data->shipaddress}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
           </tr>
            <tr>
              <td>Tel:</td>
              <td><input type="text" name="billtel" style="width:400px;" value="{{$data->billtel}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
              <td>Tel:</td>
              <td colspan="2"><input type="text" name="shiptel" style="width:400px;" value="{{$data->shiptel}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
@endforeach
             </tr>
             <tr>
               <td>Tax ID</td>
               <td colspan="4"><input type="text" name="taxid" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
             </tr>
       </table>
       <table id="test" class="bor-blue tbl" width="90%" style="margin: auto">
           <tr style="background:#305496;">
               <th ><font color="white">Model Name</font></th>
               <th><font color="white">Description</font></th>
               <th><font color="white">Currency</font></th>
               <th><font color="white">Quantity<br>(PCS)</font></th>
               <th><font color="white">Unit Price <br>(USD)</font></th>
               <th><font color="white">Total Amount<br>(USD)</font></th>
               <th><font color="white">刪除</font></th>
           </tr>
           <tbody>
           @foreach($pipay as $pay)
               <tr>
                <td><input type="text" name="modelname[]" value="{{$pay->modelname}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                 <td><textarea style="text-align: left;vertical-align:top" name="description[]"  rows="8" cols="20" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                    {{$pay->description}}</textarea></td>
                 <td>
                     <select name="currency[]" class="currency">
                         <option value="USD$" {{$pay->currency=="USD$"?'selected ' :''}}>USD$</option>
                         <option value="NTD$" {{$pay->currency=="NTD$"?'selected ' :''}}>NTD$</option>
                         <option value="CNY￥" {{$pay->currency=="CNY￥"?'selected ' :''}}>CNY￥</option>
                         <option value="EUR€" {{$pay->currency=="EUR€"?'selected ' :''}}>EUR€</option>
                     </select>
                 </td>
                   <td><input type="text" name="quantity[]" min='1' required class="quantity" value="{{$pay->quantity}}" required onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                   <td><input type="text" name="unitprice[]" required class="unitprice" value="{{$pay->unitprice}}" required onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                   <td class="convert"><input type="text" name="total[]"  class="total" value="{{$pay->total}}" required onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                   <td><button class="bt-del jq-delete ">刪除</button></td>
               </tr>
           @endforeach
           </tbody>

           @foreach($custdata as $cust)
               <tr><td colspan="5" style="text-align: right;">TOTAL:</td>
                   <td colspan="2" style="text-align: left;"><input type="text" id="total_all" name="total_all" class="total_all" value="{{$cust->total_all}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}" readonly></td></tr>
                    <tr><td colspan="7"> <input type="button" id="btn2" value="增加欄位" class="bt-add"></td></tr>
     </table>
        <br>
        <table class="bor-blue tbl" width="90%" style="margin: auto" >
            <tr><td class="bg-blue">Delivery Term:</td>
                <td  style="text-align: left;"><input type="text" name="deliveryterm"  style="width:400px;" value="{{$cust->deliveryterm}}" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td></tr>
        </table>

        <table class="bor-blue tbl" width="90%" style="margin: auto" id="payaddrow">
            <tr style="background:#305496;">
                <th colspan="4"><font color="white">Payment Term:</font></th>
            </tr>
            @if($payment>0)
            <tbody>
            @foreach($payment as $m)
                <tr>
                    <td><input type="text" name="payposit[]" value="{{$m->payposit}}" placeholder="付款%數"
                                   onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                    <td><input type="text" name="amount[]" value="{{$m->amount}}" placeholder="金額ex:10000"
                                   onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                    <td  style="text-align: left;"><input type="text" name="method[]" value="{{$m->method}}" placeholder="ex:Deposit T/T"
                                   onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}"></td>
                    <td><input type="button" class="bt-del" value="刪除" id="delpayment"></td>
                </tr>
            </tbody>
            @endforeach
            @endif
            <tr>
                <td colspan="4"><input type="button" id="payadd" value="增加Payment Term欄位" class="bt-add"></td>
            </tr>
        </table>

        <table class="bor-blue tbl" width="90%" style="margin: auto">
            <tr>
                <td class="bg-blue">shipdate:</td>
                <td colspan="7" style="text-align: left;">
                    <textarea name="shipdate"  rows="6" cols="120" style="text-align: left;vertical-align:top" onkeydown="if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}">
                        {{$cust->shipdate}}</textarea></td>
            </tr>
            <tr>
                <td class="bg-blue">ADDRESS OF BANK:</td>
                <td colspan="7" style="text-align: left;">
                    <select id="addressofbank"  class="addressofbank" style="width:600px;" >
   <option value="1"  {{$cust->addressofbank=="65 CHULIA STREET, OCBC CENTRE, SINGAPORE 049513 "?'selected ' :''  }}>65 CHULIA STREET, OCBC CENTRE, SINGAPORE 049513 </option>
   <option value="2" {{$cust->addressofbank=="28th FLOOR, TOWER 6, THE GATEWAY, 9 CANTON ROAD, TSIMSHATSUI, KOWLOON, HONG KONG"?'selected ' :''  }}>28th FLOOR, TOWER 6, THE GATEWAY, 9 CANTON ROAD, TSIMSHATSUI, KOWLOON, HONG KONG</option>
  <option value="3" {{$cust->addressofbank=="NO.90, SEC.2, WUNHUA RD., BANCIAO DIST., NEW TAIPEI CITY 220-41,TAIWAN(R.O.C)"?'selected ' :''  }}>NO.90, SEC.2, WUNHUA RD., BANCIAO DIST., NEW TAIPEI CITY 220-41,TAIWAN(R.O.C)</option>
                    </select>
                    <input type="hidden" id="bankadd" name="addressofbank"></td>
            </tr>
            <tr>
                <td class="bg-blue">Bank Name:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="bankname" name="bankname" style="width:600px;" value="{{$cust->bankname}}"></td>
            </tr>
            <tr>
                <td class="bg-blue">Acount No.:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="acountno" name="acountno" style="width:600px;" value="{{$cust->acountno}}"></td>
            </tr>
            <tr>
                <td class="bg-blue">Swift Code:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="swiftcode" name="swiftcode" style="width:600px;" value="{{$cust->swiftcode}}"></td>
            </tr>
            <tr>
                <td class="bg-blue">公司地址</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" id="ouraddress" name="ouraddress" style="width:600px;" value="{{$cust->ouraddress}}"></td>
            </tr>
            <tr>
                <td class="bg-blue">Note:</td>
                <td colspan="7" style="text-align: left;">
                    <input type="text" name="note"  style="width:800px;" value="{{$cust->note}}"></td>
            </tr>




                    <input style="background:#F0F0F0;" type="hidden" name="updatedate" value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>

                    <input style="background:#F0F0F0;" type="hidden" name="updateemp"  value="{{Session::get('name')}}" readonly></td>
                    <input type="hidden" name="sts" value="{{$cust->sts}}">

            @endforeach
        </table>
        <br>
        <input type="submit" class="bt-send" value="修改客戶PI單" ><br><br>
    </form>

        </div>
    </div>
</div>
<script>
    function total_(a,b){
        n = parseFloat(a) * parseFloat(b).toFixed(5);
        return  Math.round(n)
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
                /*if (isNaN(unitprice)) {
                    alert("請輸入數字");
                    $(this).parent().next().children().val(""); $(this).parent().next().children().val("").focus();
                }*/
                if (quantity != "" && unitprice != "") {
                    res = total_(quantity,unitprice)
                }
            }
            else {
                unitprice = $(this).val();
                /*if (isNaN(unitprice)) {
                    alert("請輸入數字");
                    $(this).val("");
                    $(this).focus();
                }*/
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
