<?php
include 'db_connector.php';

Session_start();
$_SESSION['username'] = "Guest";
$id = array();
$name = array();
$age = array();

$tablename = $_SESSION['CSVfilename'];        

if($tablename == "")
{
//	echo "empty";
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
    

 
//$sql = "SHOW COLUMNS FROM test1";    
$res = $conn->query($sql); 
    
         $row = $res->fetch_assoc(); 
        foreach ($row as $k=>$v) 
        {
        	$tmpData[] = $k;
        	//echo $k;
        } 
   //     echo count($tmpData);       
         $columnCount = count($tmpData);
   
     
     
     $res = $conn->query($sql);      
   
   
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <script src="js/jquery-3.3.1.js"></script>
   
    
    <script src="js/jquery.json.min.js"></script>
    <script type="text/javascript" src="js/main.js" ></script>
   

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
<script type="text/javascript">
	
// ==========================================================================================
// @Description:    Redirect to a page after waiting a specified number of milliseconds
// @Author:         Eric Zhou
// ========================================================================================== 
  
function delayURL(url,time)
{
  	setTimeout("top.location.href = '" + url + "'",time);
}

// ==========================================================================================
// @Description:    Load csv file and create a table in database to store its value
// @Author:         Eric Zhou
// ========================================================================================== 
function fileLoad()
{
	
	
	  var formData = new FormData($( "#uploadForm" )[0]);  
	$.ajax({ 
		
        type: "post",  
        url: 'file_handle.php',  
         async: false,  
          cache: false,  
          contentType: false,  
          processData: false, 
        data: formData,  
        
        
        success: function(data) {  
           
         data = data.replace(/\"/g, "");
         data = data.replace("[","");
         data = data.replace("]","");
         var tmp = data.split(",");
        // alert(tmp[0]);
        // alert(tmp[1]);
         //alert(tmp[2]);
         //alert(tmp.length);
         tmpFirstRow = tmp[1];
       
         
        }  
    });  
	location.reload();	
	 
	 
}


selectedRow = 1;
selectedID = 1;

// ==========================================================================================
// @Description:    Make data case viewer clickable and record which row is clicked by user
// @Author:         Eric Zhou
// ========================================================================================== 	
$(document).ready(function(){ 
	
	
    $("#table1 > tbody > tr").click(function(){
    var columnCount = document.getElementById("getColumnNumber").value;  
    selectedRow = this.rowIndex ;
    selectedRow = (selectedRow-1)*columnCount;
    var res =document.getElementsByTagName("td");         
     selectedID=res[selectedRow].innerHTML;
    // alert(selectedID);
    var warningText = "SystemID :" + selectedID;
    document.getElementById("deleteWarning").innerHTML = warningText;
    
    
    
        }); 
          
});

// ==========================================================================================
// @Description:    Update value which user inputs in the pop-up window to database via Ajax
// @Author:         Eric Zhou
// ==========================================================================================    
function updateDeleteResult()
   {
   	$.ajax({  
        type: "post",  
        url: 'tableDelete.php',  
        async: true, 
        data: JSON.stringify({                    
            msg: "delete",
            id:selectedID
        }),  
        contentType: "application/json; charset=utf-8",  
        dataType: "text",  
        success: function(data) {  
        	//   alert(data);
        
        } 
    });  
    delayURL('data.php',500);
   }
   


// ==========================================================================================
// @Description:    Insert new data into database via Ajax
// @Author:         Eric Zhou
// ========================================================================================== 
function updateAddResult()
{
	var addValue = "addValue";
	var addColumn = "addColumn";
	var columnCount = document.getElementById("getColumnNumber").value;          
	for(var count = 1; count < columnCount; count++)                             
	{
		var tmpIdC = addColumn+count;
		var resultColumn = document.getElementById(tmpIdC).value;              
		var tmpIdV = addValue+count;
		var resultValue = document.getElementById(tmpIdV).value;                
		
		//alert(resultColumn);
		//alert(resultValue);
		if(count == 1)
		{
			var jsont = {[resultColumn]:[resultValue]};                     
			
			
		}
		else
		{
			var jsonNew = {[resultColumn]:[resultValue]};
			addGroupJson(jsont, jsonNew);                                  
			
		}
		

	}

	 var encoded = JSON.stringify(jsont);  
     var jsonStr = encoded;  
   // alert(jsonStr);
	$.ajax({  
        type: "post",  
        url: 'tableAdd.php',  
        async: true,  
        data:jsonStr,  
        contentType: "application/json; charset=utf-8",  
        dataType: "text",  
        success: function(data) 
        	{  
	      //  alert("get value");   
	    //    alert(data);
        	} 
  		});  
	 delayURL('data.php',500);
}

// ==========================================================================================
// @Description:    Modify current data and update it to database via Ajax         
// @Author:         Eric Zhou
// ========================================================================================== 
function updateModifyResult()
   {
   		var SystemID = document.getElementById("modifySystemID").value;
   		
   		var ColumnName = document.getElementById("modifyColumnName").value;
   		
   		var Value = document.getElementById("modifyValue").value;
   		
   		$.ajax({  
        type: "post",  
        url: 'tableModify.php',  
        async: true,  
        data: JSON.stringify({                    
            msg: "update",
            id:SystemID,
            columnname:ColumnName,
            value:Value
        }),  
        contentType: "application/json; charset=utf-8",  
        dataType: "text",  
        success: function(data) {  
           
        alert(data);
 			  
        } 
    });  
    
     delayURL('data.php',500);
   }

// ==========================================================================================
// @Description:    Add json arrays to one
// @Author:         Eric Zhou
// ========================================================================================== 
function addGroupJson(targetJson, packJson)
{

    if(targetJson && packJson){

       for(var p in packJson){

           targetJson[p] = packJson[p];

       }

    }

}
   
function clickDropdownMenu()
{
	
	
	$("#dropselect").click();
}
  
   
</script>

<body style="font-family:helvetica,'arial, helvetica, sans-serif';"  onload="clickDropdownMenu();">

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
                <a href="#" onclick="mydataClick()" ><i class="fa fa-folder-open"></i>    My Data</a> 
                
                
                <!-- /.dropdown -->
                <li class="dropdown">
                	 
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
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

        <div id="page-wrapper" >
        	<br />
        	<br />
        	<br />
            <div class="row">
                <div class="col-lg-12">
                	<div class="panel panel-default">
                	<div class="panel-heading ">
                		<h4>Upload file here:</h4>
                		<form  id= "uploadForm" class="col-lg-12 page-header row">  
     							<div class="col-lg-2">
     								<input type="file"  name="file" id="file" accept="text/csv" />
     							</div>
      							
						</form> 
                	</div>
                	<div class="panel-body ">
                		<div class="container-fluid">
                			<div class="row">
                				<div class="col-lg-1 "  style="min-width: 130px;">
	                				<input type="button" class="btn btn-default "  name="submit" value="Load File"  onclick="fileLoad()" style="margin-left: 10px; border-radius: 5px;width: auto;"/>  
			                	</div>
			                	<div class="col-lg-7"  >
			                		<h5>Please load .csv file only</h5>		
			                	</div> 
                			</div>
                		</div>
                	</div>
                	
                	
                </div>
                </div>
    						
                
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                            	<div class="col-lg-3" ><h4>Data Case Viewer</h4></div>
                            	
                            	<div class="col-lg-9"  >
                            			<div class="btn-toolbar" style="float: right;">
                            				<div class="btn-group">
                            					<button class="btn btn-outline btn-success " data-toggle="modal" data-target="#addmodal" style="border-radius: 5px;margin-right: 4px;" onclick="removeShadow()">Add</button>
    											<button class="btn btn-outline btn-danger " data-toggle="modal" data-target="#deletemodal" style="border-radius: 5px;margin-right: 4px;">Delete</button>
    											<button class="btn btn-outline btn-info " data-toggle="modal" data-target="#modifymodal" style="border-radius: 5px;">Modify</button> 
                            				</div>
                            			</div>
                            	</div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="table1" style="word-break: keep-all;">
                                <thead>
                                    <tr>
								      	<?php 
				    					   for($i = 0; $i < count($tmpData); $i++) {       
				        		         ?>
								        <th><?php echo $tmpData[$i]; ?></th>
								        <?php  		
				        					}
				    					 ?>
				        			</tr>
                                </thead>
                                <tbody>
                                    <?php 
    					  				for($i = 0; $i < $rowCount; $i++) {               
				        		         ?>
				 						<tr >
				        						
				        						<?php 
				    					   		$row=$res->fetch_assoc()  
				        		         		?>
				        						
				        						
				        							<?php 
				        							foreach ($row as $value)                    
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
                            <!-- /.table-responsive -->
                            
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="panel panel-default">
            	<div class="panel-heading">
            		<h4>Data Preprocessing</h4>
            	</div>
            	<div class="panel-body row" >
            		<div class="col-lg-12">
            			<div class="col-lg-2">
            				<button class="btn btn-warning " style="border-radius: 5px;" onclick="missingDataHandle()">Missing Data Handling</button>   
            			</div>        			
            		</div>
            		
            	</div>
            	
            </div>
            <div class="row" style="height: 190px;">
            	<div class="col-lg-12">
            			<div class="col-lg-8">
            				
            			</div>
            			
						<div class="col-lg-4" >
							<div style="float: right;">
								<button class="btn btn-success  " type="button" id="dropdownMenu1"  style="float: right;border: none;" onclick="if(test1.size==1){test1.size=test1.length} else{test1.size=1}">
							    Model</button>
								
								
								
                                <div style="float: right;">
                                	<select class="form-control"  size="1" name="D1" id="test1" onchange="JJModel()">
	                                <option> <a href="javascript:void(0);" onclick="#">Options..</a></option>
	                                <option>J48</option>
	                                <option>NB</option>
	                                <option>NN</option>
	                                <option>K-NN</option>                     
                                </select>
                                </div>
                            </div>
			                
						</div>
						
            	</div>
            </div>
            
            
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		<!-- 模态框（Modal One） -->
				<div class="modal fade" id="addmodal" tabindex="-1" role="dialog"  >
							
					
					
					<div class="modal-dialog" style="width: 830px;overflow-x:scroll;background-color:white;" >
						
							
							<div  style="border-width: 0px!important;">
								<table class="table" id="tableModifyFucntion">
    				
							    <thead>
							     <tr >
							      	<?php 
			    					   for($i = 1; $i < count($tmpData); $i++) {       
			        		         ?>
							        <th ><input  style="margin-left: 6px; height: 50px;line-height: 50px; border:1px;border-bottom-style:none;border-top-style:none;border-left-style:none;border-right-style:none;" readonly="readonly" id="<?php echo "addColumn"; ?><?php echo $i; ?>"  value="<?php echo $tmpData[$i]; ?>"/></th>
							        <?php  		                                                                
			        					}
			    					 ?>
						        </tr>
							    </thead>
							    <tbody>
			 							<tr>
			 								<?php 
			    					  		 for($i = 1; $i < count($tmpData); $i++) {       
			        		         		?>
			        						<td> <input style="height: 35px;line-height: 35px;" id="<?php echo "addValue"; ?><?php echo $i; ?>" type="text"  />  </td>          
			        						<?php  		                                                                          
			        						}
			    							 ?>
			    						</tr>    		         		    
							    </tbody>
								</table>
							
							</div>
						
						<div style="height: 64px; float: left;" >
							<div style="margin-left: 10px;">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="button" class="btn btn-primary" onclick="updateAddResult()">Confirm</button>
							</div>
						</div>
						
						
					</div><!-- /.modal -->
					
					 -->
				</div>
				
				<!-- 模态框（Modal Two） -->
				<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<div class="modal-body" >
								<p>Do you want to delete this row: </p><p id="deleteWarning">SystemId :1</p>
							</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" onclick="updateDeleteResult()">Confirm	</button>
						</div>
						
						</div><!-- /.modal-content -->
					</div><!-- /.modal -->
				</div>
	<!-- 模态框（Modal）Three -->
				<div class="modal fade" id="modifymodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog" style="width: 800px;">
						<div class="modal-content">
							
							<div class="modal-body">
								<table class="table" id="tableModifyFucntion">
    				
							    <thead>
							      <tr>
							        <th>Column Name</th>
							        <th>System ID</th>
							        <th>Value</th>
							        </tr>
							    </thead>
							    <tbody>
			 							<tr>
			 									   
			        						<td> <input id="modifyColumnName"  type="text"  />  </td>
			        						<td> <input id="modifySystemID" type="text" />  </td>	
			        						<td> <input id="modifyValue"  type="text"  />  </td>
			    				</tr>       		         		    
							    </tbody>
								</table>
							
							</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" onclick="updateModifyResult()">Confirm</button>
						</div>
						
						</div><!-- /.modal-content -->
					</div><!-- /.modal -->
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
    	

    

    	
// ==========================================================================================
// @Description:    Configure table (data case viewer)        
// @Author:         Eric Zhou
// ==========================================================================================    	
$(document).ready(function() {
    $('#table1').DataTable({
        "scrollX": true,
        "ordering": false
             
           
    });
});
    </script>

</body>

</html>
