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
            border: 1px solid #e7e7e7;
            width: 2rem;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .input4 {
            background-color: white;
            color: black;
            border: 1px solid #e7e7e7;
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
    <div class="container-fluid bg-light vh-100">
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    if (count(@$_SESSION["carts"])) {
                        $summary = 0;
                    ?>
                        <div class="col-lg-12 col-md-12 col-sm-12" style="background-color: #fff;">
                            <div class="row mb-3 shadow-sm p-3">
                                <div class="col-4">
                                    <div class="col">สินค้า</div>
                                </div>
                                <div class="col-8 d-flex justify-content-between text-center">
                                    <div class="col-2">ราคาต่อชิ้น</div>
                                    <div class="col-2">จำนวน</div>
                                    <div class="col-2">ราคารวม</div>
                                    <div class="col-2">แอคชั่น</div>
                                </div>
                            </div>
                            <!-- LOOP HERE -->
                            <div class="row mb-3 shadow-sm p-3">
                                <?php
                                for ($i = 0; $i < count(@$_SESSION["carts"]); $i++) {
                                    @$summary += (int)$_SESSION['carts'][$i]["pro_amount"] * (float)$_SESSION['carts'][$i]["pro_price"];
                                ?>
                                    <div class="col-4 d-flex mb-4">
                                        <div class="col-3">
                                            <a href="#">
                                                <img src="./../admin/uploads/<?php echo $_SESSION["carts"][$i]["pro_image"] ?>" alt="..." width="70" , height="70">
                                            </a>
                                        </div>
                                        <div class="row d-flex flex-column">
                                            <span class="fs-5"><?php echo $_SESSION["carts"][$i]["pro_name"] ?></span>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex justify-content-between align-items-center text-center mb-4">
                                        <div class="col-2">
                                            <span class="fs-5">฿<?php echo $_SESSION["carts"][$i]["pro_price"] ?></span>
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
                                            <span class="fs-5">฿<?php echo $_SESSION["carts"][$i]["pro_amount"] * $_SESSION["carts"][$i]["pro_price"] ?></span>
                                        </div>
                                        <div class="col-2">
                                            <a class="text-danger" href="<?php echo $_SERVER["PHP_SELF"] ?>?delete_item=<?php echo $i ?>"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="d-flex justify-content-end">
                                        <a class="text-danger mx-4" href="<?php echo $_SERVER["PHP_SELF"] ?>?clear_cart=0">ลบทั้งหมด</a>
                                    </div>
                            </div>
                            <div class="row shadow-sm p-3 flex-row-reverse">
                                <div class="col-4">
                                    <div class="row text-center">
                                        <div class="col-4 w-100 mb-3">
                                            <span class="fs-5">ราคาทั้งหมด</span>
                                            <span class="fs-4">฿</i><?php echo $summary ?></span><br>
                                            <span class="fs-6 text-center">(รวม <?php echo count($_SESSION["carts"]) ?> รายการ)</span><br>
                                        </div>
                                        <div class="col-4 w-100 mb-3">
                                            <button data-bs-toggle="modal" type="button" data-bs-target="#modalApprove" class="btn btn-dark" style="width: 10rem;">สั่งซื้อสินค้า</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 d-flex justify-content-center mt-5 flex-column"></div>
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
                                                <span class="fs-5">คุณต้องการสั่งซื้อสินค้า</span>
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
                        </div>
                </div>
            <?php } else { ?>
                <!-- NO PRODUCTS -->
                <div class="row p-3">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="col">
                            <span><i class='bx bxs-cart' style="font-size: 6rem;"></i></span>
                        </div>
                        <div class="col">
                            <span class="fs-5" style="color: #262626;">ตระกร้าสินค้าว่าง</span>
                        </div>
                        <div class="col mt-4">
                            <a class="btn btn-dark" style="width: 10rem;" href="./index.php">เลือกสินค้า</a>
                        </div>
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