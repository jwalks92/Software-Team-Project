<?php
// Start the session
session_start();
//The style of the table is from https://codepen.io/mlms13/pen/CGgLF
?>
<html>
<head>
    <meta charset="utf-8">
    <title>CLUK Warehouse Staff</title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    
    <!––style of the table and the add button––>
    <style>
    table {
            border-collapse: separate;
            border-spacing: 0;
            min-width: 350px;
            background: white;
        }
        table tr th,table tr td {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
            padding: 12px;
        }
        table tr th:first-child,table tr td:first-child {
            border-left: 1px solid black;
        }
        table tr th {
            background: white;
            border-top: 1px solid black;
            text-align: left;
        }
        table tr:first-child th:first-child {
            border-top-left-radius: 6px;
        }
        table tr:first-child th:last-child {
            border-top-right-radius: 6px;
        }
        table tr:last-child td:first-child {
            border-bottom-left-radius: 6px;
        }
        table tr:last-child td:last-child {
            border-bottom-right-radius: 6px;
        }
        .add__button{
 
            margin-bottom: 0.5em;
            padding: 0.5em 1em;
            border-radius: 0.2em 0.2em 0.2em 0.2em;
            text-align: center;
            text-decoration: none;
            background-color: rgb(119, 119, 119);
            background-image: var(--button-grad);
            box-shadow: 0 0.2em 2em 0 var(--shadow);
            color: white;
            display: inline-block;
        }
        .add__button:hover, .add__button:active{
            background-color: rgb(66, 66, 66);
        }
    </style>
</head>
<body>
	
<!––Add navigation bar––>	
<?php
	include 'ManageNavBar.php';
?>
	
<main>
	<h1>Warehouse Staff Records</h1>

	<div class="display__table">
	<?php include("connect.php");
            
		//Set a global variable into a local variable
        	$getUser = $_SESSION['getUser'];
		//A MySql statement to get user's position and workplace to limit user's access 
		$selectUserPosition = "SELECT Position, Workplace FROM Staff WHERE ID = '$getUser'";
			
		$resultUserPosition = $conn->query($selectUserPosition);
		if ($resultUserPosition->num_rows > 0) 
		{
			while($row = $resultUserPosition->fetch_assoc()) 
			{
				$UserPosition = $row['Position'];
				$UserWorkplace = $row['Workplace'];
				$_SESSION['UserPosition'] = $UserPosition;
				$_SESSION['UserWorkplace'] = $UserWorkplace;
				//echo $UserPosition;
				//echo $UserWorkplace;
			}
		}
		else 
    		{
        		echo "";              
    		}
		
		//If user is a manager of warehouse, user will see a table of staff with add, update and delete features	
		if($_SESSION['UserPosition']=='manager' && $_SESSION['UserWorkplace']=='W')
		{
    			$sql = "SELECT ID, Name, Position, Telephone FROM csc8005_team03.Staff WHERE Workplace = 'W' AND BranchID = '1'";
    			$result = $conn->query($sql);
	    		if ($result->num_rows > 0) 
	    		{
				echo "<a href='addNewWarehouseStaff.php' class='add__button'>Add New Staff</a>";
				echo "<table><tr><th>ID</th><th>Name</th><th>Position</th><th>Telephone</th>
				<th>Delete</th><th>Update</th></tr>";

				while($row = $result->fetch_assoc()) 
				{   
					$id = $row["ID"];
					$name = $row['Name'];
					$position = $row['Position'];
					$tel = $row['Telephone'];           
					echo "<tr><td>$id</td><td>$name</td><td>$position</td><td>$tel</td>
					<td><a href='DeleteWareStaff.php?ID=$id'>Delete</td><td><a href='UpdateWareStaff.php?ID=$id'>Update</td></tr>";
				}
        			echo "</table>";
        		}
        		else 
        		{
            			echo "0 result";              
        		}
		} 
		//If user is not a manager of the selected restaurant, user will only see a table of staff
		else 
		{
			$sql = "SELECT ID, Name, Position, Telephone FROM csc8005_team03.Staff WHERE Workplace = 'W' AND BranchID = '1'";
    			$result = $conn->query($sql);
    			if ($result->num_rows > 0) 
    			{
        			echo "<table><tr><th>ID</th><th>Name</th><th>Position</th><th>Telephone</th></tr>";
         
        			while($row = $result->fetch_assoc()) 
        			{   
					$id = $row["ID"];
					$name = $row['Name'];
					$position = $row['Position'];
					$tel = $row['Telephone'];           
					echo "<tr><td>$id</td><td>$name</td><td>$position</td><td>$tel</td></tr>";
				}
        			echo "</table>";
        		}
        		else 
        		{
        			echo "0 result";              
        		}
		}
        ?>
        </div>
</main>
</body>
</html>
