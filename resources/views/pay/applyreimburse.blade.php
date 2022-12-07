<?php
header("Pragma: no-cache");
session_start();
header('Content-Type: text/html;charset=UTF-8');
$title = "填寫國外出差旅費報告表";
date_default_timezone_set('Asia/Taipei');
?>
    <!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1; charset=utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/employeesstyle.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="icon" href="{{ URL::asset('img/pageicon.ico')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/pageicon.ico" type="image/x-icon"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
            crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

    <title><?php echo $title ?></title>
    <style>
        input [type="text"] {
            width: 80px;
        }

        table {
            margin: auto;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            /* 按下GoTop按鈕時的事件 */
            $('#gotop').click(function () {
                $('html,body').animate({scrollTop: 0}, 'fast');   /* 返回到最頂上 */
                return false;
            });

            /* 偵測卷軸滑動時，往下滑超過400px就讓GoTop按鈕出現 */
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#gotop').fadeIn();
                } else {
                    $('#gotop').fadeOut();
                }
            });
        });
        //這是載入DOM後執行
        $(function () {


            $('#btn2').click(function () {
                // $("#rownum").val(num+1);
                $("#test tbody").append("<tr><td><input type='text' name='summary[]'></td><td><input type='text' name='details[]'></td>" +
                    "<td><select name='currency[]'><option value='NTD'>NTD</option> <option value='RMB'>RMB</option>" +
                    "<option value='USD'>USD</option><option value='GBP'>GBP</option> <option value='EUR'>EUR</option>" +
                    "<option value='other'>其他</option></select></td> <td><input type='text' name='amount[]' class='amount'></td>" +
                    "<td><input type='text' name='rate[]' class='rate'></td><td class='convert'><input type='text' name='convert_T[]' class='convert_T'></td>" +
                    "<td><input type='text' name='remark[]'></td><td><button class='btn jq-delete'>刪除</button></td></tr>");

            });

            $(document).on('click', '.jq-delete', function () {
                // $("#rownum").val(num-1);
                $(this).parent().parent().remove();
            });


        });
    </script>

</head>
<body style="text-align: center">
<div class="mt-5">
    <div>
        <a href="{{route('verify')}}"><img src="{{ URL::asset('img/logo.png') }}"></a>
        <h2 class="title-m "><?php echo $title ?></h2>
    </div>
</div>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            <a id="gotop">
                <font size="20px"> ^</font>
            </a>
            <br>


            <form action="{{Route('Pay.store')}}" method="post" id="from1">
                {{ csrf_field() }}
                <table border="2" style="text-align: left" class="bor-blue tbl" width="90%">
                    <tr>    @foreach($order_list as $emp)
                            <td class="bg-blue"> Name</td>
                            <input type="hidden" name="empid" value="{{$emp->empid}}">
                            <input type="hidden" name="orderid" value="{{$emp->orderid}}">
                            <td><input type="text" name="name" value="{{$emp->name}}"></td>
                            <td class="bg-blue">職稱</td>
                            <td><input type="text" name="title" value="{{$emp->title}}">

                            </td>
                    </tr>

                    <tr>
                        <td class="bg-blue">出差事由</td>
                        <td colspan="3"><input type="text" name="trip_reason" style="width:400px;" value=""></td>
                    </tr>
                    <tr>
                        <td class="bg-blue">出差日期(出發日)</td>
                        <td><input type="text" name="leavestart" value="{{$emp->leavestart}}"></td>
                        <td class="bg-blue">出差日期(結束日)</td>
                        <td><input type="text" name="leaveend" value="{{$emp->leaveend}}"></td>
                    </tr>
                    <tr>
                        <td class="bg-blue">出發地點</td>
                        <td><input type="text" name="startarea" value="TPE"></td>
                        <td class="bg-blue">目的地點</td>
                        <td><input type="text" name="endarea" value=""></td>
                    <tr>
                        <td class="bg-blue">工作記要</td>
                        <td colspan="3"><textarea rows="7" name="worknote" style="width:700px;"></textarea></td>
                    </tr>
                </table>

                <table id="test" class="bor-blue tbl" width="90%">
                    <thead>
                    <tr class="bg-blue">
                        <th>摘要</th>
                        <th>明細</th>
                        <th>幣別</th>
                        <th>金額</th>
                        <th>匯率</th>
                        <th>換算台幣</th>
                        <th>備註</th>
                        <th>刪除</th>
                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <td><input type="text" name="summary[]" value=""></td>
                        <td><input type="text" name="details[]" value=""></td>
                        <td><select name="currency[]">
                                <option value="NTD">NTD</option>
                                <option value="RMB">RMB</option>
                                <option value="USD">USD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                                <option value="other">其他</option>
                            </select></td>

                        <td><input type="text" name="amount[]" value="" class="amount" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                        <td><input type="text" name="rate[]" value="" class="rate" onkeypress="if (event.keyCode == 13) {return false;}"> </td>
                        <td class="convert"><input type="text" name="convert_T[]" value="" class="convert_T"></td>
                        <td><input type="text" name="remark[]" value=""></td>
                        <td>
                            <button class="btn jq-delete">刪除</button>
                        </td>
                    </tr>

                    <tr>
                        <td><input type="text" name="summary[]" value=""></td>
                        <td><input type="text" name="details[]" value=""></td>
                        <td><select name="currency[]">
                                <option value="NTD">NTD</option>
                                <option value="RMB">RMB</option>
                                <option value="USD">USD</option>
                                <option value="GBP">GBP</option>
                                <option value="EUR">EUR</option>
                                <option value="other">其他</option>
                            </select></td>
                        <td><input type="text" name="amount[]" class="amount" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                        <td><input type="text" name="rate[]" class="rate" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                        <td class="convert"><input type="text" name="convert_T[]" class="convert_T"></td>
                        <td><input type="text" name="remark[]"></td>
                        <td>
                            <button class="btn jq-delete">刪除</button>
                        </td>
                    </tr>
                    </tbody>

                </table>
                <br>

                <input type="button" id="btn2" value="增加欄位" class="bt-add">
                <input type="button" id="btn1" value="確認送出" class="bt-send" onclick="sendsubmit()">

                <br><br>
            <table class="bor-blue tbl" width="90%">
                <tr>
                    <td class="bg-blue">出差費總計</td>
                    <td colspan="7" style="text-align: left;">NT$<input type="text" name="triptotal" value="" class="total"></td>
                </tr>
                <tr class="bg-blue">
                    <th>摘要</th>
                    <th>明細</th>
                    <th>幣別</th>
                    <th>金額</th>
                    <th>匯率</th>
                    <th>換算台幣</th>
                    <th>備註</th>
                </tr>
                <tr>
                    <td class="bg-pink">預支</td>
                    <td><input type="text" name="advancedetails" value="預支現鈔"></td>
                    <td><select name="advancecurrency">
                            <option value="NTD">NTD</option>
                            <option value="RMB">RMB</option>
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                            <option value="EUR">EUR</option>
                            <option value="other">其他</option>
                        </select></td>
                    <td><input type="text" name="advanceamount" value="" class="advanceamount" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                    <td><input type="text" name="advancerate" value="" class="advancerate" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                    <td><input type="text" name="advanceconvert_T" value="" class="advanceconvert_T"></td>
                    <td><input type="text" name="advanceremark" value=""></td>
                </tr>
                <tr>
                    <td class="bg-pink">退還</td>
                    <td><input type="text" name="advancereturndetails" value="退還現鈔"></td>
                    <td><select name="advancereturncurrency">
                            <option value="NTD">NTD</option>
                            <option value="RMB">RMB</option>
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                            <option value="EUR">EUR</option>
                            <option value="other">其他</option>
                        </select></td>
                    <td><input type="text" name="advancereturnamount" value="" class="advancereturnamount" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                    <td><input type="text" name="advancereturnrate" value="" class="advancereturnrate" onkeypress="if (event.keyCode == 13) {return false;}"></td>
                    <td><input type="text" name="advancereturnconvert_T" value="" class="advancereturnconvert_T"></td>
                    <td><input type="text" name="advancereturnremark" value=""></td>
                </tr>
                <tr><td colspan="7"><font color="red">* 若無預支或退還請輸入 0 *</font> </td></tr>
            </table>
            <table class="bor-blue tbl" width="90%">

                <tr>
                    <td class="bg-blue">應付員工費用</td>
                    <td colspan="7" style="text-align: left;">NT$<input type="text" name="copeemptotal" value="" class="copeemptotal"></td>
                </tr>

               <tr>
                    <td class="bg-blue">總經理</td>
                    <td><input type="text" name="managername" value="{{Session::get('empdata')->manage2name}}" disabled></td>
                    <td class="bg-blue">單位主管</td>
                    <td><input type="text" name="supervisorname" value="{{Session::get('empdata')->manage1name}}" disabled></td>
                    <td class="bg-blue">財務</td>
                    <td><input type="text" name="financename" value="陳雅琴" disabled></td>
                    <td class="bg-blue">申請人</td>
                    <td><input type="text" name="createmp" value="{{$emp->name}}" disabled></td>

                </tr>
            </table> @endforeach
            </form>
            <br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>
<script>
    $(function () {
            $(document).on('input propertychange', '.amount,.rate', function () {

            clas = $(this).attr('class')
            if (clas == 'amount') {
                amount = $(this).val();
                if (isNaN(amount)) {
                    alert("請輸入數字");
                    $(this).val("");
                }
                rate = $(this).parent().next().children().val();
                if (isNaN(rate)) {
                    alert("請輸入數字");
                    $(this).parent().next().children().val("");
                }
                if (amount != "" && rate != "") {
                    res = total_(amount,rate)
                }
            } else {
                rate = $(this).val();
                if (isNaN(rate)) {
                    alert("請輸入數字");
                    $(this).val("");
                }
                amount = $(this).parent().prev().children().val();
                if (isNaN(amount)) {
                    alert("請輸入數字");
                    $(this).parent().prev().children().val("");
                }
                if (amount != "" && rate != "") {
                    res = total_(amount,rate)
                }
            }

            $(this).parent().parent().find('.convert').children().val(res)
            total = 0

            $('.convert_T').each(function (i, v) {
                total += parseFloat($(this).val())
            })

            $('.total').val (total);
        });

        $(document).on('input propertychange', '.advanceamount,.advancerate', function () {
            clas1 = $(this).attr('class')

            if (clas1 == 'advanceamount') {
                advanceamount = $(this).val();
                if (isNaN(advanceamount)) {
                    alert("請輸入數字");
                    $(this).val("");
                } }
                clas2= $(this).attr('class')
            if (clas2 == 'advancerate') {
                advancerate =$(this).val();
                if (isNaN(advancerate)) {
                    alert("請輸入數字");
                    $(this).val("");
                }

                if (advanceamount != "" && advancerate != "") {
                    res = total_(advanceamount,advancerate)
                    $(".advanceconvert_T").val(res);
                }

            }
 })




        $(document).on('input propertychange', '.advancereturnamount,.advancereturnrate', function () {
            clas1 = $(this).attr('class')

            if (clas1 == 'advancereturnamount') {
                advancereturnamount = $(this).val();
                if (isNaN(advancereturnamount)) {
                    alert("請輸入數字");
                    $(this).val("");
                } }
            clas2= $(this).attr('class')
            if (clas2 == 'advancereturnrate') {
                advancereturnrate =$(this).val();
                if (isNaN(advancereturnrate)) {
                    alert("請輸入數字");
                    $(this).val("");
                }

                if (advancereturnamount != "" && advancereturnrate != "") {
                    res = total_(advancereturnamount,advancereturnrate)
                    $(".advancereturnconvert_T").val(res);
                }

            }
            $t=$(".total").val();
            adt=$(".advanceconvert_T").val();
            adct=$(".advancereturnconvert_T").val();
            to=parseFloat($t)-parseFloat(adt)+parseFloat(adct);
            $('.copeemptotal').val(to);

        })



        function total_(a,b){
           n = parseFloat(a) * parseFloat(b).toFixed(5);
           return  Math.round(n)
        }


    })
    function sendsubmit(){
        $("#from1").submit();
    }

</script>
</body>

</html>
