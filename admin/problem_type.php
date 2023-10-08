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
                            <div class="col-md-9">
                                <h3>ข้อมูลประเภทปัญหา</h3>
                            </div>
                            <button class="btn btn-outline-success col-md-3" data-bs-toggle="modal" data-bs-target="#modalAddProblemType">
                                <i class="fas fa-plus"></i>
                                <span class="ml-2">เพิ่มประเภทปัญหา</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover text-center mt-2">
                                    <thead>
                                        <tr>
                                            <th width="10%">ลำดับ</th>
                                            <th width="15%">รหัสประเภท</th>
                                            <th width="15%">ชื่อประเภท</th>
                                            <th width="25%">รายละเอียด</th>
                                            <th width="20%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM problem_type";
                                        $query = @mysqli_query($con, $sql);
                                        $i = 0;
                                        if ($query->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $row["probType_id"]; ?></td>
                                                    <td><?php echo $row["probType_name"]; ?></td>
                                                    <td><?php echo $row["probType_detail"]; ?></td>
                                                    <td>
                                                        <button class="btn btn-outline-warning" data-bs-toggle="modal" type="button" data-bs-target="#modalUpdateProblemType<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" type="button" data-bs-target="#modalDeleteProblemType<?php echo $row["id"] ?>"><i class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- modal edit -->
                                                <div class="modal fade" tabindex="-1" id="modalUpdateProblemType<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalUpdateProblemTypeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/updateProblemType.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">แก้ไขประเภทปัญหา</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <input type="hidden" name="id" value="<?php echo $row["id"] ?>">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อประเภทปัญหา</label>
                                                                        <input value="<?php echo $row["probType_name"] ?>" type="text" name="name" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ราคา</label>
                                                                        <textarea value="<?php echo $row["probType_detail"] ?>" type="text" name="detail" class="form-control" rows="3" required><?php echo $row["probType_detail"] ?></textarea>
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
                                                <div class="modal fade" tabindex="-1" id="modalDeleteProblemType<?php echo $row["id"] ?>" tabindex="-1" aria-labelledby="modalDeleteProblemTypeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/deleteProblemType.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">ลบประเภทปัญหา</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <input type="hidden" value="<?php echo $row["id"] ?>" name="id" class="form-control" required>
                                                                    <div class="mb-3">
                                                                        <p>คุณต้องการลบ <b>"<?php echo $row["probType_name"] ?>"</b> ใช่หรือไม่?</p>
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

                                            <?php ++$i;
                                            }
                                        } else { ?>
                                            <tr>
                                                <td colspan="5">ไม่มีข้อมูล</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- modal add -->
                            <div class="modal fade" tabindex="-1" id="modalAddProblemType" tabindex="-1" aria-labelledby="modalAddProblemTypeLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="./api/addProblemType.php" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title">เพิ่มประเภทปัญหา</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อประเภทปัญหา</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รายละเอียด</label>
                                                    <textarea type="text" name="detail" class="form-control" rows="3" required></textarea>
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
if (@$_SESSION['addProblemType'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'เพิ่มประเภทปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProblemType'] = "";
} else if (@$_SESSION['addProblemType'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'เพิ่มประเภทปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProblemType'] = "";
} else if (@$_SESSION['addProblemType'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'ชื่อประเภทปัญหาซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProblemType'] = "";
}else if (@$_SESSION['updateProblemType'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'แก้ไขประเภทปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateProblemType'] = "";
}else if (@$_SESSION['updateProblemType'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'แก้ไขประเภทปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateProblemType'] = "";
}else if (@$_SESSION['deleteProblemType'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'ลบประเภทปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['deleteProblemType'] = "";
}else if (@$_SESSION['deleteProblemType'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'ลบประเภทปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['deleteProblemType'] = "";
}
?>