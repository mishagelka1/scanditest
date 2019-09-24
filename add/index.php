<?php

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="addStyle.css">
        <!--script src="..jquery.js"></script-->
        <script src="script.js"></script>
    </head>
    <body>
        <div class="pageContent" id="pageCont">
            <div class="topbar">
                <h1>Product add</h1>
            </div>

            <form id="form" method="POST" class="addForm" action="./validate.php">
                <p>SKU</p> 
                <input class="attr" type="text" name="sku" placeholder="SKU">
                <p>Name</p> 
                <input class="attr" type="text" name="name" placeholder="Name">
                <p>Price</p>
                <input class="attr" type="text" name="price" placeholder="Price">

                <p>Type switcher</p>
                <select onchange="dynamicChange()" class="attr" name="productType" id="switch">
                    <option style="display:none"></option>
                    <option value="dvd">DVD</option>
                    <option value="book">Book</option>
                    <option value="furniture">Furniture</option>
                </select>
            </form>
            <button onClick="submit()" id="applyBtn">Apply</button>
        </div>
    </body>
</html>