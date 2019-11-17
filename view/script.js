var dvdsChecked = false;
var booksChecked = false;
var furnsChecked = false;
var allChecked = false;

var allCheckBoxes = document.getElementsByClassName("ch");

function checkboxes() {

    var dvds = document.getElementsByName("dvdC");
    var books = document.getElementsByName("bookC");
    var furns = document.getElementsByName("furnC");


    var typeChosen = document.getElementById("switch");
    var selected = typeChosen.options[typeChosen.selectedIndex].value;
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
        
        case "all":
            if(!allChecked) {
                for (let unit of allCheckBoxes) unit.checked = true;
                allChecked = true;
            }
            break;

        case "deselect":
            for (let unit of allCheckBoxes) unit.checked = false;
            allChecked = false;
    }
}


function submit() {
    var products = [];
    var skus = [];
    for (let box of allCheckBoxes) if (box.checked == true) products.push(box.parentElement.textContent);
    for (var sku of products) {
        var onesku = "";
        var skuPos = sku.search("Sku: ");
        skuPos = skuPos + 5;
        var length = skuPos + 8;
        for (let i = skuPos; i < length; i++) {
            onesku += sku[i];
        }
        skus.push(onesku);
    }
    console.log(skus);
    // now skus [] is an array with skus that have to be removed from the database we have to remove from the database
    JSON.stringify(skus);
    var form = document.getElementById("stuff");
    form.submit();
}