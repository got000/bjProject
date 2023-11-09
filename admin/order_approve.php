<?php
@session_start();
if (!isset($_SESSION["emp_level"])) {
    @$_SESSION["empty"] = "y";
    header("location: index.php");
}
@include("./../config/config.php")
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emp_id = $_SESSION["emp_id"];
    $id = $_POST["order_id"];
    $sql = "UPDATE orders SET order_status=99, emp_id='" . $emp_id . "'WHERE id='" . $id . "'";
    $query = mysqli_query($con, $sql);
    if ($query) {
        $_SESSION["cancel_order"] = 'success';
        header("location: order_approve.php");
        exit;
    }
    $_SESSION["cancel_order"] = 'failed';
    header("location: order_approve.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include("./../css/css_bootstap.php");
    ?>
    <link rel="stylesheet" href="./../css/sidebar.css">
    <title>รายการอนุมัติแล้ว</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-2 col-md-2">
                <?php include("./menu.php"); ?>
            </div>
            <div class="col-lg-10 col-md-10">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <h3>รายการอนุมัติแล้ว</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover text-center mt-2">
                                <thead>
                                    <tr>
                                        <th width="5%">ลำดับ</th>
                                        <th width="10%">รหัสสั่งซื้อ</th>
                                        <th width="10%">วันที่</th>
                                        <th width="10%">ชื่อลูกค้า</th>
                                        <th width="15%">ที่อยู่ลูกค้า</th>
                                        <th width="10%">รายละเอียด</th>
                                        <th width="10%">ดำเนินการโดย</th>
                                        <th width="20%">#</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql = "SELECT orders.id, orders.order_id, orders.order_date, orders.cus_id, customers.cus_name, customers.cus_tel, 
                                    customers.cus_address, provinces.name_th AS province_name, amphures.name_th AS amphur_name, 
                                    districts.name_th AS district_name, districts.zip_code, employees.emp_name 
                                    FROM orders
                                    LEFT JOIN customers ON orders.cus_id = customers.cus_id
                                    LEFT JOIN employees ON orders.emp_id = employees.emp_id
                                    LEFT JOIN provinces ON customers.cus_province = provinces.id
                                    LEFT JOIN amphures ON customers.cus_amphur = amphures.id
                                    LEFT JOIN districts ON customers.cus_district = districts.id
                                    WHERE orders.cus_id = customers.cus_id AND orders.order_status = 2 AND orders.emp_id=employees.emp_id AND orders.order_type = 1";
                                $query = mysqli_query($con, $sql);
                                $i = 0;
                                if ($query->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query)) {
                                        $i++;
                                ?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $order["order_id"] ?></td>
                                                <td><?php echo $order["order_date"] ?></td>
                                                <td><?php echo $order["cus_name"] ?></td>
                                                <td><?php echo $order["cus_address"] ?>,
                                                    <?php echo $order["district_name"] ?>,
                                                    <?php echo $order["amphur_name"] ?>,
                                                    <?php echo $order["province_name"] ?>,
                                                    <?php echo $order["zip_code"] ?><br>
                                                    เบอร์โทร: <?php echo $order["cus_tel"] ?>
                                                </td>
                                                <td><button data-bs-toggle="modal" type="button" data-bs-target="#modalOrder<?php echo $order["id"] ?>" class="btn btn-secondary btn-sm">รายการสั่งซื้อ</button></td>
                                                <td><?php echo $order["emp_name"] ?></td>
                                                <td>
                                                    <button data-bs-toggle="modal" type="button" data-bs-target="#modalApprove<?php echo $order["id"] ?>" class="btn btn-success btn-sm">ได้คิวติดตั้ง</button>
                                                    <button data-bs-toggle="modal" type="button" data-bs-target="#modalCancel<?php echo $order["id"] ?>" class="btn btn-danger btn-sm">ยกเลิก</button>
                                                </td>
                                            </tr>
                                            <!-- modal Approve wait to install -->
                                            <div class="modal fade" id="modalApprove<?php echo $order["id"] ?>" tabindex="-1" tabindex="-1" aria-labelledby="modalApproveLabel<?php echo $order["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <form action="./api/wait_install_api.php" method="post">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">ติดตั้ง <?php echo $order["order_id"] ?></h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <select class="form-select" id="emp_work" name="emp_work" required>
                                                                        <option selected>เลือกผู้ติดตั้ง</option>
                                                                        <?php
                                                                        $select_emp_work = "SELECT * FROM employees WHERE emp_level=2";
                                                                        $query_emp_work = mysqli_query($con, $select_emp_work);
                                                                        while ($row = mysqli_fetch_assoc($query_emp_work)) {
                                                                        ?>
                                                                            <option value="<?php echo $row["emp_id"] ?>"><?php echo $row["emp_name"] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="emp_id" value="<?php echo $_SESSION["emp_id"] ?>">
                                                                <input type="hidden" name="order_id" value="<?php echo $order["id"] ?>">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                <button type="submit" id="submitBtn" class="btn btn-primary">ยืนยัน</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- End modal Approve wait to install-->
                                            <!-- modal cancel -->
                                            <div class="modal fade" id="modalCancel<?php echo $order["id"] ?>" tabindex="-1" tabindex="-1" aria-labelledby="modalCancelLabel<?php echo $order["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">ยกเลิก</h5>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="mb-3">
                                                                <p>คุณต้องการยกเลิกรายการ <strong><?php echo $order["order_id"] ?></strong> ใช่หรือไม่?</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                                                                <input type="hidden" name="emp_id" value="<?php echo $_SESSION["emp_id"] ?>">
                                                                <input type="hidden" name="order_id" value="<?php echo $order["id"] ?>">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End modal cancel -->
                                            <!-- modal order detail -->
                                            <div class="modal fade" id="modalOrder<?php echo $order["id"] ?>" tabindex="-1" aria-labelledby="modalOrderLabel<?php echo $order["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $order["order_id"] ?></h5>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="row g-4 justify-content-center">
                                                                <div class="col"><strong>ลำดับ</strong></div>
                                                                <div class="col"><strong>ชื่อสินค้า</strong></div>
                                                                <div class="col"><strong>รูปภาพ</strong></div>
                                                                <div class="col"><strong>ราคา</strong></div>
                                                                <div class="col"><strong>จำนวน</strong></div>
                                                            </div>
                                                            <hr class="my-3" />
                                                            <?php
                                                            $_sql = "SELECT orders.order_id, products.pro_name, products.pro_image, 
                                                                            order_detail.odetail_amount, order_detail.odetail_price
                                                                            FROM order_detail
                                                                            LEFT JOIN orders ON order_detail.order_id = orders.id
                                                                            LEFT JOIN products ON order_detail.pro_id = products.id
                                                                            WHERE order_detail.order_id = '" . $order["id"] . "';";
                                                            $_query = mysqli_query($con, $_sql);
                                                            $j = 0;
                                                            $summary = 0;
                                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                                $summary += (int)$detail["odetail_amount"] * (int)$detail["odetail_price"];
                                                                $j++;
                                                            ?>
                                                                <div class="row g-4 justify-content-center mb-4">
                                                                    <div class="col"><?php echo $j ?></div>
                                                                    <div class="col"><?php echo $detail["pro_name"] ?></div>
                                                                    <div class="col"><img src="./../admin/uploads/<?php echo $detail["pro_image"] ?>" alt="รูปสินค้า" width="50" height="50"></div>
                                                                    <div class="col"><?php echo number_format($detail["odetail_price"]) ?></div>
                                                                    <div class="col"><?php echo $detail["odetail_amount"] ?></div>
                                                                </div>
                                                            <?php } ?>
                                                            <hr class="my-4" />
                                                            <h5>ราคาสินค้าทั้งหมด ฿<?php echo number_format($summary) ?></h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ออก</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End modal order detail -->
                                        <?php }
                                } else { ?>
                                        <tr>
                                            <td colspan="8">ไม่มีข้อมูลรายการอนุมัติ</td>
                                        </tr>
                                    <?php } ?>
                                        </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Check user input selected 
        // if option === "เลือกผู้ติดตั้ง" button disabled
        $(document).ready(function() {
            $("#emp_work").on("change", function() {
                var submitButton = $("#submitBtn");
                if (this.value !== "เลือกผู้ติดตั้ง") {
                    submitButton.prop("disabled", false);
                } else {
                    submitButton.prop("disabled", true);
                }
            });
            // Trigger the change event on page load to check the initial selection
            $("#emp_work").trigger("change");
        });
    </script>
</body>
<?php
include("./../js/jquery.php");
include("./../js/js_bootstrap.php");
include("./../js/sweetalert.php");
?>

<?php
if (@$_SESSION['approve_wait'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "อนุมัติรายการรอติดตั้งสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['approve_wait'] = "";
} else if (@$_SESSION['approve_wait'] == "failed") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "อนุมัติรายการรอติดตั้งไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['approve_wait'] = "";
} else if (@$_SESSION['cancel_order'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "ยกรายการรอติดตั้งสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['cancel_order'] = "";
} else if (@$_SESSION['cancel_order'] == "failed") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "ยกเลิกรายการรอติดตั้งไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['cancel_order'] = "";
}
?>

</html>