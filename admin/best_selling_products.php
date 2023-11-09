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
    <title>รายงานสินค้าที่ถูกสั่งซื้อ</title>
    <?php include("./../css/css_bootstap.php"); ?>
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
                            <h3>รายงานสินค้าที่ถูกสั่งซื้อ</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex justify-content-end align-items-center">
                                <div class="row">
                                    <div class="col-4 md-3">
                                        <input type="date" name="start_date" class="form-control" value="<?php echo @$preview_start_date ?>">
                                    </div>
                                    <div class="col-4 md-3">
                                        <input type="date" name="end_date" class="form-control" value="<?php echo @$preview_end_date ?>">
                                    </div>
                                    
                                    <div class="col-4 md-3">
                                        <button type="submit" name="submit" class="btn btn-primary" id="search">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mt-3"><?php echo ($start_date) ? " รายงานสินค้าที่ถูกสั่งซื้อ " . $start_date . " ถึง " . $end_date : "" ?></h5>
                            <table class="table table-striped table-hover text-center mt-3">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>ราคาต่อชิ้น</th>
                                        <th>จำนวน</th>
                                        <th>ราคารวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if (!empty($start_date) && !empty($end_date)) {
                                    $whereCondition = "AND DATE(order_date) BETWEEN '".$start_date."' AND '".$end_date."'";
                                } else {
                                    $whereCondition = "";
                                }
                                @$total_sum = 0;
                                $sql = "SELECT o.order_date, od.pro_id, SUM(od.odetail_amount) as total, p.pro_price, p.pro_name FROM orders o 
                                        LEFT JOIN order_detail od ON o.id = od.order_id 
                                        LEFT JOIN products p ON od.pro_id = p.id
                                        WHERE order_type = 1 $whereCondition
                                        GROUP BY od.pro_id 
                                        ORDER BY total DESC";
                                $query = mysqli_query($con, $sql);
                                $i = 0;
                                if ($query->num_rows > 0){
                                    while($row=mysqli_fetch_assoc($query)){
                                        @$total_sum += (int)$row["total"] * (float)$row["pro_price"];
                                ?>
                                    <tr>
                                        <td><?php echo $i+1?></td>
                                        <td><?php echo $row["pro_name"]?></td>
                                        <td><?php echo @number_format($row["pro_price"])?></td>
                                        <td><?php echo $row["total"]?></td>
                                        <td><?php echo @number_format($row["total"] * $row["pro_price"])?></td>
                                    </tr>
                                    <?php $i++;}?>
                                    <tr>
                                        <td colspan="4">รวม</td>
                                        <td><?php echo @number_format($total_sum); ?></td>
                                    </tr>
                                    <?php }else{?>
                                        <tr>
                                            <td colspan="5">ไม่มีรายงานสินค้าที่ถูกสั่งซื้อ</td>
                                        </tr>
                                    <?php }?>
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
include("./../js/ajax.php");
include("./../js/js_bootstrap.php");
include("./../js/sweetalert.php");
?>

</html>