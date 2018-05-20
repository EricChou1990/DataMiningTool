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

if($msg == "delete")
{
	$id = $obj->id; 
	$sql = "delete from $tablename where System_ID = $id";
  $conn->query($sql);
  echo $sql;
}


$conn->close();
?>