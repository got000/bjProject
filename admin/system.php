<?php
@session_start();
if(isset($_SESSION["emp_level"]) && @$_SESSION["emp_level"] !== "1"){
   @$_SESSION["empty"] = "y";
   header("location: index.php");
}else if(!isset($_SESSION["emp_level"])){
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
    <title>ตั้งค่าระบบ</title>
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
                    <?php include("./menu.php");?>
                </div>
                <?php
                $sql = "SELECT * FROM systems";
                $query = @mysqli_query($con, $sql);
                if ($query->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                ?>
                        <div class="col-lg-10 col-md-10">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <h3>ตั้งค่าร้าน</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-lg-5 col-md-5">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 text-center">
                                            <img src="./uploads/systems/<?php echo $row['stru_logo'] ?>" alt="Logo" height="100" width="100">
                                        </div>
                                    </div>
                                    <form action="./api/systemAction.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="hidden" name="stru_id" value="<?php echo $row["stru_id"] ?>">
                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>โลโก้</label>
                                            <input type="file" name="stru_logo" class="form-control">
                                            <input type="hidden" value="<?php echo $row["stru_logo"] ?>" name="stru_logo_old" class="form-control" required>

                                        </div>
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ชื่อร้าน</label>
                                            <input type="text" value="<?php echo $row["stru_name"] ?>" name="stru_name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ประกาศทางร้าน</label>
                                            <textarea rows="3" class="form-control" value="<?php echo $row["stru_ann"] ?>" name="stru_ann"><?php echo $row["stru_ann"] ?></textarea rows="3">
                                        </div>
                                        <div class="mb-3">
                                            <label for="recipient-name" class="col-form-label"><span class="text-danger"><b>*</b></span>ที่อยู่ร้าน</label>
                                            <textarea rows="3" class="form-control" value="<?php echo $row["stru_add"] ?>" name="stru_add"><?php echo $row["stru_add"] ?></textarea rows="3">
                                        </div>
                                        <div class="mb-3" align="right">
                                            <button class="btn btn-primary" type="submit">บันทึก</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                    }
                } else {
                        ?>
                        <div class="row">ไม่มัข้อมูล</div>
                    <?php
                }
                    ?>
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
@$type = @$_SESSION["systemHeader"];

if (@$_SESSION['updateSystem'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "ระบบสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateSystem'] = "";
} else if (@$_SESSION['updateSystem'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: 'ข้อมูลระบบซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateSystem'] = "";
} else if (@$_SESSION['updateSystem'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ล้มเหลว',";
    $swal .= "text: 'แก้ไขระบบ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['updateSystem'] = "";
}
?>