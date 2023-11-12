<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
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
                            <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">ทั้งหมด</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wait-approve-tab" data-bs-toggle="pill" data-bs-target="#wait-approve" type="button" role="tab" aria-controls="wait-approve" aria-selected="false">ที่ต้องรออนุมัติ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="approve-tab" data-bs-toggle="pill" data-bs-target="#approve" type="button" role="tab" aria-controls="approve" aria-selected="false">ที่อนุมัติแล้ว</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="success-tab" data-bs-toggle="pill" data-bs-target="#success" type="button" role="tab" aria-controls="success" aria-selected="false">ที่สำเร็จแล้ว</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancel-tab" data-bs-toggle="pill" data-bs-target="#cancel" type="button" role="tab" aria-controls="cancel" aria-selected="false">ยกเลิก</button>
                        </li>
                    </ul>
                    <!-- END TABS MENU -->
                    <!-- CONTENTS -->
                    <!-- ทั้งหมด -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active p-3" id="all" role="tabpanel" aria-labelledby="all-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_type = 2 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm">
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
                                                        <span class="badge bg-success">แจ้งสำเร็จ</span>
                                                    <?php }else if ($row["order_status"] == 5){?>
                                                        <span class="badge bg-danger">ยกเลิก</span>
                                                    <?php }else if ($row["order_status"] == 9){?>
                                                        <span class="badge bg-dark">รออนุมัติยกเลิก</span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="row mb-3 p-3 text-center">
                                                <div class="col-3">
                                                    <p class="fw-bold">ปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">รายละเอียดปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ราคา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ส่วนลด</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $_sql = "SELECT orders.id,order_detail.odetail_amount,order_detail.odetail_price,problems.prob_name,problems.prob_detail, problems.prob_discount, problem_type.probType_name
                                                FROM order_detail 
                                                LEFT JOIN orders ON order_detail.order_id = orders.id 
                                                LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                LEFT JOIN problem_type ON problems.probType_id = problem_type.id
                                                WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $summary = 0;
                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                $summary += $detail["odetail_price"] * $detail["odetail_amount"];
                                            ?>
                                                <div class="row mb-3 p-3 text-center">
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_name"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_detail"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["odetail_price"]) ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["prob_discount"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row">
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
                                        <span><i class='bx bxs-message-rounded-error' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการแจ้งปัญหา</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- ทั้งหมด -->
                        <!-- Status1 -->
                        <div class="tab-pane fade show p-3" id="wait-approve" role="tabpanel" aria-labelledby="wait-approve-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 1 AND order_type = 2 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
                                            <div class="row mb-3 p-3 text-center">
                                                <div class="col-3">
                                                    <p class="fw-bold">ปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">รายละเอียดปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ราคา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ส่วนลด</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $_sql = "SELECT orders.id,order_detail.odetail_amount,order_detail.odetail_price,problems.prob_name,problems.prob_detail, problems.prob_discount, problem_type.probType_name
                                                FROM order_detail 
                                                LEFT JOIN orders ON order_detail.order_id = orders.id 
                                                LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                LEFT JOIN problem_type ON problems.probType_id = problem_type.id
                                                WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $summary = 0;
                                            $number = mysqli_num_rows($_query);
                                            $i = 1;
                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                $summary += $detail["odetail_price"] * $detail["odetail_amount"];
                                            ?>
                                                <div class="row mb-3 p-3 text-center">
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_name"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_detail"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["odetail_price"]) ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["prob_discount"]) ?></p>
                                                    </div>
                                                </div>
                                                 <!-- modal cancel -->
                                                 <div class="modal fade" id="modalCancel<?php echo $row["id"] ?>" tabindex="-1" tabindex="-1" aria-labelledby="modalCancelLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ยกเลิก</h5>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <div class="mb-3">
                                                                    <p>คุณต้องการยกเลิกรายการแจ้งปัญหาใช่หรือไม่?</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form action="./api/cancelProblem.php" method="post">
                                                                    <input type="hidden" name="order_id" value="<?php echo $row["id"] ?>">
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
                                                        <button style="width: 6rem;" data-bs-toggle="modal" type="button" data-bs-target="#modalCancel<?php echo $row["id"] ?>" class="btn btn-danger btn-sm">ยกเลิก</button>
                                                    </div>
                                                </div>
                                                <?php }else{?>
                                                <div></div>
                                                <?php }?>
                                            <?php $i++;} ?>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row mb-3 shadow-sm">
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <span><i class='bx bxs-message-rounded-error' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการแจ้งปัญหา</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Status1 -->
                        <!-- Status2 -->
                        <div class="tab-pane fade show p-3" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 2 AND order_type = 2 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
                                            <div class="row mb-3 p-3 text-center">
                                                <div class="col-3">
                                                    <p class="fw-bold">ปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">รายละเอียดปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ราคา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ส่วนลด</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $_sql = "SELECT orders.id,order_detail.odetail_amount,order_detail.odetail_price,problems.prob_name,problems.prob_detail, problems.prob_discount, problem_type.probType_name
                                                FROM order_detail 
                                                LEFT JOIN orders ON order_detail.order_id = orders.id 
                                                LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                LEFT JOIN problem_type ON problems.probType_id = problem_type.id
                                                WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $summary = 0;
                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                $summary += $detail["odetail_price"] * $detail["odetail_amount"];
                                            ?>
                                                <div class="row mb-3 p-3 text-center">
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_name"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_detail"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["odetail_price"]) ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["prob_discount"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row">
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
                                        <span><i class='bx bxs-message-rounded-error' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการแจ้งปัญหา</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Status2 -->
                        <!-- Status3 -->
                        <div class="tab-pane fade show p-3" id="success" role="tabpanel" aria-labelledby="success-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 3 AND order_type = 2 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
                                            <div class="row mb-3 p-3 text-center">
                                                <div class="col-3">
                                                    <p class="fw-bold">ปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">รายละเอียดปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ราคา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ส่วนลด</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $_sql = "SELECT orders.id,order_detail.odetail_amount,order_detail.odetail_price,problems.prob_name,problems.prob_detail, problems.prob_discount, problem_type.probType_name
                                                FROM order_detail 
                                                LEFT JOIN orders ON order_detail.order_id = orders.id 
                                                LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                LEFT JOIN problem_type ON problems.probType_id = problem_type.id
                                                WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $summary = 0;
                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                $summary += $detail["odetail_price"] * $detail["odetail_amount"];
                                            ?>
                                                <div class="row mb-3 p-3 text-center">
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_name"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_detail"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["odetail_price"]) ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["prob_discount"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row">
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
                                        <span><i class='bx bxs-message-rounded-error' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการแจ้งปัญหา</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Status3 -->
                        <!-- Status5 -->
                        <div class="tab-pane fade show p-3" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                            <?php
                            $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' AND order_status = 5 OR order_status = 9 AND order_type = 2 ORDER BY order_date DESC";
                            $query = mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="row mb-3 shadow-sm">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3 shadow-sm p-3">
                                                <div class="col-6 align-items-center">
                                                    <p class="fw-bold"><?php echo $row["order_id"] ?></p>
                                                </div>
                                                <div class="col-6 text-end"><?php echo $row["order_date"] ?></div>
                                            </div>
                                            <div class="row mb-3 p-3 text-center">
                                                <div class="col-3">
                                                    <p class="fw-bold">ปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">รายละเอียดปัญหา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ราคา</p>
                                                </div>
                                                <div class="col-3">
                                                    <p class="fw-bold">ส่วนลด</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                            $_sql = "SELECT orders.id,order_detail.odetail_amount,order_detail.odetail_price,problems.prob_name,problems.prob_detail, problems.prob_discount, problem_type.probType_name
                                                FROM order_detail 
                                                LEFT JOIN orders ON order_detail.order_id = orders.id 
                                                LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                LEFT JOIN problem_type ON problems.probType_id = problem_type.id
                                                WHERE order_detail.order_id = '" . $row["id"] . "'";
                                            $_query = mysqli_query($con, $_sql);
                                            $summary = 0;
                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                $summary += $detail["odetail_price"] * $detail["odetail_amount"];
                                            ?>
                                                <div class="row mb-3 p-3 text-center">
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_name"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo $detail["prob_detail"] ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["odetail_price"]) ?></p>
                                                    </div>
                                                    <div class="col-3">
                                                        <p class="mx-5"><?php echo number_format($detail["prob_discount"]) ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="row">
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
                                        <span><i class='bx bxs-message-rounded-error' style="font-size: 10rem;"></i></span>
                                        <p class="fs-4">ไม่มีประวัติการแจ้งปัญหา</p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Status5 -->
                        <!-- END CONTENTS -->
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
include("./../css/css_bootstap.php");
include("./../css/css_bx_icon.php");
include("./../js/js_bootstrap.php");
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
}
?>
</html>