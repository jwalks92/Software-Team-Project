<?php
// Start the session
session_start();
include("connect.php");
//The style of the table is from https://codepen.io/mlms13/pen/CGgLF
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> CLUK Staff Management </title>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
    <script src="JavaScript.js"></script>
	
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
	    
        <h2>Restaurant Staff Records</h2>
           
<?php 
	    
	//Set a global variable into a local variable    
	$getUser = $_SESSION['getUser'];
	
	//A MySql statement to get user's position and workplace to limit user's access    
	$selectUserBranch = "SELECT BranchID, Position, Workplace FROM Staff WHERE ID='$getUser'";
	$resultUserBranch = $conn->query($selectUserBranch);
	
	if ($resultUserBranch->num_rows > 0) 
	{
		while($row = $resultUserBranch->fetch_assoc()) 
        	{
			$UserBranch = $row['BranchID'];
			$UserPosition = $row['Position'];
			$UserWorkplace = $row['Workplace'];
			$_SESSION['UserBranch'] = $UserBranch;
			$_SESSION['UserPosition'] = $UserPosition;
			$_SESSION['UserWorkplace'] = $UserWorkplace;
			//echo "This first part works";
			//echo $_SESSION['UserBranch'];
			//echo $_SESSION['UserPosition'];
			//echo $_SESSION['UserWorkplace'];
		}
	}
	else 
    	{
        	echo "";
    	}
	
	//Make sure that after adding new staff or updating staff profile, 
	//it will link back to this display page without having to select the branch again
	if(isset($_POST['BranchID']))
	{
		//Get the user's choice of branch from the previous page
		$_SESSION['BID'] = filter_input(INPUT_POST, 'BranchID');
		//Set a global variable into a local variable 
		$BID = $_SESSION['BID'];
	} 
	else 
	{
		$BID = $_SESSION['BID'];
	}
	    
	//If user is a manager of the selected restuarant, user will see a table of staff with add, update and delete features    
	if($_SESSION['UserPosition']=='manager' && $_SESSION['UserBranch']==$BID && $_SESSION['UserWorkplace']=='R')
	{
		
		$sql = "SELECT ID, Name, Position, BranchID, Telephone FROM Staff WHERE Workplace = 'R' AND BranchID='$BID'";
		$result = $conn->query($sql);  
    
		if ($result->num_rows > 0) 
		{
                	echo "<a href='addNewResStaff.php' class='add__button'>Add New Staff</a>";
                	echo "<table><tr><th>ID</th><th>Name</th><th>Position</th><th>Branch</th><th>Telephone</th>
        		      <th>Delete</th><th>Update</th></tr>";
         
			while($row = $result->fetch_assoc()) 
			{   
				$id = $row["ID"];
				$name = $row['Name'];
				$tel = $row['Telephone'];
				$position = $row['Position'];
				$branch = $row['BranchID']; 
				
				//Display branch name instead of branch id
				$whereRes = "SELECT Res_Branch_Name FROM Restaurant WHERE '$branch' = Res_ID;";      
				$resultResName=$conn->query($whereRes);
                        	
				if($resultResName->num_rows>0)
				{
					while($row1=$resultResName->fetch_assoc())
					{
                            			$branchName = $row1['Res_Branch_Name'];
					}
				}   
			echo "<tr><td>$id</td><td>$name</td><td>$position</td><td>$branchName</td><td>$tel</td>
			<td><a href='DeleteResStaff.php?ID=$id'>Delete</td><td><a href='UpdateResStaff.php?ID=$id'>Update</td></tr>";
			}
			echo "</table>";
		} 
		else 
		{
            		echo "if 0 results";              
		}
	}
	//If user is not a manager of the selected restaurant, user will only see a table of staff
	else 
	{
		$sql = "SELECT ID, Name, Position, BranchID, Telephone FROM Staff WHERE Workplace = 'R' AND BranchID='$BID'";
		$result = $conn->query($sql);  

	    	if ($result->num_rows > 0) 
	    	{
	       		echo "<table><tr><th>ID</th><th>Name</th><th>Position</th><th>Branch</th><th>Telephone</th></tr>";

			while($row = $result->fetch_assoc()) 
			{   
				$id = $row["ID"];
				$name = $row['Name'];
				$tel = $row['Telephone'];
				$position = $row['Position'];
				$branch = $row['BranchID']; 
				$whereRes = "SELECT Res_Branch_Name FROM Restaurant WHERE '$branch' = Res_ID;";      
				$resultResName=$conn->query($whereRes);
				if($resultResName->num_rows>0)
				{
					while($row1=$resultResName->fetch_assoc())
					{
					 	$branchName = $row1['Res_Branch_Name'];
					}
			    	}
				echo "<tr><td>$id</td><td>$name</td><td>$position</td><td>$branchName</td><td>$tel</td></tr>";
			}
			echo "</table>";
		}
        	else 
        	{
            		echo "else 0 results";              
        	}
	
    	}
?>
</main>
</body>
</html>
