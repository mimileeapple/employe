<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "新增客戶PI規格單";
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
    <link href="{{ URL::asset('myjs/jquery-editable-select.css') }}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{ URL::asset('myjs/jquery-editable-select.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <style>
        input {
            margin: 10px;
            width: 400px;
        }

        select {
            margin: 10px;
            width: 400px;
        }

        table {
            margin: auto;
        }
    </style>
    <script>
        $(function () {
            $("#backioadd").click(function () {
                // $("#rownum").val(num+1);
                $("#addbackio tbody").eq(0).append("<tr><td><input type='text' name='backio[]' placeholder='(自填型號)' autocomplete='off' " +
                    "style='width:300px;' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/><button class='bt-del delbackio' style='width:80px;' >刪除</button></td></tr>");
            });

            $(document).on('click', '.delbackio', function () {
                var yes = confirm('你確定刪除此列嗎？');
                if (yes) {
                    // $("#rownum").val(num-1);
                    $(this).parent().parent().remove();
                    alert('刪除成功');
                } else {
                    alert('取消');
                    return false;
                }
            });


            $("#remarkadd").click(function () {
                // $("#rownum").val(num+1);
                $("#addremark tbody").eq(0).append(" <tr><td style='vertical-align: middle !important;text-align: center;'><textarea name='remark[]'  onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></textarea>" +
                "<button class='bt-del delremark' style='width:80px;'>刪除<tton></td></tr>");
            });
            $(document).on('click', '.delremark', function () {
                var yes = confirm('你確定刪除此列嗎？');
                if (yes) {
                    // $("#rownum").val(num-1);
                    $(this).parent().parent().remove();
                    alert('刪除成功');
                } else {
                    alert('取消');
                    return false;
                }
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

        <td><p style="color:#8EA9DB;font-size: 26px;margin-top:8px;"><b>All in One Specification</b></p></td>
    </tr>
</table>
<form action="{{ route('pispace.store') }}" method="post" id="form1" name="form1">
    {{ csrf_field() }}

    <table class="tbl bor-blue" width="90%" style="text-align: center;">
        @foreach($list as $data)
            <tr>
                <td class="bg-blue">PI Number</td>
                <td><input type="text" name="pino" value="{{$data->pino}}"
                           onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
                <td class="bg-blue">Date</td>
                <td><input type="text" name="orderdate" value="{{$data->orderdate}}"
                           onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'>
                    <input type="hidden" name="orderid" value="{{$data->id}}"
                           onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="bg-blue">Model Name</td>
            <td><input type="text" name="modelname" value="BF24-"
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">System Type</td>
            <td>
                <select id="systemtype" name="systemtype">
                    <option value="L5-">L5</option>
                    <option value="L6-">L6</option>
                    <option value="L9-">L9</option>
                    <option value="LT-">LT</option>
                    <option value="LTN-">LTN</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Knocked Down</td>
            <td>
                <select id="knockeddown" name="knockeddown">
                    <option value="A-">Aassembled</option>
                    <option value="S-">SKD</option>
                    <option value="C-">CKD</option>
                </select></td>
            <td class="bg-blue">Front</td>
            <td><input type="text" name="front" value="p"
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">Motherboard</td>
            <td><input type="text" name="motherboard" list="motherboard" style="padding: 0.5em; border-radius: 10px"
                       autocomplete='off'/>
                <datalist id="motherboard">
                    <option value="ITX1">ITX1</option>
                    <option value="ITX2">ITX2</option>
                </datalist>
            </td>
            <td class="bg-blue">BIOS</td>
            <td><input type="text" name="bios" placeholder="(自填)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">Front IO</td>
            <td>
                <select id="frontio" name="frontio">
                    <option value="20">U2 (Black) + U2 Type C</option>
                    <option value="21">U2 (Blue) + U2 Type C</option>
                    <option value="22">U3 (Blue) + U3 Type C</option>
                </select></td>
            <td class="bg-blue">Back IO</td>
            <td>
                <table id="addbackio">
                    <tbody>
                    <tr>
                        <td>
                            <input type="text" name="backio[]" placeholder="(自填型號)" autocomplete='off'
                                   style="width:300px;"
                                   onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/>
                            <button class="bt-del delbackio " style="width:80px;">刪除</button>
                        </td>
                    </tr>
                    </tbody>
                    <input type="button" id="backioadd" value="新增BackIo列" class="bt-add">
                </table>
            </td>
        </tr>
        <tr>
            <td class="bg-blue">Side IO</td>
            <td>
                <select name="sideio" id="sideio">
                    <option value="24">No side IO</option>
                    <option value="25">USB2.0 + No Type C(with rubber)</option>
                    <option value="26">USB2.0 + USB2.0 Type C</option>
                </select></td>
            <td class="bg-blue">Wireless</td>
            <td>
                <select id="wireless" name="wireless">
                    <option value="27">None</option>
                    <option value="28">M.2 Wifi b/g/n</option>
                    <option value="29">M.2 Wifi b/g/n+BT</option>
                    <option value="30">Dual Antenna Only (M.2)</option>
                    <option value="31">M.2 Wifi ac/b/g/n+BT4.2</option>
                    <option value="32">M.2 Wifi ac/b/g/n+BT5.0</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">LCD</td>
            <td>
                <select id="lcd" name="lcd">
                    <option value="34">IPS/ADS/AHVA</option>
                    <option value="35">VA</option>
                </select></td>
            <td class="bg-blue">LCD亮度</td>
            <td>
                <select id="lcdlingt" name="lcdlingt">
                    <option value="36">250nits</option>
                    <option value="37">300nits</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">LCD備註</td>
            <td>
                <select id="lcdnote" name="lcdnote">
                    <option value="38">Bright Dot</option>
                    <option value="39">No Bright Dot</option>
                </select></td>
            <td class="bg-blue">Thermal Module</td>
            <td>
                <select id="thermalmodule" name="thermalmodule">
                    <option value="40">None</option>
                    <option value="41">Thermal Module without Thermal Paste</option>
                    <option value="42">Thermal Module Thermal Module with Thermal Paste</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">System Fan</td>
            <td>
                <select id="systemfan" name="systemfan">
                    <option value="43">None</option>
                    <option value="44">System Fan</option>
                </select></td>
            <td class="bg-blue">CPU</td>
            <td><input type="text" name="cpu" placeholder="(自填型號)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>

        <tr>
            <td class="bg-blue">Key parts</td>
            <td><input type="text" name="keyparts" placeholder="(自填i3/i5/i7)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Memory</td>
            <td><input type="text" name="memory" placeholder="(自填型號)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">SSD/HDD</td>
            <td><input type="text" name="ssd" placeholder="(自填型號)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Side Function</td>
            <td>
                <select id="sidefunction" name="sidefunction">
                    <option value="49">None</option>
                    <option value="50">ODD cover + ODD bezel</option>
                    <option value="51">9.5mm ODD</option>
                    <option value="52">HDD Tray</option>
                    <option value="53">Smart Card Reader</option>
                    <option value="54">Side IO</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Camera Housing</td>
            <td>
                <select id="cameraahousing" name="cameraahousing">
                    <option value="55">None</option>
                    <option value="56">Pop up</option>
                    <option value="57">Type C</option>
                    <option value="58">Pop up with mic on/off switch</option>
                </select></td>
            <td class="bg-blue">Camera</td>
            <td>
                <select id="camera" name="camera">
                    <option value="59">None</option>
                    <option value="60">2M (1920*1080) Camera + Single Mic</option>
                    <option value="61">2M (1920*1080) Camera + Dual Mic</option>
                    <option value="62">5M (2592*1944) Camera + Dual Mic</option>
                    <option value="63">5M (2592*1944) Camera + Single Mic</option>
                    <option value="64">2M (1920*1080) Camera + Dual DMic</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Camera FW</td>
            <td><input type="text" name="camerafw" placeholder="(自填)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
            <td class="bg-blue">Power</td>
            <td>
                <select id="power" name="power">
                    <option value="66">None</option>
                    <option value="67">120W Internal power board</option>
                    <option value="68">90W Internal power board+battery</option>
                    <option value="69">120W adaptor(7.4/5.1mm)</option>
                    <option value="70">120W adaptor(5.5/2.5mm)</option>
                    <option value="71">65W adaptor</option>
                    <option value="72">150W adaptor</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue"> Speaker</td>
            <td><input type="text" name="speaker" value="2 x 3W Speakers" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Chassis+Stand Color</td>
            <td>
                <select id="chassisstandcolor" name="chassisstandcolor">
                    <option value="75"> Black Color Chassis</option>
                    <option value="76">White Color Chassis</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Silk Print</td>
            <td><input type="text" name="silkprint" placeholder="(自填)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Cable Cover</td>
            <td>
                <select id="cablecover" name="cablecover">
                    <option value="78">None</option>
                    <option value="79">Cable cover</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Hinge</td>
            <td>
                <select id="hinge" name="hinge">
                    <option value="81">Default Y hinge</option>
                    <option value="82">Hinge outside</option>
                    <option value="83">Hinge outside + mylar</option>
                    <option value="84">VESA only, no mylar</option>
                </select></td>
            <td class="bg-blue">VESA Screw</td>
            <td>
                <select id="vesascrew" name="vesascrew">
                    <option value="85">No Screw(VESA or No need)</option>
                    <option value="86">VESA screw</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">EMC</td>
            <td>
                <select id="emc" name="emc">
                    <option value="87">None</option>
                    <option value="88">EMI Coating</option>
                </select></td>
            <td class="bg-blue">Kensington Lock</td>
            <td><input type="text" name="kensingtonlock" value="Kensington Lock" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">Stand</td>
            <td>
                <select id="stand" name="stand">
                    <option value="90">No Stand</option>
                    <option value="91">Y Stand V2.0</option>
                    <option value="92">2-in-1 Stand</option>
                    <option value="93">Round Stand</option>
                    <option value="94">C Stand</option>
                    <option value="95">HAS03 Generic Black</option>
                    <option value="96">HAS-R-B Round Black</option>
                    <option value="97">HAS-R-S Round Silver</option>
                    <option value="98">HAS 1804</option>
                </select></td>
            <td class="bg-blue">2-in-1 Stand Screw</td>
            <td>
                <select id="standscrew" name="standscrew">
                    <option value="99">Not 2in1 stand</option>
                    <option value="100">Hex head screw</option>
                    <option value="101">Philips screw</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">COM</td>
            <td>
                <select id="com" name="com">
                    <option value="103">None</option>
                    <option value="104">COM</option>
                </select></td>
            <td class="bg-blue">Extra USB</td>
            <td>
                <select id="extrausb" name="extrausb">
                    <option value="105">None</option>
                    <option value="106">2 x USB3.2 Gen1 Type A</option>
                    <option value="107">2 x USB2.0 Type A</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Chassis Intrusion</td>
            <td><select id="chassisintrusion" name="chassisintrusion">
                    <option value="108">None</option>
                    <option value="109">Chassis Intrusion</option>
                </select></td>
            <td class="bg-blue">Power Cord Type</td>
            <td>
                <select id="powercordtype" name="powercordtype">
                    <option value="110">None</option>
                    <option value="111">Default ST</option>
                    <option value="112">RA (with powerboard and cable cover)</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Power Cord</td>
            <td>
                <select id="powercord" name="powercord">
                    <option value="113">Power Cord None</option>
                    <option value="114">Europe / Middle east / Korea</option>
                    <option value="115">USA / South America</option>
                    <option value="116">Brazil</option>
                    <option value="117">Chile/Italy</option>
                    <option value="118">Argentina</option>
                    <option value="119">England</option>
                    <option value="120">India (3 round)</option>
                    <option value="121">China</option>
                </select></td>
            <td class="bg-blue">Customer Code</td>
            <td><input type="text" name="customercode" placeholder="(自填)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
        </tr>
        <tr>
            <td class="bg-blue">Customization</td>
            <td>
                <select id="customization" name="customization">
                    <option value="124">No Customization</option>
                    <option value="125">Customization</option>
                </select></td>
            <td class="bg-blue">LOGO</td>
            <td>
                <select id="logo" name="logo">
                    <option value="126">No logo</option>
                    <option value="127">Front silk print only</option>
                    <option value="128">Front nickel logo only</option>
                    <option value="129">Back silk print only</option>
                    <option value="130">Back nickel logo only</option>
                    <option value="131">Front and Back silk print</option>
                    <option value="132">Front and Back nickel logo</option>
                    <option value="133">Front silk print and Back nickel logo</option>
                    <option value="134">Front nickel logo and Back silk print</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Remark</td>
            <td>
                <table id="addremark">
                    <tbody>
                    <tr>
                        <td style="vertical-align: middle !important;text-align: center;">
                            <textarea name="remark[]"  onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></textarea>
                            <button class="bt-del delremark" style="width:80px;">刪除</button>
                        </td>
                    </tr>
                    </tbody>
                    <input type="button" id="remarkadd" value="新增remark列" class="bt-add">
                </table>
            </td>
            <td class="bg-blue">Version</td>
            <td><input type="text" name="version" placeholder="(自填)" autocomplete='off'
                       onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
        </tr>

        <tr>
            <td class="bg-blue">Buyer:Date</td>
            <td><input type="date" name="buyer"></td>
            <td class="bg-blue">Seller:Date</td>
            <td><input type="date" name="seller"></td>
        </tr>


        <tr>
            <td class="bg-blue">建檔日期</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="creatdate"
                       value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
            <td class="bg-blue">建檔人員</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="createmp"
                       value="{{Session::get('name')}}" readonly></td>
        </tr>
        <tr>
            <td class="bg-blue">最後修改日期</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="updatedate"
                       value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
            <td class="bg-blue">最後修改人員</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="updateemp"
                       value="{{Session::get('name')}}"></td>
            <input type="hidden" name="sts" value="N">
        </tr>

    </table>
    <br><input type="submit" class="bt-send" value="新增PI規格單"><br><br>
</form>


</body>
</html><?php
