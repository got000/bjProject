<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emp_id = $_POST['emp_id'];
        $emp_name =   $_POST['emp_name'];
        $emp_level =   $_POST['emp_level'];
        $emp_tel =   $_POST['emp_tel'];
        $emp_username =   $_POST['emp_username'];
    }
?>
<?php
    //process
    $_SESSION["employeeHeader"] = "แก้ไข";
    $sql_select = "SELECT * FROM employees WHERE emp_id='".$emp_id."' LIMIT 1";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $fetch = mysqli_fetch_assoc($result_select);
        $idS = $fetch["emp_username"];

        if($idS != $emp_username){
            $_SESSION["addEmployee"] = "duplicate";
            header("location: ../employees.php");
            exit;
        }
    }

    $sql = "UPDATE employees SET emp_name='".$emp_name."', emp_level='".$emp_level."', emp_tel='".$emp_tel."' WHERE emp_id='".$emp_id."'";
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