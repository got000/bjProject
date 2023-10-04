<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = $_SESSION["emp_id"];
    $id = $_POST["order_id"];
    $cus_id = $_POST["cus_id"];
}
?>
<!-- PROCESS -->
<?php
$sql = "UPDATE orders SET order_status = 3, emp_id='" . $emp_id . "' WHERE id='" . $id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION['approve_wait'] == "success";
    $eq_id = uniqid("INSTALLATION-" . date("Y-m-d") . "-", false);
    $_sql = "INSERT INTO installation(eq_id, eq_status, cus_id, order_id) VALUES ('" . $eq_id . "', '1', '" . $cus_id . "', '" . $id . "')";
    $_query = mysqli_query($con, $_sql);
    header("location: ../order_approve.php");
    exit;
}
$_SESSION['approve_wait'] == "failed";
header("location: ../order_approve.php");
exit;
?>