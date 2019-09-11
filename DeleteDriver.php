<?php
// Start the session
session_start();
?>
<?php include("connect.php");
 
//Get Driver ID of the selected driver and set this id as a variable
$id = intval($_GET['DR_ID']); 
 
//MySQL statement to delete that driver profile from the database
//Return the result instantly to the display table
$sql = "DELETE FROM Driver WHERE DR_ID=$id";
if($conn->query($sql)===TRUE)
{
    echo "Record updated successfully; ";
    header("location:DisplayDriver.php");
}
else
{
    echo "Error updating record: ".$conn->error;
}
