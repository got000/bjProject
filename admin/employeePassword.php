<?php
@session_start();
if(!isset($_SESSION["emp_level"])){
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
                    <?php include("./menu.php"); 
                    ?>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-5">
                            <form action="./api/updatePasswordEmployee.php" method="POST">
                                <div class="mb-3">
                                    <h3>แก้ไขรหัสผ่าน</h3>
                                    <!-- Current SESSION['emp_id'] -->
                                    <input type="hidden" name="emp_id" value="<?php echo $_SESSION["emp_id"] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>รหัสผ่านใหม่</label>
                                    <input type="password" name="emp_newPassword" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ยืนยันรหัสผ่าน</label>
                                    <input type="password" name="emp_confirmPassword" class="form-control">
                                </div>
                                <div class="mb-3" align="right">
                                    <button data-bs-toggle="modal" type="button" data-bs-target="#modalSubmitPassword" class="btn btn-primary">บันทึก</button>
                                </div>
                            </form>
                        </div>
                        <!-- modal submit -->
                        <div class="modal fade" id="modalSubmitPassword" tabindex="-1" tabindex="-1" aria-labelledby="modalSubmitPasswordLabel" aria-hidden="true">
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
                                        <button type="submit" class="btn btn-warning">ยืนยัน</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End modal submit -->
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