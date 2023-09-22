<?php 
  @session_destroy();
	@session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        include("./../css/css_bootstap.php");
    ?>
    <link rel="stylesheet" href="./../css/sidebar.css">
    <title>Admin Management|Login</title>
    <style>
        :root{
            --main-bg:#3399ff;
        }

        .main-bg {
            background: var(--main-bg) !important;
        }

        input:focus, button:focus {
            border: 1px solid var(--main-bg) !important;
            box-shadow: none !important;
        }

        .form-check-input:checked {
            background-color: var(--main-bg) !important;
            border-color: var(--main-bg) !important;
        }

        .card, .btn, input{
            border-radius:0 !important;
        }
    </style>
</head>
<body class="main-bg">
  <!-- Login Form -->
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-3 col-md-3"></div>
      <div class="col-lg-6 col-md-6">
        <?php if(@$_SESSION["authen"] === "failed"){ ?>
          <div class="alert alert-danger text-center" role="alert">
            ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง
          </div>
        <?php unset($_SESSION["authen"]); } ?>
      </div>
      <div class="col-lg-3 col-md-3"></div>
    </div>
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">เข้าสู่ระบบ</h2>
          </div>
          <div class="card-body">
            <form action="./login.php" method="POST">
              <div class="mb-4">
                <label for="username" class="form-label">ชื่อผู้ใช้/เบอร์โทรศัพท์</label>
                <input type="text" name="username" class="form-control" id="username" />
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" id="password" />
              </div>
              <div class="d-grid">
                <button type="submit" class="btn text-light main-bg">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php 
  include("./../js/jquery.php");
  include("./../js/sweetalert.php");
  if (@$_SESSION['empty'] == "y") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: 'ไม่มีสิทธิ',";
    $swal .= "text: 'กรุณาเข้าสู่ระบบใหม่อีกครั้ง', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    session_destroy();
  }
?>
</html>