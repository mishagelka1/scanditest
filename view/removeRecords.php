<?php

// this page is used to post the mass delete action to the database

$db = new mysqli('localhost', 'root', '', 'scanditest') 
or die("something went wrong!");

function createQuery($arr) { // this function creates a text that must be inserted into query into "IN ()" parenthesis
    $printArray = "";
    for ($i = 0; $i < sizeof($arr); $i++) {
        if ($i == sizeof($arr) - 1) $printArray = $printArray .'\'' .  $arr[$i] . '\'';
        else $printArray = $printArray . '\'' . $arr[$i] . '\'' . ", ";
    } 
    return $printArray;
}


$skus = array();
$skus_d = array();
$skus_b = array();
$skus_f = array();

foreach($_POST as $sku) { // this applies an htmlspecialchars function to every attribute to get protection form sql injections
    htmlspecialchars($sku);
    array_push($skus, $sku);
}

foreach ($skus as $val) { // this cycle loops through all skus that must be deleted and distributes them to their corresponding arrays
    switch ($val[8]) {
        case 'd':
            $val = substr($val, 0, -1); // here that product type letter is getting removed
            array_push($skus_d, $val);
            break;
        case 'b':
            $val = substr($val, 0, -1);
            array_push($skus_b, $val);
            break;
        case 'f':
            $val = substr($val, 0, -1);
            array_push($skus_f, $val);
            break;
    }
}


if (!empty($skus_d)) { // these are the queries which work if the corredponding product type array is not empty
    $dvdRequest = createQuery($skus_d); // creates a right syntax for the query
    $massDeleteDvd = "DELETE products, dvd_attr FROM products
    LEFT OUTER JOIN dvd_attr ON products.sku = dvd_attr.sku_d
    WHERE sku IN ($dvdRequest)";
    if ($db->query($massDeleteDvd) !== TRUE) echo "You failed, here is why: " . $db->error; // outputs an error if there was such
}
if (!empty($skus_b)) {
    $bookRequest = createQuery($skus_b);
    $massDeleteBook = "DELETE products, book_attr FROM products
    LEFT OUTER JOIN book_attr ON products.sku = book_attr.sku_b
    WHERE sku IN ($bookRequest)";
    if ($db->query($massDeleteBook) !== TRUE) echo "You failed, here is why: " . $db->error;

}
if (!empty($skus_f)) {
    $furnitureRequest = createQuery($skus_f);
    $massDeleteFurniture = "DELETE products, furniture_attr FROM products
    LEFT OUTER JOIN furniture_attr ON products.sku = furniture_attr.sku_f
    WHERE sku IN ($furnitureRequest)";
    if ($db->query($massDeleteFurniture) !== TRUE) echo "You failed, here is why: " . $db->error;
}

$db->close();

require 'index.php';


?>