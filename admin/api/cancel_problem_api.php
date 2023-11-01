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
$sql = "UPDATE orders SET order_status=99, emp_id='" . $emp_id . "'WHERE id='".$id."'";
$query = mysqli_query($con, $sql);
if ($query) {
  $_SESSION["cancel_problem"] = 'success';
  header("location: ../problem_cancel.php");
  exit;
}
$_SESSION["cancel_problem"] = 'failed';
  header("location: ../problem_cancel.php");
  exit;
?>