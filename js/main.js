function mydataClick(){
	alert("No previous data");
}

function removeShadow(){
	
	
}

function missingDataHandle(){
	alert("No missing data");
}

function JJModel()
{
		window.location.href='model.php';	
			
			
}   

function checkUser()
		{
			
			if(document.getElementById("username").value == "eric" && document.getElementById("password").value=="123"){
				
				document.getElementById("wrongUsernameAlert").innerHTML = "";
				
				return true;
			}
			else
			{
				document.getElementById("wrongUsernameAlert").innerHTML = "Username or password is incorrect!!";
				
				return false;
			}
		
			 
		}