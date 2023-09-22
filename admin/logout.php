<?php 
    @date_default_timezone_set("Asia/Bangkok");
    session_start();
    session_destroy();
    header("location:./index.php");
    exit;
?>