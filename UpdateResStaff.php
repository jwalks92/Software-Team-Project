<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> CLUK Stock Management </title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    <script src="JavaScript.js"></script>
    
	<!––style of the table––>
	<style>
        table, th, td 
        {           
            border: 1px solid black;
            border-collapse: collapse;
            background-color: white;
            color: black;
            padding: 10px;
        }
    </style>
</head>

<body>
	
    <!––Add navigation bar––>
    <?php
       include 'ManageNavBar.php';
    ?>
	
    <main>
        <h2>Manage Restaurant Staff</h2>
         
		<?php include("connect.php");

			if(!empty($_GET['ID']))
			{
				//Get restaurant staff ID of the selected staff and set this id as a variable
				$getid = $_GET['ID'];

				//MySQL statement to select that restaurant staff profile from the database
				$selectid = "SELECT * FROM Staff WHERE ID='$getid'";
				$result = $conn->query($selectid);

				while ($row = $result->fetch_assoc()) 
				{
					$id = $row["ID"];              
					$name = $row['Name'];
					$position = $row['Position'];
					$tel = $row['Telephone'];   
					$branchID = $row['BranchID'];
				}
			}
		?>

		<div class = "content__form">
            
			<h1>Updating Staff Profile</h1>
            
			<!––A new form with existed information that user can update before posting into the database––>
			<form method="post" action="UpdateRStaffServer.php">
				ID: <em> *You cannot change staff ID</em><br>
				<input type = "text" name="ID" readonly value = "<?php echo $id?>"><br><br>
				Full Name:<br>
				<!––This field is required and limit to only 45 characters––>
				<input required type = "text" name="name" maxlength="45" value = "<?php echo $name?>"><br><br>
				Telephone:<br>
				<!––Limit the length of the characters in this field––>
				<input type = "text" name="telephone" maxlength="15" value = "<?php echo $tel?>"><br><br>
				Position: <br>
				<select name = "position" value = "<?php echo $position?>">
				<option value = "manager">Manager</option>
				<option value = "staff">Staff</option>
				</select>
				<br>
				<br>       
				<em>Please check your information carefully before submitting the form</em>
				<br>
				<br>
				<input type = "submit" value = "Submit">
			</form> 
		</div>
	</main>
</body>
</html>
