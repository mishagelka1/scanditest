<?php
    $db = new mysqli('localhost', 'root', '', 'scanditest') 
    or die('Error while connecting yo the database');
?>


<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="startStyle.css">
    </head>

    <body>
        <h1 id="choose">Choose one</h1>
        <div class="pageContent">
            <div class="buttons">
                <form action="/add">
                    <button class="button" type="submit">Add product</button>
                </form>
                <form action="/view">
                    <button class="button" type="submit">View products</button>
                </form>
            </div>
        </div>
    </body>
</html>