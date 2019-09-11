// replica of function found in FinalSoftwareDevelopment.js
// difference is that function is automatically validated to prevent orders with no items from being passed throgh to the database. 
// if lastArray's length is greater than 0 then the information is passed over. 
// excpetion errors occur and posts a strigified JSON object to WorkVault.php

function sendToServerWithAjax() {
	var valid = false;
	mainTableData();
	if(lastArray.length==0){
		
	alert("Please Make An Order Before Pressing Submit");	
		
	}
	
	if (lastArray.length>0){
		valid = true;
    var dating = document.getElementById("date").value;
    console.log(lastArray);
  $.ajax({
     
    url: 'WorkVault.php',
    type: "POST",
    data: {
      menu: JSON.stringify(lastArray),
	  date:JSON.stringify(dating)
    },
    success: function(response, textStatus, jqXHR) {
      // Log a message to the console
     
        document.getElementById("tableArea").innerHTML = this.responseText
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // Log the error to the console
       
        
      console.error(
        "The following error occurred: " +
        textStatus, errorThrown
      )
    }
  });
      console.log(lastArray);  
    debugger;//this works
	valid = true;
	}
	return valid;
}

// Ingredient Item replica of order item found in finalSoftwareDevelopment.js

function IngredientItem (IngredientID,IngredientName, UnitAmmount)
{
    this.IngredientID = IngredientID;
    this.IngredientName = IngredientName;
    this.UnitAmmount = UnitAmmount;
    
}    

// validates the date and then presents alert if not checked. 
// if date is checked:
// nodes and parent elements utilize the "this" type in the corresponding html page so that each line takes the ID Name and Number
// parse used for number. 
// passes variable information to an object and pushes it to an array.
// the first array is then emptied so that array orders do not overlap and each indiviual array is emptied. 

function confirm(element){
        foo = element;
var date = document.getElementById("date").value;
	if ( date== null || date== ''){
		alert("Please enter a date");
		
	}
	
	else
		{
        if (foo.parentElement.parentElement.children[3].children[0].value>0)
        {
        var ID = foo.parentElement.parentElement.children[0].innerHTML;
        var Name = foo.parentElement.parentElement.children[1].innerHTML;
        var Number = foo.parentElement.parentElement.children[3].children[0].value;
        var newNumber = parseInt(Number);
        var Ingredients = new IngredientItem(ID, Name, newNumber);
        firstArray.push(Ingredients);
        foo.parentElement.parentElement.children[3].children[0].value =0;
        populate();
        empty();
        }
}
}

// empties first array list. 

function empty(){
    firstArray=[];
}

// dynamcially populates the second table and is called in the confirm function. 
// insert table rows 
// table cells within rows
// innerHTML changes. 

function populate(){
         
        var insert = document.getElementById("list").getElementsByTagName('tbody')[0];
		var table = document.getElementById("list");
		
		if(table.rows.length==0)
		{
		var row = insert.insertRow();
        var cell1 = row.insertCell();
        var cell2 = row.insertCell();
        var cell3 = row.insertCell();
		var cell4 = row.insertCell();
		cell1.innerHTML = '<th> ID </th>';
        cell2.innerHTML =  '<th> Ingredient Name </th>';
        cell3.innerHTML = '<th> Unit Number </th>';
		cell4.innerHTML = '<th> Action </th>';
		}
		
		if(table.rows.length>0){
        if (!(firstArray.length==0)){
        for (var i=0; i<firstArray.length;i++){
        var row = insert.insertRow();
        var cell1 = row.insertCell();
        var cell2 = row.insertCell();
        var cell3 = row.insertCell();
        var cell4 = row.insertCell();  
        cell1.innerHTML = firstArray[0].IngredientID;
        cell2.innerHTML = firstArray[0].IngredientName;
        cell3.innerHTML = firstArray[0].UnitAmmount;
        // onclick for delete row utilizes a specific function. 
        // id is incrementing every single time over an iterating for loop. 
        cell4.innerHTML = '<button type ="button" class="button" onclick="deleteRow()">Delete</button><button type ="button" class="button" id ="input[i]" onclick="editor(this)">Edit</button>';
        cell4.id = i;
        row.appendChild(cell4);
        }
        }
                }
     }

//information from the html table is then placed into the second array list. 
// similar functionality again seen to that of finalSoftwareDevelopment.js

function mainTableData(){
           var table = document.getElementById("list");
           for (var i=1; i<table.rows.length;i++){
               var ID = table.rows.item(i).cells[0].innerHTML;
               var newId = parseInt(ID);
               var Name = table.rows.item(i).cells[1].innerHTML;
               var Ammount = table.rows.item(i).cells[2].innerHTML;
               var newInt = parseInt(Ammount);
               var information = new IngredientItem(newId,Name,newInt);
               lastArray.push(information);
               console.log(lastArray);
           }
           
       } 

// wanted to delete entire table including boldened header tags at the top hence why the following was used rather than delete row (this)

function deleteRow(){
		    var dTable = document.getElementById("list");
            for (var i=1;i<table.rows.length;i++ ){
            dTable.deleteRow(i);
			if(dTable.rows.length==1)
			{
				dTable.deleteRow(0);
            }
			
        }
	}

// used to edit information. 
// parent node from previous functions replicated. 
// elements from each row stored for future manipulation in next fuunctions. 
	
	function editor(element){
        
	    foo = element;
        console.log(element);
        var ID = foo.parentElement.parentElement.children[0].innerHTML;
        var Name = foo.parentElement.parentElement.children[1].innerHTML;
        var Category = foo.parentElement.parentElement.children[2].innerHTML;
	
	    document.getElementById("id").value = ID;  
	    document.getElementById("name").value = Name;
        document.getElementById("units").value = Category;
    }

// uses dynamic table information to place information into editing input boxes. 

	
	function inputCreator(){
		var table = document.getElementById("editing");
		
		var row = table.insertRow();
        var cell1 = row.insertCell();
        var cell2 = row.insertCell();
        var cell3 = row.insertCell();
		var cell4 = row.insertCell();
		
		cell1.innerHTML = '<p> ID <input type="text" readonly = "readonly" id="id"/> </p>'
        cell2.innerHTML =  '<p> IngredientName: <input type="text" readonly = "readonly" id="name"/> </p>';
        cell3.innerHTML = '<p> Units: <input type="text"  id="units"/> </p>';
	    cell4.innerHTML = '<button type ="button" class="button" onclick="changeInformation()">Edit Units</button>';
	}

// uses incrementing for loop to change the unit number accoding to corresponding ids. 
// for loop begins at 1 in the main table so that the header row is not included. 
	
	function changeInformation(){
        var mainTable = document.getElementById("list");
        var mainLength = mainTable.rows.length;
        for(var i=1;i<mainLength;i++)
            {
                if (document.getElementById("id").value==i)
                    {
                        var units = document.getElementById("units").value;
                        
                        var row = mainTable.rows[i].cells[3].value;
                        
                        mainTable.rows[i].cells[2].innerHTML = units;
                        
                        
                    }
            }
    }