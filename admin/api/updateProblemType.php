<?php
include("./header.php");
@session_start();
?>
<!-- INPUT -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $probType_name =   $_POST['name'];
    $probType_detail =   $_POST['detail'];
}
?>
<!-- PROCESS -->
<?php
// SELECT
$sql_select = "SELECT * FROM problem_type WHERE id='" . $id . "' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $fetch = mysqli_fetch_assoc($result_select);
    $idS = $fetch["id"];

    if ($idS != $id) {
        $_SESSION["updateProblemType"] = "duplicate";
        header("location: ../problem_type.php");
        exit;
    }
}
// UPDATE
$sql = "UPDATE problem_type SET probType_name='" . $probType_name . "', probType_detail='" . $probType_detail . "'WHERE id='" . $id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    $_SESSION["updateProblemType"] = "success";
    header("location: ../problem_type.php");
    exit;
}
$_SESSION["updateProblemType"] = "error";
header("location: ../problem_type.php");
exit;
?>