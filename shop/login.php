<?php
@session_start();
@header("content-type:application/json;charset=utf-8");
@header('Content-Type: text/html; charset=UTF-8');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
include("./../config/config.php");
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username =   $_POST['username'];
    $password =   md5($_POST['password']);
}
?>
<?php
$sql = "SELECT * FROM customers WHERE cus_tel='".$username."' LIMIT 1";
$query = mysqli_query($con, $sql);
if ($query) {
    $fetch = mysqli_fetch_assoc($query);
    if ($fetch["cus_password"] !== $password) {
        $_SESSION["login"] = "error";
        header("location: index.php");
        exit;
    }
    $_SESSION["carts"] = [];
    $_SESSION["login"] = "success";
    $_SESSION["cus_id"] = $fetch["cus_id"];
    $_SESSION["cus_name"] = $fetch["cus_name"];
    $_SESSION["cus_tel"] = $fetch["cus_tel"];
    $_SESSION["cus_province"] = $fetch["cus_province"];
    $_SESSION["cus_amphur"] = $fetch["cus_amphur"];
    $_SESSION["cus_district"] = $fetch["cus_district"];
    $_SESSION["cus_zip_code"] = $fetch["cus_zip_code"];
    header("location: index.php");
    exit;
}

$_SESSION["login"] = "error";
header("location: index.php");
exit;
?>