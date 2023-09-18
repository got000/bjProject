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
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../product_type.php'>";
        exit(0);
    }else{
        $_SESSION["addProductType"] = "error";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../product_type.php'>";
        exit(0);
    }
?>