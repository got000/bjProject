<?php 
    @session_start();
?>
<?php 
    include("./../config/config.php");
    $sql = "SELECT * FROM systems LIMIT 1";
    $query = @mysqli_query($con, $sql);
    $fetch = @mysqli_fetch_assoc($query);
?>

<style>
    .dropdown-menu[data-bs-popper]{
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
        background: #ff0000;
        color: #fff;
        padding: 0 5px;
        vertical-align: top;
        margin-left: -10px; 
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="./../admin/uploads/systems/<?php echo @$fetch["stru_logo"] ?>" width="30" height="30" alt="">
        </a>
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
                <?php if(!isset($_SESSION['cus_id'])){ ?>
                <li class="nav-item">
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalLogin">เข้าสู่ระบบ</button>
                </li>
                <li style="width: 10px;"></li>
                <li class="nav-item">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegister">สมัครสมาชิก</button>
                </li>
                <?php } ?>
                <li style="width: 10px;"></li>
                <?php if(isset($_SESSION['cus_id'])){ ?>
                <li class="nav-item">
                    <i class="fas fa-shopping-cart mt-2" style="font-size: 22px; cursor: pointer;">
                        <span class='badge badge-warning' id='lblCartCount'>0</span>
                    </i>
                </li>
                <li style="width: 10px;"></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                        <?php echo $_SESSION['cus_name'] ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="./edit_profile.php">จัดการข้อมูลส่วนตัว</a></li>
                        <li><a class="dropdown-item" href="./edit_password.php">แก้ไขรหัสผ่าน</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="">ประวัติการซื้อสินค้า</a></li>
                        <li><a class="dropdown-item" href="">ประวัติการแจ้งปัญหา</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="./logout.php">ออกจากระบบ</a></li>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<?php
include("./../js/jquery.php");
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