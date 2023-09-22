<?php
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
                <div class="col-lg-12 col-md-12">
                </div>
            </div>
        </div>

        <!-- Modal Register -->
        <div class="modal fade" id="modalRegister" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="" method="post">
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
                                        while($row = mysqli_fetch_assoc($query)){
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
                    <form action="" method="post">
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
                    console.log({error})
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
                    console.log({error})
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
                    console.log({error})
                }
            })
        })
    </script>
</html>