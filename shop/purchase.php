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

    <style>
        .nav-pills .nav-item .nav-link.active {
            background-color: #212529;
            color: #FFFFFF;
        }

        .nav-pills .nav-item .nav-link {
            color: #000000;
        }
    </style>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <!-- TABS MENU -->
                    <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
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
                    <!-- END TABS MENU -->
                    <!-- CONTENT -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- ทั้งหมด -->
                        <div class="tab-pane fade show active p-3" id="pills-purchase-all" role="tabpanel" aria-labelledby="pills-purchase-all-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <p><?php echo $row["order_date"] ?></p><br>
                                                    <?php if($row["order_status"] == 1){?>
                                                        <span class="badge bg-info text-dark">รออนุมัติ</span>
                                                    <?php }else if ($row["order_status"] == 2){?>
                                                        <span class="badge bg-primary">อนุมัติแล้ว</span>
                                                    <?php }else if ($row["order_status"] == 3){?>
                                                        <span class="badge bg-warning text-dark">รอติดตั้ง</span>
                                                    <?php }else if ($row["order_status"] == 4){?>
                                                        <span class="badge bg-success">ติดตั้งสมบูรณ์</span>
                                                    <?php }else if ($row["order_status"] == 5){?>
                                                        <span class="badge bg-danger">ยกเลิก</span>
                                                    <?php }else if ($row["order_status"] == 9){?>
                                                        <span class="badge" style="background-color: #FF4500;">รออนุมัติยกเลิก</span>
                                                    <?php }?>
                                                </div>
                                            </div>
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
                                                <div class="row mb-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></ห>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿</i><?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row" style="background-color: #FFFFFF;">
                                                <div class="text-end">
                                                    <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- ทั้งหมด -->
                        </div>
                        <!-- status1 -->
                        <div class="tab-pane fade p-3" id="pills-purchase-must-buy" role="tabpanel" aria-labelledby="pills-purchase-must-buy-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 1 AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
                                            <?php
                                            $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                            LEFT JOIN orders ON order_detail.order_id = orders.id
                                            LEFT JOIN products ON order_detail.pro_id = products.id
                                            WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $number = mysqli_num_rows($_query);
                                            $i = 1;
                                            $summary = 0;
                                            while ($order = mysqli_fetch_assoc($_query)) {
                                                $summary += (int)$order["odetail_amount"] * $order["odetail_price"];
                                            ?>
                                                <div class="row mb-3 p-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></p>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿<?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                                <!-- modal cancel -->
                                                <div class="modal fade" id="modalCancel<?php echo $order["id"] ?>" tabindex="-1" tabindex="-1" aria-labelledby="modalCancelLabel<?php echo $order["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ยกเลิก</h5>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <div class="mb-3">
                                                                    <p>คุณต้องการยกเลิกรายการสั่งซื้อใช่หรือไม่?</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="./api/cancelOrder.php" method="post">
                                                                    <input type="hidden" name="order_id" value="<?php echo $order["id"] ?>">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End modal cancel -->
                                                <?php 
                                                if ($i >= $number){ ?>
                                                <div class="row mb-3">
                                                    <div class="text-end">
                                                        <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                        <button style="width: 6rem;" data-bs-toggle="modal" type="button" data-bs-target="#modalCancel<?php echo $order["id"] ?>" class="btn btn-danger btn-sm">ยกเลิก</button>
                                                    </div>
                                                </div>
                                                <?php }else{?>
                                                <div></div>
                                                <?php }?>
                                            <?php $i++;
                                            } ?>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="col-lg-12 col-md-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- status1 -->
                        <!-- status2 -->
                        <div class="tab-pane fade p-3" id="pills-purchase-delivery" role="tabpanel" aria-labelledby="pills-purchase-delivery-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 2 AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
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
                                                <div class="row mb-3 p-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></ห>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿</i><?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row mb-3">
                                                <div class="text-end">
                                                    <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                    <button class="btn btn-sm btn-danger" style="width: 6rem;">ยกเลิก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- status2 -->
                        <!-- status3 -->
                        <div class="tab-pane fade p-3" id="pills-purchase-receive" role="tabpanel" aria-labelledby="pills-purchase-receive-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 3 AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
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
                                                <div class="row mb-3 p-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></ห>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿</i><?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row mb-3">
                                                <div class="text-end">
                                                    <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- status3 -->
                        <!-- status4 -->
                        <div class="tab-pane fade p-3" id="pills-purchase-finished" role="tabpanel" aria-labelledby="pills-purchase-finished-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 4 AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
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
                                                <div class="row mb-3 p-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></ห>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿</i><?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row mb-3">
                                                <div class="text-end">
                                                    <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- status4 -->
                        <!-- status5 -->
                        <div class="tab-pane fade p-3" id="pills-purchase-cancel" role="tabpanel" aria-labelledby="pills-purchase-cancel-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 5 OR order_status = 9 AND order_type = 1 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
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
                                                <div class="row mb-3 p-3">
                                                    <div class="col-3 text-center">
                                                        <img src="../admin/uploads/<?php echo $order["pro_image"] ?>" alt="..." height="100" width="100">
                                                    </div>
                                                    <div class="col-6 d-flex flex-column justify-content-between">
                                                        <p class="fs-5"><?php echo $order["pro_name"] ?></ห>
                                                        <p><?php echo $order["pro_detail"] ?></p>
                                                        <span>x<?php echo $order["odetail_amount"] ?></span>
                                                    </div>
                                                    <div class="col-3 d-flex flex-column-reverse text-center">
                                                        <p>฿</i><?php echo number_format($order["odetail_price"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row mb-3" style="background-color: #FFFFFF;">
                                                <div class="text-end">
                                                    <p class="fs-5">รวมราคาทั้งหมด: ฿<span><?php echo number_format($summary) ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm" style="background-color: #FFFFFF;">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bx-history' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการสั่งซื้อ</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- status5 -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>
<?php 
if (@$_SESSION['cancel_order'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "ยกเลิกรายการสั่งซื้อสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['cancel_order'] = "";
} else if (@$_SESSION['cancel_order'] == "failed") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "ยกเลิกรายการสั่งซื้อไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['cancel_order'] = "";
}else  if (@$_SESSION['order'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
} else  if (@$_SESSION['order'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
} else  if (@$_SESSION['order'] == "empty") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่มีรายการสินค้า',";
    $swal .= "text: '" . "ไม่สามารถสั่งซื้อได้ เนื่องจากไม่พบสินค้าในตระกร้า', icon: 'warning', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
}
?>
</html>