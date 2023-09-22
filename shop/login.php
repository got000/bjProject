<?php
@session_start();
@header("content-type:application/json;charset=utf-8");
@header('Content-Type: text/html; charset=UTF-8');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
include("./../../config/config.php");
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username =   $_POST['username'];
    $password =   md5($_POST['password']);
}
?>
<?php
$_SESSION["loginHeader"] = "เข้าสู่ระบบ";
$sql = "SELECT * FROM customers WHERE cus_tel='" . $username . "' LIMIT 1";
$query = mysqli_query($con, $sql);
if ($query) {
    $fetch = mysqli_fetch_assoc($query);
    if ($fetch["cus_password"] !== $password) {
        $_SESSION["login"] = "error";
        header("location: index.php");
        exit;
    }

    $_SESSION["login"] = "success";
    header("location: index.php");
    exit;
}

$_SESSION["login"] = "error";
header("location: index.php");
exit;
?>