<?php @session_start() ?>
<?php 
    function getPermissions($level){
        if($level === "1"){
            echo "ผู้ดูแลระบบ";
        }else if($level === "2"){
            echo "พนักงาน";
        }
    }
?>
<div id="mySidenav" class="sidenav">
    <div class="brand mb-3">
        <h4><?php 
            echo @ucfirst($_SESSION["emp_name"])." "
        ?><span style="font-size: 16px">(<?php getPermissions(@$_SESSION["emp_level"]) ?>)</span></h4>
    </div>
    <div class="manage-title">
        <h6>ข้อมูลพื้นฐาน</h6>
    </div>
    <?php if(@$_SESSION["emp_level"] === "1"){ ?>
    <a href="./system.php" id="activeSystem">จัดการข้อมูลร้าน</a>
    <a href="./employees.php" id="activeEmployee">จัดการข้อมูลผู้ใช้งาน</a>
    <?php } ?>
    <a href="./product_type.php" id="activeProductType">จัดการประเภทสินค้า</a>
    <a href="./products.php" id="activeProducts">จัดการสินค้า</a>
    <div class="manage-title">
        <h6>ข้อมูลซื้อขาย</h6>
    </div>
    <div class="manage-title">
        <h6>ข้อมูลการติดตั้ง</h6>
    </div>
    <div class="manage-title">
        <h6>ข้อมูลการแจ้งปัญหา</h6>
    </div>
    <a href="./employeePassword.php" id="activeEmployeePassword">แก้ไขรหัสผ่าน</a>
    <a href="./logout.php">ออกจากระบบ</a>
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
    }else if(url === "employeePassword.php"){
        $('#activeEmployeePassword').addClass("active")
    }
</script>