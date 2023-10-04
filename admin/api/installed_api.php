<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = $_SESSION["emp_id"];
    $id = $_POST["order_id"];
}
?>
<!-- PROCESS -->
<?php
$sql = "UPDATE orders SET order_status = 4, emp_id='".$emp_id."' WHERE id='".$id."'";
$query = mysqli_query($con, $sql);
if ($query){
    $_sql = "UPDATE installation SET eq_status = 2 WHERE order_id='" . $id . "'";
    $_query = mysqli_query($con, $_sql);
    if ($_query) {
        $_SESSION["approve_installation"] = "success";
        header("location: ../wait_install.php");
        exit;
    }
}
$_SESSION["approve_installation"] = "failed";
header("location: ../wait_install.php");
exit;
?>