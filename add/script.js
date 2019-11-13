/*function handleInput(textField) {
    if (textField.value == "") {
        textField.style.backgroundColor = "red";
        return false;
    }
    else {
        textField.style.backgroundColor = "white";
        return true;
    }
} */

 var errorMessageUp = false;
 var dvdUp = false;
 var bookUp = false;
 var furnitureUp = false;


 function dvdBoxUp() { // function to display dvd inputbox
    dvdUp = true;
    var dvdInput = document.getElementById("form");
    var dvdBox = document.createElement("input");
    var dvdText = document.createElement("p");

    dvdText.innerText = "Enter size (in MB)";
    dvdText.id = "did";

    dvdBox.type = "text";
    dvdBox.name = "size";
    dvdBox.className = "attr";

    dvdInput.appendChild(dvdText);
    dvdInput.appendChild(dvdBox);
 }

 function bookBoxUp() { // function to display book inputbox
    bookUp = true;
    var bookInput = document.getElementById("form")
    var bookBox = document.createElement("input");
    var bookText = document.createElement("p");

    bookText.innerText = "Enter weight (in kg)";
    bookText.id = "bid";

    bookBox.type = "text";
    bookBox.name = "weight";
    bookBox.className = "attr";

    bookInput.appendChild(bookText);
    bookInput.appendChild(bookBox);
 }

 function furnitureBoxUp() {
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
    furnitureInput.appendChild(furnitureTextH);
    furnitureInput.appendChild(furnitureBoxH);
    furnitureInput.appendChild(furnitureTextW);
    furnitureInput.appendChild(furnitureBoxW);
    furnitureInput.appendChild(furnitureTextL);
    furnitureInput.appendChild(furnitureBoxL);
 }
 
 // Experiment for dynamic - result = success!
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


    var typeChosen = document.getElementById("switch");
    var slctd = typeChosen.options[typeChosen.selectedIndex].value; //Checks which option is selected
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

// End of experiment

function submit() {
    var price = document.getElementsByName("price")[0];
    
    var correct = true;

    var text_elem = document.getElementsByClassName("attr");
    for (let i = 0; i < text_elem.length; i++) {
        if (text_elem[i].value == "") {
            text_elem[i].style.backgroundColor = "Coral";
            correct = false;
        }
    }

    if (isNaN(price.value)) {
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
    else if(!correct && errorMessageUp == true) {
        form.removeChild(errorMess);
        return;
    }

    var form = document.getElementById("form");
    form.submit(); 
}