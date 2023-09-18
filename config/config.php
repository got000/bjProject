<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "shop";

    $con = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    mysqli_set_charset($con, "utf8");
?>