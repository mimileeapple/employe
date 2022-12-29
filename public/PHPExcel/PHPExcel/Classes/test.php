<?php
    $FileName=$_POST['mytext'];
    $hostname = "localhost";  		
	$username ="root";
	$password ="foxlink";
	$database_name = "sfc";
    $mysqli = new mysqli($hostname,$username,$password,$database_name);
	$mysqli->query('SET NAMES utf8');	 
	$mysqli->query('SET CHARACTER_SET_CLIENT=utf8');
	$mysqli->query('SET CHARACTER_SET_RESULTS=utf8'); 
    
    
    $file_name=$_POST['filename1'];
    $move_folder = "C:\\inetpub\\wwwroot\\SFC\\PHPExcel\\Classes\\";
	if ($_FILES["file1"]["error"] > 0)
    {
        echo "Error: " . $_FILES["file1"]["error"] . "<br>";
    }
        else
    {
        echo "Upload: " . $_POST['filename1']."<br>";
        echo "Type: " . $_FILES["file1"]["type"] . "<br>";
        echo "Size: " . ($_FILES["file1"]["size"] / 1024) . " kB<br>";
        //echo "Stored in: " . $_FILES["file1"]["tmp_name"]. "<br>";
        move_uploaded_file($_FILES["file1"]["tmp_name"],$move_folder. iconv("utf-8", "big5", $_FILES["file1"]["name"]));
    }
            
  
set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');
include 'PHPExcel/IOFactory.php';
$old_sql="TRUNCATE TABLE test";
$mysqli->query($old_sql);
$reader = PHPExcel_IOFactory::createReader('Excel5'); // 讀取舊版 excel 檔案
$PHPExcel = $reader->load($file_name);
$sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
$highestRow = $sheet->getHighestRow(); // 取得總列數
$final_array = array();
$data_array = array();
// 從第二行開始 一次讀取一列
for ($row = 2; $row <= $highestRow; $row++) 
{
    //定義字符串,不定義會出現數組錯誤，分割字符串成數組出現問題
    $strs="";
    $continue_flag = 0;
   // echo ($row-1)." ";
        
    for ($column = 1; $column <= 9; $column++) 
    {
        //假如讀取到的第一行數據的第一筆是空的就break。
        if($column==1)
        {
            if(strcmp($sheet->getCellByColumnAndRow($column, $row)->getValue(),"")==0)
            {
                $continue_flag = 1;
                break;
            }
        }
        //$strs 是字符串  下面會分割成數組   分割條件用|*|來進行。
        $strs .= $sheet->getCellByColumnAndRow($column, $row)->getValue()."|*|";      
    }
    //echo $strs."<BR>";
    //假如$continue_flag大於0，代表有數據為空  不進行分割
    
     if($continue_flag>0){
        //echo "BYE<BR>";
     }
     else
     {  
        //字符串分割成數組
        $str=explode("|*|",$strs);
        //$row代表第二筆   減去1就是id。
        $data_array["id"]=$row-1;
        //分割的數組分別存進data_array。
        $data_array["name"]=$str[0];
        $data_array["Depart_Code"]=$str[1];
        $data_array["parent_Code"]=$str[2];
        if($str[2]==0)
            $data_array["parentId"]="0";
        else
            $data_array["parentId"]="";
        $data_array["childId"]="";
        $data_array["levelNum"]=$str[4];
        $data_array["FAC_CODE"]=$str[6];
        $data_array["right"]=$str[4];
        
        /*
        echo "1:".$data_array["id"]."<br>";
        echo "2:".$data_array["name"]."<br>";
        echo "3:".$data_array["Depart_Code"]."<br>";
        echo "3.4:".$data_array["parent_Code"]."<br>";
        echo "4:".$data_array["levelNum"]."<br>";
        echo "5:".$data_array["FAC_CODE"]."<br>";
        echo "6:".$data_array["right"]."<br>";
        */
        //if($row>1750)
         //echo "3:".$data_array["Depart_Code"]."<br>";
        //$temp_array = array();
        //檢查$final_array裏面有沒有parent，如果有就把data_array["id"]放到parent的child
        if(array_key_exists($data_array["parent_Code"],$final_array))
        {
            //如果child等於0就直接放進去
            if(strcmp($final_array[$data_array["parent_Code"]]["childId"],"")==0)
            {
                //把data_array["id"]放到parent的child
                $final_array[$data_array["parent_Code"]]["childId"]=$data_array["id"];  
                //把parent的id放進parentId。
                $data_array["parentId"]=$final_array[$data_array["parent_Code"]]["id"];            
            }
            else
            {
                //如果child不等於0就把child加起來
                $final_array[$data_array["parent_Code"]]["childId"].=",".$data_array["id"];
                //把parent的id放進parentId。
                $data_array["parentId"]=$final_array[$data_array["parent_Code"]]["id"];            
            }
            //把data_array的數據全部搬進$final_array
            $final_array[$data_array["Depart_Code"]]=$data_array;
        }
        else
        {            
            //把data_array的數據全部搬進$final_array
            $final_array[$data_array["Depart_Code"]]=$data_array;  
        }
     }
}

//得到$final_array  遍歷$value;
 foreach($final_array as $key=>$value){
    //分別取$value出來
        $id=$value["id"];
        $name=$value["name"];
        $Depart_Code=$value["parent_Code"];
        $childId=$value["childId"];
        $parentId=$value["parentId"];
        $FAC_CODE=$value["FAC_CODE"];
        $right=$value["right"];
        $levelNum=$value["levelNum"];
        /*
        echo "1:".$Depart_Code." ";
        echo "2:".$id." ";
        echo "3:".$name." ";
        echo "4:".$childId." ";
        echo "5:".$parentId." ";
        echo "6:".$FAC_CODE." ";
        echo "7:".$right." ";
        echo "8:".$levelNum."<BR>";
        */
        $sql = "INSERT INTO `test` (`id`,`parentId`,`childId`,`levelNum`,`name`,`Depart_Code`,`FAC_CODE`,`right`) VALUES(";
        $sql.="'$id','$parentId','$childId','$levelNum','$name','$key','$FAC_CODE','$right'".")";
        //echo $key;
        
    $mysqli->query($sql);
    
   
}
echo "上傳完成";
mysqli_close($mysqli);

?>
