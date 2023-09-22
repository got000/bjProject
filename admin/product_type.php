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
    <title>ประเภทสินค้า</title>
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
                            <h3>ข้อมูลประเภทสินค้า</h3>
                        </div>
                        <button class="btn btn-outline-success col-md-3" data-bs-toggle="modal" data-bs-target="#modalAddProductType">
                            <i class="fas fa-plus"></i>
                            <span class="ml-2">เพิ่มประเภทสินค้า</span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover text-center mt-2">
                                <thead>
                                    <tr>
                                        <th width="10%">ลำดับ</th>
                                        <th width="35%">รหัสประเภท</th>
                                        <th width="35%">ชื่อประเภท</th>
                                        <th width="20%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM product_type";
                                        $query = @mysqli_query($con, $sql);
                                        $i = 0;
                                        if($query->num_rows > 0){
                                            while($row = mysqli_fetch_assoc($query)){
                                    ?>
                                    <tr>
                                        <td><?php echo $i+1 ?></td>
                                        <td><?php echo $row["protype_id"]; ?></td>
                                        <td><?php echo $row["protype_name"]; ?></td>
                                        <td>
                                            <button class="btn btn-outline-warning" data-bs-toggle="modal" type="button" data-bs-target="#modalUpdateProductType<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" type="button" data-bs-target="#modalDeleteProductType<?php echo $row["id"] ?>"><i class="fas fa-trash-alt"></i></button>
                                        </td>
                                    </tr>

                                    <!-- modal edit -->
                                    <div class="modal fade" tabindex="-1" id="modalUpdateProductType<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalUpdateProductTypeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="./api/updateProductType.php" method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">แก้ไขประเภทสินค้า</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" value="<?php echo $row["id"] ?>"  maxlength="13" name="id" class="form-control" required>
                                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสประเภทสินค้า<b>[สูงสุด 13 ตัวอักษร]</b></label>
                                                            <input type="text" value="<?php echo $row["protype_id"] ?>"  maxlength="13" name="protype_id" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อประเภทสินค้า</label>
                                                            <input type="text" value="<?php echo $row["protype_name"] ?>" name="protype_name" class="form-control" required>
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
                                    <div class="modal fade" tabindex="-1" id="modalDeleteProductType<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalDeleteProductTypeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="./api/deleteProductType.php" method="POST">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">ลบประเภทสินค้า</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <input type="hidden" value="<?php echo $row["id"] ?>"  maxlength="13" name="id" class="form-control" required>
                                                        <div class="mb-3">
                                                            <p>คุณต้องการลบ <b>"<?php echo $row["protype_name"] ?>"</b> ใช่หรือไม่?</p>
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

                                    <?php $i++; }} else { ?>
                                        <tr>
                                            <td colspan="4">ไม่มีข้อมูล</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- modal add -->
                        <div class="modal fade" tabindex="-1" id="modalAddProductType" tabindex="-1" aria-labelledby="modalAddProductTypeLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="./api/addProductType.php" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">เพิ่มประเภทสินค้า</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสประเภทสินค้า<b>[สูงสุด 13 ตัวอักษร]</b></label>
                                                <input type="text" maxlength="13" name="protype_id" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อประเภทสินค้า</label>
                                                <input type="text" name="protype_name" class="form-control" required>
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
</html>
</body>
</html>

<?php 
    @$type = @$_SESSION["productTypeHeader"];
    
    if(@$_SESSION['addProductType'] == "success"){
        $swal = "";
        $swal .= "<script>";
        $swal .= "Swal.fire({";
        $swal .= "title: '".@$type."สำเร็จ',";
        $swal .= "text: '".@$type."ประเภทสินค้าสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
        $swal .= "</script>";
        echo @$swal;
        @$_SESSION['addProductType'] = "";
    }else if(@$_SESSION['addProductType'] == "duplicate"){
        $swal = "";
        $swal .= "<script>";
        $swal .= "Swal.fire({";
        $swal .= "title: '".@$type."ล้มเหลว',";
        $swal .= "text: 'รหัสประเภทสินค้าซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
        $swal .= "</script>";
        echo @$swal;
        @$_SESSION['addProductType'] = "";
    }else if(@$_SESSION['addProductType'] == "error"){
        $swal = "";
        $swal .= "<script>";
        $swal .= "Swal.fire({";
        $swal .= "title: '".@$type."ล้มเหลว',";
        $swal .= "text: '".@$type."ประเภทสินค้าไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
        $swal .= "</script>";
        echo @$swal;
        @$_SESSION['addProductType'] = "";
    }
?>