<?php
// Start the session
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Result of Adding New Restaurant Staff Profile</title>
    
    <!––style of the add button––>
    <style>
	.add__button{
            margin-bottom: 0.5em;
            padding: 0.5em 1em;
            border-radius: 0.2em 0.2em 0.2em 0.2em;
            text-align: center;
            text-decoration: none;
            background-color: var(--grey);
            background-image: var(--button-grad);
            box-shadow: 0 0.2em 2em 0 var(--shadow);
            color: white;
            display: inline-block;
        }
        .add__button:hover, .add__button:active{
            background-color: rgb(66, 66, 66);
        }
	</style>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
</head>
<body>
    
    <!––Add navigation bar––>
    <?php
    include 'ManageNavBar.php';
    ?>
    
    <main>
        <div class="content">
            <h1>Result of Adding New Restaurant Staff Profile</h1>
        </div>


    <?php
        $name = filter_input(INPUT_POST, 'name');
        $telephone = filter_input(INPUT_POST, 'telephone');
        $selectPosition = filter_input(INPUT_POST, 'position');
        $branch = filter_input(INPUT_POST, 'branchId');
        if (!empty($name))
        {
            $servername = "homepages.cs.ncl.ac.uk";
            $username = "csc8005_team03";
            $password = "Gray(SatBand";
            $dbname = "csc8005_team03";
 
		// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        }
        else
        {
            //Automatically generate ID and password
            function generateNumber($digit = 4)
            {
                $i = 0;
                $number = "";
                while($i < $digit){
                    $number .= mt_rand(0,9);
                    $i++;
                }
                return $number;
            }            
            $loginID = generateNumber();                
            $password = generateNumber();
               
	    //MySQL statement to select that branch name from the database	
	    $whereRes = "SELECT Res_Branch_Name FROM csc8005_team03.Restaurant WHERE '$branch' = Res_ID;";	
			
            //MySQL statement to insert that restaurant staff profile into the Staff table
            $sql = "INSERT INTO csc8005_team03.Staff (ID, Name, Telephone, Position, BranchID, Workplace, Password)
                    VALUES ('$loginID', '$name', '$telephone', '$selectPosition', '$branch', 'R', '$password');"; 
			
            //MySQL statement to insert that restaurant staff profile into the Employ table
			$addToEmploy = "INSERT INTO csc8005_team03.Employ VALUES ('$loginID', '0', '$branch');";
			
	
			$resultResName=$conn->query($whereRes);
		
			
            if ($conn->query($sql) === TRUE) {
                echo "<b>New record created successfully</b>" . '<br><br>';
                
                //Display the restaurant staff profile instantly after the submit
				echo "Staff ID: " . $loginID . '<br><br>';
                echo "Restaurant staff name: " . $_POST ["name"] . '<br><br>';
                echo "Telephone: " . $_POST ["telephone"] . '<br><br>';
                echo "Branch: " ;
					if($resultResName->num_rows>0){
						while($row=$resultResName->fetch_assoc()){
							echo $row['Res_Branch_Name'] . '<br><br>';
						}
					}
				
                echo "Position: " . $_POST ["position"] . '<br><br>';
		echo "<b>This is the log-in information for this person</b>" . '<br><br>';
                
                //Display the automatically generated ID and password for that  staff
		echo "Login ID: " . $loginID . '<br><br>';
                echo "Password: " . $password . '<br><br>';
                echo "<a href='DisplayResStaff.php' class='add__button'>Back to Staff Records</a>";
            } else {
		echo "Oops! It's not you. It's us. Please try adding this profile again.";
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
			
			if ($conn->query($addToEmploy) === TRUE) {
				echo "" . '<br><br>';
			}else{
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
            $conn->close();
        }
    }
    else{
        echo "Name cannot be empty";
        die();
    }
	
?>
    </main>
</body>
</html>
