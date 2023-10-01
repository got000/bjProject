<?php
@session_start();
if(!isset($_SESSION["emp_level"])){
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
    <title>สินค้า</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
        include("./../css/css_bootstap.php");
        ?>
        <link rel="stylesheet" href="./../css/sidebar.css">
        <title>admin management</title>
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
                            <div class="col md-9">
                                <h3>ข้อมูลสินค้า</h3>
                            </div>
                            <button class="btn btn-outline-success col-md-3" data-bs-toggle="modal" data-bs-target="#modalAddProduct">
                                <i class="fas fa-plus"></i>
                                <span class="ml-2">เพิ่มสินค้า</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover text-center mt-2">
                                    <thead>
                                        <tr>
                                            <th width="5%">ลำดับ</th>
                                            <th width="12.14%">รหัสสินค้า</th>
                                            <th width="12.14%">ชื่อสินค้า</th>
                                            <th width="12.14%">จำนวนสินค้า</th>
                                            <th width="12.14%">ราคาสินค้า</th>
                                            <th width="12.14%">รายละเอียดสินค้า</th>
                                            <th width="12.14%">รูปภาพ</th>
                                            <th width="12.14%">รหัสประเภทสินค้า</th>
                                            <th width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM products";
                                        $query = @mysqli_query($con, $sql);
                                        $i = 0;
                                        if ($query->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $row["pro_id"]; ?></td>
                                                    <td><?php echo $row["pro_name"]; ?></td>
                                                    <td><?php echo $row["pro_amount"]; ?></td>
                                                    <td><?php echo $row["pro_price"]; ?></td>
                                                    <td><?php echo $row["pro_detail"]; ?></td>
                                                    <td>
                                                        <img src='uploads/<?php echo $row['pro_image']; ?>' alt="เพิ่มรูปภาพ" width="80" height="80">
                                                    </td>
                                                    <td><?php echo $row["protype_id"]; ?></td>
                                                    <td>
                                                        <button class="btn btn-outline-warning" data-bs-toggle="modal" type="button" data-bs-target="#modalUpdateProduct<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" type="button" data-bs-target="#modalDeleteProduct<?php echo $row["id"] ?>"><i class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- modal edit -->
                                                <div class="modal fade" tabindex="-1" id="modalUpdateProduct<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalUpdateProductLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/updateProduct.php" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">แก้ไขสินค้า</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสประเภทสินค้า<b>[สูงสุด 11 ตัวอักษร]</label>
                                                                        <select value="<?php echo $row['protype_id'] ?>" class="form-select" aria-label="Default select example">
                                                                            <?php
                                                                            $sql2 = "SELECT * FROM product_type";
                                                                            $query2 = @mysqli_query($con, $sql2);
                                                                            while ($row2 = mysqli_fetch_assoc($query2)) {
                                                                            ?>
                                                                                <option value="<?php echo $row2["id"] ?>">
                                                                                    <?php echo $row2['protype_name'] ?>
                                                                                </option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อสินค้า</label>
                                                                        <input type="text" value="<?php echo $row["pro_name"] ?>" name="pro_name" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>จำนวนสินค้า</label>
                                                                        <input type="number" value="<?php echo $row["pro_amount"] ?>" name="pro_amount" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ราคา</label>
                                                                        <input type="number" value="<?php echo $row["pro_price"] ?>" name="pro_price" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="form-label"><span class="text-danger"><b>*</b></span>รายละเอียดสินค้า</label>
                                                                        <input class="form-control" value="<?php echo $row["pro_detail"] ?>" type="text" name="pro_detail" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รูปภาพ</label>
                                                                        <input type="file" name="pro_image" class="form-control">
                                                                        <input type="hidden" name="pro_image_old" value="<?php echo $row['pro_image'] ?>" class="form-control" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                    <button type="submit" class="btn btn-warning">บันทึก</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- modal edit -->

                                                <!-- modal delete -->
                                                <div class="modal fade" tabindex="-1" id="modalDeleteProduct<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalDeleteProductLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/deleteProduct.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">ลบสินค้า</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <input type="hidden" value="<?php echo $row["id"] ?>" name="id" class="form-control">
                                                                    <input type="hidden" value="<?php echo $row["pro_image"] ?>" name="pro_image" class="form-control">
                                                                    <div class="mb-3">
                                                                        <p>คุณต้องการลบ <b>"<?php echo $row["pro_name"] ?>"</b> ใช่หรือไม่?</p>
                                                                        <img src='uploads/<?php echo $row['pro_image']; ?>' alt="เพิ่มรูปภาพ" width="80" height="80">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                                    <button type="submit" class="btn btn-warning">ยืนยัน</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- modal delete -->

                                            <?php $i++;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="9">ไม่มีข้อมูล</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- modal add -->
                            <div class="modal fade" tabindex="-1" id="modalAddProduct" tabindex="-1" aria-labelledby="modalAddProductLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="./api/addProduct.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title">เพิ่มสินค้า</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสประเภทสินค้า<b>[สูงสุด 11 ตัวอักษร]</label>
                                                    <select class="form-select" aria-label="Default select example">
                                                        <?php
                                                        $sql2 = "SELECT * FROM product_type";
                                                        $query2 = @mysqli_query($con, $sql2);
                                                        while ($row2 = mysqli_fetch_assoc($query2)) {
                                                        ?>
                                                            <option value="<?php echo $row2["id"] ?>">
                                                                <?php echo $row2['protype_name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อสินค้า</label>
                                                    <input type="text" name="pro_name" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>จำนวนสินค้า</label>
                                                    <input type="number" name="pro_amount" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ราคา</label>
                                                    <input type="number" name="pro_price" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รายละเอียดสินค้า<br>*ถ้ารายละเอียดมากกว่า 1 โปรดใส่ ,</label>
                                                    <input type="text" name="pro_detail" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รูปภาพ</label>
                                                    <input type="file" id="imgInput" name="pro_image" class="form-control" required onchange="previewImage()">
                                                    <div id="previewContainer" style="display: flex; justify-content: center;align-items: center;">
                                                        <img id="previewImg" style="max-width: 100px; max-height: 100px; display: none; margin-top: 10px">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                                <button type="submit" class="btn btn-success">บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- modal add -->
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

    <script>
        function previewImage() {
            const imgInput = document.getElementById("imgInput");
            const previewImg = document.getElementById("previewImg");
            if (imgInput.files && imgInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                };
                reader.readAsDataURL(imgInput.files[0]);
                previewImg.style.display = "block";
            } else {
                previewImg.src = "";
                previewImg.style.display = "none";
            }
        }
    </script>

    </html>
</body>

</html>

<?php
@$type = @$_SESSION["productHeader"];

if (@$_SESSION['addProduct'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "สินค้าสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProduct'] = "";
} else if (@$_SESSION['addProduct'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: 'รหัสสินค้าซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProduct'] = "";
} else if (@$_SESSION['addProduct'] == "image_duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: 'รูปภาพสินค้าซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProduct'] = "";
} else if (@$_SESSION['addProduct'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: '" . @$type . "สินค้าไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProduct'] = "";
} else if (@$_SESSION['addProduct'] == "imageType_error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: '" . @$type . "ไฟล์รูปสินค้าอยู่ประเภท jpg, png, jpeg, gif', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProduct'] = "";
}
?>