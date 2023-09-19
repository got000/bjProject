
<div id="mySidenav" class="sidenav">
    <div class="brand">
        LOGO
    </div>
    <a href="./system.php" id="activeSystem">ข้อมูลระบบ</a>
    <a href="./employees.php" id="activeEmployee">จัดการข้อมูลผู้ใช้งาน</a>
    <a href="./product_type.php" id="activeProductType">จัดการประเภทสินค้า</a>
    <a href="./products.php" id="activeProducts">จัดการสินค้า</a>
    <a href="./logout.php" id="activeProductType">ออกจากระบบ</a>
</div>

<?php 
    include("./../js/jquery.php");
?>

<script>
    let pathname = window.location.href.split('/');
    let url = pathname[5];
    if(url === "system.php"){
        $('#activeSystem').addClass("active")
    }else if(url === "employees.php"){
        $('#activeEmployee').addClass("active")
    }else if(url === "product_type.php"){
        $('#activeProductType').addClass("active")
    }else if(url === "products.php"){
        $('#activeProducts').addClass("active")
    }
</script>