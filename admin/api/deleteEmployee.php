<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emp_id = $_POST["emp_id"];
    }
?>
<?php
    //process
    $_SESSION["employeeHeader"] = "ลบ";
    $sql = "DELETE FROM employees WHERE emp_id='".$emp_id."'";
    $query = mysqli_query($con, $sql);
    if($query){
        $_SESSION["addEmployee"] = "success";
        header("location: ../employees.php");
        exit;
    }else{
        $_SESSION["addEmployee"] = "error";
        header("location: ../employees.php");
        exit;
    }
?>