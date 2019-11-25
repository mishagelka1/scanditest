// Global variables to check if dynamic objects appear on the page
var errorMessageUp = false;
var dvdUp = false;
var bookUp = false;
var furnitureUp = false;

// These 3 functions generate input fields and thext above them

 function dvdBoxUp() { // function to display dvd input text and the inputbox 
    dvdUp = true;
    var dvdInput = document.getElementById("form");
    var dvdBox = document.createElement("input");
    var dvdText = document.createElement("p");

    dvdText.innerText = "Enter size (in MB)";
    dvdText.id = "did";

    dvdBox.type = "text";
    dvdBox.name = "size";
    dvdBox.className = "attr";
    dvdBox.setAttribute("onchange", "validator_dynamic()");

    dvdInput.appendChild(dvdText);
    dvdInput.appendChild(dvdBox);
 }

 function bookBoxUp() { // function to display book input text and the inputbox
    bookUp = true;
    var bookInput = document.getElementById("form")
    var bookBox = document.createElement("input");
    var bookText = document.createElement("p");

    bookText.innerText = "Enter weight (in kg)";
    bookText.id = "bid";

    bookBox.type = "text";
    bookBox.name = "weight";
    bookBox.className = "attr";
    bookBox.setAttribute("onchange", "validator_dynamic()");

    bookInput.appendChild(bookText);
    bookInput.appendChild(bookBox);
 }

 function furnitureBoxUp() { // function to display furniture input text and the inputbox
    furnitureUp = true;
    var furnitureInput = document.getElementById("form")
    var furnitureBoxH = document.createElement("input");
    var furnitureBoxW = document.createElement("input");
    var furnitureBoxL = document.createElement("input");
    var furnitureTextH = document.createElement("p");
    var furnitureTextW = document.createElement("p");
    var furnitureTextL = document.createElement("p");

    furnitureTextH.innerText = "Enter height";
    furnitureTextW.innerText = "Enter width";
    furnitureTextL.innerText = "Enter length";

    furnitureTextH.id = "hid";
    furnitureTextW.id = "wid";
    furnitureTextL.id = "lid";

    //
    furnitureBoxH.type = "text";
    furnitureBoxW.type = "text";
    furnitureBoxL.type = "text";
    //
    furnitureBoxH.name = "h";
    furnitureBoxW.name = "w";
    furnitureBoxL.name = "l";
    //
    furnitureBoxH.className = "attr";
    furnitureBoxW.className = "attr";
    furnitureBoxL.className = "attr";
    //
    furnitureBoxH.setAttribute("onchange", "validator_dynamic()");
    furnitureBoxW.setAttribute("onchange", "validator_dynamic()");
    furnitureBoxL.setAttribute("onchange", "validator_dynamic()");
    //
    furnitureInput.appendChild(furnitureTextH);
    furnitureInput.appendChild(furnitureBoxH);
    furnitureInput.appendChild(furnitureTextW);
    furnitureInput.appendChild(furnitureBoxW);
    furnitureInput.appendChild(furnitureTextL);
    furnitureInput.appendChild(furnitureBoxL);
 }

// Javascript validation functions use 'this' field and then get their value. Depending on it, they either turn red or green

 function validator_n() { // a function to check if the name field is not empty
    var nameChecker = document.getElementsByName("name")[0];
    if(nameChecker.value == "") {
        nameChecker.style.borderColor = "red";
        return false;
    }
    else nameChecker.style.borderColor = "green";
    return true;
}
 
function validator_s() {
    var skuChecker = document.getElementsByName("sku")[0];
    if (skuChecker.value.length != 8 ||skuChecker.value == "") { 
        skuChecker.style.borderColor= "red";
        return false;
    }
    else {
        skuChecker.style.borderColor = "green";
        return true;
    } 
}


function validator_p() { // this function must ensure that number is not only a number, but also contains not more than 2 symbols after comma
    var priceChecker = document.getElementsByName("price")[0];
    var hasComma = false;
    var afterComma = 0;
    for (let symb of priceChecker.value) { // if comma is in the value, it counts the number of symbols after it
        if (hasComma) afterComma++;
        if (symb == '.') hasComma = true;
    }
    
    if (hasComma) {
        if ((afterComma > 2) || (isNaN(priceChecker.value))) { // if the value isNaN and there are more than 2 symbols after comma, the window turns red
            priceChecker.style.borderColor = "red";  
            return false;                     
        }
        else {
            priceChecker.style.borderColor = "green";
            return true;
        } 
        
    }
    else if (isNaN(priceChecker.value) || priceChecker.value == "") { 
        priceChecker.style.borderColor = "red";
        return false;

    } 
    else  {
        priceChecker.style.borderColor = "green";
        return true;
    }
}    

 function dynamicChange() {

    var form = document.getElementById("form"); // to access form elements



// This section removes element (by checking if it exists) if the type chosen is being changed 
    if(dvdUp) {
        var deleteDVDBox = document.getElementsByName("size")[0];
        var deleteDVDText = document.getElementById("did");
        form.removeChild(deleteDVDBox);
        form.removeChild(deleteDVDText);
        dvdUp = false;
    }
    if (bookUp) {
        var deleteBookBox = document.getElementsByName("weight")[0];
        var deleteBookText = document.getElementById("bid");
        form.removeChild(deleteBookBox);
        form.removeChild(deleteBookText);
        bookUp = false;
    }
    if(furnitureUp) {
        var deleteHBox = document.getElementsByName("h")[0];
        var deleteWBox = document.getElementsByName("w")[0];
        var deleteLBox = document.getElementsByName("l")[0];
        var deleteHText = document.getElementById("hid");
        var deleteWText = document.getElementById("wid");
        var deleteLText = document.getElementById("lid");
        //
        form.removeChild(deleteHBox);
        form.removeChild(deleteWBox);
        form.removeChild(deleteLBox);
        form.removeChild(deleteHText);
        form.removeChild(deleteWText);
        form.removeChild(deleteLText);

        furnitureUp = false;
    }


    var typeChosen = document.getElementById("switch"); // To get the value of the "select" element
    var slctd = typeChosen.options[typeChosen.selectedIndex].value; //Checks which option is selected in the "select" element for special attribute
    if(slctd == "dvd") {
        dvdBoxUp();
    }

    else if(slctd == "book") {
        bookBoxUp();
    }

    else if(slctd == "furniture") {
        furnitureBoxUp();
    }

 }


function submit() { // Function that validates the data and submits it after that
    var correct = true;
    if (!validator_n() || !validator_p() || !validator_s()) correct = false;

    var text_elem = document.getElementsByClassName("attr");

    var price = document.getElementsByName("price")[0];
    if (isNaN(price.value) || price.value == "") {
        price.style.backgroundColor = "pink";
        correct = false;
    }
    
    if(dvdUp) {
        var size = document.getElementsByName("size")[0];
        if (isNaN(size.value)) {
            size.style.backgroundColor = "pink";
            correct = false;
        }
    }

    else if (bookUp) {
        var weight = document.getElementsByName("weight")[0];
        if (isNaN(weight.value)) {
            weight.style.backgroundColor = "pink";
            correct = false;
        }
    }
    else { 
        var hbox = document.getElementsByName("h")[0];
        var wbox = document.getElementsByName("w")[0];
        var lbox = document.getElementsByName("l")[0];

        if (isNaN(hbox.value)) {
            hbox.style.backgroundColor = "pink";
            correct = false;
        }

        if (isNaN(wbox.value)) {
            wbox.style.backgroundColor = "pink";
            correct = false;
        }

        if (isNaN(lbox.value)) {
            lbox.style.backgroundColor = "pink";
            correct = false;
        }


    }


    if(!correct && errorMessageUp == false) // outputs an error message
    {
        var form = document.getElementById("form");
        var errorMess = document.createElement("p");
        errorMess.innerText = "Sorry, wrong input";
        errorMess.style.marginTop = "0";
        errorMess.style.marginBottom = "0";
        errorMess.style.color = "red";
        form.appendChild(errorMess);
        errorMessageUp = true;
        return;
    }
    else if(!correct && errorMessageUp == true) { // this block removes an errormessage
        form.removeChild(errorMess);
        return;
    }

    var form = document.getElementById("form");
    form.submit(); 
}