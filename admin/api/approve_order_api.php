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
$sql = "UPDATE orders SET order_status=2, emp_id='" . $emp_id . "' WHERE id='" . $id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
  // Insert receipt and gen id Receipt-
  $_SESSION["approve_problem"] = 'success';
  $receipt_id = uniqid("Receipt-", false);
  $_sql = "INSERT INTO receipt (receipt_id, order_id) VALUES('" . $receipt_id . "', '" . $id . "')";
  $_query = mysqli_query($con, $_sql);
  header("location: ../wait_approve.php");
  exit;
}
$_SESSION["approve_order"] = 'failed';
header("location: ../wait_approve.php");
exit;
?>