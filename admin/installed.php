<?php
@session_start();
if (!isset($_SESSION["emp_level"])) {
    @$_SESSION["empty"] = "y";
    header("location: index.php");
}
@include("./../config/config.php")
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
    <title>รายการติดตั้งเสร็จสมบูรณ์</title>
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
                            <h3>รายการติดตั้งเสร็จสมบูรณ์</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover text-center mt-2">
                                <thead>
                                    <tr>
                                        <th width="5%">ลำดับ</th>
                                        <th width="15%">รหัสสั่งซื้อ</th>
                                        <th width="10%">วันที่</th>
                                        <th width="15%">ชื่อลูกค้า</th>
                                        <th width="25%">ที่อยู่ลูกค้า</th>
                                        <th width="10%">ดำเนินการโดย</th>
                                        <th width="20%">#</th>
                                    </tr>
                                </thead>
                                <?php
                                $sql = "SELECT installation.id, installation.eq_id, installation.eq_status,installation.cus_id , orders.id, orders.order_id, orders.order_date, customers.cus_name, customers.cus_tel, 
                                customers.cus_address, provinces.name_th AS province_name, amphures.name_th AS amphur_name, 
                                districts.name_th AS district_name, districts.zip_code, employees.emp_name 
                                FROM installation
                                LEFT JOIN orders ON installation.order_id = orders.id
                                LEFT JOIN employees ON orders.emp_id = employees.emp_id
                                LEFT JOIN customers ON installation.cus_id = customers.cus_id
                                LEFT JOIN provinces ON customers.cus_province = provinces.id
                                LEFT JOIN amphures ON customers.cus_amphur = amphures.id
                                LEFT JOIN districts ON customers.cus_district = districts.id
                                WHERE orders.cus_id = customers.cus_id AND orders.order_status = 4 AND installation.eq_status = 2;";
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
                                                <td><?php echo $order["emp_name"]?></td>
                                                <td>
                                                    <button data-bs-toggle="modal" type="button" data-bs-target="#modalOrder<?php echo $order["id"] ?>" class="btn btn-secondary btn-sm">รายการสั่งซื้อ</button>
                                                </td>
                                            </tr>
                                            <!-- modal order detail -->
                                            <div class="modal fade" id="modalOrder<?php echo $order["id"] ?>" tabindex="-1" aria-labelledby="modalOrderLabel<?php echo $order["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
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
                                                                    <div class="col"><?php echo $detail["odetail_price"] ?></div>
                                                                    <div class="col"><?php echo $detail["odetail_amount"] ?></div>
                                                                </div>
                                                            <?php } ?>
                                                            <hr class="my-4" />
                                                            <h5>ราคาสินค้าทั้งหมด $<?php echo $summary ?></h5>
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
                                            <td colspan="7">รายการติดตั้งเสร็จสมบูรณ์</td>
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
</body>
<?php
include("./../js/jquery.php");
include("./../js/js_bootstrap.php");
include("./../js/sweetalert.php");
?>
</html>