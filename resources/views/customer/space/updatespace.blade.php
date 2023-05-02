<?php
header("Pragma: no-cache");
session_start();
header("Content-Type:text/html;charset=utf-8");
$title = "修改客戶PI規格單";
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
    <script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.js"></script>
    <link href="//rawgithub.com/indrimuska/jquery-editable-select/master/dist/jquery-editable-select.min.css" rel="stylesheet"> <title><?php echo $title ?></title>
    <style>
        input {
            margin:10px;
            width:400px;
        }
        select{
            margin:10px;
            width:400px;
        }
        table{
            margin: auto;
        }
    </style>
    <script>
        $(function () {
            $("#backioadd").click(function () {
                // $("#rownum").val(num+1);
                $("#addbackio tbody").eq(0).append("<tr><td><input type='text' name='backio[]' placeholder='(自填型號)' autocomplete='off' " +
                    "style='width:300px;' onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/><button class='bt-del delbackio' style='width:80px;'>刪除</button></td></tr>");
            });
            $(document).on('click', '.delbackio', function () {
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
                    alert('刪除成功');}
                else {
                    alert('取消');
                    return false;
                }
            });

        });
    </script>
</head>
<body style="text-align: center">
<img src="{{ URL::asset('img/logo.png') }}">

<h2 class="title-m "><?php echo $title?></h2>

<a id="gotop">
    <font size="20px"> ^</font>
</a>
<br><br>

@php $pm=Session::get('empdata')->ename;$pm=substr($pm,0,2) @endphp
<table  class="" width="90%">
    <tr>

        <td><p style="color:#8EA9DB;font-size: 26px;margin-top:8px;"><b>All in One Specification</b></p></td>
    </tr>
</table>
@foreach($data as $d)
<form action="{{ route('pispace.update',$d->id) }}" method="post" id="form1" name="form1">
    {{ csrf_field() }}
    {{method_field('PUT')}}
    <table class="tbl bor-blue" width="90%" style="text-align: center;" >

            <tr><td class="bg-blue">PI Number</td><td><input type="text" name="pino" value="{{$d->pino}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
                <td class="bg-blue">Date</td>
                <td><input type="text" name="orderdate" value="{{$d->orderdate}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'>
                    <input type="hidden" name="orderid" value="{{$d->orderid}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'>
                </td></tr>

        <tr>
            <td class="bg-blue">Model Name</td>
            <td><input type="text" name="modelname" value="{{$d->modelname}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">System Type</td>
            <td>
                <select id="systemtype" name="systemtype">
                    <option value="L5-" {{ $d->systemtype == 'L5-'?'selected ' :''}}>L5</option>
                    <option value="L6-" {{ $d->systemtype == 'L6-'?'selected ' :''}}>L6</option>
                    <option value="L9-" {{ $d->systemtype == 'L9-'?'selected ' :''}}>L9</option>
                    <option value="LT-" {{ $d->systemtype == 'LT-'?'selected ' :''}}>LT</option>
                    <option value="LTN-" {{ $d->systemtype == 'LTN-'?'selected ' :''}}>LTN</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Knocked Down</td>
            <td>
                <select id="knockeddown" name="knockeddown">
                    <option value="A-"  {{ $d->knockeddown == 'L5-'?'selected ' :''}}>Aassembled</option>
                    <option value="S-"  {{ $d->knockeddown == 'L5-'?'selected ' :''}}>SKD</option>
                    <option value="C-"  {{ $d->knockeddown == 'L5-'?'selected ' :''}}>CKD</option>
                </select></td>
            <td class="bg-blue">Front</td>
            <td> <input type="text" name="front" value="{{$d->front}}"></td>
        </tr>
        <tr><td class="bg-blue">Motherboard</td>
            <td><input  type="text" name="motherboard" list="motherboard" style="padding: 0.5em; border-radius: 10px"  autocomplete= 'off' value="{{ $d->motherboard }}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/>
                <datalist id="motherboard">
                    <option value="ITX1"  {{ $d->motherboard =='ITX1'?'selected ' :''}}>ITX1</option>
                    <option value="ITX2" {{ $d->motherboard =='ITX1'?'selected ' :''}}>ITX2</option>
                </datalist></td>
            <td class="bg-blue">BIOS</td>
            <td><input type="text" name="bios" placeholder="(自填)" autocomplete= 'off' value="{{$d->bios}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr><td class="bg-blue">Front IO</td>
            <td>
                <select id="frontio" name="frontio">
                    <option value="20" {{ $d->frontio =='20'?'selected ' :''}}>U2 (Black) + U2 Type C</option>
                    <option value="21" {{ $d->frontio =='21'?'selected ' :''}}>U2 (Blue) + U2 Type C</option>
                    <option value="22" {{ $d->frontio =='22'?'selected ' :''}}>U3 (Blue) + U3 Type C</option>
                </select></td>
            <td class="bg-blue">Back IO</td>
            <td><table id="addbackio">
                    <tbody>
                    @if($backio>0)
                    @foreach($backio as $i=>$b)
                    <tr>
                        <td>
                            <input type="text" name="backio[]" placeholder="(自填型號)" autocomplete= 'off' style="width:300px;" value="{{$b}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/>
                            <button class="bt-del delbackio " style="width:80px;">刪除</button>
                        </td>
                    </tr>
                    @endforeach
                        @endif
                    </tbody>
                    <input type="button" id="backioadd" value="新增BackIo列" class="bt-add" >
                </table>
            </td>
        </tr>
        <tr>
            <td class="bg-blue">Side IO</td>
            <td>
                <select name="sideio" id="sideio">
                    <option value="24" {{ $d->sideio =='24'?'selected ' :''}}>No side IO</option>
                    <option value="25" {{ $d->sideio =='25'?'selected ' :''}}>USB2.0 + No Type C(with rubber)</option>
                    <option value="26" {{ $d->sideio =='26'?'selected ' :''}}>USB2.0 + USB2.0 Type C</option>
                </select></td>
            <td class="bg-blue">Wireless</td>
            <td>
                <select id="wireless" name="wireless">
                    <option value="27" {{ $d->wireless =='27'?'selected ' :''}}>None</option>
                    <option value="28" {{ $d->wireless =='28'?'selected ' :''}}>M.2 Wifi b/g/n</option>
                    <option value="29" {{ $d->wireless =='29'?'selected ' :''}}>M.2 Wifi b/g/n+BT</option>
                    <option value="30" {{ $d->wireless =='30'?'selected ' :''}}>Dual Antenna Only (M.2)</option>
                    <option value="31" {{ $d->wireless =='31'?'selected ' :''}}>M.2 Wifi ac/b/g/n+BT4.2</option>
                    <option value="32" {{ $d->wireless =='32'?'selected ' :''}}>M.2 Wifi ac/b/g/n+BT5.0</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">LCD</td>
            <td>
                <select id="lcd" name="lcd">
                    <option value="34"  {{ $d->lcd =='34'?'selected ' :''}}>IPS/ADS/AHVA</option>
                    <option value="35" {{ $d->lcd =='35'?'selected ' :''}}>VA</option>
                </select></td>
            <td class="bg-blue">LCD亮度</td>
            <td>
                <select id="lcdlingt" name="lcdlingt">
                    <option value="36" {{ $d->lcdlingt =='36'?'selected ' :''}}>250nits</option>
                    <option value="37" {{ $d->lcdlingt =='37'?'selected ' :''}}>300nits</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">LCD備註</td>
            <td>
                <select id="lcdnote" name="lcdnote">
                    <option value="38" {{ $d->lcdnote =='38'?'selected ' :''}}>Bright Dot</option>
                    <option value="39" {{ $d->lcdnote =='39'?'selected ' :''}}>No Bright Dot</option>
                </select></td>
            <td class="bg-blue">Thermal Module</td>
            <td>
                <select id="thermalmodule" name="thermalmodule">
                    <option value="40"  {{ $d->thermalmodule =='40'?'selected ' :''}}>None</option>
                    <option value="41" {{ $d->thermalmodule =='41'?'selected ' :''}}>Thermal Module without Thermal Paste</option>
                    <option value="42" {{ $d->thermalmodule =='42'?'selected ' :''}}>Thermal Module	Thermal Module with Thermal Paste</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">System Fan</td>
            <td>
                <select id="systemfan" name="systemfan">
                    <option value="43" {{ $d->systemfan =='43'?'selected ' :''}}>None</option>
                    <option value="44" {{ $d->systemfan =='44'?'selected ' :''}}>System Fan</option>
                </select></td>
            <td class="bg-blue">CPU</td>
            <td><input type="text" name="cpu" placeholder="(自填型號)" autocomplete= 'off' value="{{$d->cpu}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>

        <tr>
            <td class="bg-blue">Key parts</td>
            <td><input type="text" name="keyparts" placeholder="(自填i3/i5/i7)" autocomplete= 'off' value="{{$d->keyparts}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Memory</td>
            <td><input type="text" name="memory" placeholder="(自填型號)" autocomplete= 'off' value="{{$d->memory}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">SSD/HDD</td>
            <td><input type="text" name="ssd" placeholder="(自填型號)" autocomplete= 'off' value="{{$d->ssd}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Side Function</td>
            <td>
                <select id="sidefunction" name="sidefunction">
                    <option value="49" {{ $d->sidefunction =='49'?'selected ' :''}}>None</option>
                    <option value="50"  {{ $d->sidefunction =='50'?'selected ' :''}}>ODD cover + ODD bezel</option>
                    <option value="51" {{ $d->sidefunction =='51'?'selected ' :''}}>9.5mm ODD</option>
                    <option value="52" {{ $d->sidefunction =='52'?'selected ' :''}}>HDD Tray</option>
                    <option value="53" {{ $d->sidefunction =='53'?'selected ' :''}}>Smart Card Reader</option>
                    <option value="54" {{ $d->sidefunction =='54'?'selected ' :''}}>Side IO</option>
                </select></td>
        </tr>
        <tr><td class="bg-blue">Camera Housing</td>
            <td>
                <select id="cameraahousing" name="cameraahousing">
                    <option value="55" {{ $d->cameraahousing =='55'?'selected ' :''}}>None	</option>
                    <option value="56" {{ $d->cameraahousing =='56'?'selected ' :''}}>Pop up</option>
                    <option value="57" {{ $d->cameraahousing =='57'?'selected ' :''}}>Type C</option>
                    <option value="58" {{ $d->cameraahousing =='58'?'selected ' :''}}>Pop up with mic on/off switch</option>
                </select></td>
            <td class="bg-blue">Camera</td>
            <td>
                <select id="camera" name="camera">
                    <option value="59" {{ $d->camera =='59'?'selected ' :''}}>None</option>
                    <option value="60" {{ $d->camera =='60'?'selected ' :''}}>2M (1920*1080) Camera + Single Mic</option>
                    <option value="61" {{ $d->camera =='61'?'selected ' :''}}>2M (1920*1080) Camera + Dual Mic</option>
                    <option value="62" {{ $d->camera =='62'?'selected ' :''}}>5M (2592*1944) Camera + Dual Mic</option>
                    <option value="63" {{ $d->camera =='63'?'selected ' :''}}>5M (2592*1944) Camera + Single Mic</option>
                    <option value="64" {{ $d->camera =='64'?'selected ' :''}}>2M (1920*1080) Camera + Dual DMic</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Camera FW</td>
            <td><input  type="text" name="camerafw" placeholder="(自填)" autocomplete= 'off' value="{{$d->camerafw}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
            <td class="bg-blue">Power</td>
            <td>
                <select id="power" name="power">
                    <option value="66" {{ $d->power =='66'?'selected ' :''}}>None</option>
                    <option value="67" {{ $d->power =='67'?'selected ' :''}}>120W Internal power board</option>
                    <option value="68" {{ $d->power =='68'?'selected ' :''}}>90W Internal power board+battery</option>
                    <option value="69" {{ $d->power =='69'?'selected ' :''}}>120W adaptor(7.4/5.1mm)</option>
                    <option value="70" {{ $d->power =='70'?'selected ' :''}}>120W adaptor(5.5/2.5mm)</option>
                    <option value="71" {{ $d->power =='71'?'selected ' :''}}>65W adaptor</option>
                    <option value="72" {{ $d->power =='72'?'selected ' :''}}>150W adaptor</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue"> Speaker</td>
            <td><input type="text" name="speaker"  autocomplete= 'off' value="{{$d->speaker}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Chassis+Stand Color</td>
            <td>
                <select id="chassisstandcolor" name="chassisstandcolor">
                    <option value="75" {{ $d->chassisstandcolor =='75'?'selected ' :''}}>Black Color Chassis</option>
                    <option value="76" {{ $d->chassisstandcolor =='76'?'selected ' :''}}>White Color Chassis</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Silk Print</td>
            <td><input type="text" name="silkprint" placeholder="(自填)" autocomplete= 'off' value="{{$d->silkprint}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
            <td class="bg-blue">Cable Cover</td>
            <td>
                <select id="cablecover"  name="cablecover">
                    <option value="78" {{ $d->cablecover =='78'?'selected ' :''}}>None</option>
                    <option value="79" {{ $d->cablecover =='79'?'selected ' :''}}>Cable cover</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Hinge</td>
            <td>
                <select id="hinge" name="hinge">
                    <option value="81" {{ $d->hinge =='81'?'selected ' :''}}>Default Y hinge</option>
                    <option value="82" {{ $d->hinge =='82'?'selected ' :''}}>Hinge outside</option>
                    <option value="83" {{ $d->hinge =='83'?'selected ' :''}}>Hinge outside + mylar</option>
                    <option value="84" {{ $d->hinge =='84'?'selected ' :''}}>VESA only, no mylar</option>
                </select></td>
            <td class="bg-blue">VESA Screw</td>
            <td>
                <select id="vesascrew" name="vesascrew">
                    <option value="85" {{ $d->vesascrew =='85'?'selected ' :''}}>No Screw(VESA or No need)</option>
                    <option value="86" {{ $d->vesascrew =='86'?'selected ' :''}}>VESA screw</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">EMC</td>
            <td>
                <select id="emc" name="emc">
                    <option value="87" {{ $d->emc =='87'?'selected ' :''}}>None</option>
                    <option value="88" {{ $d->emc =='88'?'selected ' :''}}>EMI Coating</option>
                </select></td>
            <td class="bg-blue">Kensington Lock</td>
            <td><input type="text" name="kensingtonlock"  autocomplete= 'off' value="{{$d->kensingtonlock}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'></td>
        </tr>
        <tr>
            <td class="bg-blue">Stand</td>
            <td>
                <select id="stand" name="stand">
                    <option value="90" {{ $d->stand =='90'?'selected ' :''}}>No Stand</option>
                    <option value="91" {{ $d->stand =='91'?'selected ' :''}}>Y Stand V2.0</option>
                    <option value="92" {{ $d->stand =='92'?'selected ' :''}}>2-in-1 Stand</option>
                    <option value="93" {{ $d->stand =='93'?'selected ' :''}}>Round Stand</option>
                    <option value="94" {{ $d->stand =='94'?'selected ' :''}}>C Stand</option>
                    <option value="95" {{ $d->stand =='95'?'selected ' :''}}>HAS03 Generic Black</option>
                    <option value="96" {{ $d->stand =='96'?'selected ' :''}}>HAS-R-B Round Black</option>
                    <option value="97" {{ $d->stand =='97'?'selected ' :''}}>HAS-R-S Round Silver</option>
                    <option value="98" {{ $d->stand =='98'?'selected ' :''}}>HAS 1804</option>
                </select></td>
            <td class="bg-blue">2-in-1 Stand Screw</td>
            <td>
                <select id="standscrew"  name="standscrew">
                    <option value="99"  {{ $d->standscrew =='99'?'selected ' :''}}>Not 2in1 stand</option>
                    <option value="100"  {{ $d->standscrew =='100'?'selected ' :''}}>Hex head screw</option>
                    <option value="101"  {{ $d->standscrew =='101'?'selected ' :''}}>Philips screw</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">COM</td>
            <td>
                <select id="com" name="com">
                    <option value="103" {{ $d->com =='103'?'selected ' :''}}>None</option>
                    <option value="104" {{ $d->com =='104'?'selected ' :''}}>COM</option>
                </select></td>
            <td class="bg-blue">Extra USB</td>
            <td>
                <select id="extrausb" name="extrausb">
                    <option value="105" {{ $d->extrausb =='105'?'selected ' :''}}>None</option>
                    <option value="106" {{ $d->extrausb =='106'?'selected ' :''}}>2 x USB3.2 Gen1 Type A</option>
                    <option value="107" {{ $d->extrausb =='107'?'selected ' :''}}>2 x USB2.0 Type A</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Chassis Intrusion</td>
            <td><select id="chassisintrusion" name="chassisintrusion">
                    <option value="108" {{ $d->chassisintrusion =='108'?'selected ' :''}}>None</option>
                    <option value="109" {{ $d->chassisintrusion =='109'?'selected ' :''}}>Chassis Intrusion</option>
                </select></td>
            <td class="bg-blue">Power Cord Type</td>
            <td>
                <select id="powercordtype" name="powercordtype">
                    <option value="110" {{ $d->powercordtype =='110'?'selected ' :''}}>None</option>
                    <option value="111" {{ $d->powercordtype =='111'?'selected ' :''}}>Default ST</option>
                    <option value="112" {{ $d->powercordtype =='112'?'selected ' :''}}>RA (with powerboard and cable cover)</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Power Cord</td>
            <td>
                <select id="powercord" name="powercord">
                    <option value="113" {{ $d->powercord =='113'?'selected ' :''}}>Power Cord	None</option>
                    <option value="114" {{ $d->powercord =='114'?'selected ' :''}}>Europe / Middle east / Korea</option>
                    <option value="115" {{ $d->powercord =='115'?'selected ' :''}}>USA / South America</option>
                    <option value="116" {{ $d->powercord =='116'?'selected ' :''}}>Brazil</option>
                    <option value="117" {{ $d->powercord =='117'?'selected ' :''}}>Chile/Italy</option>
                    <option value="118" {{ $d->powercord =='118'?'selected ' :''}}>Argentina</option>
                    <option value="119" {{ $d->powercord =='119'?'selected ' :''}}>England</option>
                    <option value="120" {{ $d->powercord =='120'?'selected ' :''}}>India (3 round)</option>
                    <option value="121" {{ $d->powercord =='121'?'selected ' :''}}>China</option>
                </select></td>
            <td class="bg-blue">Customer Code</td>
            <td><input  type="text" name="customercode" placeholder="(自填)" autocomplete= 'off' value="{{$d->customercode}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
        </tr>
        <tr>
            <td class="bg-blue">Customization</td>
            <td>
                <select id="customization" name="customization">
                    <option value="124" {{ $d->customization =='124'?'selected ' :''}}>No Customization</option>
                    <option value="125" {{ $d->customization =='125'?'selected ' :''}}>Customization</option>
                </select></td>
            <td class="bg-blue">LOGO</td>
            <td>
                <select id="logo" name="logo">
                    <option value="126" {{ $d->logo =='126'?'selected ' :''}}>No logo</option>
                    <option value="127" {{ $d->logo =='127'?'selected ' :''}}>Front silk print only</option>
                    <option value="128" {{ $d->logo =='128'?'selected ' :''}}>Front nickel logo only</option>
                    <option value="129" {{ $d->logo =='129'?'selected ' :''}}>Back silk print only</option>
                    <option value="130" {{ $d->logo =='130'?'selected ' :''}}>Back nickel logo only</option>
                    <option value="131" {{ $d->logo =='131'?'selected ' :''}}>Front and Back silk print</option>
                    <option value="132" {{ $d->logo =='132'?'selected ' :''}}>Front and Back nickel logo</option>
                    <option value="133" {{ $d->logo =='133'?'selected ' :''}}>Front silk print and Back nickel logo</option>
                    <option value="134" {{ $d->logo =='134'?'selected ' :''}}>Front nickel logo and Back silk print</option>
                </select></td>
        </tr>
        <tr>
            <td class="bg-blue">Remark</td>
            <td>
                <table id="addremark" >
                    <input type="button" id="remarkadd" value="新增remark列" class="bt-add">
                    <tbody>
                    @if($remarklist>0)
                    @foreach($remarklist as $r)
                        <tr><td style="vertical-align: middle !important;text-align: center;"><br>
                         <textarea name="remark[]" cols="50" rows="3" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'>{{$r}}</textarea>
                         <button class="bt-del delremark" style="width:80px;">刪除</button>
                          </td></tr>
                    @endforeach
                        @endif
                    </tbody>
                </table></td>
            <td class="bg-blue">Version</td>
            <td><input  type="text" name="version"  placeholder="(自填)" autocomplete= 'off' value="{{$d->version}}" onkeydown='if(event.keyCode==13){event.keyCode=0;event.returnValue=false;}'/></td>
        </tr>

        <tr><td class="bg-blue">Buyer:Date</td><td><input type="date" name="buyer" value="{{$d->buyer}}"></td>
            <td class="bg-blue">Seller:Date</td><td><input type="date" name="seller" value="{{$d->seller}}"></td></tr>


        <tr>
            <td class="bg-blue">最後修改日期</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="updatedate" value="<?php echo date("Y-m-d H:i:s");?>" readonly></td>
            <td class="bg-blue">最後修改人員</td>
            <td><input style="background:#F0F0F0;width:200px;" type="text" name="updateemp" value="{{Session::get('name')}}"></td>
            <input type="hidden" name="sts" value="N">
        </tr>

    </table>
    <br><input type="submit" class="bt-send" value="修改PI規格單" ><br><br>

</form>
@endforeach




</body>
</html><?php
