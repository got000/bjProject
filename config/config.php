<?php 
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "senior_project";

    $con = new mysqli($host, $user, $pass, $db);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    mysqli_set_charset($con, "utf8");
?>