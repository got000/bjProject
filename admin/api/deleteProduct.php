<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST["id"];
        $pro_image = $_POST["pro_image"];
    }
?>
<?php
    //process
    $_SESSION["productHeader"] = "ลบ";
    $sql = "DELETE FROM products WHERE id='".$id."'";
    $query = mysqli_query($con, $sql);
    if($query){
        unlink("../uploads/" . $pro_image);
        $_SESSION["addProduct"] = "success";
        header("location: ../products.php");
        exit;
    }else{
        $_SESSION["addProduct"] = "error";
        header("location: ../products.php");
        exit;
    }
?>