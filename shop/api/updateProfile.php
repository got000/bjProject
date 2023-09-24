<?php 
include("./header.php");
@session_start();
?>

<?php 
// INPUT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cus_id = $_SESSION['cus_id'];
    $fname =   $_POST['fname'];
    $lname =   $_POST['lname']; 
    $password =   $_POST['password']; 
    $tel =   $_POST['tel'];
    $province =   $_POST['province'];
    $amphur =   $_POST['amphur'];
    $district =   $_POST['district'];
    $zip_code =   $_POST['zip_code'];
    $fullname = $fname." ".$lname;
}
?>

<?php 
// PROCESS
$sql_select = "SELECT * FROM customers WHERE cus_id='".$cus_id."' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $fetch = mysqli_fetch_assoc($result_select);
    $idS = $fetch["cus_tel"];

    if($idS != $tel){
        $_SESSION["editProfile"] = "duplicate";
        header("location: edit_profile.php");
        exit;
    }
}
$sql = "UPDATE customers SET cus_name='".$fullname."', cus_pass='".$password."', cus_tel='".$tel."', cus_province='".$province."', cus_amphur='".$amphur."', cus_district='".$district."', cus_zip_code='".$zip_code."' WHERE id='".$id."'";
$query = mysqli_query($con, $sql);
if($query){
    $_SESSION["editProfile"] = "success";
    header("location: edit_profile.php");
    exit;
}

$_SESSION["editProfile"] = "error";
header("location: edit_profile.php");
exit;
?>