var dvdsChecked = false;
var booksChecked = false;
var furnsChecked = false;
var allChecked = false;

if(performance.navigation.type == 2){ //to prevent the page showing the same products when the button back in the browser is pressed after delete action
    location.reload(true);
}

var allCheckBoxes = document.getElementsByClassName("ch");


function checkTheBox(CheckBox) { // function to check the checkbox when the product div is pressed
    if (CheckBox.checked == true) {
        CheckBox.checked = false;
    }
    else {
        CheckBox.checked = true;
    } 
}

function checkboxes() { // this function allows to select multiple elements at once

    var dvds = document.getElementsByName("dvdC");
    var books = document.getElementsByName("bookC");
    var furns = document.getElementsByName("furnC");


    var typeChosen = document.getElementById("switch");
    var selected = typeChosen.options[typeChosen.selectedIndex].value;
    // this switch works like on/off element and turns all checkboxes of the desired type checked/unchecked
    switch (selected) {
        case "dvd":
            if (!dvdsChecked) {
                for (let dvdUnit of dvds) dvdUnit.checked = true;
                dvdsChecked = true;
            }
            else {
                for (let dvdUnit of dvds) dvdUnit.checked = false;
                dvdsChecked = false;
            } 
   
            break;

        case "book":
            if (!booksChecked) {
                for (let bookUnit of books) bookUnit.checked = true;
                booksChecked = true;
            }
            else {
                for (let bookUnit of books) bookUnit.checked = false;
                booksChecked = false;
            }
            break;

        case "furniture":
            if(!furnsChecked) {
                for (let furnUnit of furns) furnUnit.checked = true;
                furnsChecked = true;
            }
            else {
                for (let furnUnit of furns) furnUnit.checked = false;
                booksChecked = false;
            }
            break;
        
        case "all": // this checks all the checkboxes
            if(!allChecked) {
                for (let unit of allCheckBoxes) unit.checked = true;
                allChecked = true;
            }
            break;

        case "deselect": // this unchecks all the checkboxes
            for (let unit of allCheckBoxes) unit.checked = false;
            allChecked = false;
    }
}


function submit() {
    var products = [];
    var skus = [];
    for (let box of allCheckBoxes) if (box.checked == true) products.push(box.parentElement);
    for (var elem of products) {
        var sku = elem.children[2].textContent;
// there are one letter concatenations when pushing the elements into the array, that is done to distinguish the type of the product for furthere delete action purposes
        if (elem.textContent.includes("Size")) skus.push(sku + "d");
        if (elem.textContent.includes("Weight")) skus.push(sku + "b");
        if (elem.textContent.includes("Dimensions")) skus.push(sku + "f");
    }
    var skusLength = skus.length;

    // now skus [] is an array with skus that have to be removed from the database
    var formDiv = document.getElementById("artificialForm");

    var invisibleForm = document.createElement("form");
    invisibleForm.method = "POST";
    invisibleForm.action = "./removeRecords.php";

    for(var i = 0; i < skusLength; i++){ // here, to create form elements I decided to use the for cycle, because this way, it is easy to create different name attributes for each "input" field
        let child = document.createElement("input");
        child.setAttribute("type","text");
        child.setAttribute("value",skus[i]);
        child.name = "sku" + i; // as I understood, the names of input fields must be different in order for them to post them correctly, so there is index variable concatenation 
        invisibleForm.appendChild(child);
    }
    formDiv.appendChild(invisibleForm);
    
    invisibleForm.submit()
}