<?php
// Start the session
session_start();
?>
<?php include("connect.php");

    //Get driver new information from the update form and set these as the variables
    $updateId = filter_input(INPUT_POST, 'ID');
    $updateName = filter_input(INPUT_POST, 'name');
    $updateTel = filter_input(INPUT_POST, 'telephone');
    
    //MySQL statement to update that driver profile in the database
    $update = "UPDATE Driver SET DR_Name='$updateName', DR_Tel='$updateTel' WHERE DR_ID='$updateId';";
    
	
	if ($conn->query($update) === TRUE) {
		echo "The data has been changed!";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
    //Return back to the display table page
    header("Location:DisplayDriver.php?");
?>
