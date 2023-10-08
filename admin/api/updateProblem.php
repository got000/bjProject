<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $prob_id = $_POST["prob_id"];
    $prob_name = $_POST['name'];
    $prob_detail = $_POST['detail'];
    $prob_price =   $_POST['price'];
    $prob_discount =   $_POST['discount'];
    $probType_id = $_POST['probType_id'];
}
?>
<!-- PROCESS -->
<?php 
// SELECT
$select = "SELECT * FROM problems WHERE id='".$id."' LIMIT 1";
$query_select = mysqli_query($con, $select);
if ($query_select->num_rows > 0){
    $fetch = mysqli_fetch_assoc($query_select);
    $idS = $fetch["prob_id"];

    if($idS != $prob_id){
        $_SESSION["updateProblem"] = "duplicate";
        header("location: ../problems.php");
        exit;
    }
}
// UPDATE
$sql = "UPDATE problems SET prob_name='".$prob_name."', prob_detail='".$prob_detail."', prob_price='".$prob_price."', prob_discount='".$prob_discount."', probType_id='".$probType_id."' WHERE id='".$id."'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["updateProblem"] = "success";
    header("location: ../problems.php");
    exit;
}
$_SESSION["updateProblem"] = "error";
header("location: ../problems.php");
exit;
?>