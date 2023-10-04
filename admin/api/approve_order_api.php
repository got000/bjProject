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
$sql = "UPDATE orders SET order_status=2, emp_id='" . $emp_id . "' WHERE id='".$id."'";
$query = mysqli_query($con, $sql);
if ($query) {
  $_SESSION["approve_order"] = 'success';
  header("location: ../wait_approve.php");
  exit;
}
$_SESSION["approve_order"] = 'failed';
  header("location: ../wait_approve.php");
  exit;
?>