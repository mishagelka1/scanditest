<?php

var_dump($_POST);

$sku = $name = $price = $type = $param = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sku = test_input($_POST["sku"]);
    $name = test_input($_POST["name"]);
    $price = test_input($_POST["price"]);
    $productType = test_input($_POST["productType"]);
    
    if($_POST["productType"] == "dvd") $param = test_input($_POST["size"]);
    else if ($_POST["productType"] == "book") $param = test_input($_POST["weight"]);
    else {
        $param = test_input(array($_POST["h"], $_POST["w"], $_POST["l"]));
    }
} 

function test_input($data) {
    if (is_array($data)) {
        foreach($data as $value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value = htmlspecialchars($value);
        }
    }
    else {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
        return $data;
}


echo "<h2>Your input:</h2>";
echo $sku;
echo "<br>";
echo $name;
echo "<br>";
echo $price;
echo "<br>";
echo $productType;
echo "<br>";
if(is_array($param)) {
    foreach($param as $value) echo $value . " ";
}
else echo $param;

?>

