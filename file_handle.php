<?php
include 'db_connector.php';

Session_start();

	
ini_set('max_execution_time', 300);	 
function getCSVdata($filename)  
{  
    $row = 1;//第一行开始  
    if(($handle = fopen($filename, "r")) !== false)   
    {  
        while(($dataSrc = fgetcsv($handle)) !== false)   
        {  
            $num = count($dataSrc);  
            for ($c=0; $c < $num; $c++)//列 column   
            {  
                if($row === 1)//第一行作为字段   
                {  
                    $dataName[] = $dataSrc[$c];//字段名称  
                    
                }  
                else  
                {  // www.# 
                    foreach ($dataName as $k=>$v)  
                    {  
                        if($k == $c)//对应的字段  
                        {  
                            $data[$v] = $dataSrc[$c];  
                        }  
                    }  
                }  
            }  
            if(!empty($data))  
            {  
                 $dataRtn[] = $data;  
                 unset($data);  
            }  
            $row++;  
        }  
        fclose($handle);  
        return $dataRtn;  
    }  
}  




//header('Content-Type:text/html;charset=utf-8');  
error_reporting(E_ALL & ~ (E_STRICT | E_NOTICE | E_WARNING));

// 获取文件资源
$file  = $_FILES['file'];

$file_name = $file['tmp_name'];  //用于打开文件
$file_realname = $_FILES["file"]["name"];
//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
$file_realname = str_replace('.csv','',$file_realname);  //去掉.csv后缀
//echo $file_realname;  //用文件名来创建数据表
$_SESSION['CSVfilename'] = $file_realname ;  //通过session传给前端 用来打开数据表

if($file_name == '')
{
    die("请选择要上传的csv文件");
}



$aData = getCSVdata($file_name);  
$count_ColumnNumber = count(array_keys($aData[0]));  //在读完文件后 先获取CSV文件里有多少列数据 用于回传给网页   $aData[0]表示csv文件中的第一行数据
$count_ColumnNumber++;         //获得有多少column后 自加一  因为还要算上人为加上的System_Id这一栏

echo "diyihang de shuju";
		print_r($aData[0]);
//CESHI


//CESHI


//sql part
$conn = (new DatabaseConnector())->connectDatabase("127.0.0.1","root","Zyh812625","data_analysis");

$column_name =  array_keys($aData[0]);  //从csv文件中获得column name的集合
$count = count($column_name);
 //   echo $count;
  //  echo  $column_name[34];
//    echo  $column_name[0];
//    echo  $column_name[1];
 //   echo  $column_name[2];
 //   echo  $column_name[3];
 //   echo  $column_name[4];
 
 	$result = $conn->query("SHOW TABLES LIKE '". $file_realname."'");
	$rowtest = $result->fetch_all();
	
	if('1' == count($rowtest))
	{
	    echo "Table exists";
	} 
	else 
	{
	    echo "Table does not exist";
	    
	    
	    $sql = "CREATE TABLE IF NOT EXISTS $file_realname (System_ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";     //为所有table添加System_ID为primary key 便于增删改查
		for($i=0;$i<$count;$i++)
			{
				if($i == $count-1)
				{
					$sql .= "$column_name[$i] VARCHAR(80))";
				}
				else
				{
					$sql .= "$column_name[$i] VARCHAR(80),";
				}
			}
	
	echo $sql;
	
	
	//$sql .= "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
	//$sql .= "reg_date TIMESTAMP)";
	
	
   
	    $sql123 = "CREATE TABLE IF NOT EXISTS $file_realname (
		id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
		firstname VARCHAR(30) NOT NULL,
		lastname VARCHAR(30) NOT NULL,
		email VARCHAR(50),
		reg_date TIMESTAMP
		)";
	
		if (mysqli_query($conn, $sql)) {
	    echo "数据表 MyGuests 创建成功";
	    echo "<br />";
		} 
		else 
		{
	    echo "创建数据表错误: " . mysqli_error($conn);
		}
		

//创建完数据表 开始往插入数据

		$count_dataRow = count($aData);  //获取CSV文件里有多少行数据
		echo "diyihang de shuju";
		print_r($aData[0]);
		echo "<br />";

		for($n=0;$n<$count_dataRow;$n++)
		{
			unset($strK);
			unset($strV);
			//$Keytmp[] =array();
			//$Valuetmp[] =array();
			while(list($k,$v) = each($aData[$n]))
			{ 
				echo $k.'=>'.$v.'<br />'; 
				//$k = $k + " int";
				
				// $Keytmp[] = '`'.$k.'`';  //将字段作为一个数组；  
	     		// $Valuetmp[] = '"'.$v.'"';  //将插入的值作为一个数组；
	     		$Keytmp[] = $k;  //将字段作为一个数组；  
	     		 $Valuetmp[] = '"'.$v.'"';  //将插入的值作为一个数组；      
	     		 $strK=implode(',',$Keytmp);     
	   			 $strV=implode(",",$Valuetmp);   
	//  			 echo $strK;
	 //  			 echo "<br />";
	//			echo $strV;
	//			echo "<br />";
				
				
			} 
			$sql = "insert into $file_realname ($strK) values ($strV)";  
			echo $sql;
			echo "<br />";
			mysqli_query($conn, $sql);
	//		echo "andasdsad:";
			unset($strK);
			unset($strV);
			unset($k);
			unset($v);
			unset($Keytmp);
			unset($Valuetmp);
	//		 echo "<br />";
			
		}

	
	    
	}  //创建数据表操作到此结束
	






//此部分代码  获取csv文件的所有column name  回传给网页


 $key_index =  array_keys($aData[0]);  //从csv文件中获得column name的集合
//   echo count($key_index);
//echo  $key_index[4];//获取到每个column name  用在创建table
//print_r($key_index);
echo json_encode($key_index);  // 将所有的column name组装 回传给网页


	 	

//echo $count_ColumnNumber;  //将csv文件中有多少行  回传给网页 用于定位table中的System_Id的位置




$conn->close();
?>