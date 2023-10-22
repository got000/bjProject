<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../css/css_bx_icon.php");
include("./../js/js_bootstrap.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <style>
        .button4 {
            background-color: white;
            color: black;
            border: 1px solid #e7e7e7;
            width: 2rem;
            text-decoration: none;
            font-size: 1.2rem;
            text-align: center;
            cursor: pointer;
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

    <div class="py-5 vh-100">
        <div class="container">
            <div class="row">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM products WHERE id='" . $id . "' LIMIT 1";
                    $query = @mysqli_query($con, $sql);
                    $product = mysqli_fetch_assoc($query);
                    if ($product) {
                ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 bg-light">
                            <div class="text-center p-3">
                                <img src="../admin/uploads/<?php echo $product["pro_image"] ?>" alt="..." width="500" height="500">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 px-5">
                            <div class="col-6 w-100 mb-3">
                                <span class="fs-2 fw-bold"><?php echo $product["pro_name"] ?></span>
                            </div>
                            <div class="col-6 w-100 mb-3">
                                <span class="fs-4">฿<?php echo $product["pro_price"] ?></span>
                            </div>
                            <div class="col-md-6 w-100 mb-3">
                                <span class="fs-5">รายละเอียดสินค้า</span>
                                <ul class="mt-3">
                                    <?php
                                    $details = $product['pro_detail'];
                                    $detail_parts = explode(',', $details);
                                    foreach ($detail_parts as $detail) {
                                    ?>
                                        <li><?php echo $detail ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex gap-2 align-items-center mt-4 w-100 mb-3">
                                <div class="col-3 d-flex">
                                    <a class="button4">-</a>
                                    <input type="text" class="input4" value="1">
                                    <a class="button4">+</a>
                                </div>
                                <div class="col-6">
                                    <span>มีจำนวนสินค้าทั้งหมด <?php echo $product["pro_amount"] ?> ชิ้น</span>
                                </div>
                            </div>
                            <div class="col-6 d-flex w-100 mt-5">
                                <a class="btn btn-outline-dark" style="width: 10rem;"><i class='bx bxs-cart-add fs-5'></i> เพิ่มไปยังรถเข็น </a>
                                <a class="btn btn-dark mx-3" style="width: 10rem;">ซื้อสินค้า</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row justify-content-center text-center py-5 px-5">
                                <div><i class='bx bxs-x-square' style="font-size: 8rem;"></i></div>
                                <span class="fs-3 fw-bolder">ไม่พบสินค้า</span>
                                <div class="mt-5">
                                    <a href="./index.php" style="width: 10rem;" class="btn btn-outline-dark">กลับสู่หน้าหลัก</a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </div>

</body>
<?php
include("./../js/jquery.php");
?>

</html>