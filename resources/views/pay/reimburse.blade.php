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
    table{margin: auto;}
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


            $('#btn2').click(function(){
               // $("#rownum").val(num+1);
                $("#test tbody").append("<tr><td><input type='text' name='summary[]'></td><td><input type='text' name='details[]'></td>" +
                    "<td><select name='currency[]'><option value='NTD'>NTD</option> <option value='RMB'>RMB</option>" +
                    "<option value='USD'>USD</option><option value='GBP'>GBP</option> <option value='EUR'>EUR</option>" +
                    "<option value='other'>其他</option></select></td> <td><input type='text' name='amount[]'></td>" +
                    "<td><input type='text' name='rate[]'></td> <td><input type='text' name='convert_T[]'></td>" +
                    "<td><input type='text' name='remark[]'></td><td><button class='btn jq-delete'>刪除</button></td></tr>");

            });

            $(document).on('click', '.jq-delete',function(){
               // $("#rownum").val(num-1);
                $(this).parent().parent().remove();
            });

            $("input[type='text']").attr("readonly","readonly");
            $("#currency").attr("readonly","readonly");
            $("input[type='text']").css("background-color","#F0F0F0");
            $("#worknote").attr("readonly","readonly")

        });

    </script>
    <style>

    </style>
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
            @foreach($order_list as $emp)

            <table border="2" style="text-align: left" class="bor-blue tbl" width="90%">
                <tr>
                    <td class="bg-blue"> Name</td>
                    <input type="hidden" name="empid" value="{{$emp->empid}}"  >
                    <input type="hidden" name="orderid" value="{{$emp->orderid}}">
                    <td><input type="text" name="name" value="{{$emp->name}}" readonly></td>
                    <td class="bg-blue">職稱</td>
                    <td ><input type="text" name="title" value="{{$emp->title}}">

                    </td>
                </tr>

                <tr>
                    <td class="bg-blue">出差事由</td>
                    <td colspan="3"><input type="text" name="trip_reason" style="width:400px;" value="{{$emp->trip_reason}}"></td>
                </tr>
                <tr>
                    <td class="bg-blue">出差日期(出發日)</td>
                    <td><input type="text" name="leavestart" value="{{$emp->leavestart}}"></td>
                    <td class="bg-blue">出差日期(結束日)</td>
                    <td><input type="text" name="leaveend"  value="{{$emp->leaveend}}"></td>
                </tr>
                <tr>
                    <td class="bg-blue">出發地點</td>
                    <td><input type="text" name="startarea" value="TPE"></td>
                    <td class="bg-blue">目的地點</td>
                    <td><input type="text" name="endarea" value="{{$emp->endarea}}"></td>
                <tr>
                    <td class="bg-blue">工作記要</td>
                    <td colspan="3"><textarea rows="7"  name="worknote" style="width:700px;" id="worknote">{{$emp->worknote}}</textarea></td>
                </tr>
            </table>
                @endforeach
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
                </tr>
                </thead>
                <tbody>

            @foreach($ordeapay as $data)

                <tr>
                <td><input type="text" name="summary[]" value="{{$data->summary}}"></td>
                <td><input type="text" name="details[]" value="{{$data->details}}"></td>
                <td><input type="text" name="currency[]" value="{{$data->currency}}"></td>

                <td><input type="text" name="amount[]" value="{{$data->amount}}"></td>
                <td><input type="text" name="rate[]" value="{{$data->rate}}"></td>
                <td><input type="text" name="convert_T[]" value="{{$data->convert_T}}"></td>
                <td><input type="text" name="remark[]" value="{{$data->remark}}"></td>

                @if(!$order_list[0]->status)
                <tr>
                    <td><input type="text" name="summary[]" value="{{$data->summary}}"></td>
                    <td><input type="text" name="details[] value="{{$data->details}}"></td>
                    <td><input type="text" name="currency[]" value="{{$data->currency}}"></td>
                    <td><input type="text" name="amount[]" {{$data->amount}}></td>
                    <td><input type="text" name="rate[]" {{$data->rate}}></td>
                    <td><input type="text" name="convert_T[]" {{$data->convert_T}}></td>
                    <td><input type="text" name="remark[]" {{$data->remark}}></td>
                    <td><button class="btn jq-delete">刪除</button></td>
                </tr> @endif
            @endforeach
                </tbody>

            </table><br>

            @foreach($ordertotal as $total)

            <table class="bor-blue tbl" width="90%">
                <tr>
                    <td class="bg-blue">出差費總計</td>
                    <td colspan="7" style="text-align: left;">NT$<input type="text" name="triptotal" class="total" value="{{$total->triptotal}}"></td>
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
                    <td  class="bg-pink">預支</td>
                    <td><input type="text" name="advancedetails" value="預支現鈔"></td>
                    <td><input type="text" name="advancecurrency" value="{{$total->advancecurrency}}">
                    </td>
                    <td><input type="text" name="advanceamount" class="advanceamount" value="{{$total->advanceamount}}"></td>
                    <td><input type="text" name="advancerate" class="advancerate" value="{{$total->advancerate}}"></td>
                    <td><input type="text" name="advanceconvert_T"  class="advanceconvert_T" value="{{$total->advanceconvert_T}}"></td>
                    <td><input type="text" name="advanceremark" value="{{$total->advanceremark}}"></td>
                </tr>
                <tr>
                    <td class="bg-pink">退還</td>
                    <td><input type="text" name="advancereturndetails" value="退還現鈔"></td>
                    <td><input type="text" name="advancereturncurrency" value="{{$total->advancereturncurrency}}"></td>
                    <td><input type="text" name="advancereturnamount" class="advancereturnamount" value="{{$total->advancereturnamount}}"></td>
                    <td><input type="text" name="advancereturnrate"  class="advancereturnrate" value="{{$total->advancereturnrate}}"></td>
                    <td><input type="text" name="advancereturnconvert_T"  class="advancereturnconvert_T" value="{{$total->advancereturnconvert_T}}"></td>
                    <td><input type="text" name="advancereturnremark" value="{{$total->advancereturnremark}}"></td>
                </tr>
            </table>
            <table class="bor-blue tbl" width="90%">

                <tr>
                    <td class="bg-blue">應付員工費用</td>
                    <td colspan="7" style="text-align: left;">NT$<input type="text" name="copeemptotal" class="copeemptotal" value="{{$total->copeemptotal}}"></td>
                </tr>
                @endforeach
                @foreach($ordersign as $sign)
                <tr>
                    <td class="bg-blue">總經理</td>
                    <td>{{$sign->managername}}{{$sign->supervisor_signdate}}</td>
                    <td class="bg-blue">單位主管</td>
                    <td> {{$sign->supervisorname}}{{$sign->manager_signdate}}</td>
                    <td class="bg-blue">財務</td>
                    <td>{{$sign->financename}}{{$sign->finance_signdate}}</td>
                    <td class="bg-blue">申請人</td>
                    <td>{{$sign->createmp}}{{$sign->creatdate}}</td>
                    @endforeach
                </tr>
            </table>

            </table>

            <br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>
</body>

</html>
