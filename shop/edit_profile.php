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
    <title>แก้ไขข้อมูลส่วนตัว</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 bg-light shadow rounded-5 p-3">
                <h1 class="text-center">แก้ไขข้อมูลส่วนตัว</h1>
                <form action="./api/updateProfile.php" method="post">
                    <input type="hidden" value="<?php echo $_SESSION['cus_id'] ?>" class="form-control">
                    <div class="row g-2 px-5">
                        <div class="col-md mb-3">
                            <?php
                            $name = $_SESSION["cus_name"];
                            $name_parts = explode(" ", $name);
                            $fname = $name_parts[0];
                            $lname = $name_parts[1];
                            ?>
                            <label for="flname" class="form-label">ชื่อ</label>
                            <input value="<?php echo $fname ?>" name="fname" type="text" class="form-control" id="flname">
                        </div>
                        <div class="col-md mb-3">
                            <div class="mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input value="<?php echo $lname ?>" name="lname" type="text" class="form-control" id="lname">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 px-5">
                        <label for="tel" class="form-label">เบอร์โทร</label>
                        <input maxlength="10" value="<?php echo $_SESSION['cus_tel'] ?>" name="tel" type="text" class="form-control" id="tel">
                    </div>
                    <div class="mb-3 px-5">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <input value="<?php echo $_SESSION['cus_address'] ?>" name="address" type="text" class="form-control" id="address">
                    </div>
                    <div class="mb-3 px-5">
                        <label for="province" class="col-form-label">จังหวัด:</label>
                        <select value="<?php echo $_SESSION['cus_province'] ?>" name="province" id="province" class="form-select">
                            <option selected>เลือกจังหวัด</option>
                            <?php
                            $sql = "SELECT * FROM provinces";
                            $query = @mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                <option value="<?php echo $row["id"] ?>"><?php echo $row["name_th"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3 px-5">
                        <label for="amphur" class="col-form-label">อำเภอ:</label>
                        <select value="<?php echo $_SESSION['cus_amphur'] ?>" name="amphur" id="amphur" class="form-select"></select>
                    </div>
                    <div class="mb-3 px-5">
                        <label for="district" class="col-form-label">ตำบล:</label>
                        <select value="<?php echo $_SESSION['cus_district'] ?>" name="district" id="district" class="form-select"></select>
                    </div>
                    <div class="mb-3 px-5">
                        <label for="zip_code" class="col-form-label">ไปรษณีย์:</label>
                        <input value="<?php echo $_SESSION['cus_zip_code'] ?>" type="text" name="zip_code" id="zip_code" class="form-control">
                    </div>
                    <div class="mb-3 px-5 d-flex justify-content-end">
                        <button data-bs-toggle="modal" type="button" data-bs-target="#modalSubmit" class="btn btn-primary">บันทึก</button>
                    </div>
                    <!-- modal Submit -->
                    <div class="modal fade" id="modalSubmit" tabindex="-1" tabindex="-1" aria-labelledby="modalSubmitLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">แก้ไขข้อมูลส่วนตัว</h5>
                                </div>
                                <div class="modal-body text-center">
                                    <div class="mb-3">
                                        <p>คุณต้องการแก้ไขข้อมูลส่วนตัว ใช่หรือไม่?</p>
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
</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>

<script>
    $(document).ready(function() {
        getCurrentProvince();
        getCurrentAmphur();
        getCurrentDistrict();
    })
</script>

<script>
    const getCurrentProvince = () => {
        let province = <?php echo $_SESSION["cus_province"] ?>;
        $.ajax({
            url: "api/getAmphur.php",
            method: "POST",
            data: JSON.stringify({
                province
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                $.each(data, (index, value) => {
                    $("#amphur").append(`<option value="${value.id}">${value.name_th}</option>`)
                })
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    }

    const getCurrentAmphur = () => {
        let amphur = <?php echo $_SESSION["cus_amphur"] ?>

        $.ajax({
            url: "api/getDistrict.php",
            method: "POST",
            data: JSON.stringify({
                amphur
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                $.each(data, (index, value) => {
                    $("#district").append(`<option value="${value.id}">${value.name_th}</option>`)
                })
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    }

    const getCurrentDistrict = () => {
        let district = <?php echo $_SESSION["cus_district"] ?>

        $.ajax({
            url: "api/getZipCode.php",
            method: "POST",
            data: JSON.stringify({
                district
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                $("#zip_code").val(data?.zip_code)
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    }
</script>

<script>
    $('#province').change((e) => { // ค้นหาอำเภอด้วย id ของจังหวัด
        let province = e.target.value
        $.ajax({
            url: "api/getAmphur.php",
            method: "POST",
            data: JSON.stringify({
                province
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                $("#amphur").empty();
                $("#zip_code").val("");
                $("#district").empty();
                $("#amphur").append(`<option value="0">เลือกอำเภอ</option>`)
                $.each(data, (index, value) => {
                    $("#amphur").append(`<option value="${value.id}">${value.name_th}</option>`)
                })
                console.log(data);
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    })

    $('#amphur').change((e) => { // ค้นหาตำบลด้วย id ของอำเภอ
        let amphur = e.target.value
        $.ajax({
            url: "api/getDistrict.php",
            method: "POST",
            data: JSON.stringify({
                amphur
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                $("#district").empty();
                $("#zip_code").val("");
                $("#district").append(`<option value="0">เลือกตำบล</option>`)
                $.each(data, (index, value) => {
                    $("#district").append(`<option value="${value.id}">${value.name_th}</option>`)
                })
                console.log(data);
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    })

    $('#district').change((e) => { // ค้นหารหัสไปรษณีย์ด้วย id ของตำบล
        let district = e.target.value

        $.ajax({
            url: "api/getZipCode.php",
            method: "POST",
            data: JSON.stringify({
                district
            }),
            async: false,
            success: (response) => {
                $("#zip_code").val("");
                let data = JSON.parse(response)
                $("#zip_code").val(data?.zip_code)
            },
            error: (error) => {
                console.log({
                    error
                })
            }
        })
    })
</script>

<?php
if (@$_SESSION['editProfile'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "แก้ไขข้อมูลสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['editProfile'] = "";
} else if (@$_SESSION['editProfile'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "แก้ไขข้อมูลไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['editProfile'] = "";
} else if (@$_SESSION['editProfile'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "มีผู้ใช้เบอร์โทรศัพท์นี้แล้ว', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['editProfile'] = "";
}
?>

</html>