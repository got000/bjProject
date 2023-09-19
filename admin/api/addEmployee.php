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
    $_SESSION["employeeHeader"] = "เพิ่ม";
    $sql_select = "SELECT * FROM employees WHERE emp_id='".$emp_id."'";
    $result_select = mysqli_query($con,$sql_select);
    if($result_select->num_rows > 0){
        $_SESSION["addEmployee"] = "duplicate";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        exit(0);
    }
    $sql = "INSERT INTO employees (emp_id, emp_name, emp_level, emp_tel) VALUES('".$emp_id."', '".$emp_name."', '".$emp_level."', '".$emp_tel."')";
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