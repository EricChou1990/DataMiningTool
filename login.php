<!DOCTYPE html>
<html>
	<head>
		
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
   
   
    
    
    <!--主要写的css代码-->
    <link href="css/login.css" rel="stylesheet" type="text/css" />
   <!--主要写的js代码-->
    
	<link rel="stylesheet"    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
    <script type="text/javascript" src="js/main.js" ></script>
		<title></title>
	</head>
	<body >
		
		<div class="container" >
			<div class="row">
				<div class=" col-lg-12 " style="padding: 40px;">
    			<h1>Greeting! Please type your credentials to enter to the system</h1>
				</div>
			</div>
				
			<div class="row">
				<h4 id="wrongUsernameAlert" style="color: red;" class="col-lg-11 col-lg-offset-4"></h4>
				<form role="form" action="index.php" method="post">
			 			<div class="form-group">
			    			<label class="col-lg-12 col-lg-offset-5" for="username">Username</label>
			    			<div class="col-lg-3 col-lg-offset-4" >
			    				<input type="text" class="form-control"  placeholder="Username" id="username" name="username">
			    			</div>
			    			<label for="pwd" class="col-lg-12 col-lg-offset-5">Password</label>
			    			<div class="col-lg-3 col-lg-offset-4">
			    				<input type="password" class="form-control" placeholder="Password" id="password">
			    			</div>
			    			<div class="col-lg-10 col-lg-offset-5" style="margin-top: 20px;">
			    				<button type="submit" class="btn btn-default" onclick="return checkUser()" style="background-color: royalblue;color: white;">Sign In</button>
			    			</div>
			    			
			  			</div>
		  				
		 		</form>
			</div>
			
			
		</div>
			
			
			
			
			
					
			
		
		
		
		
		
	</body>
	
	
</html>
