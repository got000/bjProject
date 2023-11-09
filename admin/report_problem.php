<?php
@session_start();
if (!isset($_SESSION["emp_level"])) {
    @$_SESSION["empty"] = "y";
    header("location: index.php");
}
@include("./../config/config.php")
?>
<?php
$start_date = null;
$end_date = null;
$preview_start_date = date("Y-m-d");
$preview_end_date = date("Y-m-d");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $preview_start_date = $_POST["start_date"] != "" ? $_POST["start_date"] : date("Y-m-d");
    $preview_end_date = $_POST["end_date"] != "" ? $_POST["end_date"] : date("Y-m-d");
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการแจ้งปัญหา</title>
    <link rel="stylesheet" href="./../css/sidebar.css">
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
                            <h3>รายงานการแจ้งปัญหา</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex justify-content-end align-items-center">
                                <div class="row">
                                    <div class="col md-3">
                                        <input type="date" name="start_date" class="form-control" value="<?php echo @$preview_start_date ?>">
                                    </div>
                                    <div class="col md-3">
                                        <input type="date" name="end_date" class="form-control" value="<?php echo @$preview_end_date ?>">
                                    </div>
                                    <div class="col md-3">
                                        <button type="submit" name="submit" class="btn btn-primary" id="search">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table_order" class="table table-striped table-hover text-center mt-2">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>รหัสแจ้งปัญหา</th>
                                        <th>วันที่</th>
                                        <th>รายละเอียด</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($start_date) && !empty($end_date)) {
                                        $whereCondition = "AND DATE(order_date) BETWEEN '".$start_date."' AND '".$end_date."'";
                                    } else {
                                        $whereCondition = "";
                                    }

                                    $sql = "SELECT * FROM orders WHERE order_type = 2 $whereCondition";
                                    $query = mysqli_query($con, $sql);
                                    $i = 0;

                                    if ($query->num_rows > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $i + 1 ?></td>
                                                <td><?php echo $row["order_id"] ?></td>
                                                <td><?php echo $row["order_date"] ?></td>
                                                <td><button data-bs-toggle="modal" type="button" data-bs-target="#modalOrder<?php echo $row["id"] ?>" class="btn btn-secondary btn-sm">รายการแจ้งปัญหา</button></td>
                                                <td>
                                                    <?php if ($row["order_status"] == 1) { ?>
                                                        <span class="badge bg-info text-dark">รออนุมัติ</span>
                                                    <?php } else if ($row["order_status"] == 2) { ?>
                                                        <span class="badge bg-warning text-dark">อนุมัติ</span>
                                                    <?php } else if ($row["order_status"] == 3) { ?>
                                                        <span class="badge bg-success">สำเร็จ</span>
                                                    <?php } else if ($row["order_status"] == 99) { ?>
                                                        <span class="badge bg-danger">ยกเลิก</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <!-- modal order detail -->
                                            <div class="modal fade" id="modalOrder<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalOrderLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $row["order_id"] ?></h5>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="row g-4 justify-content-center">
                                                                <div class="col"><strong>ลำดับ</strong></div>
                                                                <div class="col"><strong>ชื่อปัญหา</strong></div>
                                                                <div class="col"><strong>รายละเอียดปัญหา</strong></div>
                                                                <div class="col"><strong>ราคา</strong></div>
                                                                <div class="col"><strong>จำนวน</strong></div>
                                                            </div>
                                                            <hr class="my-3" />
                                                            <?php
                                                            $_sql = "SELECT orders.order_id, problems.prob_name, problems.prob_detail, 
                                                                            order_detail.odetail_amount, order_detail.odetail_price
                                                                            FROM order_detail
                                                                            LEFT JOIN orders ON order_detail.order_id = orders.id
                                                                            LEFT JOIN problems ON order_detail.pro_id = problems.id
                                                                            WHERE order_detail.order_id = '" . $row["id"] . "'";
                                                            $_query = mysqli_query($con, $_sql);
                                                            $j = 0;
                                                            $summary = 0;
                                                            while ($detail = mysqli_fetch_assoc($_query)) {
                                                                $summary += (int)$detail["odetail_amount"] * (int)$detail["odetail_price"];

                                                            ?>
                                                                <div class="row g-4 justify-content-center mb-4">
                                                                    <div class="col"><?php echo $j + 1 ?></div>
                                                                    <div class="col"><?php echo $detail["prob_name"] ?></div>
                                                                    <div class="col"><?php echo $detail["prob_detail"] ?></div>
                                                                    <div class="col"><?php echo number_format($detail["odetail_price"]) ?></div>
                                                                    <div class="col"><?php echo $detail["odetail_amount"] ?></div>
                                                                </div>
                                                            <?php $j++;
                                                            } ?>
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
                                        <?php
                                            $i++;
                                        }
                                    } else { ?>
                                        <!-- display date empty or no records found -->
                                        <tr>
                                            <td colspan="5">ไม่มีรายงานการแจ้งปัญหา</td>
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
include("./../css/css_bootstap.php");
?>

</html>