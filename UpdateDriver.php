<?php
// Start the session
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>CLUK Stock Management</title>
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
        <h2>Manage Driver</h2>

        <?php include("connect.php");

            if(!empty($_GET['DR_ID']))
            {
                //Get Driver ID of the selected driver and set this id as a variable
                $getid = $_GET['DR_ID'];
                
                //MySQL statement to select that driver profile from the database
                $selectid = "SELECT * FROM Driver WHERE DR_ID='$getid'";
                $result = $conn->query($selectid);

                while ($row = $result->fetch_assoc()) 
                {
                    $id = $row["DR_ID"];              
                    $name = $row['DR_Name'];
                    $tel = $row['DR_Tel'];             
                }
            }
        ?>
	
        <div class = "content__form">
            <h1>Updating Driver Profile</h1>
            
            <!––A new form with existed information that user can update before posting into the database––>
            <form method="post" action="UpdateDriverServer.php">
                ID: <em> *You cannot change driver ID</em><br>
                <input type = "text" name="ID" readonly value = "<?php echo $id?>"><br><br>
                Full Name:<br>
		<!––This field is required and limit to only 50 characters––>
                <input required maxlength="50" type = "text" name="name" value = "<?php echo $name?>"><br><br>
                Telephone:<br>
		<!––Limit the length of the characters in this field––>
                <input maxlength="15" type = "text" name="telephone" value = "<?php echo $tel?>"><br><br>
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
