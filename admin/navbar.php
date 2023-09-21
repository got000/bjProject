<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
include("./../js/jquery.php");
include("./../js/js_bootstrap.php");
?>

<script>
    let pathname = window.location.href.split('/');
    let url = pathname[5];
    if (url === "system.php") {
        $('#activeSystem').addClass("active")
    } else if (url === "employees.php") {
        $('#activeEmployee').addClass("active")
    } else if (url === "product_type.php") {
        $('#activeProductType').addClass("active")
    } else if (url === "products.php") {
        $('#activeProducts').addClass("active")
    } else if (url === "employeePassword.php") {
        $('#activeEmployeePassword').addClass("active")
    }
</script>