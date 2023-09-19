<?php
include("./header.php");
@session_start();
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pro_id = $_POST['pro_id'];
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
$sql_select = "SELECT * FROM products WHERE pro_id='" . $pro_id . "'";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $_SESSION["addProduct"] = "duplicate";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
    exit(0);
}
$targetFile = "../uploads/" . basename($pro_image);
$allowed_extension = array('gif', 'png', 'jpg', 'jpeg');
$file_extension = pathinfo($targetFile, PATHINFO_EXTENSION);

if (!in_array($file_extension, $allowed_extension)) {
    $_SESSION["addProduct"] = "imageType_error";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
    exit(0);
} else {
    if (file_exists("../uploads/" . $pro_image)) {
        $_SESSION["addProduct"] = "image_duplicate";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
        exit(0);
    } else {
        $sql = "INSERT INTO products (pro_id, pro_name, pro_amount, pro_price, pro_detail, pro_image, protype_id) 
         VALUES('" . $pro_id . "', '" . $pro_name . "', '" . $pro_amount . "', '" . $pro_price . "', '" . $pro_detail . "', '" . $pro_image . "', '" . $protype_id . "')";
        $query = mysqli_query($con, $sql);
        if ($query) {
            move_uploaded_file($tmp_image, $targetFile);
            $_SESSION["addProduct"] = "success";
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
            exit(0);
        } else {
            $_SESSION["addProduct"] = "error";
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../products.php'>";
            exit(0);
        }
    }
}
?>