<?php 
    @session_start();
    include("./api/header.php");
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
        if($fetch["emp_password"] !== $password){
            $_SESSION["authen"] = "failed";
            header("location:index.php");
            exit;
        }

        $_SESSION["authen"] = "success";
        $_SESSION["emp_id"] = $fetch["emp_id"];
        $_SESSION["emp_name"] = $fetch["emp_name"];
        $_SESSION["emp_level"] = $fetch["emp_level"];
        header("location:products.php");
        exit;
    }

    $_SESSION["authen"] = "failed";
    header("location:index.php");
    exit;
?>