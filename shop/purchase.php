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
            <div class="col-lg-6 col-md-6">
                <!-- TABS -->
                <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-purchase-all-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-all" type="button" role="tab" aria-controls="pills-purchase-all" aria-selected="true">ทั้งหมด</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-must-buy-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-must-buy" type="button" role="tab" aria-controls="pills-purchase-must-buy" aria-selected="false">ที่ต้องชำระ</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-delivery-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-delivery" type="button" role="tab" aria-controls="pills-purchase-delivery" aria-selected="false">ที่ต้องจัดส่ง</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-purchase-receive-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-receive" type="button" role="tab" aria-controls="pills-purchase-receive" aria-selected="false">ที่ต้องได้รับ</button>
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
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' ORDER BY order_date ASC";
                                $query = mysqli_query($con, $sql);
                                $i = 0;
                                if ($query->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- ทั้งหมด -->
                    <!-- status1 -->
                    <div class="tab-pane fade" id="pills-purchase-must-buy" role="tabpanel" aria-labelledby="pills-purchase-must-buy-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_status1 = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' 
                                AND order_status = 1 ORDER BY order_date ASC";
                                $query_status1 = mysqli_query($con, $sql_status1);
                                $i = 0;
                                if ($query_status1->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query_status1)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- status1 -->
                    <!-- status2 -->
                    <div class="tab-pane fade" id="pills-purchase-delivery" role="tabpanel" aria-labelledby="pills-purchase-delivery-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_status2 = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' 
                                AND order_status = 2 ORDER BY order_date ASC";
                                $query_status2 = mysqli_query($con, $sql_status2);
                                $i = 0;
                                if ($query_status2->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query_status2)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- status2 -->
                    <!-- status3 -->
                    <div class="tab-pane fade" id="pills-purchase-receive" role="tabpanel" aria-labelledby="pills-purchase-receive-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_status3 = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' 
                                AND order_status = 3 ORDER BY order_date ASC";
                                $query_status3 = mysqli_query($con, $sql_status3);
                                $i = 0;
                                if ($query_status3->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query_status3)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- status3 -->
                    <!-- status4 -->
                    <div class="tab-pane fade" id="pills-purchase-finished" role="tabpanel" aria-labelledby="pills-purchase-finished-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_status4 = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' 
                                AND order_status = 4 ORDER BY order_date ASC";
                                $query_status4 = mysqli_query($con, $sql_status4);
                                $i = 0;
                                if ($query_status4->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query_status4)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- status4 -->
                    <!-- status99 -->
                    <div class="tab-pane fade" id="pills-purchase-cancel" role="tabpanel" aria-labelledby="pills-purchase-cancel-tab">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_status99 = "SELECT * FROM orders WHERE cus_id='" . $_SESSION["cus_id"] . "' 
                                AND order_status = 99 ORDER BY order_date ASC";
                                $query_status99 = mysqli_query($con, $sql_status99);
                                $i = 0;
                                if ($query_status99->num_rows > 0) {
                                    while ($order = mysqli_fetch_assoc($query_status99)) {
                                        $i++;
                                ?>
                                        <?php ?>
                                        <tr>
                                            <td><?php echo $order["order_id"] ?></td>
                                            <td>
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>รูปสินค้า</th>
                                                            <th>ชื่อสินค้า</th>
                                                            <th>ราคาต่อชิ้น</th>
                                                            <th>จำนวน</th>
                                                            <th>ราคารวม</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $_sql = "SELECT orders.id, order_date, order_detail.odetail_id, order_detail.odetail_amount, order_detail.odetail_price, products.pro_name, products.pro_detail, products.pro_image FROM order_detail
                                                        LEFT JOIN orders ON order_detail.order_id = orders.id
                                                        LEFT JOIN products ON order_detail.pro_id = products.id
                                                        WHERE order_detail.order_id = '" . $order["id"] . "'";
                                                        $_query = mysqli_query($con, $_sql);
                                                        $summary = 0;
                                                        while ($row = mysqli_fetch_assoc($_query)) {
                                                            $summary += $row["odetail_amount"] * $row["odetail_price"];
                                                        ?>

                                                            <tr>
                                                                <td><?php echo $row["order_date"] ?></td>
                                                                <td><img src="./../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="100" height="100"></td>
                                                                <td><?php echo $row["pro_name"] ?></td>
                                                                <td><?php echo $row["odetail_price"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] ?></td>
                                                                <td><?php echo $row["odetail_amount"] * $row["odetail_price"] ?></td>
                                                            </tr>
                                                    </tbody>
                                                <?php } ?>
                                                <tfoot>
                                                    <tr>
                                                        <td><strong>ราคาทั้งหมด$ <?php echo $summary ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6">ไม่มีข้อมูลรายการ</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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