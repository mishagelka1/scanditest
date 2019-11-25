<?php
// This code is used to validate the data and submit it to the database

include "exceptions.php";
use sku as sku;
use name as name;
use price as price;
use productType as productType;
use size as size;
use weight as weight;
use dims as dims;


class Validator { // this class validates the input fields and outputs an errormessage, if needed
    static public function sku($sku) {
        if (strlen($sku) != 8) throw new sku\characterAmount();

        for ($i=0; $i < strlen($sku); $i++) { 
            if(!IntlChar::isalnum($sku[$i])) throw new sku\correctSymbols();
        }
    }


    static public function name($name) {
        if(strlen($name) > 30) throw new name\characterAmount();
    }


    static public function price($price) {
        $priceChar = str_split($price);
        $hasComma = false;
        $afterComma = 0;

        foreach ($priceChar as $symbol) {
            if ($hasComma) $afterComma++;
            if ($symbol == '.') $hasComma = true;
        }
        
        if (($afterComma > 2) || (is_nan($price)) || (strlen($price) > 10)) throw new price\correctSymbols();  
    
    }


    static public function productType($productType) {
        if ($productType == "") throw new productType\isEmpty();
    }

    static public function size ($size) {
        $sizeChar = str_split($size);
        $hasComma = false;
        foreach ($sizeChar as $symbol) if ($symbol == '.') $hasComma = true;
        if ($hasComma) {
            $commapos = strlen($size) - 3;
            if (!is_numeric($size) && !($size[$commapos] == '.') && !(strlen($size) < 10 )) throw new size\correctSymbols();
        }  
    }

    static public function weight ($weight) {
        $weightChar = str_split($weight);
        $hasComma = false;
        foreach ($weightChar as $symbol) if ($symbol == '.') $hasComma = true;
        if ($hasComma) {
            $commapos = strlen($weight) - 3;
            if (!is_numeric($weight) && !($weight[$commapos] == '.') && !(strlen($weight) < 10 )) throw new weight\correctSymbols();
        } 
    }
}


class Item { // the most complicated part - logics to build classes with their attributes
    protected $sku, $name, $price, $type, $query, $secondary_query;
    function __construct($i_sku, $i_name, $i_price) { // a constructor for all types of products and a common query
        $this->sku = $i_sku;
        $this->name = $i_name;
        $this->price = $i_price;
        $this->query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
    }

    function post() {
        $db = new mysqli('localhost', 'root', '', 'scanditest') 
        or die('U fail!');
// This block of code submiths the data to the database with the corresponding functions 
        $stmt = $db->prepare($this->query);
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->type);
        $stmt->execute();
        echo " You inserted main query ";
// These blocks of code insert the secondary query to the corresponding secondary tables
        $stmt = $db->prepare($this->secondary_query);
        if ($_POST["productType"] == "dvd") {
            $stmt->bind_param("sd", $this->sku, $this->size);
            $stmt->execute();
            echo "U inserted a dvd attribute! ";
        }
        if ($_POST["productType"] == "book") {
            $stmt->bind_param("sd", $this->sku, $this->weight);
            $stmt->execute();
            echo "U inserted a book attribute! ";
        }
        if ($_POST["productType"] == "furniture") {
            $stmt->bind_param("sddd", $this->sku, $this->h, $this->w, $this->l);
            $stmt->execute();
            echo "U inserted a furniture attribute! ";
        }

        echo " Done";
        require 'inserted.php'; // a webpage to navigate to /home, /add and /view
    }
}

// Here are subclasses that inherit from the main one. They add their special attribute
class dvd extends Item {
    public $size;
    function __construct($i_sku, $i_name, $i_price, $i_size) {
        parent::__construct($i_sku, $i_name, $i_price); // as you can see, the parent constructor is called first, then special attributes are ades
        $this->size = $i_size;
        $this->type = 'D'; 
        $this->secondary_query = "INSERT INTO dvd_attr (sku_d, size) VALUES (?, ?)";
    }
    function post() {
        parent::post();
    }
}

class book extends Item {
    public $weight;
    function __construct($i_sku, $i_name, $i_price, $i_weight) {
        parent::__construct($i_sku, $i_name, $i_price);
        $this->weight = $i_weight;
        $this->type = 'B';
        $this->secondary_query = "INSERT INTO book_attr (sku_b, weight) VALUES (?, ?)";
    }
    function post() {
        parent::post();
    }
}

class furniture extends Item {
    public $h, $w, $l;
    function __construct($i_sku, $i_name, $i_price, $i_h, $i_w, $i_l) {
        parent::__construct($i_sku, $i_name, $i_price);
        $this->h = $i_h;
        $this->w = $i_w;
        $this->l = $i_l;
        $this->type = 'F';
        $this->secondary_query = "INSERT INTO furniture_attr (sku_f, h, w, l) VALUES (?, ?, ?, ?)";
    }
    function post() {
        parent::post();
    }
}


function validate() { // this function is always called and it validates the corresponding fields
    try {
        Validator::sku($_POST["sku"]);
        Validator::name($_POST["name"]);
        Validator::price($_POST["price"]);
        Validator::productType($_POST["productType"]);
        if ($_POST["productType"] == "dvd") Validator::size($_POST["size"]);
        if ($_POST["productType"] == "book") Validator::weight($_POST["weight"]);   
    } catch (sku\characterAmount | sku\correctSymbols | name\characterAmount | price\correctSymbols | productType\isEmpty | size\correctSymbols | weight\correctSymbols | dims\correctSymbols $e) {
        // if an error is caught, the block of code below ensures that the page work will abort
        require 'index.php';
        $val_out = $e->errorMessage();
        echo htmlspecialchars($val_out);
        die(); 
    }
    $db = new mysqli('localhost', 'root', '', 'scanditest') 
    or die('U fail!');

    // this block of code ensures that it is not possible to insert a product with a sku that already exists
    $newitemsku = $_POST["sku"];
    $skuChecker = "SELECT sku FROM products WHERE sku = \"$newitemsku\" LIMIT 1";
    $skuexists = $db->query($skuChecker);
    if ($skuexists->num_rows != 0) {
        echo "Whoops, this sku is already occupied!";
        require 'index.php';
        die();
    } 
    $db->close();
}

function beautify() { // this function applys the htmlspecialchars function to everything to pervent the sql injections
    $_POST['sku'] = htmlspecialchars($_POST['sku']);
    $_POST['name'] = htmlspecialchars($_POST['name']);
    $_POST['price'] = htmlspecialchars($_POST['price']);
    $_POST['productType'] = htmlspecialchars($_POST['productType']);

    if($_POST["productType"] == "dvd") $_POST['size'] = htmlspecialchars($_POST['size']);
    if($_POST["productType"] == "book") $_POST['weight'] = htmlspecialchars($_POST['weight']);
    if($_POST["productType"] == "furniture") {
        $_POST['h'] = htmlspecialchars($_POST['h']);
        $_POST['w'] = htmlspecialchars($_POST['w']);
        $_POST['l'] = htmlspecialchars($_POST['l']);
    }
}

beautify();
validate();



switch ($_POST["productType"]) { // this block of code checks which type of the product was chosen, and creates it and posts to the database
    case "dvd": 
    $newItem = new dvd($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["size"]);
    $newItem->post(); 
    break;
    
    case "book": 
    $newItem = new book($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["weight"]);
    $newItem->post();
    break;

    case "furniture":
    $newItem = new furniture($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["h"], $_POST["w"], $_POST["l"]);
    $newItem->post();
}

?>

