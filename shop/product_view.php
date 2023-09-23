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
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM products WHERE id='" . $id . "' LIMIT 1";
                $query = @mysqli_query($con, $sql);
                $product = mysqli_fetch_assoc($query);
                if ($product) {
            ?>
                    <div class="col-md-6">
                        <img src="../admin/uploads/<?php echo $product["pro_image"] ?>" class="d-block mx-lg-auto img-fluid" alt="Product Image" width="700" height="500" loading="lazy">
                    </div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bold lh-1 mb-5 position-static"><?php echo $product["pro_name"] ?></h1>
                        <p><strong>ราคา:</strong> $<?php echo $product["pro_price"] ?></p>
                        <p><strong>รายละเอียดสินค้า:</strong> <?php echo $product["pro_detail"] ?></p>
                        <div class="input-group mb-3">
                            <button style="width: 3rem;" class="btn btn-outline-secondary" type="button"><i class="fas fa-minus"></i></button>
                            <input type="text" class="form-control-sm" style="width: 3rem; text-align: center; border-width: 1px" placeholder="1">
                            <button style="width: 3rem;" class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i></button>
                            <span class="form-text mx-3">มีสินค้าทั้งหมด <?php echo $product["pro_amount"] ?> ชิ้น</span>
                        </div>
                        <div class="d-flex align-items-center my-5">
                            <button class="btn btn-outline-primary p-3" style="width: 12rem;"><i class="fas fa-cart-plus"></i> เพิ่มไปยังรถเข็น </button>
                            <button class="btn btn-primary mx-3 p-3" style="width: 12rem;">ซื้อสินค้า</button>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <!-- NO PRODUCT -->
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-header">
                                ไม่พบข้อมูลสินค้า
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-danger fs-1"><i class="fas fa-thumbs-down"></i></h5>
                                <p class="card-text">กลับไปเลือกสินค้า</p>
                                <a href="./index.php" class="btn btn-primary">ย้อนกลับ</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>
<?php
include("./../js/jquery.php");
?>
<!-- Write Alert -->

</html>