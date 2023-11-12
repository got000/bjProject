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
    if(count($_SESSION["carts"]) > 0){
        $order_id = uniqid("ORDERS-".date("Y-m-d")."-", false);
        $sql = "INSERT INTO orders(order_id, order_status, cus_id, order_type) VALUES('".$order_id."', '1', '".$cus_id."', '1')";
        if($con->query($sql)){
            $order_id = $con->insert_id; // last id orders
            foreach($_SESSION["carts"] as $item){ // loop order detail
                // insert order detail
                $sql_detail = "INSERT INTO order_detail(odetail_amount, odetail_price, pro_id, order_id) VALUES('".$item["pro_amount"]."', '".$item["pro_price"]."', '".$item["id"]."', '".$order_id."')";
                $query_detail = mysqli_query($con, $sql_detail);
                if($query_detail){
                    // get product amount
                    $sql_check = "SELECT * FROM products WHERE id='".$item["id"]."' LIMIT 1";
                    $query_check = mysqli_query($con, $sql_check);
                    $fetch_check = mysqli_fetch_assoc($query_check);

                    $amount = (int)$fetch_check["pro_amount"] - (int)$item["pro_amount"];
                    //update stock
                    $sql_update = "UPDATE products SET pro_amount='".$amount."' WHERE id='".$item["id"]."'";
                    mysqli_query($con, $sql_update);
                }
            }

            $_SESSION["order"] = "success";
            $_SESSION["carts"] = [];
            header("location:../purchase.php");
            exit;
        }

        $_SESSION["order"] = "error";
        header("location:../purchase.php");
        exit;
    }

    $_SESSION["order"] = "empty";
    header("location:../purchase.php");
    exit;
?>