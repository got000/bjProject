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
    }
?>
<?php
    //process
    $_SESSION["employeeHeader"] = "แก้ไข";
    $sql_select = "SELECT * FROM employees WHERE emp_id='".$emp_id."' LIMIT 1";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $fetch = mysqli_fetch_assoc($result_select);
        $idS = $fetch["emp_id"];

        if($idS != $emp_id){
            $_SESSION["addEmployee"] = "duplicate";
            echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
            exit(0);
        }
        
    }

    $sql = "UPDATE employees SET emp_name='".$emp_name."', emp_level='".$emp_level."', emp_tel='".$emp_tel."' WHERE emp_id='".$emp_id."'";
    $query = mysqli_query($con, $sql);
    if($query){
        $_SESSION["addEmployee"] = "success";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        exit(0);
    }else{
        $_SESSION["addEmployee"] = "error";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        exit(0);
    }
?>