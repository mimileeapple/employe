<?php

namespace App\Http\Controllers;

use App\Model\piheade;
use App\Model\pispace\pispacedata;
use App\Model\pispace\pispaceorder;
use App\Model\pispace\productname;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class PIspaceController extends Controller
{
    private $CustomerService;

    public function __construct()
    {

        $this->CustomerService = new CustomerService();
    }


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }
    public function showpispace($id)
    {
        $issetspace = productname::where('orderid', $id)->count();//單據
        if ($issetspace > 0) {
            //當已經填寫完畢時候則跳入修改頁面
            $data=productname::where('orderid', $id)->get();
            return view("customer.space.updatespace", ['data' => $data]);
        } else {
            //沒資料時跳至新增頁面
            $list=piheade::where('id',$id)->get();
            return view("customer.space.newpispace",['list'=>$list]);
        }
}

    public function store(Request $request)
    {
        //修改規格表資料
        $con='-';
        $productdata=$request->input();
        $camerafw = $request->input("camerafw");//無顯示
        $modelname = $request->input("modelname");//0
        $systemtype = $request->input("systemtype");//2
        $knockeddown = $request->input("knockeddown");//4
        $front = $request->input("front");//6
        $productname = $modelname . $systemtype . $front;
        $motherboard = $request->input("motherboard");//可能有自key---8
        $bios = $request->input("bios");//自key 無顯示x
        $frontio =$this->CustomerService->findspaceid($request->input("frontio"));//9
        $sideio = $this->CustomerService->findspaceid($request->input("sideio"));//10

        $wireless =$this->CustomerService-> findspaceid($request->input("wireless"));//11
        $a12=$con;
        $lcd =$this->CustomerService->findspaceid($request->input("lcd"));//13
        $thermalmodule =$this->CustomerService->findspaceid($request->input("thermalmodule"));//14
        $systemfan =$this->CustomerService->findspaceid($request->input("systemfan"));//15
        $keyparts =$request->input("keyparts");//16
        $sidefunction =$this->CustomerService->findspaceid($request->input("sidefunction"));//17
        $cameraahousing =$this->CustomerService->findspaceid($request->input("cameraahousing"));//18
        $camera =$this->CustomerService->findspaceid($request->input("camera"));//19

        $power =$this->CustomerService->findspaceid($request->input("power"));//20
        $a21=$con;

        $chassisstandcolor =$this->CustomerService->findspaceid($request->input("chassisstandcolor"));//22
        $silkprint=$request->input("silkprint");//23
        $cablecover =$this->CustomerService->findspaceid($request->input("cablecover"));//24
        $a25=$con;
        $hinge =$this->CustomerService->findspaceid($request->input("hinge"));//26
        $vesascrew =$this->CustomerService->findspaceid($request->input("vesascrew"));//27
        $emc =$this->CustomerService->findspaceid($request->input("emc"));//28
        $stand =$this->CustomerService->findspaceid($request->input("stand"));//29
        $standscrew=$this->CustomerService->findspaceid($request->input("standscrew"));//30
        $a31=$con;
        $com =$this->CustomerService->findspaceid($request->input("com"));//32
        $chassisintrusion =$this->CustomerService->findspaceid($request->input("chassisintrusion"));//33
        $powercordtype =$this->CustomerService->findspaceid($request->input("powercordtype"));//34
        $powercord =$this->CustomerService->findspaceid($request->input("powercord"));//35
        $a36=$con;
        $customercode =$this->CustomerService->findspaceid($request->input("customercode"));//37
        $customization=$this->CustomerService->findspaceid($request->input("customization"));//38
        $logo =$this->CustomerService->findspaceid($request->input("logo"));//39
        $a40=$con;
        $version =$request->input("version");//41
        $productmodel=$productname."-".$motherboard.$frontio.$sideio.$wireless.$a12.$lcd.$thermalmodule.$systemfan.$keyparts.$sidefunction
            .$cameraahousing.$camera.$power.$a21.$chassisstandcolor.$silkprint.$cablecover.$a25.$hinge.$vesascrew.$emc.$stand.$standscrew
            .$a31.$com.$chassisintrusion.$powercordtype.$powercord.$a36.$customercode.$customization.$logo.$a40.$version;
        $productdata['productmodel']=$productmodel;
        //$productdata = array_except($productdata, ['backio', 'remark']);//這兩個我不要ㄟ


        $productdata['backio']=json_encode($productdata['backio']);
        $productdata['remark']=json_encode($productdata['remark']);


        productname::create($productdata);

//----------------------------------------------
        //業務顯示文字
        $lcdsales =$this->CustomerService->findspacesales($request->input("lcd"));//1
        $lcdlingt =$this->CustomerService->findspacesales($request->input("lcdlingt"));//1
        $lcdnote =$this->CustomerService->findspacesales($request->input("lcdnote"));//1
        $motherboard = $request->input("motherboard");//可能有自key---3
        $cpu = $request->input("cpu");//4
        $thermalmodulesales =$this->CustomerService->findspacesales($request->input("thermalmodule"));//5
        $systemfansales =$this->CustomerService->findspacesales($request->input("systemfan"));//5
        $memory =$request->input("memory");//6
        $storage =$request->input("ssd");//7
        $sidefunctionsales =$this->CustomerService->findspacesales($request->input("sidefunction"));//8
        $cameraahousingsales =$this->CustomerService->findspacesales($request->input("cameraahousing"));
        $camerasales  =$this->CustomerService->findspacesales($request->input("camera"));///9
        $wirelesssales  =$this->CustomerService->findspacesales($request->input("wireless"));//10
        $frontiosales =$this->CustomerService->findspacesales($request->input("frontio"));//11
        $backio = $request->input("backio");//自key sales顯示---//12
        $sideiosales = $this->CustomerService->findspacesales($request->input("sideio"));//13
        $comsales = $this->CustomerService->findspacesales($request->input("com"));//14
        $extrausb = $this->CustomerService->findspacesales($request->input("extrausb"));// 14
        $speaker = $request->input("speaker");//sales顯示//15
        $cablecoversales = $this->CustomerService->findspacesales($request->input("cablecover"));//16
        $vesascrewsales= $this->CustomerService->findspacesales($request->input("vesascrew"));//16
        $emcsales = $this->CustomerService->findspacesales($request->input("emc"));//16
        $kensingtonlock = $request->input("kensingtonlock");//16
        $chassisintrusionsales = $this->CustomerService->findspacesales($request->input("chassisintrusion"));//16
        $powersales = $this->CustomerService->findspacesales($request->input("power"));//17
        $standsales = $this->CustomerService->findspacesales($request->input("stand"));//18
        $hingesales = $this->CustomerService->findspacesales($request->input("hinge"));//18
        $chassisstandcolorsales = $this->CustomerService->findspacesales($request->input("chassisstandcolor"));//19
        $logosales = $this->CustomerService->findspacesales($request->input("logo"));//20
        //$remark =$request->input("remark");//21
        $backio=[];
        $remark=[];
        if($request->input('backio')!=""){
            foreach ($request->input('backio') as $i => $v) {
                $backio[] = array('backio' => $request->input('backio')[$i]);
            }}
        if($request->input('remark')!=""){
            foreach ($request->input('remark') as $i => $v) {
                $remark[] = array('remark' => $request->input('remark')[$i]);
            }}
//-----------------------------------------------------------------------------
        //標題
        $lcdtitle = "Display";//1
        $lcdlingttitle ="Display_0";
        $lcdnotetitle = "Display_1";
        $motherboardtitle = "Motherboard";//可能有自key---3
        $cputitle = "Processor";//4
        $thermalmoduletitle = "Thermal";//5
        $systemfantitle = "Thermal_0";//5
        $memorytitle ="Memory";//6
        $storagetitle ="Storage_0";//7
        $sidefunctiontitle= $this->CustomerService->usetitlefindall($request->input("sidefunction"));//8
        $cameraahousingtitle ="Camera";
        $cameratitle  ="Camera_0";///9
        ///
        $wirelesstitle  = $this->CustomerService->usetitlefindall($request->input("wireless"));//10
        $frontiotitle = $this->CustomerService->usetitlefindall($request->input("frontio"));//11
        $backiotitle = "Back IO";//自key sales顯示---//12
        $sideiotitle = "Side IO_0";//13
        $comsalestitle = "Extra IO";//14
        $extrausbtitle = "Extra IO_0";// 14

        $cablecovertitle = "Security";//16
        $vesascrewtitle= "Security_0";//16
        $emctitle= "Security_1";//16
        $kensingtonlocktitle ="Security_2";//16
        $chassisintrusiontitle = "Security_3";//16
        $powertitle = $this->CustomerService->usetitlefindall($request->input("power"));//17
        $standtitle ="Stand";//18
        $hingetitle= "Stand_0";//18

        $logotitle = $this->CustomerService->usetitlefindall($request->input("logo"));//20
        $remarktitle = "Remark";//21

        $data=array("Product Name"=>$productname,$lcdtitle=>$lcdsales,$lcdlingttitle=>$lcdlingt,$lcdnotetitle=>$lcdnote,
            $thermalmoduletitle=>$thermalmodulesales,$systemfantitle=>$systemfansales,
            $motherboardtitle=>$motherboard,$cputitle=>$cpu,
            $memorytitle=>$memory,$storagetitle=>$storage,$sidefunctiontitle=>$sidefunctionsales,$cameraahousingtitle=>$cameraahousingsales,
            $cameratitle=>$camerasales,$wirelesstitle=>$wirelesssales,$frontiotitle=>$frontiosales,$backiotitle=>$backio,$sideiotitle=>$sideiosales,
            $comsalestitle=>$comsales,$extrausbtitle=>$extrausb,"Speaker"=>$speaker,$cablecovertitle=>$cablecoversales,$vesascrewtitle=>$vesascrewsales,
            $emctitle=>$emcsales,$kensingtonlocktitle=>$kensingtonlock,$chassisintrusiontitle=>$chassisintrusionsales,$powertitle=>$powersales,
            $standtitle=>$standsales,$hingetitle=>$hingesales,"Color"=>$chassisstandcolorsales,$logotitle=>$logosales,$remarktitle=>$remark);
        $data=json_encode($data);

        //dd($data);

        $s=$request->input();
        $s['spacedata']=$data;

//     dd($data);

        pispaceorder::create($s);
        echo " <script>alert('新增成功'); self.opener.location.reload();window.close(); </script>";
    }

    public function show($id)
    {
        //秀出規格表
        /*$spacelist=pispaceorder::where('orderid',$id)->get();
        $spacedata=pispaceorder::where('orderid',$id)->value('spacedata');
       $spacedata= json_decode($spacedata,true);


        return view('customer.space.printspace',['spacelist'=>$spacelist,'spacedata'=>$spacedata]);*/
    }


    public function edit($id)
    {
        //抓出規格表
       $data= productname::where('orderid',$id)->get();

        $backio= json_decode($data[0]['backio']);
        $remarklist=json_decode($data[0]['remark']);
       return view("customer.space.updatespace",['data'=>$data,'backio'=>$backio,'remarklist'=>$remarklist]);
    }

    public function update(Request $request, $id)
    {
        //修改規格表資料
        $con='-';
        $productdata=$request->input();
        $camerafw = $request->input("camerafw");//無顯示
        $modelname = $request->input("modelname");//0
        $systemtype = $request->input("systemtype");//2
        $knockeddown = $request->input("knockeddown");//4
        $front = $request->input("front");//6
        $productname = $modelname . $systemtype . $front;
        $motherboard = $request->input("motherboard");//可能有自key---8
        $bios = $request->input("bios");//自key 無顯示x
        $frontio =$this->CustomerService->findspaceid($request->input("frontio"));//9
        $sideio = $this->CustomerService->findspaceid($request->input("sideio"));//10

        $wireless =$this->CustomerService-> findspaceid($request->input("wireless"));//11
        $a12=$con;
        $lcd =$this->CustomerService->findspaceid($request->input("lcd"));//13
        $thermalmodule =$this->CustomerService->findspaceid($request->input("thermalmodule"));//14
        $systemfan =$this->CustomerService->findspaceid($request->input("systemfan"));//15
        $keyparts =$request->input("keyparts");//16
        $sidefunction =$this->CustomerService->findspaceid($request->input("sidefunction"));//17
        $cameraahousing =$this->CustomerService->findspaceid($request->input("cameraahousing"));//18
        $camera =$this->CustomerService->findspaceid($request->input("camera"));//19

        $power =$this->CustomerService->findspaceid($request->input("power"));//20
        $a21=$con;

        $chassisstandcolor =$this->CustomerService->findspaceid($request->input("chassisstandcolor"));//22
        $silkprint=$request->input("silkprint");//23
        $cablecover =$this->CustomerService->findspaceid($request->input("cablecover"));//24
        $a25=$con;
        $hinge =$this->CustomerService->findspaceid($request->input("hinge"));//26
        $vesascrew =$this->CustomerService->findspaceid($request->input("vesascrew"));//27
        $emc =$this->CustomerService->findspaceid($request->input("emc"));//28
        $stand =$this->CustomerService->findspaceid($request->input("stand"));//29
        $standscrew=$this->CustomerService->findspaceid($request->input("standscrew"));//30
        $a31=$con;
        $com =$this->CustomerService->findspaceid($request->input("com"));//32
        $chassisintrusion =$this->CustomerService->findspaceid($request->input("chassisintrusion"));//33
        $powercordtype =$this->CustomerService->findspaceid($request->input("powercordtype"));//34
        $powercord =$this->CustomerService->findspaceid($request->input("powercord"));//35
        $a36=$con;
        $customercode =$this->CustomerService->findspaceid($request->input("customercode"));//37
        $customization=$this->CustomerService->findspaceid($request->input("customization"));//38
        $logo =$this->CustomerService->findspaceid($request->input("logo"));//39
        $a40=$con;
        $version =$request->input("version");//41
        $productmodel=$productname."-".$motherboard.$frontio.$sideio.$wireless.$a12.$lcd.$thermalmodule.$systemfan.$keyparts.$sidefunction
            .$cameraahousing.$camera.$power.$a21.$chassisstandcolor.$silkprint.$cablecover.$a25.$hinge.$vesascrew.$emc.$stand.$standscrew
            .$a31.$com.$chassisintrusion.$powercordtype.$powercord.$a36.$customercode.$customization.$logo.$a40.$version;
        $productdata['productmodel']=$productmodel;
        //
        productname::find($id)->update($productdata);

//----------------------------------------------
        //業務顯示文字
        $lcdsales =$this->CustomerService->findspacesales($request->input("lcd"));//1
        $lcdlingt =$this->CustomerService->findspacesales($request->input("lcdlingt"));//1
        $lcdnote =$this->CustomerService->findspacesales($request->input("lcdnote"));//1
        $motherboard = $request->input("motherboard");//可能有自key---3
        $cpu = $request->input("cpu");//4
        $thermalmodulesales =$this->CustomerService->findspacesales($request->input("thermalmodule"));//5
        $systemfansales =$this->CustomerService->findspacesales($request->input("systemfan"));//5
        $memory =$request->input("memory");//6
        $storage =$request->input("ssd");//7
        $sidefunctionsales =$this->CustomerService->findspacesales($request->input("sidefunction"));//8
        $cameraahousingsales =$this->CustomerService->findspacesales($request->input("cameraahousing"));
        $camerasales  =$this->CustomerService->findspacesales($request->input("camera"));///9
        $wirelesssales  =$this->CustomerService->findspacesales($request->input("wireless"));//10
        $frontiosales =$this->CustomerService->findspacesales($request->input("frontio"));//11
        $backio = $request->input("backio");//自key sales顯示---//12
        $sideiosales = $this->CustomerService->findspacesales($request->input("sideio"));//13
        $comsales = $this->CustomerService->findspacesales($request->input("com"));//14
        $extrausb = $this->CustomerService->findspacesales($request->input("extrausb"));// 14
        $speaker = $request->input("speaker");//sales顯示//15
        $cablecoversales = $this->CustomerService->findspacesales($request->input("cablecover"));//16
        $vesascrewsales= $this->CustomerService->findspacesales($request->input("vesascrew"));//16
        $emcsales = $this->CustomerService->findspacesales($request->input("emc"));//16
        $kensingtonlock = $request->input("kensingtonlock");//16
        $chassisintrusionsales = $this->CustomerService->findspacesales($request->input("chassisintrusion"));//16
        $powersales = $this->CustomerService->findspacesales($request->input("power"));//17
        $standsales = $this->CustomerService->findspacesales($request->input("stand"));//18
        $hingesales = $this->CustomerService->findspacesales($request->input("hinge"));//18
        $chassisstandcolorsales = $this->CustomerService->findspacesales($request->input("chassisstandcolor"));//19
        $logosales = $this->CustomerService->findspacesales($request->input("logo"));//20
        //$remark =$request->input("remark");//21
        $backio=[];
        $remark=[];
        if($request->input('backio')!=""){
        foreach ($request->input('backio') as $i => $v) {
            $backio[] = array('backio' => $request->input('backio')[$i]);
        }}
        if($request->input('remark')!=""){
        foreach ($request->input('remark') as $i => $v) {
            $remark[] = array('remark' => $request->input('remark')[$i]);
        }}

//-----------------------------------------------------------------------------
        //標題
        $lcdtitle = "Display";//1
        $lcdlingttitle ="Display_0";
        $lcdnotetitle = "Display_1";
        $motherboardtitle = "Motherboard";//可能有自key---3
        $cputitle = "Processor";//4
        $thermalmoduletitle = "Thermal";//5
        $systemfantitle = "Thermal_0";//5
        $memorytitle ="Memory";//6
        $storagetitle ="Storage_0";//7
        $sidefunctiontitle= $this->CustomerService->usetitlefindall($request->input("sidefunction"));//8
        $cameraahousingtitle ="Camera";
        $cameratitle  ="Camera_0";///9
        ///
        $wirelesstitle  = $this->CustomerService->usetitlefindall($request->input("wireless"));//10
        $frontiotitle = $this->CustomerService->usetitlefindall($request->input("frontio"));//11
        $backiotitle = "Back IO";//自key sales顯示---//12
        $sideiotitle = "Side IO_0";//13
        $comsalestitle = "Extra IO";//14
        $extrausbtitle = "Extra IO_0";// 14

        $cablecovertitle = "Security";//16
        $vesascrewtitle= "Security_0";//16
        $emctitle= "Security_1";//16
        $kensingtonlocktitle ="Security_2";//16
        $chassisintrusiontitle = "Security_3";//16
        $powertitle = $this->CustomerService->usetitlefindall($request->input("power"));//17
        $standtitle ="Stand";//18
        $hingetitle= "Stand_0";//18

        $logotitle = $this->CustomerService->usetitlefindall($request->input("logo"));//20
        $remarktitle = "Remark";//21

        $data=array("Product Name"=>$productname,$lcdtitle=>$lcdsales,$lcdlingttitle=>$lcdlingt,$lcdnotetitle=>$lcdnote,
            $thermalmoduletitle=>$thermalmodulesales,$systemfantitle=>$systemfansales,
            $motherboardtitle=>$motherboard,$cputitle=>$cpu,
            $memorytitle=>$memory,$storagetitle=>$storage,$sidefunctiontitle=>$sidefunctionsales,$cameraahousingtitle=>$cameraahousingsales,
            $cameratitle=>$camerasales,$wirelesstitle=>$wirelesssales,$frontiotitle=>$frontiosales,$backiotitle=>$backio,$sideiotitle=>$sideiosales,
            $comsalestitle=>$comsales,$extrausbtitle=>$extrausb,"Speaker"=>$speaker,$cablecovertitle=>$cablecoversales,$vesascrewtitle=>$vesascrewsales,
            $emctitle=>$emcsales,$kensingtonlocktitle=>$kensingtonlock,$chassisintrusiontitle=>$chassisintrusionsales,$powertitle=>$powersales,
            $standtitle=>$standsales,$hingetitle=>$hingesales,"Color"=>$chassisstandcolorsales,$logotitle=>$logosales,$remarktitle=>$remark);
        $data=json_encode($data);

        //dd($data);

        $s=$request->input();
        $s['spacedata']=$data;
        pispaceorder::find($id)->update($s);
        echo " <script>alert('修改成功'); self.opener.location.reload();window.close(); </script>";
    }


    public function destroy($id)
    {
        //
    }

}
