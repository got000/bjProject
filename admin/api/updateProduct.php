<?php
include("./header.php");
@session_start();
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $pro_id = $_POST['pro_id'];
    $pro_name =   $_POST['pro_name'];
    $pro_amount =   $_POST['pro_amount'];
    $pro_price =   $_POST['pro_price'];
    $pro_detail =   $_POST['pro_detail'];
    $pro_image = $_FILES['pro_image']['name'];
    $pro_image_old = $_POST['pro_image_old'];
    $protype_id =   $_POST['protype_id'];
}
?>
<?php
//process
$_SESSION["productHeader"] = "แก้ไข";
$sql_select = "SELECT * FROM products WHERE pro_id='" . $pro_id . "' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $fetch = mysqli_fetch_assoc($result_select);
    $idS = $fetch["pro_id"];

    if ($idS != $pro_id) {
        $_SESSION["addProduct"] = "duplicate";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
        exit(0);
    }
}

if ($pro_image != "") {
    $update_fileName = $pro_image;
} else {
    $update_fileName = $pro_image_old;
}

if ($pro_image != "") {
    if (file_exists("../uploads/" . $pro_image)) {
        $_SESSION["addProduct"] = "image_duplicate";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
        exit(0);
    }
} else {
    // Updating 
    $targetFile = "../uploads/" . basename($pro_image);
    $sql = "UPDATE products SET pro_id='" . $pro_id . "', pro_name='" . $pro_name . "', pro_amount='" . $pro_amount . "', pro_price='" . $pro_price . "', pro_detail='" . $pro_detail . "', pro_image = '" . $update_fileName . "',  protype_id='" . $protype_id . "' WHERE id='" . $id . "'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        if ($pro_image != "") {
            // Move image to file 
            move_uploaded_file($_FILES['pro_image']['tmp_name'], $targetFile);
            // Delete image old
            unlink("../uploads/" . $pro_image_old);
        }
        $_SESSION["addProduct"] = "success";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
        exit(0);
    } else {
        $_SESSION["addProduct"] = "error";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
        exit(0);
    }
}
?>