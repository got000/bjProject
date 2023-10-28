<?php
include("./header.php");
@session_start();
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $pro_id = $_POST['pro_id'];
    $pro_name =   $_POST['pro_name'];
    $pro_amount =   $_POST['pro_amount'];
    $pro_price =   $_POST['pro_price'];
    $pro_detail = $_POST['pro_detail'];
    $pro_image = $_FILES['pro_image']['name'];
    $tmp_image = $_FILES['pro_image']['tmp_name'];
    $protype_id =   $_POST['protype_id'];
}
?>
<?php
//process
$_SESSION["productHeader"] = "เพิ่ม";
$sql_select = "SELECT * FROM products WHERE pro_name='" . $pro_name . "'";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $_SESSION["addProduct"] = "duplicate";
    header("location: ../products.php");
    exit;
}
$targetFile = "../uploads/" . basename($pro_image);
$allowed_extension = array('gif', 'png', 'jpg', 'jpeg');
$file_extension = pathinfo($targetFile, PATHINFO_EXTENSION);
if (!in_array($file_extension, $allowed_extension)) {
    $_SESSION["addProduct"] = "imageType_error";
    header("location: ../products.php");
    exit;
} else {
    if (file_exists("../uploads/" . $pro_image)) {
        $_SESSION["addProduct"] = "image_duplicate";
        header("location: ../products.php");
        exit;
    } else {
        $uniqueID = substr(uniqid(rand(), true), 13, 13); // 13 characters long
        $sql = "INSERT INTO products (pro_id, pro_name, pro_amount, pro_price, pro_detail, pro_image, protype_id) 
         VALUES('" . $uniqueID . "', '" . $pro_name . "', '" . $pro_amount . "', '" . $pro_price . "', '" . $pro_detail . "', '" . $pro_image . "', '" . $protype_id . "')";
        $query = mysqli_query($con, $sql);
        if ($query) {
            move_uploaded_file($tmp_image, $targetFile);
            $_SESSION["addProduct"] = "success";
            header("location: ../products.php");
            exit;
        } else {
            $_SESSION["addProduct"] = "error";
            header("location: ../products.php");
            exit;
        }
    }
}
?>