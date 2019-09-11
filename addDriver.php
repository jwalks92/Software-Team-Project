<?php
// Start the session
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Result of Adding New Driver Profile</title>
    
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
            <h1>Result of Adding New Driver Profile</h1>
        </div>


        <?php include("connect.php");
            //Get driver's information from the form and set these as the variables
            $name = filter_input(INPUT_POST, 'name');
            $telephone = filter_input(INPUT_POST, 'telephone');
            if (!empty($name))
            {
                //MySQL statement to insert that driver profile into the database
                $sql = "INSERT INTO csc8005_team03.Driver (DR_Name, DR_Tel) VALUES ('$name', '$telephone');";
                if ($conn->query($sql) === TRUE) 
                {
                    $last_id = $conn->insert_id;
                    echo "<b>New record created successfully</b>" . '<br><br>';
                    
                    //Display the driver profile instantly after the submit
                    echo "Driver ID: " . $last_id . '<br><br>';
                    echo "Driver name: " . $_POST ["name"] . '<br><br>';
                    echo "Telephone: " . $_POST ["telephone"] . '<br><br>';
                    echo "<a href='DisplayDriver.php' class='add__button'>Back to Staff Records</a>";
                 } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            else
            {
                echo "Name cannot be empty";
                die();
            }
        ?>
    </main>
</body>
</html>
