<?php

$db = new mysqli('localhost', 'root', '', 'scanditest')
or die("Fekd up");
 
class Item {
    protected $sku, $name, $price, $type;
    function __construct($i_sku, $i_name, $i_price) {
        $this->sku = $i_sku;
        $this->name = $i_name;
        $this->price = $i_price;
    }

    function print() {
        echo "Sku: " . $sku . "<br>" . "Name: " . $name . "<br>" . "Price: " . $price . "<br>";
    }
}

class dvd extends Item {
    public $size;
    function __construct($i_sku, $i_name, $i_price, $i_size) {
        parent::__construct($i_sku, $i_name, $i_price);
        $this->size = $i_size;
        $this->type = 'D';
    }

    function print() {
        parent::print();
        echo "Size: " . $size;
    }
}

class book extends Item {
    public $weight; 
    function __construct($i_sku, $i_name, $i_price, $i_weight) {
        parent::__construct($i_sku, $i_name, $i_price);
        $this->weight = $i_weight;
        $this->type = 'B';
    }

    function print() {
        parent::print();
        echo "Weight: " . $weight;
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
    }

    function print() {
        parent::print();
        echo "Dimensions: " . $h . "x" . $w . "x" . $l;
    }
}

$selectAll = "SELECT products.*, dvd_attr.*, book_attr.*, furniture_attr.* FROM products
LEFT OUTER JOIN dvd_attr ON products.sku = dvd_attr.sku
LEFT OUTER JOIN book_attr ON products.sku = book_attr.sku
LEFT OUTER JOIN furniture_attr ON products.sku = furniture_attr.sku";

$result=$db->query($selectAll);
if ($result->num_rows >0) {
    while($row = $result->fetch_assoc()) {

        switch ($row["type"]) {
            case 'D':
                unset($item);
                $item = new dvd($row["sku"], $row["name"], $row["price"], $row["size"]);
                $item->print();
                break;
            
            case 'B':
                unset($item);
                $item = new book($row["sku"], $row["name"], $row["price"], $row["weight"]);
                $item->print();
                break;

            case 'F':
                unset($item);
                $item = new furniture($row["sku"], $row["name"], $row["price"], $row["h"], $row["w"], $row["l"]);
                $item->print();
                break;
        }
    }
}
else echo "You don't have nothing to output";



?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product view</title>
        <link rel="stylesheet" href="viewStyle.css" />
    </head>
    <body>
        <div class="topbar">
            <h2>Product List</h2>

            <div class="topRight">
                <form>
                    <select class="topElem" id="switch">
                        <option style="display:none"></option>
                        <option value="dvd">DVD</option>
                        <option value="book">Book</option>
                        <option value="furniture">Furniture</option>
                    </select>
                </form>
                <button class="topElem" id="applyBtn">Apply</button>      
            </div>
        </div>

        <hr>

        <div class="productGrid">
            <div class="product">
                <?php
                    $selectDvds = "SELECT products.sku, products.name, products.price, dvd_attr.size 
                    FROM products WHERE type=d
                    JOIN dvd_attr ON products.sku=dvd_attr.sku";
                    $result = $db->query($selectDvds);
                    if($result->num_rows >0) {
                        while($row = $result->fetch_assoc()) {
                            echo "sku: " . $row["sku"] . " name: " . $row["name"] . " price: " . $row["price"] . " size: " . $row["size"] . "<br>";
                        }
                    }
                    else echo "You don't have dvd's";
                ?>
            </div>
        </div> 
    </body>
</html>