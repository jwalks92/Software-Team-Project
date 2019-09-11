<?php include ("connect.php");
session_start();
error_reporting(0);
?>
<!DOCTYPE html>

<html>
    <head>
        <!--takes the following form information from inout tags, username and password and passes the information to the same page
where PHP uses POST methods later down the page.-->
        <meta charset="utf-8">
    <title> Software Development Login Page</title>
        
        <link rel = "stylesheet" type = "text/css" href = "css/login.css"/>
    </head>
    <body>
    <div class="containerBox">
        <img src="img/logo.jpg" class="user">
        <h2> Log In Here </h2>
        <form method = "POST" action="mainPage.php">
            <p> Username</p>
            <input type="text" name = "username" required = "required" placeholder="Enter Username">
            <p> Password</p>
            <input type="password" name = "password" required = "required"
            placeholder = "Enter Password">
            <input type = "submit" name = "" value = "Login">

            <a href ="#">Forgot Password?</a>
        </form>
	</div>
   
<?php
		// the password and username are set they are provided the assigned to unique variables. 
    
	if (isset($_POST["username"])){
		if(isset($_POST["password"])){
			$uname = $_POST ['username'];
		
			$pword = $_POST ['password'];
			
		}
	}
	
// parsed through the connection $conn through safeparse functionality, designed to stop SQL injection. 
	$uname = safeParse($conn,$_POST ['username']);
	$pword = safeParse($conn,$_POST ['password']);
	
	function safeParse($conn, $input)
	{
		$input = htmlspecialchars($input);
		$input = $conn->real_escape_string($input);
		
		return $input;
	}
	
   // if empty the variables are echoed as nothing.    
        
	if(empty($uname)){echo " ";}
	if(empty($pword)){echo " ";}
		    
	$workPlace="select Workplace from Staff where ID='".$uname."'";	  
	$resultW=$conn->query($workPlace);
	
	if($resultW->num_rows>0)
	{
		while($rowW=$resultW->fetch_assoc()){
			$workType=$rowW['Workplace'];
		}
	}
	// sql to search through database and check for id and password. 	
	
  $sql="SELECT ID, Password FROM Staff WHERE ID = '$uname'AND Password ='$pword' ";
  $resultS = $conn->query($sql);
  
  
  if($resultS->num_rows>0)
  {  
	$row=mysqli_fetch_array($resultS);
  
  // if id and password chosen by the user are the same as the password in the database. 
  
	if($row['ID']==$uname&&$row['Password']==$pword){
		$_SESSION['username']=$uname;
	  
	 // each if worker type  equal to either restaurant or worker, take them to the following pages.
		if($workType=='R'){
			header("location:menu.php");
		}
	
		else if($workType=='W'){
			header("location:Homepage.html");
		}
		
		echo "Login Successful";
		exit();
	}
	 else {
		echo "Incorrect Password";
		exit();
	 }
  }
?>	

	</body>
    </html>
