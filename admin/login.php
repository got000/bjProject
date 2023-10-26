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
        $username =   $_POST['username'];
        $password =   $_POST['password'];
    }
?>
<?php 
    $password = md5($password);
    $sql = "SELECT * FROM employees WHERE emp_username='".$username."' OR emp_tel='".$username."' LIMIT 1";
    $query = mysqli_query($con, $sql);
    if($query){

        $fetch = mysqli_fetch_assoc($query);
        echo $fetch;
        if($fetch["emp_password"] !== $password){
            $_SESSION["authen"] = "failed";
            header("location:index.php");
            exit;
        }

        $_SESSION["authen"] = "success";
        $_SESSION["emp_id"] = $fetch["emp_id"];
        $_SESSION["emp_name"] = $fetch["emp_name"];
        $_SESSION["emp_level"] = $fetch["emp_level"];
        header("location:system.php");
        exit;
    }

    $_SESSION["authen"] = "failed";
    header("location:index.php");
    exit;
?>