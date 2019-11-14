<?php

include "exceptions.php";
use sku as sku;
use name as name;
use price as price;
use productType as productType;
use size as size;
use weight as weight;
use dims as dims;


class Validator {
    static public function sku($sku) {
        if (strlen($sku) != 8) throw new sku\characterAmount();

        for ($i=0; $i < strlen($sku); $i++) { 
            if(!IntlChar::isalnum($sku[$i])) throw new sku\correctSymbols();
        }
    }


    static public function name($name) {
        if(strlen($name) > 30) throw new name\characterAmount();

        for ($i=0; $i < strlen($name); $i++) { 
            if(!ctype_alpha($name[$i])) throw new name\correctSymbols();
        }      
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
            if (is_numeric($size) && ($size[$commapos] == '.') && (strlen($size) < 10 )) (float) $size; // return??
            else throw new size\correctSymbols();
        }
        else {
           (float) $size; //return?
        }   
    }

    static public function weight ($weight) {
        $weightChar = str_split($weight);
        $hasComma = false;
        foreach ($weightChar as $symbol) if ($symbol == '.') $hasComma = true;
        if ($hasComma) {
            $commapos = strlen($weight) - 3;
            if (is_numeric($weight) && ($weight[$commapos] == '.') && (strlen($weight) < 10 )) (float) $weight; // return??
            else throw new weight\correctSymbols();
        }
        else {
           (float) $weight; //return?
        }  
    }

    static public function dims ($dims) {
        $dimsChar = str_split($dims);
        $hasComma = false;
        foreach ($dimsChar as $symbol) if ($symbol == '.') $hasComma = true;
        if ($hasComma) {
            $commapos = strlen($dims) - 3;
            if (is_numeric($dims) && ($dims[$commapos] == '.') && (strlen($dims) < 5 )) (float) $dims; // return??
            else throw new dims\correctSymbols();
        }
        else {
           (float) $dims; //return?
        }  
    }


}


class Item {
    protected $sku, $name, $price, $type, $query, $secondary_query;
    function __construct($i_sku, $i_name, $i_price) {
        $this->sku = $i_sku;
        $this->name = $i_name;
        $this->price = $i_price;
        $this->query = "INSERT INTO products (sku, name, price, type) VALUES (?, ?, ?, ?)";
    }

    function post() {
        $db = new mysqli('localhost', 'root', '', 'scanditest') 
        or die('U fail!');

        $stmt = $db->prepare($this->query);
        $stmt->bind_param("ssds", $this->sku, $this->name, $this->price, $this->type);
        $stmt->execute();
        echo " You inserted main query ";

        $stmt = $db->prepare($this->secondary_query);
        if ($_POST["productType"] == "dvd") {
            $stmt->bind_param("sd", $this->sku, $this->size);
            $stmt->execute();
            echo "U inserted a dvd attr! ";
        }
        if ($_POST["productType"] == "book") {
            $stmt->bind_param("sd", $this->sku, $this->weight);
            $stmt->execute();
            echo "U inserted a book attr! ";
        }
        if ($_POST["productType"] == "furniture") {
            $stmt->bind_param("sddd", $this->sku, $this->h, $this->w, $this->l);
            $stmt->execute();
            echo "U inserted a furniture attr! ";
        }


        echo " Done";
        require 'inserted.php';
    }

}

class dvd extends Item {
    public $size; // is this ok public?
    function __construct($i_sku, $i_name, $i_price, $i_size) {
        parent::__construct($i_sku, $i_name, $i_price);
        $this->size = $i_size;
        $this->type = 'D'; 
        $this->secondary_query = "INSERT INTO dvd_attr (sku_d, size) VALUES (?, ?)";
    }
    function post() {
        parent::post();
    }
}

class book extends Item {
    public $weight; // is this ok public?
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
    public $h, $w, $l; // is this ok public?
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

function validate() {
    try {
        Validator::sku($_POST["sku"]);
        Validator::name($_POST["name"]);
        Validator::price($_POST["price"]);
        Validator::productType($_POST["productType"]);
        if ($_POST["productType"] == "dvd") Validator::size($_POST["size"]);
        if ($_POST["productType"] == "book") Validator::weight($_POST["weight"]);
       // if ($_POST["productType"] == "furniture") Validator::dims($_POST["dims"]); might correct later
    } catch (sku\characterAmount | sku\correctSymbols | name\characterAmount | name\correctSymbols | price\correctSymbols | productType\isEmpty | size\correctSymbols | weight\correctSymbols | dims\correctSymbols $e) {
        require 'index.php';
        $val_out = $e->errorMessage();
        echo htmlspecialchars($val_out);
        die();
    }
    $db = new mysqli('localhost', 'root', '', 'scanditest') 
    or die('U fail!');

    $skuChecker = "SELECT sku FROM products";
    $existingSku = $db->query($skuChecker);
    if ($existingSku->num_rows > 0) {
        while($row = $existingSku->fetch_assoc()) {
            if($_POST["sku"] == $row["sku"]) {
                require 'index.php';
                echo "Whoops, this sku already is occupied!";
                die();
            }
        }
    } 
    $db->close();
}

function beautify() {
    $price = $_POST['price'];
    (float) $price;

    if($_POST["productType"] == "dvd") {
        $size = $_POST['size'];
        (float) $size;
    }
    if($_POST["productType"] == "book") {
        $weight = $_POST['weight'];
        (float) $weight;
    }
    if($_POST["productType"] == "futniture") {
        $h = $_POST['h'];
        $w = $_POST['w'];
        $l = $_POST['l'];
        (float) $h;
        (float) $w;
        (float) $l;
    }


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

validate();
beautify();


switch ($_POST["productType"]) {
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

