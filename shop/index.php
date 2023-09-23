<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <!-- LEFT SIDE HERE! -->
            </div>
            <div class="col-lg-6 col-md-6">
                <h2 class="pb-2 border-bottom text-center mt-5">เลือกซื้อสินค้า</h2>
                <div class="row px-5 py-4">
                    <?php
                    $sql = "SELECT * FROM products";
                    $query = @mysqli_query($con, $sql);
                    if ($query->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                            <div class="col-lg-3 col-md-3 mb-3">
                                <div class="card">
                                    <a href="./product_view.php?pro_id=<?php echo $row["pro_id"] ?>">
                                        <img src="../admin/uploads/<?php echo $row["pro_image"] ?>" style="width: 100%; height: 100px; object-fit:cover;" class="card-img-top" alt="...">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row["pro_name"] ?></h5>
                                        <p class="card-text"><?php echo $row["pro_detail"] ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="fw-bold"><i class="fab fa-btc"></i><?php echo $row["pro_price"] ?></p>
                                            <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-cart-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <!-- ADD HTML ELEMENTS FOR DEBUGING CASE: NO PRODUCTS -->
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- ADD HTML ELEMENTS FOR NO PRODUCTS -->
            <div class="col-lg-3 col-md-3">
                <!-- RIGHT SIDE HERE! -->
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="modalRegister" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="./register.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegisterLabel">ลงทะเบียน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">ชื่อ:</label>
                            <input type="text" name="fname" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">นามสกุล:</label>
                            <input type="text" name="lname" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">เบอร์โทร:</label>
                            <input type="text" name="tel" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">รหัสผ่าน:</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">จังหวัด:</label>
                            <select name="province" id="province" class="form-select">
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
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">อำเภอ:</label>
                            <select name="amphur" id="amphur" class="form-select"></select>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">ตำบล:</label>
                            <select name="district" id="district" class="form-select"></select>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">ไปรษณีย์:</label>
                            <input type="text" name="zip_code" id="zip_code" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-outline-success">ลงทะเบียน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Register -->

    <!-- Modal Login -->
    <div class="modal fade" id="modalLogin" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="./login.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLoginLabel">เข้าสู่ระบบ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-outline-success">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Login -->
</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/js_bootstrap.php");
?>

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
<!-- Alert -->
<?php
@$type = @$_SESSION["registerHeader"] || @$_SESSION["loginHeader"];

if (@$_SESSION['register'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "บัญชีสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
}else if (@$_SESSION['register'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ไม่สำเร็จ',";
    $swal .= "text: '" . @$type . "บัญชีไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
}else if (@$_SESSION['register'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ไม่สำเร็จ',";
    $swal .= "text: '" . @$type . "เบอร์โทรศัพท์ซ้ำ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
}else if (@$_SESSION['login'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "สำเร็จ',";
    $swal .= "text: '" . @$type . "สำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['login'] = "";
}else  if (@$_SESSION['login'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . @$type . "ไม่สำเร็จ',";
    $swal .= "text: '" . @$type . "ไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['login'] = "";
}    
?>
</html>