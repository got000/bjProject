<?php
include("./header.php");
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
$sql_select = "SELECT * FROM customers WHERE cus_id='" . $cus_id . "' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
$select_password = mysqli_fetch_assoc($result_select);
$data_pwd = $select_password['cus_pass'];

if ($data_pwd != "") {
    if ($newPassword == $confirmPassword) {
        $hashPassword = md5($newPassword);
        $sql = "UPDATE customers SET cus_pass='" . $hashPassword . "' WHERE cus_id='" . $cus_id . "'";
        $query = mysqli_query($con, $sql);
        if ($query) {
            $_SESSION["editPassword"] = "success";
            header("location: ./edit_password.php");
            exit;
        }
    }
}

$_SESSION["editPassword"] = "error";
header("location: ./edit_password.php");
exit;

?>