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
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        exit(0);
    }else{
        $_SESSION["addEmployee"] = "error";
        echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../employees.php'>";
        exit(0);
    }
?>