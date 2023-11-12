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
    <a href="./problem_type.php" id="activeProblemType">จัดการประเภทปัญหา</a>
    <a href="./problems.php" id="activeProblems">จัดการรายการปัญหา</a>
    <div class="manage-title">
        <h6>ข้อมูลซื้อขาย</h6>
    </div>
    <a href="./wait_approve.php" id="activeWaitForApprove">รายการรออนุมัติ</a>
    <a href="./order_approve.php" id="activeOrderApprove">รายการอนุมัติ</a>
    <a href="./cancelOrder_approve.php" id="activeCancelApprove">รายการอนุมัติยกเลิก</a>
    <a href="./order_cancel.php" id="activeOrderCancel">รายการยกเลิก</a>
    <div class="manage-title">
        <h6>ข้อมูลการติดตั้ง</h6>
    </div>
    <a href="./wait_install.php" id="activeWaitInstall">รายการรอติดตั้ง</a>
    <a href="./installed.php" id="activeInstalled">รายการติดตั้งสำเร็จ</a>
    <div class="manage-title">
        <h6>ข้อมูลการแจ้งปัญหา</h6>
    </div>
    <a href="./wait_approve_problem.php" id="activeProblemWaitForApprove">รายการรออนุมัติแจ้งปัญหา</a>
    <a href="./problem_approve.php" id="activeProblemApprove">รายการอนุมัติแจ้งปัญหา</a>
    <a href="./problem_success.php" id="activeProblemSuccess">รายการแจ้งปัญหาสำเร็จ</a>
    <a href="./cancelProblem_approve.php" id="activeProblemCancelApprove">รายการอนุมัติยกเลิกแจ้งปัญหา</a>
    <a href="./problem_cancel.php" id="activeProblemCancel">รายการยกเลิกแจ้งปัญหา</a>
    <div class="manage-title">
        <h6>ข้อมูลรายงาน</h6>
    </div>
    <a href="./report_purchase.php" id="reportPurchase">รายงานการสั่งซื้อ</a>
    <a href="./report_intallation.php" id="reportInstallation">รายงานการติดตั้ง</a>
    <a href="./report_problem.php" id="reportProblem">รายงานการแจ้งปัญหา</a>
    <a href="./best_selling_products.php" id="bestseller">รายงานสินค้าที่ถูกสั่งซื้อ</a>
    <a href="./unsold_products.php" id="unsold">รายงานสินค้าที่ไม่ถูกสั่งซื้อ</a>
    <div class="manage-title">
        <h6>ข้อมูลส่วนตัว</h6>
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
    }else if(url === "wait_approve.php"){
        $('#activeWaitForApprove').addClass("active")
    }else if(url === "wait_install.php"){
        $('#activeWaitInstall').addClass("active")
    }else if(url === "installed.php"){
        $('#activeInstalled').addClass("active")
    }else if(url === "order_cancel.php"){
        $('#activeOrderCancel').addClass("active")
    }else if(url === "order_approve.php"){
        $('#activeOrderApprove').addClass("active")
    }else if(url === "problem_type.php"){
        $('#activeProblemType').addClass("active")
    }else if(url === "problems.php"){
        $('#activeProblems').addClass("active")
    }else if(url === "wait_approve_problem.php"){
        $('#activeProblemWaitForApprove').addClass("active")
    }else if(url === "problem_approve.php"){
        $('#activeProblemApprove').addClass("active")
    }else if(url === "problem_success.php"){
        $('#activeProblemSuccess').addClass("active")
    }else if(url === "problem_cancel.php"){
        $('#activeProblemCancel').addClass("active")
    }else if(url === "report_purchase.php"){
        $('#reportPurchase').addClass("active")
    }else if(url === "report_intallation.php"){
        $('#reportInstallation').addClass("active")
    }else if(url === "report_problem.php"){
        $('#reportProblem').addClass("active")
    }else if(url === "best_selling_products.php"){
        $('#bestseller').addClass("active")
    }else if(url === "unsold_products.php"){
        $('#unsold').addClass("active")
    }else if(url === "cancelOrder_approve.php"){
        $('#activeCancelApprove').addClass("active")
    }else if(url === "cancelProblem_approve.php"){
        $('#activeProblemCancelApprove').addClass("active")
    }

</script>