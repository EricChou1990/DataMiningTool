<?php
include 'db_connector.php';
$model = "sada";

Session_start();
$_SESSION['username'] = "Guest";
$id = array();
$name = array();
$age = array();
//$tmpData = array();
//$_SESSION['CSVfilename'] ="";
$tablename = $_SESSION['CSVfilename'];        //获得tablename用于数据库操作

if($tablename == "")
{
	echo "empty";
	$tablename = "wine";
}


$conn = (new DatabaseConnector())->connectDatabase("127.0.0.1","root","Zyh812625","data_analysis");
$sql = "select * from $tablename";
 
$result = $conn->query($sql);  

$rowCount = 0;  
	while($row=$result->fetch_assoc())                
	{                                  
    	
  	  $rowCount++; 
	}
    
echo $rowCount;  //得到数据表一共多少行

echo "rowcount";
//echo $rowCount;
 
//$sql = "SHOW COLUMNS FROM test1";    
$res = $conn->query($sql); 
    
         $row = $res->fetch_assoc(); //获取第一行数据 把key值提取出来 即可获得column name  后面再次使用$res需要重新赋值
        foreach ($row as $k=>$v) 
        {
        	$tmpData[] = $k;
        	//echo $k;
        } 
        echo count($tmpData);       //获得由几个column 即一共几列  用于后面从数据库取值
         $columnCount = count($tmpData);
        echo $tmpData[0];
        echo $tmpData[1];
        echo $tmpData[2];
        echo "<br/>";
     
     
     $res = $conn->query($sql);      //重置$res 因为刚才第一行已经被读掉了 
?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <script src="js/jquery-3.3.1.js"></script>
   
    
    <script src="js/jquery.json.min.js"></script>
    <script type="text/javascript" src="js/main.js" ></script>
    <link rel="stylesheet" href="css/main.css" />
   

    <!-- Bootstrap Core CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body style="font-family:helvetica,'arial, helvetica, sans-serif';">

    <div id="wrapper" style="min-height: 903px;">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                 <a class="navbar-brand">Web-based Data Mining Tool</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                 <a href="#"  onclick="mydataClick()"><i class="fa fa-folder-open"></i>    My Data</a> 
                
                
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i><?php echo $_SESSION['username']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li><a href="login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse" >
                    <ul class="nav" id="side-menu" >
                        
                        <li>
                            <a href="data.php" style="color: black;"> <img src="img/data.png" style="display: block;width: 15px;height: 15px;float: left;margin-top: 2px;padding-right: 2px;" />Data</a>
                        </li>
                        <li>
                            <a href="model.php" style="color: black;"> <img src="img/model.png" style="display: block;width: 15px;height: 15px;float: left;margin-top: 2px;padding-right: 2px;" />Model</a>
                        </li>
                        
                        <li>
                            <a href="analysis.php" style="color: black;"> <img src="img/analysis.png" style="display: block;width: 15px;height: 15px;float: left;margin-top: 2px;padding-right: 2px;" />Analysis</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        
        <div id="page-wrapper"  style="padding-top: 50px;">
        	
        	<div class="row">
        		<div class="col-lg-10">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					<h4>Decision Tree:</h4>
        				</div>
        				<div class="panel-body">
        					
        					<div style="max-height: 560px;max-width:1200px; margin: 0 auto;" >
        						<img src="img/decisionTree.png"  style=" width: 100%;height: 100%;padding: auto;"/>
        					</div>
        				</div>
        			</div>
        		</div>
        		<div class="col-lg-2">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					<h4>Result:</h4>
        				</div>
        				<div class="panel-body">
        					<div style="max-height: 560px;list-style: none;">
        						
        						
        						
        						<ul style="list-style-type:circle;padding-left: 10px;">
        							<li class="modelResult">
        								Correctly Classified Instances: 164 (92.1348%)	
        							</li>
        							<li class="modelResult">
        								Incorrectly Classified Instances: 14 (7.8652%)	
        							</li>
        							<li class="modelResult">
        								Kappa staticstic: 0.8799	
        							</li>
        							<li class="modelResult">
        								Mean absolute error: 0.0607
        							</li>
        							<li class="modelResult">
        								Root mean squared error: 0.2262
        							</li>
        							<li class="modelResult">
        								Relative absolute error: 13.8153%
        							</li>
        							<li class="modelResult">
        								Root relative squared error: 48.2704%
        							</li>
        							<li class="modelResult">
        								Coverage of cases: 93.2584%
        							</li>
        						</ul>
        						
        						
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	
        	<div class="row">
        		<div class="col-lg-12">
        			<div class="panel panel-default">
        				<div class="panel-heading">
        					<h4>Data Case Viewer</h4>
        				</div>
        				<div class="panel-body">
        					<table width="100%" class="table table-striped table-bordered table-hover" id="table1" style="word-break: keep-all;">
                                <thead>
                                    <tr>
								      	<?php 
				    					   for($i = 0; $i < count($tmpData); $i++) {       /*用for循环来show column name*/
				        		         ?>
								        <th><?php echo $tmpData[$i]; ?></th>
								        <?php  		
				        					}
				    					 ?>
				        			</tr>
                                </thead>
                                <tbody>
                                    <?php 
    					  				for($i = 0; $i < $rowCount; $i++) {               /*用for循环来展示每一行的数据*/
				        		         ?>
				 						<tr >
				        						
				        						<?php 
				    					   		$row=$res->fetch_assoc()  
				        		         		?>
				        						
				        						
				        							<?php 
				        							foreach ($row as $value)                    /*用for each遍历一行数据中的每一个值  展示在td中*/
											    	{
											    	?>
											   			<td style="white-space: nowrap;">
											        	<?php  		
				        								echo $value;
				        								?>
											   			</td>
											  	   <?php  
											  	    }
				        							?>
				        						
				        						
				        						
				        						
				    					</tr>       		         		
				        		         <?php  		
				        					}
				    					 ?>
  
                                </tbody>
                            </table>
                             <input type="hidden" id="getColumnNumber" value="<?php echo count($tmpData); ?>" />	
        				</div>
        			</div>
        		</div>
        	</div>
        	
        	
        </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="https://blackrockdigital.github.io/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#table1').DataTable({
             "scrollX": true,
             "ordering": false
             
           
        });
    });
    </script>

</body>

</html>
