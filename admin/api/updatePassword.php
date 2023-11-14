<?php
include("./header.php");
@session_start();
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Change  $_POST TO $_SESSION
    $emp_id = $_SESSION['emp_id'];
    // $currentPassword = $_POST["emp_password"];
    $newPassword = $_POST["emp_newPassword"];
    $confirmPassword = $_POST["emp_confirmPassword"];
}
?>
<?php
//process
$_SESSION["employeeHeader"] = "แก้ไข";
$sql_select = "SELECT * FROM employees WHERE emp_id = '" . $emp_id . "' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
$select_password = mysqli_fetch_assoc($result_select);
$data_pwd = $select_password['emp_password'];

if ($data_pwd != "") {
    if ($newPassword == $confirmPassword) {
        $hashPassword = md5($newPassword);
        $sql = "UPDATE employees set emp_password = '" . $hashPassword . "' WHERE emp_id = '" . $emp_id . "'";
        $query = mysqli_query($con, $sql);
        if ($query){
            $_SESSION["changePassword"] = "success";
            header("location:../employeePassword.php");
            exit;
        }else {
            $_SESSION["changePassword"] = "error";
            header("location:../employeePassword.php");
            exit;
        }
    }else {
        $_SESSION["comparePassword"] = "error";
        header("location:../employeePassword.php");
        exit;
    }
}else {
    $_SESSION["changePassword"] = "error";
    header("location:../employeePassword.php");
    exit;
}
?>