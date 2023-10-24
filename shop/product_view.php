<?php

use function PHPSTORM_META\map;

@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../css/css_bx_icon.php");
include("./../js/js_bootstrap.php");
?>
<!DOCTYPE html>
<html lang="en">
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
    header("location: product_view.php?id=".$fetch['id']);
}

if (isset($_GET["to_cart"])) {
    $pro_id = $_GET["to_cart"];
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
    header("location: cart.php");
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <style>
        .button4 {
            background-color: white;
            color: black;
            border: 1px solid #e7e7e7;
            width: 2rem;
            text-decoration: none;
            font-size: 1.2rem;
            text-align: center;
            cursor: pointer;
        }

        .input4 {
            background-color: white;
            color: black;
            border: 1px solid #e7e7e7;
            width: 3rem;
            text-align: center;
        }

        .button4:hover {
            background-color: #e7e7e7;
        }
    </style>
</head>

<body>
    <?php include("./navbar.php") ?>

    <div class="py-5 vh-100">
        <div class="container">
            <div class="row">
                <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM products WHERE id='" . $id . "'";
                    $query = @mysqli_query($con, $sql);
                    $product = mysqli_fetch_assoc($query);
                    if ($product) {
                ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 bg-light">
                            <div class="text-center p-3">
                                <img src="../admin/uploads/<?php echo $product["pro_image"] ?>" alt="..." width="500" height="500">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 px-5">
                            <div class="col-6 w-100 mb-3">
                                <span class="fs-2 fw-bold"><?php echo $product["pro_name"] ?></span>
                            </div>
                            <div class="col-6 w-100 mb-3">
                                <span class="fs-4">฿<?php echo number_format($product["pro_price"]) ?></span>
                            </div>
                            <div class="col-md-6 w-100 mb-3">
                                <span class="fs-5">รายละเอียดสินค้า</span>
                                <ul class="mt-3">
                                    <?php
                                    $details = $product['pro_detail'];
                                    $detail_parts = explode(',', $details);
                                    foreach ($detail_parts as $detail) {
                                    ?>
                                        <li><?php echo $detail ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php if (isset($_SESSION["cus_id"])) { ?>
                                <div class="col-md-6 d-flex gap-2 align-items-center mt-4 w-100 mb-3">
                                    <!-- <div class="col-3 d-flex">
                                        <a class="button4">-</a>
                                        <input type="text" class="input4" value="1">
                                        <a class="button4">+</a>
                                    </div> -->
                                    <div class="col-6">
                                        <span>มีสินค้าทั้งหมด <?php echo number_format($product["pro_amount"]) ?> ชิ้น</span>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-6 d-flex w-100 mt-5">
                                <?php
                                if (isset($_SESSION["cus_id"])) {
                                ?>
                                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?add_cart=<?php echo $product["pro_id"] ?>" class="btn btn-outline-dark" style="width: 10rem;"><i class='bx bxs-cart-add fs-5'></i> เพิ่มไปยังรถเข็น </a>
                                    <a href="<?php echo $_SERVER["PHP_SELF"] ?>?to_cart=<?php echo $product["pro_id"] ?>" class="btn btn-dark mx-3" style="width: 10rem;">ซื้อสินค้า</a>
                                <?php } else { ?>
                                    <a data-bs-toggle="modal" data-bs-target="#modalLogin" class="btn btn-outline-dark" style="width: 10rem;"><i class='bx bxs-cart-add fs-5'></i> เพิ่มไปยังรถเข็น </a>
                                    <a data-bs-toggle="modal" data-bs-target="#modalLogin" class="btn btn-dark mx-3" style="width: 10rem;">ซื้อสินค้า</a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row justify-content-center text-center py-5 px-5">
                                <div><i class='bx bxs-x-square' style="font-size: 8rem;"></i></div>
                                <span class="fs-3 fw-bolder">ไม่พบสินค้า</span>
                                <div class="mt-5">
                                    <a href="./index.php" style="width: 10rem;" class="btn btn-outline-dark">กลับสู่หน้าหลัก</a>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
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
    </div>

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

</html>