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
        echo "Sku: " . $this->sku . " " . "<br>" . "Name: " . $this->name . "<br>" . "Price: " . $this->price . "<br>";
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
        echo "Size: " . $this->size;
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
        echo "Weight: " . $this->weight;
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
    }

    function print() {
        parent::print();
        echo "Dimensions: " . $this->h . "x" . $this->w . "x" . $this->l;
    }
}
?>
















<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="script.js"></script>
        <title>Product view</title>
        <link rel="stylesheet" href="viewStyle.css" />
    </head>
    <body>
        <div class="topbar">
            <h1> <strong>Product List</strong></h1>

            <div class="topRight">
                <form method="POST" id="stuff" action="./removeRecords.php">
                    <select onchange="checkboxes()" class="topElem" id="switch">
                        <option style="display:none"></option>
                        <option value="dvd">DVD</option>
                        <option value="book">Book</option>
                        <option value="furniture">Furniture</option>
                        <option value="all">All</option>
                        <option value="deselect">Deselect all</option>
                    </select>
                </form>
                <button class="topElem" id="applyBtn" onclick="submit()">Remove records</button>      
            </div>
        </div>

        <hr>

        <div class="productGrid">

















<?php
$selectAll = "SELECT products.*, dvd_attr.*, book_attr.*, furniture_attr.* FROM products
LEFT OUTER JOIN dvd_attr ON products.sku = dvd_attr.sku_d
LEFT OUTER JOIN book_attr ON products.sku = book_attr.sku_b
LEFT OUTER JOIN furniture_attr ON products.sku = furniture_attr.sku_f";

$result=$db->query($selectAll);
if ($result->num_rows >0) {
    while($row = $result->fetch_assoc()) {

        switch ($row["type"]) {
            case 'D':
                unset($item);
                $item = new dvd($row["sku"], $row["name"], $row["price"], $row["size"]);
                ?>


                <div class="product">
                    <input type="checkbox" name="dvdC" class="ch">

                    <?php
                    $item->print();
                    ?>

                </div>

                <?php

                break;
            
            case 'B':
                unset($item);
                $item = new book($row["sku"], $row["name"], $row["price"], $row["weight"]);
                ?>
                <div class="product">
                    <input type="checkbox" name="bookC" class="ch">

                <?php
                $item->print();
                ?>

                </div>

                <?php
                break;

            case 'F':
                unset($item);
                $item = new furniture($row["sku"], $row["name"], $row["price"], $row["h"], $row["w"], $row["l"]);
                ?>
                
                <div class="product">
                    <input type="checkbox" name="furnC" class="ch"> 
                
                <?php
                $item->print();
                ?>


                </div>

                <?php
                break;
        }
    }
}
else echo "You don't have nothing to output";

?>





        </div> 
    </body>
</html>