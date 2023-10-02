<?php 
    @session_start();
    @header("content-type:application/json;charset=utf-8");
    @header('Content-Type: text/html; charset=UTF-8');
    @header("Access-Control-Allow-Origin: *");
    @header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
    include("./../config/config.php");
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname =   $_POST['fname'];
        $lname =   $_POST['lname']; 
        $tel =   $_POST['tel'];
        $password =   md5($_POST['password']);
        $province =   $_POST['province'];
        $amphur =   $_POST['amphur'];
        $district =   $_POST['district'];
        $zip_code =   $_POST['zip_code'];
        $fullname = $fname." ".$lname;
    }
?>
<?php 
    //process
    if(strlen($_POST['password']) < 6){
        $_SESSION['register'] = "password_minimum_six";
        header("location: index.php");
        exit;
    }
    $sql_select = "SELECT * FROM customers WHERE cus_tel='".$tel."' LIMIT 1";
    $result_select = mysqli_query($con, $sql_select);
    // check tel duplicate
    if($result_select->num_rows > 0){
        $_SESSION['register'] = "duplicate";
        header("location: index.php");
        exit;
    }
    $data = array();
    $sql = "INSERT INTO customers(cus_name, cus_password, cus_tel, cus_province, cus_amphur, cus_district, cus_zip_code) 
            VALUES ('".$fullname."', '".$password."', '".$tel."', '".$province."', '".$amphur."', '".$district."', '".$zip_code."')";
    $query = mysqli_query($con, $sql);
    if($query){
        $_SESSION["register"] = "success";
        header("location: index.php");
        exit;
    }

    $_SESSION["register"] = "error";
    header("location: index.php");
    exit;
?>