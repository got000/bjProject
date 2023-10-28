<?php
include("./header.php");
@session_start();
?>
<?php
//input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stru_id = $_POST['stru_id'];
    $stru_name =   $_POST['stru_name'];
    $stru_logo =   $_FILES['stru_logo']['name'];
    $stru_logo_old =   $_POST['stru_logo_old'];
    $stru_ann =   $_POST['stru_ann'];
    $stru_add =   $_POST['stru_add'];
}
?>
<?php
//process
$_SESSION["systemHeader"] = "แก้ไข";
$sql_select = "SELECT * FROM systems WHERE stru_id='" . $stru_id . "' LIMIT 1";
$result_select = mysqli_query($con, $sql_select);
if ($result_select->num_rows > 0) {
    $fetch = mysqli_fetch_assoc($result_select);
    $idS = $fetch["stru_id"];

    if ($idS != $stru_id) {
        $_SESSION["updateSystem"] = "duplicate";
        header("location: ../system.php");
        exit;
    }
}

if ($stru_logo != "") {
    $updateLogo = $stru_logo;
} else {
    $updateLogo = $stru_logo_old;
}

$targetFile = "../uploads/systems/" . basename($stru_logo);
$sql = "UPDATE systems SET stru_name='" . $stru_name . "', stru_logo='" . $updateLogo . "', stru_ann='" . $stru_ann . "', stru_add='" . $stru_add . "' WHERE stru_id='" . $stru_id . "'";
$query = mysqli_query($con, $sql);
if ($query) {
    if ($stru_logo != "") {
        move_uploaded_file($_FILES['stru_logo']['tmp_name'], $targetFile);
        unlink("../uploads/systems/" . $stru_logo_old);
    }
    $_SESSION["updateSystem"] = "success";
    header("location: ../system.php");
    exit;
} else {
    $_SESSION["updateSystem"] = "error";
    header("location: ../system.php");
    exit;
}
?>