<?php 
    include("./header.php");
    @session_start();
?>
<!-- INPUT -->
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $probType_name =   $_POST['name'];
        $probType_detail =   $_POST['detail'];
    }
?>
<!-- PROCESS -->
<?php
$sql_select = "SELECT * FROM problem_type WHERE probType_name='".$probType_name."'";
$result_select = mysqli_query($con,$sql_select);
if($result_select->num_rows > 0){
    $_SESSION["addEmployee"] = "duplicate";
    header("location:../problem_type.php");
    exit;
}

$probType_id = uniqid("Problem-Type-",false); 
$sql = "INSERT INTO problem_type (probType_id, probType_name, probType_detail) VALUES ('".$probType_id."', '".$probType_name."', '".$probType_detail."')";
$query = mysqli_query($con, $sql);
if ($query){
    $_SESSION["addProblemType"] = "success";
    header("location: ../problem_type.php");
    exit;
}
$_SESSION["addProblemType"] = "error";
header("location: ../problem_type.php");
exit;
?>