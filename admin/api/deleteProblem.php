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
$sql = "DELETE FROM problems WHERE id='" . $id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["deleteProblem"] = "success";
    header("location: ../problems.php");
    exit;
}
$_SESSION["deleteProblem"] = "error";
header("location: ../problems.php");
exit;
?>