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
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <div class="row mt-5 justify-content-center">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM products WHERE id='" . $id . "' LIMIT 1";
                $query = @mysqli_query($con, $sql);
                $product = mysqli_fetch_assoc($query);
                if ($product) {
            ?>
                    <div class="card" style="width: 32rem;">
                        <img src="../admin/uploads/<?php echo $product["pro_image"] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product["pro_name"] ?></h5>
                            <p class="card-text"><?php echo $product["pro_detail"] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-bold"><i class="fab fa-btc"></i><?php echo $product["pro_price"] ?></h3>
                                <a href="#" class="btn btn-warning btn-lg"><i class="fas fa-cart-plus"></i></a>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <!-- NO PRODUCTS -->
                    <div class="col-6">
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
include("./../js/ajax.php");
include("./../js/js_bootstrap.php");
?>
<!-- Write Alert -->

</html>