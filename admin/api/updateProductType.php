<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $protype_id = $_POST['protype_id'];
        $protype_name =   $_POST['protype_name'];
    }
?>
<?php
    //process
    $_SESSION["productTypeHeader"] = "แก้ไข";
    $sql_select = "SELECT * FROM product_type WHERE protype_id='".$protype_id."' LIMIT 1";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $fetch = mysqli_fetch_assoc($result_select);
        $idS = $fetch["protype_id"];

        if($idS != $protype_id){
            $_SESSION["addProductType"] = "duplicate";
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../product_type.php'>";
            exit(0);
        }
        
    }

    $sql = "UPDATE product_type SET protype_id='".$protype_id."', protype_name='".$protype_name."' WHERE id='".$id."'";
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