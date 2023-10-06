<?php
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
    <title>แก้ไขรหัสผ่าน</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light rounded-2 py-5 px-5 shadow p-3">
                <h1 class="text-center fw-bold">แก้ไขรหัสผ่าน</h1>
                <form action="./api/updatePassword.php" method="post">
                    <input type="hidden" value="<?php echo $_SESSION['cus_id'] ?>">
                    <div class="mb-3 px-5">
                        <label for="newPassword" class="form-lable">รหัสผ่าน</label>
                        <input type="password" name="newPassword" id="newPassword" class="form-control">
                    </div>
                    <div class="mb-3 px-5">
                        <label for="confirmPassword" class="form-lable">ยืนยันรหัสผ่าน</label>
                        <input onkeyup="btnActivation()" type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-end px-5">
                        <button id="btnModal" data-bs-toggle="modal" type="button" data-bs-target="#modalSubmit" class="btn btn-primary" disabled>บันทึก</button>
                    </div>

                    <!-- modal Submit -->
                    <div class="modal fade" id="modalSubmit" tabindex="-1" tabindex="-1" aria-labelledby="modalSubmitLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">แก้ไขรหัสผ่าน</h5>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="mb-3">
                                        <p>คุณต้องการแก้ไขรหัสผ่าน ใช่หรือไม่?</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End modal Submit -->

                </form>
            </div>
        </div>
    </div>
    <script>
        function btnActivation() {
            if (!document.getElementById('confirmPassword').value.length) {
                document.getElementById("btnModal").disabled = true;
            } else {
                document.getElementById("btnModal").disabled = false;
            }
        }
    </script>
</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>

<?php
if (@$_SESSION['editPassword'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "เปลี่ยนรหัสผ่านสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['editPassword'] = "";
} else if (@$_SESSION['editPassword'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "เปลี่ยนรหัสผ่านไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['editPassword'] = "";
}
?>

</html>