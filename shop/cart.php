<?php
@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../js/js_bootstrap.php");
?>
<?php
if (isset($_GET["increment"])) {
    $index = $_GET["increment"];
    $val = (int)$_SESSION["carts"][$index]["pro_amount"];
    $val += 1;
    $_SESSION["carts"][$index]["pro_amount"] = $val;
    header("location: cart.php");
}
if (isset($_GET["decrement"])) {
    $index = $_GET["decrement"];
    $val = (int)$_SESSION["carts"][$index]["pro_amount"];
    $val -= 1;
    $_SESSION["carts"][$index]["pro_amount"] = $val;
    header("location: cart.php");
}

if (isset($_GET["clear_cart"])) {
    $_SESSION["carts"] = [];
    header("location: cart.php");
}
// add button remove item of array
if (isset($_GET["delete_item"])) {
    $index = $_GET["delete_item"];
    unset($_SESSION["carts"][$index]["pro_id"]);
    header("location: cart.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container py-3">
        <div class="row d-flex justify-content-center py-4">
            <?php
            if (count(@$_SESSION["carts"])) {
                $summary = 0;
            ?>
                <div class="col-lg-10 col-md-10 rounded-5 bg-light p-4 shadow-sm">
                    <div class="row g-2 justify-content-between">
                        <div class="col-auto">
                            <h5>ตระกร้าสินค้า</h5>
                        </div>
                        <div class="col-auto"><a class="text-danger" href="<?php echo $_SERVER["PHP_SELF"] ?>?clear_cart=0">ลบทั้งหมด</a></div>
                    </div>
                    <?php
                    for ($i = 0; $i < count(@$_SESSION["carts"]); $i++) {
                        @$summary += (int)$_SESSION['carts'][$i]["pro_amount"] * (float)$_SESSION['carts'][$i]["pro_price"];
                    ?>
                        <div class="row g-4 mt-2 p-3 justify-content-between">
                            <div class="col-auto">
                                <img src="./../admin/uploads/<?php echo $_SESSION["carts"][$i]["pro_image"] ?>" alt="..." width="100" , height="100">
                            </div>
                            <div class="col-auto">
                                <div class="row g-2 d-flex flex-column">
                                    <div class="col-auto">
                                        <h5><?php echo $_SESSION["carts"][$i]["pro_name"] ?></h5>
                                    </div>
                                    <div class="col-auto">
                                        <span>Lorem, ipsum dolor.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row g-3 d-flex align-items-center">
                                    <div class="col-auto">
                                        <?php
                                        if ($_SESSION["carts"][$i]["pro_amount"] > 1) {
                                        ?>
                                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?decrement=<?php echo $i ?>" class="btn btn-outline-dark btn-sm"><i class="fas fa-minus"></i></a>
                                        <?php } else { ?>
                                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?decrement=<?php echo $i ?>" class="btn btn-outline-dark btn-sm disabled"><i class="fas fa-minus"></i></a>
                                        <?php } ?>
                                    </div>
                                    <div class="col-auto">
                                        <input value="<?php echo $_SESSION["carts"][$i]["pro_amount"] ?>" type="number" value="1" class="form-control text-center border-0 rounded" style="width: 3.5rem;">
                                    </div>
                                    <div class="col-auto">
                                        <a href="<?php echo $_SERVER["PHP_SELF"] ?>?increment=<?php echo $i ?>" class="btn btn-outline-dark btn-sm"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row g-2 d-flex flex-column">
                                    <div class="col-auto">
                                        <h5>$<?php echo $_SESSION["carts"][$i]["pro_price"] ?></h5>
                                    </div>
                                    <div class="col-auto text-end">
                                        <a class="text-danger" href="<?php echo $_SERVER["PHP_SELF"] ?>?delete_item=<?php echo $i ?>">ลบ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row d-flex flex-column align-items-end">
                        <hr class="my-3 w-75">
                        <div class="col-md-8">
                            <div class="row justify-content-end">
                                <div class="col-3 px-4 py-3">
                                    <h5>สินค้าทั้งหมด</h5>
                                    <p><?php echo count($_SESSION["carts"]) ?> รายการ</p>
                                </div>
                                <div class="col-3 px-4 py-3">
                                    <h2>$<?php echo $summary ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row px-4">
                                <form action="./api/addOrder.php" method="post">
                                    <input type="hidden" value="<?php echo $_SESSION["cus_id"] ?>" name="cus_id">
                                    <button type="submit" class="btn btn-primary" style="width: 16rem;">สั่งซื้อสินค้า</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-lg-10 col-md-10 rounded-5 bg-light p-4 shadow-sm">
                    <div class="row justify-content-between px-5 py-5">
                        <div class="col-lg-12 text-center mt-5">
                            <i class="fas fa-shopping-cart fs-1"></i>
                            <h5 class="fs-3 mt-3 mb-4">ตระกร้าของคุณไม่มีสินค้า</h5>
                            <a href="./index.php" class="btn btn-warning btn-lg mt-5">กลับไปเลือกสินค้า</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>
<!-- SWEET ALERT -->
<?php
if (@$_SESSION['order'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
} else if (@$_SESSION['order'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
}
?>

</html>