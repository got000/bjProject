<?php 
@header("content-type:application/json;charset=utf-8");
@header('Content-Type: text/html; charset=UTF-8');
@header("Access-Control-Allow-Origin: *");
@header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
include("./../../config/config.php");
@session_start();
?>

<?php 
// INPUT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cus_id = $_SESSION['cus_id'];
    $fname =   $_POST['fname'];
    $lname =   $_POST['lname'];
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
        header("location: ./../../edit_profile.php");
        exit;
    }
}
$sql = "UPDATE customers SET cus_name='".$fullname."', cus_tel='".$tel."', cus_province='".$province."', cus_amphur='".$amphur."', cus_district='".$district."', cus_zip_code='".$zip_code."' WHERE cus_id='".$cus_id."'";
$query = mysqli_query($con, $sql);
if($query){
    $_SESSION["cus_name"] = $fullname;
    $_SESSION["cus_tel"] = $tel;
    $_SESSION["cus_province"] = $province;
    $_SESSION["cus_amphur"] = $amphur;
    $_SESSION["cus_district"] = $district;
    $_SESSION["cus_zip_code"] = $zip_code;
    $_SESSION["editProfile"] = "success";
    header("location: ./../../edit_profile.php");
    exit;
}

$_SESSION["editProfile"] = "error";
header("location: ./../../edit_profile.php");
exit;
?>