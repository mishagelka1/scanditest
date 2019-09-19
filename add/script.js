function handleInput(textField) {
    if (textField.value == "") {
        textField.style.backgroundColor = "red";
        return false;
    }
    else {
        textField.style.backgroundColor = "white";
        return true;
    }
}

function submit() {
    var price = document.getElementsByName("price")[0];
    var correct = true;

    var text_elem = document.getElementsByClassName("attr");
    console.log(text_elem);
    for (let i = 0; i < text_elem.length; i++) {
        if (!handleInput(text_elem[i])) correct = false;
    }

    if (isNaN(price.value)) {
        price.style.backgroundColor = "green";
        correct = false;
    }

    if(!correct) return;

    var form = document.getElementById("form");
    form.submit();

}

window.alert('hallelouyah!');