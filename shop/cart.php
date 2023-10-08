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

    <style>
        .button4 {
            background-color: white;
            color: black;
            border: 2px solid #e7e7e7;
            width: 2rem;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .input4 {
            background-color: white;
            color: black;
            border: 2px solid #e7e7e7;
            width: 3rem;
            text-align: center;
        }

        .button4:hover {
            background-color: #e7e7e7;
        }
    </style>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-5 px-5">
            <div class="col-lg-10 col-md-10 px-5">
                <!-- CONDITION CARTS -->
                <?php
                if (count(@$_SESSION["carts"])) {
                    $summary = 0;
                ?>
                    <div class="card shadow rounded">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="fs-3">ตระกร้าสินค้า</span>
                            <a class="text-danger" href="<?php echo $_SERVER["PHP_SELF"] ?>?clear_cart=0">ลบทั้งหมด</a>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 shadow-sm p-3">
                                <div class="col-4">
                                    <div class="col">สินค้า</div>
                                </div>
                                <div class="col-8 d-flex justify-content-between align-items-center text-center">
                                    <div class="col-2">ราคาต่อชิ้น</div>
                                    <div class="col-2">จำนวน</div>
                                    <div class="col-2">ราคารวม</div>
                                    <div class="col-2">แอคชั่น</div>
                                </div>
                            </div>
                            <!-- LOOP PHP -->
                            <?php
                            for ($i = 0; $i < count(@$_SESSION["carts"]); $i++) {
                                @$summary += (int)$_SESSION['carts'][$i]["pro_amount"] * (float)$_SESSION['carts'][$i]["pro_price"];
                            ?>
                                <div class="row shadow-sm p-3">
                                    <div class="col-4 d-flex">
                                        <div class="col-3">
                                            <a href="#">
                                                <img src="./../admin/uploads/<?php echo $_SESSION["carts"][$i]["pro_image"] ?>" alt="..." width="70" , height="70">
                                            </a>
                                        </div>
                                        <div class="row d-flex flex-column">
                                            <span class="fs-4"><?php echo $_SESSION["carts"][$i]["pro_name"] ?></span>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex justify-content-between align-items-center text-center">
                                        <div class="col-2">
                                            <span class="fs-5"><i class="fab fa-btc"></i><?php echo $_SESSION["carts"][$i]["pro_price"] ?></span>
                                        </div>
                                        <div class="col-2 d-flex">
                                            <?php
                                            if ($_SESSION["carts"][$i]["pro_amount"] > 1) {
                                            ?>
                                                <a href="<?php echo $_SERVER["PHP_SELF"] ?>?decrement=<?php echo $i ?>" class="button4">-</a>
                                            <?php } else { ?>
                                                <a href="<?php echo $_SERVER["PHP_SELF"] ?>?decrement=<?php echo $i ?>" class="button4 " style="pointer-events: none;">-</a>
                                            <?php } ?>
                                            <input value="<?php echo $_SESSION["carts"][$i]["pro_amount"] ?>" type="text" class="input4">
                                            <a href="<?php echo $_SERVER["PHP_SELF"] ?>?increment=<?php echo $i ?>" class="button4">+</a>
                                        </div>
                                        <div class="col-2">
                                            <span class="fs-5"><i class="fab fa-btc"></i><?php echo $_SESSION["carts"][$i]["pro_amount"] * $_SESSION["carts"][$i]["pro_price"] ?></span>
                                        </div>
                                        <div class="col-2">
                                            <a class="text-danger" href="<?php echo $_SERVER["PHP_SELF"] ?>?delete_item=<?php echo $i ?>"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- END LOOP PHP -->
                            <div class="row shadow-sm p-3 text-center align-items-center d-flex flex-column mt-3">
                                <div class="col-md-10 mb-3">
                                    <span class="fs-5">ราคาทั้งหมด</span>
                                    <span class="fs-4"><i class="fab fa-btc"></i><?php echo $summary ?></span><br>
                                    <span class="fs-6">(รวม <?php echo count($_SESSION["carts"]) ?> รายการ)</span>
                                </div>
                                <div class="col-md-10">
                                    <button data-bs-toggle="modal" type="button" data-bs-target="#modalApprove" class="btn btn-primary" style="width: 10rem;">สั่งซื้อสินค้า</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal order -->
                    <div class="modal fade" id="modalApprove" tabindex="-1" tabindex="-1" aria-labelledby="modalApproveLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ตระกร้าสินค้า</h5>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="mb-3">
                                        <p>คุณต้องการสั่งซื้อสินค้า ใช่หรือไม่?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <form action="./api/addOrder.php" method="post">
                                        <input type="hidden" value="<?php echo $_SESSION["cus_id"] ?>" name="cus_id">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                        <button type="submit" class="btn btn-success">ยืนยัน</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End modal  order -->
                    <!-- END CONDITTION CARTS -->
                <?php } else { ?>
                    <div class="row justify-content-between px-5 py-5 rounded shadow">
                        <div class="col-lg-12 text-center mt-5">
                            <i class="fas fa-shopping-cart fs-1"></i>
                            <h5 class="fs-3 mt-3 mb-4">ตระกร้าของคุณไม่มีสินค้า</h5>
                            <a href="./index.php" class="btn btn-warning btn-lg mt-5">กลับไปเลือกสินค้า</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
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