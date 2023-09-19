<?php
@session_start();
@include("./../config/config.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลผู้ใช้งาน</title>
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
                                <h3>ข้อมูลผู้ใช้งาน</h3>
                            </div>
                            <button class="btn btn-outline-success col-md-3" data-bs-toggle="modal" data-bs-target="#modalAddEmployee">
                                <i class="fas fa-plus"></i>
                                <span class="ml-2">เพิ่มผู้ใช้งาน</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover text-center mt-2">
                                    <thead>
                                        <tr>
                                            <th width="10%">ลำดับ</th>
                                            <th width="20%">รหัสผูเใช้งาน</th>
                                            <th width="20%">ชื่อผู้ใช้งาน</th>
                                            <th width="20%">ระดับ</th>
                                            <th width="20%">เบอร์โทร</th>
                                            <th width="20%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM employees";
                                        $query = @mysqli_query($con, $sql);
                                        $i = 0;
                                        if ($query->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $row["emp_id"]; ?></td>
                                                    <td><?php echo $row["emp_name"]; ?></td>
                                                    <td>
                                                        <?php
                                                            if ($row["emp_level"] == 1){
                                                                echo "แอดมิน";
                                                            }else  if ($row["emp_level"] == 2){
                                                                echo "ผู้ใช้งาน";
                                                            }else if ($row["emp_level"] == 3){
                                                                echo "ลูกค้า";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row["emp_tel"]; ?></td>
                                                    <td>
                                                        <button class="btn btn-outline-warning" data-bs-toggle="modal" type="button" data-bs-target="#modalUpdateEmployee<?php echo $row["emp_id"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" type="button" data-bs-target="#modalDeleteEmployee<?php echo $row["emp_id"] ?>"><i class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- modal edit -->
                                                <div class="modal fade" tabindex="-1" id="modalUpdateEmployee<?php echo $row["emp_id"] ?>" tabindex="-1" aria-labelledby="modalUpdateEmployeeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/updateEmployee.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">แก้ไขข้อมูลผู้ใช้งาน</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <input type="hidden" value="<?php echo $row["emp_id"] ?>" maxlength="11" name="emp_id" class="form-control" required>
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อผู้ใช้งาน</label>
                                                                        <input type="text" value="<?php echo $row["emp_name"] ?>" name="emp_name" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dropdown" class="form-label"><span class="text-danger"><b>*</b></span>ระดับ</label>
                                                                        <select class="form-select" id="dropdown" name="emp_level" required>
                                                                            <option selected>เลือกระดับ</option>
                                                                            <option value="1">แอดมิน</option>
                                                                            <option value="2">ผู้ใช้งาน</option>
                                                                            <option value="3">ลูกค้า</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>เบอร์โทร</label>
                                                                        <input type="text" value="<?php echo $row["emp_tel"] ?>" name="emp_tel" class="form-control" required>
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
                                                <div class="modal fade" tabindex="-1" id="modalDeleteEmployee<?php echo $row["emp_id"] ?>" tabindex="-1" aria-labelledby="modalDeleteEmployeeLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/deleteEmployee.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">ลบผู้ใช้งาน</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <input type="hidden" value="<?php echo $row["emp_id"] ?>" maxlength="11" name="emp_id" class="form-control" required>
                                                                    <div class="mb-3">
                                                                        <p>คุณต้องการลบ <b>"<?php echo $row["emp_name"] ?>"</b> ใช่หรือไม่?</p>
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
                                                <td colspan="6">ไม่มีข้อมูล</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- modal add -->
                            <div class="modal fade" tabindex="-1" id="modalAddEmployee" tabindex="-1" aria-labelledby="modalAddEmployeeLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="./api/addEmployee.php" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title">เพิ่มผู้ใช้งาน</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสผู้ใช้งาน<b>[สูงสุด 11 ตัวอักษร]</b></label>
                                                    <input type="text" maxlength="11" name="emp_id" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อผู้ใช้งาน</label>
                                                    <input type="text" name="emp_name" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dropdown" class="form-label"><span class="text-danger"><b>*</b></span>ระดับ</label>
                                                    <select class="form-select" id="dropdown" name="emp_level" required>
                                                        <option selected>เลือกระดับ</option>
                                                        <option value="1">แอดมิน</option>
                                                        <option value="2">ผู้ใช้งาน</option>
                                                        <option value="3">ลูกค้า</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>เบอร์โทร</label>
                                                    <input type="text" name="emp_tel" class="form-control" required>
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
@$type = @$_SESSION["employeeHeader"];

if (@$_SESSION['addEmployee'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "ผู้ใช้งาน', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addEmployee'] = "";
} else if (@$_SESSION['addEmployee'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: 'รหัสผู้ใช้งานซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addEmployee'] = "";
} else if (@$_SESSION['addEmployee'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: '" . @$type . "ผู้ใช้งานไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addEmployee'] = "";
}
?>