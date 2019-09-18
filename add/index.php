<?php

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="addStyle.css">
    </head>
    <body>
        <div class="pageContent">
            <div class="topbar">
                <h1>Product add</h1>
                <button id="applyBtn" type="submit">Apply</button>
                <hr>
            </div>

            <form class="addForm" action="">
                SKU 
                <input type="text" name="sku" placeholder="SKU">
                Name 
                <input type="text" name="name" placeholder="Name">
                Price
                <input type="text" name="price" placeholder="Price">

                Type switcher
                <select name="productType" id="switch">
                    <option style="display:none"></option>
                    <option value="DVD">DVD</option>
                    <option value="Book">Book</option>
                    <option value="Furniture">Furniture</option>
                </select>
                <button type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>