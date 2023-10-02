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
                        <button class="nav-link" id="pills-purchase-delivery-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-delivery" type="button" role="tab" aria-controls="ills-purchase-delivery" aria-selected="false">ที่ต้องจัดส่ง</button>
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
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pills-purchase-return-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase-return" type="button" role="tab" aria-controls="pills-purchase-return" aria-selected="false">คืนเงิน/คืนสินค้า</a>
                    </li>
                </ul>
                <!-- TAB CONTENTS -->
                <div class="tab-content" id="pills-tabContent">
                    <!-- รายการทั้งหมด -->
                    <div class="tab-pane fade show active" id="pills-purchase-all" role="tabpanel" aria-labelledby="pills-purchase-all-tab">
                       <div class="card">
                        <div class="card-header"></div>
                        <div class="row g-0">
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                       </div>
                    </div>
                    <!-- รายการทั้งหมด -->
                    <!-- ที่ต้องชำระ -->
                    <div class="tab-pane fade" id="pills-purchase-must-buy" role="tabpanel" aria-labelledby="pills-purchase-must-buy-tab">

                    </div>
                    <!-- ที่ต้องชำระ -->
                    <!-- ที่ต้องจัดส่ง -->
                    <div class="tab-pane fade" id="pills-purchase-delivery" role="tabpanel" aria-labelledby="pills-purchase-delivery-tab">

                    </div>
                    <!-- ที่ต้องจัดส่ง -->
                    <!-- ที่ต้องได้รับ -->
                    <div class="tab-pane fade" id="pills-purchase-receive" role="tabpanel" aria-labelledby="pills-purchase-receive-tab">

                    </div>
                    <!-- ที่ต้องได้รับ -->
                    <!-- สำเร็จแล้ว -->
                    <div class="tab-pane fade" id="pills-purchase-finished" role="tabpanel" aria-labelledby="pills-purchase-finished-tab">

                    </div>
                    <!-- สำเร็จแล้ว -->
                    <!-- ยกเลิก -->
                    <div class="tab-pane fade" id="pills-purchase-cancel" role="tabpanel" aria-labelledby="pills-purchase-cancel-tab">

                    </div>
                    <!-- ยกเลิก -->
                    <!-- คืนสินค้า / คืนเงิน -->
                    <div class="tab-pane fade" id="pills-purchase-return" role="tabpanel" aria-labelledby="pills-purchase-return-tab">

                    </div>
                    <!-- คืนสินค้า / คืนเงิน -->
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

</html>