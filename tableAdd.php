<?php
include 'db_connector.php';

Session_start();
$tablename = $_SESSION['CSVfilename'];        //获得tablename用于数据库操作
$conn = (new DatabaseConnector())->connectDatabase("127.0.0.1","root","Zyh812625","data_analysis");
$sql = "select * from $tablename";
  
// 获得原始输入内容  
$json = file_get_contents("php://input");  
//var_dump($input_str);  
  
// JSON转换为PHP对象  
$obj = json_decode($json,true);  

//$id = $obj->id;
//$sys_id=$obj->sys_id;
//$age =$obj->age;

	foreach($obj as $k=>$val){
		if( is_array($val) ) 
		{
			//echo $k;
			$Keytmp[] = $k;  //将字段作为一个数组；        
	     	$strK=implode(',',$Keytmp);     
	   			 
			foreach( $val as $value)
			{
				//echo $value.'';  
				$Valuetmp[] = '"'.$value.'"';  //将插入的值作为一个数组； 
   				$strV=implode(",",$Valuetmp);  
			} 
		} 
		
	}
   
$sql = "insert into $tablename  ($strK) values ($strV)";  
			echo $sql;
mysqli_query($conn, $sql);
//echo print_r($obj);
$conn->close();
?>