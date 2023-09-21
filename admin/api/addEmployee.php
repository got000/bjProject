<?php 
    include("./header.php");
    @session_start();
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emp_name =   $_POST['emp_name'];
        $emp_level =   $_POST['emp_level'];
        $emp_tel =   $_POST['emp_tel'];
        $emp_username =   $_POST['emp_username'];
        $emp_password =   $_POST['emp_password'];
    }
?>
<?php
    //process
    $_SESSION["employeeHeader"] = "เพิ่ม";
    $sql_select = "SELECT * FROM employees WHERE emp_username='".$emp_username."'";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $_SESSION["addEmployee"] = "duplicate";
        // echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        header("location:../employees.php");
        exit;
    }
    $hashPassword =md5($emp_password);
    $sql = "INSERT INTO employees (emp_name, emp_level, emp_tel, emp_username, emp_password) VALUES('".$emp_name."', '".$emp_level."', '".$emp_tel."', '".$emp_username."', '".$hashPassword."')";
    $query = mysqli_query($con, $sql);
    if($query){
        $_SESSION["addEmployee"] = "success";
        header("location:../employees.php");
        exit;
    }else{
        $_SESSION["addEmployee"] = "error";
        header("location:../employees.php");
        exit;
    }
?>