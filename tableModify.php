<?php
include 'db_connector.php';

Session_start();
$tablename = $_SESSION['CSVfilename'];        //获得tablename用于数据库操作
$conn = (new DatabaseConnector())->connectDatabase("127.0.0.1","root","Zyh812625","data_analysis");

// 获得原始输入内容  
$json = file_get_contents("php://input");  
//var_dump($input_str);  
  
// JSON转换为PHP对象  
$obj = json_decode($json);  
  
$msg = $obj->msg;
$id = $obj->id;
$columnName=$obj->columnname;
$value = $obj->value;

if($msg == "update")
{
   $sql = "UPDATE $tablename SET $columnName = '$value' WHERE System_ID = $id";
    
  if($conn->query($sql) ===TRUE)
  {
  	echo "data updated";
  }
  else
  {
  	echo "fail to update data";
  }
}


$conn->close();
?>