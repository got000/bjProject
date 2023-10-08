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
    <title>รายการปัญหา</title>
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
                                <h3>ข้อมูลรายการปัญหา</h3>
                            </div>
                            <button class="btn btn-outline-success col-md-3" data-bs-toggle="modal" data-bs-target="#modalAddProblem">
                                <i class="fas fa-plus"></i>
                                <span class="ml-2">เพิ่มรายการ</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-hover text-center mt-2">
                                    <thead>
                                        <tr>
                                            <th width="5%">ลำดับ</th>
                                            <th width="12.14%">รหัสปัญหา</th>
                                            <th width="12.14%">ประเภทปัญหา</th>
                                            <th width="12.14%">ชื่อปัญหา</th>
                                            <th width="20%">รายละเอียดปัญหา</th>
                                            <th width="12.14%">ราคาต่อปัญหา</th>
                                            <th width="12.14%">ส่วนลด</th>
                                            <th width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT problems.id AS pid, problems.prob_id, problems.prob_name, problems.prob_detail, problems.prob_price, problems.prob_discount, problem_type.id AS ptid, problem_type.probType_name, 
                                                problem_type.probType_detail FROM problems 
                                                LEFT JOIN problem_type ON problems.probType_id=problem_type.id
                                                WHERE problems.probType_id=problem_type.id;";
                                        $query = @mysqli_query($con, $sql);
                                        $i = 0;
                                        if ($query->num_rows > 0) {
                                            while ($row = mysqli_fetch_assoc($query)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo $i + 1 ?></td>
                                                    <td><?php echo $row["prob_id"]; ?></td>
                                                    <td><?php echo $row["probType_name"]; ?></td>
                                                    <td><?php echo $row["prob_name"]; ?></td>
                                                    <td><?php echo $row["prob_detail"]; ?></td>
                                                    <td><?php echo $row["prob_price"]; ?></td>
                                                    <td><?php echo $row["prob_discount"]; ?></td>
                                                    <td>
                                                        <button class="btn btn-outline-warning" data-bs-toggle="modal" type="button" data-bs-target="#modalUpdateProblem<?php echo $row["pid"] ?>"><i class="fas fa-edit"></i></button>
                                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" type="button" data-bs-target="#modalDeleteProblem<?php echo $row["pid"] ?>"><i class="fas fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>

                                                <!-- modal edit -->
                                                <div class="modal fade" tabindex="-1" id="modalUpdateProblem<?php echo $row["pid"] ?>" tabindex="-1" aria-labelledby="modalUpdateProblemLabel<?php echo $row["id"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/updateProblem.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">แก้ไขรายการปัญหา</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?php echo $row["pid"] ?>">
                                                                    <input type="hidden" name="prob_id" value="<?php echo $row["prob_id"] ?>">
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ประเภทปัญหา<b></label>
                                                                            <?php
                                                                            $sql2 = "SELECT * FROM problem_type";
                                                                            $query2 = @mysqli_query($con, $sql2);
                                                                            while ($row2 = mysqli_fetch_assoc($query2)) {
                                                                            ?>
                                                                                <option value="<?php echo $row2["id"] ?>">
                                                                                    <?php echo $row2['probType_name'] ?>
                                                                                </option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อปัญหา</label>
                                                                        <input value="<?php echo $row["prob_name"] ?>" type="text" name="name" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รายละเอียดปัญหา</label>
                                                                        <textarea value="<?php echo $row["prob_detail"] ?>" type="text" name="detail" class="form-control" rows="3" required><?php echo $row["prob_detail"]?></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ราคา</label>
                                                                        <input value="<?php echo $row["prob_price"] ?>" type="number" name="price" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ส่วนลด</label>
                                                                        <input value="<?php echo $row["prob_discount"] ?>" type="number" name="discount" class="form-control" required>
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
                                                <div class="modal fade" tabindex="-1" id="modalDeleteProblem<?php echo $row["pid"] ?>" tabindex="-1" aria-labelledby="modalDeleteProblemLabel<?php echo $row["pid"] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="./api/deleteProblem.php" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">ลบรายการปัญหา</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <input type="hidden" value="<?php echo $row["pid"] ?>" name="id" class="form-control" required>
                                                                    <div class="mb-3">
                                                                        <p>คุณต้องการลบ <b>"<?php echo $row["prob_name"] ?>"</b> ใช่หรือไม่?</p>
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
                                                <td colspan="8">ไม่มีข้อมูล</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- modal add -->
                            <div class="modal fade" tabindex="-1" id="modalAddProblem" tabindex="-1" aria-labelledby="modalAddProblemLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="./api/addProblem.php" method="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title">เพิ่มรายการปัญหา</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ประเภทปัญหา<b></label>
                                                    <select class="form-select" name="probType_id" aria-label="Default select example">
                                                        <?php
                                                        $sql2 = "SELECT * FROM problem_type";
                                                        $query2 = @mysqli_query($con, $sql2);
                                                        while ($row2 = mysqli_fetch_assoc($query2)) {
                                                        ?>
                                                            <option value="<?php echo $row2["id"] ?>">
                                                                <?php echo $row2['probType_name'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อปัญหา</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รายละเอียดปัญหา</label>
                                                    <textarea type="text" name="detail" class="form-control" rows="3" required></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ราคา</label>
                                                    <input type="number" name="price" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ส่วนลด</label>
                                                    <input type="number" name="discount" class="form-control" required>
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
if (@$_SESSION['addProblem'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'เพิ่มรายการปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProblem'] = "";
} else if (@$_SESSION['addProblem'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'เพิ่มรายการปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['addProblem'] = "";
} else if (@$_SESSION['updateProblem'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'แก้ไขรายการปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateProblem'] = "";
} else if (@$_SESSION['updateProblem'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'แก้รายการปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateProblem'] = "";
} else if (@$_SESSION['deleteProblem'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'สำเร็จ',";
    $swal .= "text: 'ลบรายการปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['deleteProblem'] = "";
} else if (@$_SESSION['deleteProblem'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ล้มเหลว',";
    $swal .= "text: 'ลบรายการปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['deleteProblem'] = "";
}
?>