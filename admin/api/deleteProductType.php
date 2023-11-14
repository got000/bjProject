<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST["id"];
    }
?>
<?php
    //process
    $_SESSION["productTypeHeader"] = "ลบ";
    $sql = "DELETE FROM product_type WHERE id='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query){
        $_SESSION["addProductType"] = "success";
        header("location: ../product_type.php");
        exit;
    }else{
        $_SESSION["addProductType"] = "error";
        header("location: ../product_type.php");
        exit;
    }
?>