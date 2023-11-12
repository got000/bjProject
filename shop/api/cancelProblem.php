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
       $id = $_POST["order_id"];
    }
?>
<?php
$sql = "UPDATE orders SET order_status=9 WHERE id='".$id."' AND order_type = 2";
$query = mysqli_query($con, $sql);
if ($query) {
  $_SESSION["cancel_order"] = 'success';
  header("location: ../problem_history.php");
  exit;
}
$_SESSION["cancel_order"] = 'failed';
  header("location: ../problem_history.php");
  exit;
?>