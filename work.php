<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" /><!--import ManageCSS.css file-->
     <script type="text/javascript" src="Work.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/ManageCSS.css" />
<title> DeliverApprove Page</title>
    
<script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    
    <script>
        
    var firstArray = [];//state arraylist
    var lastArray = [];
        
    function sendToServer() 
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('POST', 'Work.php',true); //Open up connection, the connection is asynchronous, so we set the flag to true.
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) //Check that the table has been sent to us successfully
            {
                document.getElementById("tableArea").innerHTML = this.responseText;//create html form inner web
            }
        };
        
        var dataArray = lastArray;//dataarray equal lastarray
        
         xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send('array=' + encodeURIComponent(dataArray));
        
        return false;
        
    }
        
        </script>
    
     
    <body>
        
           <?php 
        include ("connect.php"); 
        
session_start();//Connect to database.
    
    $sql="SELECT OrderID, ApprovingStatus, Date_Time, Signed_By FROM Approve;";
    $resultSet=$conn->query($sql);//Select all information in database.
    ?>
    <h1> Approve Table</h1>
    
    
        <table id="table">
	
		<tr>
            <th>OrderID</th>
			<th>ApprovingStatus</th>
			<th>Date_Time</th>
			<th>Signed_By</th>
            <th>Confirm</th><!--Print the form title-->
		</tr>
        
        <?php if($resultSet->num_rows>0){ while ($rows=$resultSet->fetch_assoc()) { 
        
        $orderid=$rows['OrderID'];
        $approvingstatus=$rows['ApprovingStatus'];
		$date=$rows['Date_Time'];
        $signedby=$rows['Signed_By'];//Get the form information.
        ?>
        <tr>
		    <form action="dbConfirm" method="request">
			<td><?php echo $orderid; ?><input type="hidden" name="ID" value ="<?php echo htmlspecialchars(json_encode($orderid)); ?> "  /> </td><!--Print the orderID and post it to dbconfirm.php if it need.-->
			<td><?php echo $approvingstatus; ?></td><!--Print the information,the same below-->
            <td><?php echo $date; ?></td>
            <td><?php echo $signedby; ?></td>
            <td><button type="submit" >Confirm</button></td><!--if user click the button, post information to dbConfirm.php to confirm the order-->
			</form>
			<td>
           
			
		</tr>
        <?php } }?>
    
    </table>

</body>
</html>