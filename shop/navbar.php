<?php
@session_start();
?>
<?php
include("./../config/config.php");
$sql = "SELECT * FROM systems LIMIT 1";
$query = @mysqli_query($con, $sql);
$fetch = @mysqli_fetch_assoc($query);
?>
<?php
@$amount = 0;
if (isset($_SESSION["cus_id"])) {
    if (@count(@$_SESSION["carts"]) > 0) {
        foreach (@$_SESSION["carts"] as $item) {
            @$amount += (int)$item["pro_amount"];
        }
    }
}
?>
<style>
    .dropdown-menu[data-bs-popper] {
        top: 48px;
        left: -60px;
    }

    .badge {
        padding-left: 9px;
        padding-right: 9px;
        -webkit-border-radius: 9px;
        -moz-border-radius: 9px;
        border-radius: 9px;
    }

    .label-warning[href],
    .badge-warning[href] {
        background-color: #c67605;
    }

    #lblCartCount {
        font-size: 12px;
        background: #262626;
        color: #fff;
        padding: 0 5px;
        vertical-align: top;
        margin-left: -10px;
    }

    .btn-carts {
        text-decoration: none;
        color: #000;
    }

    .btn-carts:hover {
        text-decoration: none;
        color: darkgray;
    }
</style>

<div class="container-fluid shadow-sm">
    <header class="container">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fff;">
            <!-- <div class="container-fluid"> -->
            <!-- <a class="navbar-brand" href="#">
                    <img src="./../admin/uploads/systems/<?php echo @$fetch["stru_logo"] ?>" width="30" height="30" alt="">
                </a> -->
            <a class="navbar-brand text-primary fw-bold" href="./index.php">Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" id="homeActive" aria-current="page" href="./index.php">หน้าหลัก</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['cus_id'])) { ?>
                        <li class="nav-item">
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalLogin">เข้าสู่ระบบ</button>
                        </li>
                        <li style="width: 10px;"></li>
                        <li class="nav-item">
                            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalRegister">สมัครสมาชิก</button>
                        </li>
                    <?php } ?>
                    <li style="width: 10px;"></li>
                    <?php if (isset($_SESSION['cus_id'])) { ?>
                        <li class="nav-item">
                            <a href="./cart.php" class="btn-carts">
                                <i class="bx bxs-cart mt-2 fs-4" style="cursor: pointer;">
                                    <span class='badge badge-warning' id='lblCartCount'><?php echo @$amount; ?></span>
                                </i>
                            </a>
                        </li>
                        <li style="width: 1.5rem;"></li>
                        <li class="nav-item dropdown d-flex justify-content-between align-items-center">
                            <span><i class='bx bxs-user-circle fs-4'></i></span>
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <?php echo $_SESSION['cus_name'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="./edit_profile.php">จัดการข้อมูลส่วนตัว</a></li>
                                <li><a class="dropdown-item" href="./edit_password.php">แก้ไขรหัสผ่าน</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="./problem.php">แจ้งปัญหา</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="./purchase.php">ประวัติการซื้อสินค้า</a></li>
                                <li><a class="dropdown-item" href="./problem_history.php">ประวัติการแจ้งปัญหา</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="./logout.php">ออกจากระบบ</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>
</div>

<?php
include("./../js/jquery.php");
include("./../css/css_bx_icon.php");
include("./../css/css_bootstap.php");
?>

<script>
    let pathname = window.location.href.split('/');
    let url = pathname[5];
    if (url === "index.php" || url === "") {
        $('#homeActive').addClass("active")
    } else if (url === "employees.php") {
        $('#productActive').addClass("active")
    }
</script>