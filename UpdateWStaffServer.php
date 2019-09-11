<?php
// Start the session
session_start();
?>
<?php include("connect.php");
 
    //Get warehouse staff new information from the update form and set these as the variables
    $updateId = $_POST['ID'];
    $updateName = filter_input(INPUT_POST, 'name');
    $updateTel = filter_input(INPUT_POST, 'telephone');
    $updatePosi = filter_input(INPUT_POST, 'position');

    //MySQL statement to update that warehouse staff profile in the database
    $update = "UPDATE Staff SET Name='$updateName', Position='$updatePosi', Telephone='$updateTel' WHERE ID='$updateId';";
    
	
	if ($conn->query($update) === TRUE) {
		echo "The data has been changed!";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	//Return back to the display table page
	header("Location:DisplayWareStaff.php");
?>
