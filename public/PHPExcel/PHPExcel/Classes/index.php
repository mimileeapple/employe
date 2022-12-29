<?php
    

?>
<center>
<html>
<head>
<time>匯入Excel檔修改部門組織</time>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
function getName() 
{
  var Name1 = document.upload.file1.value.split('\\');
  document.upload.filename1.value=Name1[Name1.length-1]; 
  return true;
}
</script>
</head>
<body>
<form name="upload" action="test.php" method="post" enctype="multipart/form-data" onsubmit="return getName()">
<input type="hidden" name="filename1">
檔案名稱:<input type="file" name="file1" id="file" />
<input type="submit" name="submit" value="上傳檔案" />
</form>

</body>
</html>
