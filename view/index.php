<?php

$db = new mysqli('localhost', 'root', '', 'scanditest') // connection to the database
or die("U failed"); 

 
class Item {
    protected $sku, $name, $price, $type;
    function __construct($i_sku, $i_name, $i_price) { // constructor for the products
        $this->sku = $i_sku;
        $this->name = $i_name;
        $this->price = $i_price;
    }

    function print() { // Function to print common product attributes
        echo "<br>" . "Name: " . $this->name . "<br>" . "Price: " . $this->price . "<br>";
    }
    
    function printSku() { // function to print only product's sku
        echo $this->sku;
    }
}

class dvd extends Item { // subclass that adds a dvd attribute to the object
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

class book extends Item { // subclass that adds a furniture attribute to the object
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

class furniture extends Item { // subclass that adds a furniture attributes to the object
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
                <form id="stuff">
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
                <button class="topElem" id="goHome">Home</button>
                <script type="text/javascript">
                    // a button that is there for navigation purposes
                    document.getElementById("goHome").onclick = function () {
                    location.href = "/";
                    };
                </script>      
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

        switch ($row["type"]) { // depending on the type of the returned object, the corresponding elements are being created
            case 'D':
                unset($item);
                $item = new dvd($row["sku"], $row["name"], $row["price"], $row["size"]);
                ?>


                <div class="product" onclick="checkTheBox(this.childNodes[1])">
                    <input type="checkbox" onclick="checkTheBox(this)" name="dvdC" class="ch">
                    <p class="SkuP">Sku: </p>
                    <div class="skuDiv"><?php $item->printSku()  //I decided to print the sku separately, for it to be easier to find later?></div>

                    <?php
                    $item->print(); // here the rest of the product is printed
                    ?>

                </div>

                <?php

                break;
            
            case 'B':
                unset($item);
                $item = new book($row["sku"], $row["name"], $row["price"], $row["weight"]);
                ?>
                <div class="product" onclick="checkTheBox(this.childNodes[1])">
                    <input type="checkbox" onclick="checkTheBox(this)" name="bookC" class="ch">
                    <p class="skuP">Sku: </p>
                    <div class="skuDiv"><?php $item->printSku() ?></div>

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
                
                <div class="product" onclick="checkTheBox(this.childNodes[1])">
                    <input type="checkbox" onclick="checkTheBox(this)" name="furnC" class="ch">
                    <p class="skuP">Sku: </p>
                    <div class="skuDiv"><?php $item->printSku() ?></div> 
                
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
        <div id="artificialForm"><!-- This div is used for the mass delete action purposes. Here, the artifficial form is created and posted to the database with a delete action --> </div>
    </body>
</html>