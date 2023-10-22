<?php

@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../css/css_bx_icon.php");
include("./../js/js_bootstrap.php");
?>
<?php
if (isset($_GET["add_cart"])) {
    $pro_id = $_GET["add_cart"];
    $sql = "SELECT * FROM products WHERE pro_id='" . $pro_id . "' LIMIT 1";
    $query = @mysqli_query($con, $sql);
    $fetch = mysqli_fetch_assoc($query);

    if (count($_SESSION["carts"]) > 0) {
        $index = -1;
        for ($i = 0; $i < count($_SESSION["carts"]); $i++) {
            if ($_SESSION["carts"][$i]["pro_id"] == $pro_id) {
                $index = $i;
                break;
            }
        }

        if ((int)$index !== -1) {
            $val = (int)$_SESSION["carts"][$index]["pro_amount"];
            $val += 1;
            $_SESSION["carts"][$index]["pro_amount"] = $val;
        } else {
            array_push($_SESSION["carts"], array(
                "id" => $fetch["id"],
                "pro_id" => $fetch["pro_id"],
                "pro_name" => $fetch["pro_name"],
                "pro_amount" => 1,
                "pro_price" => $fetch["pro_price"],
                "protype_id" => $fetch["protype_id"],
                "pro_image" => $fetch["pro_image"]
            ));
        }
    } else {
        $_SESSION["carts"][0] = array(
            "id" => $fetch["id"],
            "pro_id" => $fetch["pro_id"],
            "pro_name" => $fetch["pro_name"],
            "pro_amount" => 1,
            "pro_price" => $fetch["pro_price"],
            "protype_id" => $fetch["protype_id"],
            "pro_image" => $fetch["pro_image"]
        );
    }

    header("location: index.php");
}

if (isset($_GET["clear_cart"])) {
    $_SESSION["carts"] = [];
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <style>
        .baht-icon::before {
            content: "฿";
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }

        .btn-circle:hover {
            background-color: gray;
        }

        .card:hover {
            outline: 1px solid black;
        }

        .add-card{
            cursor: pointer;
            color: #000;
        }
    </style>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container-fluid bg-light h-100">
        <!-- <div class="row">
            <div class="col-md-12">
                <?php echo json_encode(@$_SESSION["carts"]) ?>
                <a href="<?php echo $_SERVER["PHP_SELF"] ?>?clear_cart=0" class="btn btn-danger">clear cart</a>
                <form action="./api/addOrder.php" method="POST">
                    <input type="hidden" value="<?php echo @$_SESSION["cus_id"] ?>" name="cus_id">
                    <button class="btn btn-success" type="submit">order</button>
                </form>
            </div>
        </div> -->
        <div class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <?php
                            $sql = "SELECT * FROM products";
                            $query = @mysqli_query($con, $sql);
                            if ($query->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
                                        <div class="card shadow-sm">
                                            <a href="./product_view.php?id=<?php echo $row["id"] ?>" class="mx-auto my-auto mt-3">
                                                <img src="../admin/uploads/<?php echo $row["pro_image"] ?>" alt="..." width="200" height="200">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row["pro_name"] ?></h5>
                                                <p class="card-text"><?php echo $row["pro_detail"] ?></p>
                                                <div class="d-flex justify-content-between align-self-center">
                                                    <span>฿<?php echo $row["pro_price"] ?></span>
                                                    <?php
                                                    if (isset($_SESSION["cus_id"])) {
                                                    ?>
                                                        <a class="add-card" href="<?php echo $_SERVER["PHP_SELF"] ?>?add_cart=<?php echo $row["pro_id"] ?>"><i style="color: #0d6efd;" class='bx bxs-cart-add fs-4'></i></a>
                                                    <?php } else { ?>
                                                        <a class="add-card" data-bs-toggle="modal" data-bs-target="#modalLogin"><i class='bx bxs-cart-add fs-4' style="color: #0d6efd;"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>
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
                            <label for="tel" class="col-form-label">เบอร์โทร:</label>
                            <input maxlength="10" type="text" name="tel" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">รหัสผ่าน:</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="col-form-label">ที่อยู่:</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="province" class="col-form-label">จังหวัด:</label>
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
                            <select name="amphur" id="amphur" class="form-select">
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fname" class="col-form-label">ตำบล:</label>
                            <select name="district" id="district" class="form-select">
                            </select>
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
                        <div class="mb-3">
                            <label for="username" class="col-form-label">ชื่อผู้ใช้งาน:</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">รหัสผ่าน:</label>
                            <input type="password" name="password" class="form-control">
                        </div>
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
include("./../js/sweetalert.php");
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
if (@$_SESSION['register'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "ลงทะเบียนบัญชีสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
} else if (@$_SESSION['register'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "ลงทะเบียนบัญชีไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
} else if (@$_SESSION['register'] == "duplicate") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "มีผู้ใช้เบอร์โทรศัพท์นี้แล้ว', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['register'] = "";
} else if (@$_SESSION['login'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "เข้าสู่ระบบสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['login'] = "";
} else  if (@$_SESSION['login'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "เข้าสู่ระบบไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['login'] = "";
} else  if (@$_SESSION['order'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
} else  if (@$_SESSION['order'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "สั่งซื้อสินค้าไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
} else  if (@$_SESSION['order'] == "empty") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่มีรายการสินค้า',";
    $swal .= "text: '" . "ไม่สามารถสั่งซื้อได้ เนื่องจากไม่พบสินค้าในตระกร้า', icon: 'warning', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['order'] = "";
}
?>

</html>