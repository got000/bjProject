<?php 
    @session_start();
    @header("content-type:application/json;charset=utf-8");
    @header('Content-Type: text/html; charset=UTF-8');
    @header("Access-Control-Allow-Origin: *");
    @header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
    include("./../../config/config.php");
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       $cus_id = $_POST["cus_id"];
    }
?>
<?php 
    //process
    if(count($_SESSION["problems"]) > 0){
        $order_id = uniqid("Problem-".date("Y-m-d")."-", false);
        $sql = "INSERT INTO orders(order_id, order_status, cus_id, order_type) VALUES('".$order_id."', '1', '".$cus_id."', '2')";
        if($con->query($sql)){
            $order_id = $con->insert_id; // last id orders
            foreach($_SESSION["problems"] as $item){ // loop order detail
                // insert order detail
                $sql_detail = "INSERT INTO order_detail(odetail_amount, odetail_price, pro_id, order_id) VALUES('1', '".$item["prob_price"]."', '".$item["prob_id"]."', '".$order_id."')";
                $query_detail = mysqli_query($con, $sql_detail);
            }

            $_SESSION["add_problem"] = "success";
            $_SESSION["problems"] = [];
            header("location:../index.php");
            exit;
        }

        $_SESSION["add_problem"] = "error";
        header("location:../index.php");
        exit;
    }

    $_SESSION["add_problem"] = "empty";
    header("location:../index.php");
    exit;
?>