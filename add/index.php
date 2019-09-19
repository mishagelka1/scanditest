<?php

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="addStyle.css">
        <!--script src="..jquery.js"></script-->
        <script src="./script.js"></script>
    </head>
    <body>
        <div class="pageContent">
            <div class="topbar">
                <h1>Product add</h1>
            </div>

            <form id="form" class="addForm" action="validate.php"/>
                <p>SKU</p> 
                <input oninput="handleInput(this)" class="attr" type="text" name="sku" placeholder="SKU">
                <p>Name</p> 
                <input oninput="handleInput(this)" class="attr" type="text" name="name" placeholder="Name">
                <p>Price</p>
                <input oninput="handleInput(this)" class="attr" type="text" name="price" placeholder="Price">

                <p>Type switcher</p>
                <select oninput="handleInput(this)" class="attr" name="productType" id="switch">
                    <option style="display:none"></option>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>

                </select>
            </form>
            <button onClick="submit()" id="applyBtn">Apply</button>
        </div>
    </body>
</html>