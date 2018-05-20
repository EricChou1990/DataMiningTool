<?php
include 'db_connector.php';
$name;
$age; 	


// 返回JSON格式  
header('Content-Type:application/json;charset=utf-8');  
$result = array();  
$conn = (new DatabaseConnector())->connectDatabase("127.0.0.1","root","Zyh812625","data_analysis");
  
// 获得原始输入内容  
$json = file_get_contents("php://input");  
//var_dump($input_str);  
  
// JSON转换为PHP对象  
$obj = json_decode($json);  
  
$msg = $obj->msg;
$id;
$name;
$age;


if($msg == "modify")
{
	$id = $obj->id; 
	
 	$sql = "SELECT name FROM test1 where id = '$id'";
        $result = $conn->query($sql);
        if( $result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $name = $row['name'];
               // echo $name;
            }
        }

	$sql = "SELECT age FROM test1 where id = '$id'";
        $result = $conn->query($sql);
        if( $result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $age = $row['age'];
            //    echo $age;
            }
        }
  
$json='{"id":1,"name":"'.$name.'","age":"'.$age.'"}';
echo json_encode($json);  
 
}

if($msg == "update")
{
	$id = $obj->id; 
	$name = $obj->name;
	$age = $obj->age;
 	
	 $stmt = $conn->prepare("UPDATE test1 SET name = ?, age = ? WHERE id = ?");
   $stmt->bind_param("ssi",$name,$age,$id);
   $stmt->execute();	
	echo "update finished";
}

if($msg == "add")
{
	$name = $obj->name;
	$age = $obj->age;	
	$sql = "insert test1(name, age) values ('$name', '$age')";
  $conn->query($sql);
  
  echo "add finished";
}

if($msg == "delete")
{
	$id = $obj->id; 
	$sql = "delete from test1 where id = '$id'";
  $conn->query($sql);
  echo "delete finished";
}

?>