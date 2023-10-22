<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../js/js_bootstrap.php");
?>

<?php 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <h1>Report Problem</h1>
    </div>

</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>

</html>