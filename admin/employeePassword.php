<?php
@session_start();
if (!isset($_SESSION["emp_level"])) {
    @$_SESSION["empty"] = "y";
    header("location: index.php");
}
@include("./../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตั้งค่ารหัสผ่าน</title>
    <?php
    include("./../css/css_bootstap.php");
    ?>
    <link rel="stylesheet" href="./../css/sidebar.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-2 col-md-2">
                <?php include("./menu.php");
                ?>
            </div>
            <div class="col-lg-10 col-md-10">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-5">
                        <form action="./api/updatePassword.php" method="POST">
                            <div class="mt-3 mb-3">
                                <h3>แก้ไขรหัสผ่าน</h3>
                                <!-- Current SESSION['emp_id'] -->
                                <input type="hidden" name="emp_id" value="<?php echo $_SESSION["emp_id"] ?>">
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" name="emp_newPassword" id="emp_newPassword" class="form-control" placeholder="รหัสผ่านใหม่">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="input-group mb-3">
                                <input onkeyup="btnActivation()" type="password" name="emp_confirmPassword" id="emp_confirmPassword" class="form-control" placeholder="ยืนยันรหัสผ่าน">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="toggleConfirmPasswordVisibility()">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="mb-3" align="right">
                                <button id="btnModal" data-bs-toggle="modal" type="button" data-bs-target="#modalSubmit" class="btn btn-primary" disabled>บันทึก</button>
                            </div>
                            <div class="modal fade" id="modalSubmit" tabindex="-1" tabindex="-1" aria-labelledby="modalSubmitLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">เปลี่ยนรหัสผ่าน</h5>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="mb-3">
                                                <p>คุณต้องการเปลี่ยนรหัสผ่าน ใช่หรือไม่?</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function btnActivation() {
            if (!$('#emp_confirmPassword').val().length) {
                $('#btnModal').prop('disabled', true);
            } else {
                $('#btnModal').prop('disabled', false);
            }
        }

        function togglePasswordVisibility() {
            const emp_newPassword = $('#emp_newPassword');
            const toggleBtn = $('#togglePassword');

            if (emp_newPassword.attr('type') === 'password') {
                emp_newPassword.attr('type', 'text');
                toggleBtn.html('<i class="fas fa-eye"></i>');
            } else {
                emp_newPassword.attr('type', 'password');
                toggleBtn.html('<i class="fas fa-eye-slash"></i>');
            }
        }

        function toggleConfirmPasswordVisibility() {
            const emp_confirmPassword = $('#emp_confirmPassword');
            const toggleBtn = $('#toggleConfirmPassword');

            if (emp_confirmPassword.attr('type') === 'password') {
                emp_confirmPassword.attr('type', 'text');
                toggleBtn.html('<i class="fas fa-eye"></i>');
            } else {
                emp_confirmPassword.attr('type', 'password');
                toggleBtn.html('<i class="fas fa-eye-slash"></i>');
            }
        }
    </script>
</body>
<?php
include("./../js/jquery.php");
include("./../js/js_bootstrap.php");
include("./../js/sweetalert.php");
?>

<?php
if (@$_SESSION['changePassword'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: '" . @$type . "รหัสผ่านผู้ใช้งานไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['changePassword'] = "";
} else if (@$_SESSION['changePassword'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "รหัสผ่านผู้ใช้งาน', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['changePassword'] = "";
} else if (@$_SESSION['comparePassword'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: '" . @$type . "รหัสผ่านไม่ตรงกัน', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['comparePassword'] = "";
}
?>

</html>