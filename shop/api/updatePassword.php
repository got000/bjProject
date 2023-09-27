<?php
@header("content-type:application/json;charset=utf-8");
@header('Content-Type: text/html; charset=UTF-8');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
include("./../../config/config.php");
@session_start();
?>

<?php
// INPUT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cus_id = $_SESSION['cus_id'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
}
?>

<?php
// PROCESS
if(strlen($_POST['newPassword']) < 6){
    $_SESSION['editPassword'] = "password_minimum_six";
    header("location: ./../../edit_password.php");
    exit;
}
if ($newPassword != $confirmPassword) {
    $_SESSION["editPassword"] = "not_matching";
    exit;
}
$hashPassword = md5($newPassword);
$sql = "UPDATE customers SET cus_password='" . $hashPassword . "' WHERE cus_id='" . $cus_id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["editPassword"] = "success";
    header("location: ./../../edit_password.php");
    exit;
}

$_SESSION["editPassword"] = "error";
header("location: ./../../edit_password.php");
exit;

?>