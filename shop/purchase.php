<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../js/js_bootstrap.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-lg-8 col-md-8">
                <!-- TABS -->
                <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-purchase-all-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-all" type="button" role="tab" aria-controls="pills-purchase-all" aria-selected="true">ทั้งหมด</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-must-buy-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-must-buy" type="button" role="tab" aria-controls="pills-purchase-must-buy" aria-selected="false">ที่ต้องรออนุมัติ</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-delivery-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-delivery" type="button" role="tab" aria-controls="pills-purchase-delivery" aria-selected="false">ที่อนุมัติแล้ว</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-receive-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-receive" type="button" role="tab" aria-controls="pills-purchase-receive" aria-selected="false">ที่ต้องรอติดตั้ง</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-finished-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-finished" type="button" role="tab" aria-controls="pills-purchase-finished" aria-selected="false">สำเร็จแล้ว</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-cancel-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-cancel" type="button" role="tab" aria-controls="pills-purchase-cancel" aria-selected="false">ยกเลิก</button>
                    </li>
                </ul>
                <!-- END TABS -->
                <!-- TAB CONTENS -->
                <div class="tab-content" id="nav-tabContent">
                    <!-- ทั้งหมด -->
                    <div class="tab-pane fade show active" id="pills-purchase-all" role="tabpanel" aria-labelledby="pills-purchase-all-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ทั้งหมด -->
                    <!-- status1 -->
                    <div class="tab-pane fade" id="pills-purchase-must-buy" role="tabpanel" aria-labelledby="pills-purchase-must-buy-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 1 ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="btn btn-danger" style="width: 6rem;">ยกเลิก</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- status1 -->
                    <!-- status2 -->
                    <div class="tab-pane fade" id="pills-purchase-delivery" role="tabpanel" aria-labelledby="pills-purchase-delivery-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 2 ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- status2 -->
                    <!-- status3 -->
                    <div class="tab-pane fade" id="pills-purchase-receive" role="tabpanel" aria-labelledby="pills-purchase-receive-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 3 ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3 ">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- status3 -->
                    <!-- status4 -->
                    <div class="tab-pane fade" id="pills-purchase-finished" role="tabpanel" aria-labelledby="pills-purchase-finished-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 4 ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- status4 -->
                    <!-- status99 -->
                    <div class="tab-pane fade" id="pills-purchase-cancel" role="tabpanel" aria-labelledby="pills-purchase-cancel-tab">
                        <div class="container mt-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12">
                                    <!-- LOOP PHP IS HERE! -->
                                    <?php
                                    $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 99 ORDER BY order_date DESC";
                                    $query = mysqli_query($con, $sql);
                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <div class="card mt-3 mb-5 shadow-sm">
                                                <div class="card-header d-flex justify-content-between">
                                                    <h5><?php echo $row["order_id"] ?></h5>
                                                    <h5><?php echo $row["order_date"] ?></h5>
                                                </div>
                                                <div class="card-body">
                                                    <!-- LOOP ORDER DETAIL HERE! -->
                                                    <?php
                                                    $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                    LEFT JOIN orders ON order_detail.order_id = orders.id
                                                    LEFT JOIN products ON order_detail.pro_id = products.id
                                                    WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                    $_query = mysqli_query($con, $_sql);
                                                    $summary = 0;
                                                    while ($order = mysqli_fetch_assoc($_query)) {
                                                        $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                                    ?>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-3 text-center">
                                                                <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                            </div>
                                                            <div class="col-6 d-flex flex-column justify-content-between">
                                                                <h3><?php echo $order["pro_name"] ?></h3>
                                                                <p><?php echo $order["pro_detail"] ?></p>
                                                                <span>x<?php echo $order["odetail_amount"] ?></span>
                                                            </div>
                                                            <div class="col-3 d-flex flex-column-reverse text-center">
                                                                <p><i class="fab fa-btc"></i><?php echo $order["odetail_price"] ?></p>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END LOOP ORDER DETAIL HERE!  -->
                                                </div>

                                                <div class="card-footer text-end">
                                                    <div class="mb-3">
                                                        <h5>รวมราคาทั้งหมด: <i class="fab fa-btc"></i><span><?php echo $summary ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END LOOP PHP IS HERE! -->
                                        <?php }
                                    } else { ?>
                                        <div class="card text-center shadow-sm">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">ไม่มีประวัติการซื้อสินค้า</h5>
                                                <p class="card-text mt-3">
                                                    <i class="fas fa-shopping-cart" style="font-size: 5rem;"></i>
                                                </p>
                                                <a href="./index.php" class="btn btn-primary">กลับไปหน้าหลัก</a>
                                            </div>
                                            <div class="card-footer text-muted"></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- status99 -->
                </div>
                <!-- END TAB CONTENTS -->
            </div>
        </div>
    </div>
</body>

<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>

</html>