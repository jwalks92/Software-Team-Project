<!DOCTYPE html> 
<html>
<head>

<meta charset="UTF-8">

<title> Track Deliveries </title>
    
    <style>
        #map{
            width: 400px;
        height: 500px;
        background-color: grey;
      }
        }
    
    </style>
    <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/api.css" />
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7bAoaUPYLyUIXsJT7SG48fzPdM7ExjLI
">
      </script>
    
</head>

<body>
    <div class="navbar">
      <a href="Homepage.html"><img src="img/logo.jpg" class="navbar__logo" alt="CLUK Logo"></a>
    <input type="checkbox" id="navbar__hamburger" class="navbar__hamburger">
	<label for="navbar__hamburger" class="navbar__hamburger__label">
	<span>|||</span>
	</label>
	<nav class="sidebar">
	<ul>
      <li><a href="Homepage.html" class="sidebar__menu">Home</a></li>
      <li><a href="Deliveries.html" class="sidebar__stock">Deliveries</a></li>
        <li><a href="Dashboard.html" class="sidebar__received">Dashboard</a></li>
        <li> <a href="Inventories.html" class="sidebar__completed">Inventories</a></li>
        <li> <a href="date.php" class="sidebar__track">Track</a></li>
	  <li><a href="Manage.php" class="sidebar__about">Manage Staff</a></li>
	  <li><a href="about-w.html" class="sidebar__about">About</a></li>
	  <li><a href="logOut.php" class="sidebar__logout">Log Out</a></li>
	  
	  </ul>
    </nav>
	</div>
    <section class="track">
        <div class="map-block"> 
    <h1>Delivery Map System</h1>
    
<div id="map" class="map-marker"></div>
            </div>
<div class="print">
<button id ="submit" class="button" onclick="calculateAndDisplayRoute(directionsService, directionsDisplay)"> Main Function</button>    
    
 <div id="directions-panel"></div>   
    <script> 
        // shows variables which are set to specific lat and lang. 
        // each lat and lang represents a specific location which have been set to that of the restaurants in the specification
        // Google API operates on lat and lang coordinates to operate the majority of its given features and so they will be used
        // later and set equal to specific names in an interating loop with if statements.
        
  var Newcastle = {lat: 54.9881, lng:-1.6194 };
  var warehouse = {lat: 54.8723, lng:-1.5859 };
  var restaurant1 = {lat:55.0665, lng: -1.634}; 
  var restaurant2 = {lat: 55.4128, lng:-1.7096 };
  var restaurant3 = {lat: 54.6121, lng:-1.5803 };
  var restaurant4 = {lat:54.2329, lng:-1.3397};
  var restaurant5 = {lat: 54.3111, lng:-1.349 }; 
        // array list where all locations are placed eventually, act as middle points between start and end destination points
         var waypoints = [];
        // below function to test way points, would take out but relevant to testing section of the system's documentation and also shows 
        // the use of alerts within arrays to test 
        function test(){
            alert(waypoints1[1].Name.toLowerCase());
            alert(waypoints[0].location);
        }
    // code below was largely inherited from google maps documentation.
    // onload performs the function automaticaly without button functionality 
    window.onload = function initMap() {    
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    // centres on location of newcastle found in lat and long above
    var map = new google.maps.Map(
    document.getElementById('map'), {zoom: 8, center: Newcastle});
    
    var marker = new google.maps.Marker({position: warehouse, map: map});
    var marker1 = new google.maps.Marker({position: restaurant1, map: map});
    var marker2 = new google.maps.Marker({position: restaurant2, map: map});
    var marker3 = new google.maps.Marker({position: restaurant3, map: map});
    var marker4 = new google.maps.Marker({position: restaurant4, map: map});
    var marker5 = new google.maps.Marker({position: restaurant5, map: map});    
        
    directionsDisplay.setMap(map);
  // event listener waits for the event to occur
    document.getElementById('submit').addEventListener('click', function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  });    
        
    }
    // not google maps documentation, uses a set location specified above, by refernce to variables each of which hold thier own lat and long.
        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            // uses iterating loop for converted array to check the name of each restaurant is equal to the ID of the sql database allocations. 
            // then pushes that into the array waypoints, which is used in the larger functionality of the system.
        for (var i = 0; i < waypoints1.length; i++) 
            {
                // pushes the id into a second array inlcuding stopover, which is unique to Google Maps api and shows where the set of directions should be placed through.
                if(waypoints1[i].Res_ID==1){
        waypoints.push({
        location: restaurant1,
        stopover: true
      });
                }
                if(waypoints1[i].Res_ID==2){
        waypoints.push({
        location: restaurant2,
        stopover: true
      });
                       
            }
               if(waypoints1[i].Res_ID==3){
        waypoints.push({
        location: restaurant3,
        stopover: true
      }); 
           
        }
            if(waypoints1[i].Res_ID==4){
        waypoints.push({
        location: restaurant4,
        stopover: true
      });       
                
            }
               if(waypoints1[i].Res_ID==5){
        waypoints.push({
        location: restaurant5,
        stopover: true
      }); 
        }
            }
        // derived from Google Maps documentation. 
        directionsService.route({
          
          origin: warehouse,
          destination: warehouse,
          waypoints: waypoints,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
            var summaryPanel = document.getElementById('directions-panel');
            summaryPanel.innerHTML = '';
            // For each route, display summary information.
            summaryPanel.innerHTML += '<b>Departure time from Warehouse is 07:00' +
                  '</b><br>';
              var timeToSeconds =0;
            for (var i = 0; i < route.legs.length; i++) {
                //uses for loop for each way point and then creates dynamic html table to calcualte duration distance etc. 
              var routeSegment = i + 1;
              summaryPanel.innerHTML += '<b>Route Path: ' + routeSegment +
                  '</b><br>';
              summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
              summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
              summaryPanel.innerHTML += route.legs[i].distance.text + '<br>';
              summaryPanel.innerHTML += route.legs[i].duration.text + '<br>';
                
             // to come to arrival time used maths to get the duration from seconds to digital clock time
             
              timeToSeconds =timeToSeconds + route.legs[i].duration.value;
              var seven = 25200;
              var addedTime = timeToSeconds + seven;
              var date = new Date(null);
              date.setSeconds(addedTime); 
              var timeString = date.toISOString().substr(11, 10);
              summaryPanel.innerHTML += 'Estimated Arrival Time: ' + timeString +
                  '<br>';
              
            }
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
        
        }
    
// try and figure out time between the places and then stick that in a html table.
// make that  a last resort though, restaurant needs completed first. 
        
            //distance matrix
    var service = new google.maps.DistanceMatrixService;
    
    var origin = warehouse;
    var destination = warehouse;
    var middlePoints = waypoints;
        
        
        var distancing = new google.maps.DistanceMatrixService();
service.getDistanceMatrix(
  {
    origins: origin,
    waypoints: waypoints,
    optimizeWaypoints: true,
    destinations: destination,
    travelMode: 'DRIVING',
    transitOptions: TransitOptions,
    drivingOptions: DrivingOptions,
    unitSystem: UnitSystem,
    avoidHighways: Boolean,
    avoidTolls: Boolean,
  }, callback);
    function callback(response, status) {
  if (status == 'OK') {
    var origins = response.originAddresses;
    var destinations = response.destinationAddresses;
    for (var i = 0; i < origins.length; i++) {
      var results = response.rows[i].elements;
      for (var j = 0; j < results.length; j++) {
        var element = results[j];
        var distance = element.distance.text;
        var duration = element.duration.text;
        var from = origins[i];
        var to = destinations[j];
      }
    }
  }
}  
        
    // end distance matrix
    
    </script>
    </div>
    <?php
    
    include ("connect.php");
    
	// uses date from previous form to check the aray if any of the restuarant orders are allocated with said date
	$date = $_POST['dDay'];

   // if they are allocated with that date they are passed into the first array dataInfo.
	$sql="select distinct(s.Res_ID) from Approve a, OrderList s, Restaurant r where a.ApprovingStatus='APPROVE' and Order_Date='$date' and s.OrderID=a.OrderID";
    $dataInfo = array();
    
    $resultSet=$conn->query($sql);
if($resultSet->num_rows>0){
    
    while($rows=$resultSet->fetch_assoc())
	{
		$row1=$rows['Res_ID'];
        $dataInfo[] =$rows; 
		
	}
			
    }
else
{
	echo "<tr><td>0 results</td></tr>";
}
    
    ?>
<script>
    // datainfo PHP array concerted to Javascript
    var waypoints1 = JSON.parse('<?php echo json_encode($dataInfo) ?>');
	if (waypoints1.length==0){
		alert("There are no deliveries for today");
	}
    
    console.log(waypoints1);
    
    </script>
    
    </section>

</body>
  </html>  