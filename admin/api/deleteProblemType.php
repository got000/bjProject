<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
}
?>
<!-- PROCESS -->
<?php
$sql = "DELETE FROM problem_type WHERE id='" . $id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["deleteProblemType"] = "success";
    header("location: ../problem_type.php");
    exit;
}
$_SESSION["deleteProblemType"] = "error";
header("location: ../problem_type.php");
exit;
?>