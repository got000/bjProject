<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $protype_id = $_POST['protype_id'];
        $protype_name =   $_POST['protype_name'];
    }
?>
<?php
    //process
    $_SESSION["productTypeHeader"] = "เพิ่ม";
    $sql_select = "SELECT * FROM product_type WHERE protype_id='".$protype_id."'";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $_SESSION["addProductType"] = "duplicate";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../product_type.php'>";
        exit(0);
    }

    $sql = "INSERT INTO product_type (protype_id, protype_name) VALUES('".$protype_id."', '".$protype_name."')";
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