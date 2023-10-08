<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prob_name =   $_POST['name'];
    $prob_detail =   $_POST['detail'];
    $prob_price =   $_POST['price'];
    $prob_discount =   $_POST['discount'];
    $probType_id =   $_POST['probType_id'];
}
?>

<!-- PROCESS -->
<?php
$prob_id = uniqid("Problem-", false);
$sql = "INSERT INTO problems(prob_id, prob_name, prob_detail, prob_price, prob_discount, probType_id) VALUES ('" . $prob_id . "', '" . $prob_name . "', '" . $prob_detail . "', '".$prob_price."', '".$prob_discount."', '" . $probType_id . "')";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["addProblem"] = "success";
    header("location: ../problems.php");
    exit;
}
$_SESSION["addProblem"] = "error";
header("location: ../problems.php");
exit;
?>