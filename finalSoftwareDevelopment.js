/* following utilizes AJAX to send infomration over to PHP file "loading.php".
the menu stringifies the arraylist menuList to a JSON object, ready to be encoded in the aforementioned PHP page. 
the jquery proceding it then if successful passes the information over the file, elsewhile it thows an exception error. 
*/

function sendToServerWithAjax() {
  validate(); // refernce to method found below, which adds foodItems to array list, vital to task but should only be utilized on form submit function, hence why it is found with in the AJAX call. 

  $.ajax({
    url: 'loading.php',
    type: "post",
    data: {
      menu: JSON.stringify(menuList)
    },
    done: function(response, textStatus, jqXHR) {
      // Log a message to the console
      
    },
    fail: function(jqXHR, textStatus, errorThrown) {
      // Log the error to the console
      console.error(
        "The following error occurred: " +
        textStatus, errorThrown
      );
    }
  });
}

// food Object for each item. each food item, contains four variables, linked to the infomation in the menu.php file
//namely name, price, ammount and total. 

function foodItem (name,price, ammount,total)
{
    this.name=name;
    this.price=price;
    this.ammount=ammount;
    this.total = price*ammount;
    
}

//menu array contains foodItem objects which will be utilized at later discretion. 

var menuList = [];

//increases the numerical input for each corresponding input box for each item. 

function increase(str) {
    document.getElementById(str).value++;
   
    
}

//increases the numerical input for each corresponding input box for each item. 

function decrease(str) {
    if(!(document.getElementById(str).value==0))
       {
        document.getElementById(str).value--;
        
}
else {
    alert("You cannot order negative food types!");
}
    
}

// validate adds objects to menuList dependant on onclick functions, further features will be discussed below. 

function validate(){
    // since validate is called in AJAX function, it needs to be validated with a boolean statement. 
    var valid = false; //going to need 9 differnt variables
    // each food type is assigned its own element. 
    var element1 = document.getElementById("inc1");
    var element2 = document.getElementById("inc2");
    var element3 = document.getElementById("inc3");
    var element4 = document.getElementById("inc4");
    var element5 = document.getElementById("inc5");
    var element6 = document.getElementById("inc6");
    var element7 = document.getElementById("inc7");
    var element8 = document.getElementById("inc8");
    var element9 = document.getElementById("inc9");
   // if a given elements value is greater than zero then...
    if(element1.value>0){
        
        // the number variable is set to a float, there are no doubles in Javascript but it is necessary in order to pass the correct information into the database, which should only accept integer data. 
        var number = parseFloat(element1.value);
        var getClass = document.getElementsByClassName("menu__chicken")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        // following takes the price of each item, replaces the £ sign and then converts it to a numerical data type. 
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element1.name;
        //all information is added to the foodItem Object
        var food = new foodItem(name, newestPrice, number,total);
        // which is then passed into an array list - menu List. 
        menuList.push(food);
        
        
    }
    
    if(element2.value>0){
        var number = parseFloat(element2.value);
        var getClass = document.getElementsByClassName("menu__chicken-nobone")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element2.name;
        
        var food = new foodItem(name, newestPrice, number,total);
        menuList.push(food);
        
    }
    
    if(element3.value>0){
        var number = parseFloat(element3.value);
        var getClass = document.getElementsByClassName("menu__burger")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element3.name;
        
       var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
        
    }
    
    if(element4.value>0){
        
        var number = parseFloat(element4.value);
        var getClass = document.getElementsByClassName("menu__s-burger")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element4.name;
        
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
        
    }
    
    if(element5.value>0){
        
        var number = parseFloat(element5.value);
        var getClass = document.getElementsByClassName("menu__veg-strips")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element5.name;
        
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
        
    }
    
    if(element6.value>0){
        var number = parseFloat(element6.value);
        var getClass = document.getElementsByClassName("menu__veg-burger")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element6.name;
        
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
    }
    
    if(element7.value>0){
        var number = parseFloat(element7.value);
        var getClass = document.getElementsByClassName("menu__veg-s-burger")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element7.name;
        
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
        
    }
    
    if(element8.value>0){
        var number = parseFloat(element8.value);
        var getClass = document.getElementsByClassName("menu__fries")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element8.name;
    
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
    }
    
     if(element9.value>0){
        var number = parseFloat(element9.value);
        var getClass = document.getElementsByClassName("menu__cola")[0];
        var getRange = getClass.getElementsByClassName("price")[0];
        var getPrice = getRange.innerHTML;
        var newPrice = getPrice.replace("£","");
        var newestPrice = parseFloat(newPrice);
        var newestPrice = parseFloat(newPrice);
        var total = number * newestPrice;
        var name = element9.name;
        
        var food = new foodItem(name, newestPrice, number, total);
        menuList.push(food);
         
           
    }
    // below ensures that if menu length is equal to zero then vlaidation is false
   if(menuList.length==0)
       {
           alert("Please select an Order");
		   valid = false;
       }
	   // if menu length is greater than zero validation is set equal to true so that it can pass onto the next page. 
	   if(menuList.length>0)
       {
           alert("Order will be passed");
		   valid = true;
       }
    
    return valid;
}

//stringifies menu list and converts to local storage. highly useful for testing and left in here to validate the whitebox testing methods found in
// testing documentation. 

function checkArrayList(){
    
    var myJSON = JSON.stringify(menuList);
    localStorage.setItem("ObjectMenu", myJSON);
    var text = localStorage.getItem("ObjectMenu");
    var obj = JSON.parse(text);
   
    for (var i =0; i<obj.length;i++)
       {
            alert(obj[i].name); 
          
        }  
}



// below creates a dynamic html table based on object table
// parses information to text, strips the menu array 's objects into its seperate variables and proceeds to add to table. 
//alternative way to using PHP/ SQL data and was preferble solution when AJAX call would not work. 
// uses incrementing for loop to create table for each line and then proceed to add total to final line. 
function getList(){
    
    var text = localStorage.getItem("ObjectMenu");
    var obj = JSON.parse(text);
    var table = document.getElementById("table")
    
    for (var i=0; i<obj.length;i++){
        
    var tr = "<tr>";
    var td = "<tr>"
    var hello = "Total:";
    tr += "<td>" + obj[i].name + "</td>" + "<td>" + obj[i].price + "</td>" + "<td>" + obj[i].ammount + "<td>" + obj[i].total + "</td></tr>";
    table.innerHTML +=tr;
    td = "<td>" + hello + "</td>" + "<td>" + "</td></td>" ;
    
    }
   
    var newRow   = table.insertRow(table.rows.length);

    var newCell  = newRow.insertCell(0);
    var newCell1 = newRow.insertCell(1);
    var newText  = document.createTextNode('Total:');
    newCell.appendChild(newText);
    var list = menuListTotal();
    newCell1.innerHTML=list;
      
}

// return menu array list. 

function getArray(){
    return menuList;
}

// creates total which is necesary for later payment pages.  

function menuListTotal()
{
    var text = localStorage.getItem("ObjectMenu");
    var obj = JSON.parse(text);
    var count =0;
    for(var i =0; i<obj.length;i++ )
        {
            count += obj[i].total;
        }
    
    return count;
}

var previousTotal = menuListTotal();
    var payment = document.getElementById("mySuperText").value;
// empties array list and is stored in refresh each time. 
function empty(){
	menuList = [];
}