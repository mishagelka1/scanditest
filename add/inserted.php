<?php

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Queries inserted</title>
    </head>
    <body>
        <button id="goback">Return to product add</button>
        <button id="gohome">Return to home</button>
        <button id="goview">View products</button>

        <script type="text/javascript">
            document.getElementById("goback").onclick = function () {
                location.href = "/add";
            };
            
            document.getElementById("gohome").onclick = function () {
                location.href = "/";
            };

            document.getElementById("goview").onclick = function () {
                location.href = "/view";
            };
        </script>
    </body>

</html>