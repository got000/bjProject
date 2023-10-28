<?php
@session_start();
include("./../config/config.php");
include("./../css/css_bootstap.php");
include("./../js/js_bootstrap.php");
?>

<?php
if (isset($_GET["add_problem"])) {
    $problemId = $_GET["add_problem"];
    $problemTypeId = $_GET["type"];
    $_SESSION["problemTypeId"] = $problemTypeId;
    $_SESSION["problemId"] = $problemId;
    $sql = "SELECT p.prob_name, p.prob_detail, p.prob_price, pt.probType_name FROM problems p LEFT JOIN problem_type pt ON p.probType_id = pt.id WHERE p.id='" . $problemId . "' LIMIT 1";
    $query = mysqli_query($con, $sql);
    $fetch = mysqli_fetch_assoc($query);

    if (count($_SESSION["problems"]) > 0) {
        $index = -1;
        for ($i = 0; $i < count($_SESSION["problems"]); $i++) {
            if ($_SESSION["problems"][$i]["prob_id"] == $problemId) {
                $index = $i;
                break;
            }
        }

        if ((int)$index !== -1) {
        } else {
            array_push($_SESSION["problems"], array(
                "prob_id" => $problemId,
                "probType_id" => $problemTypeId,
                "prob_name" => $fetch["prob_name"],
                "prob_price" => $fetch["prob_price"],
                "prob_detail" => $fetch["prob_detail"],
                "probType_name" => $fetch["probType_name"]
            ));
        }
    } else {
        $_SESSION["problems"][0] = array(
            "prob_id" => $problemId,
            "probType_id" => $problemTypeId,
            "prob_name" => $fetch["prob_name"],
            "prob_price" => $fetch["prob_price"],
            "prob_detail" => $fetch["prob_detail"],
            "probType_name" => $fetch["probType_name"]
        );
    }

    header("location: problem.php");
}
?>
<?php
if (isset($_GET["clear_problem"])) {
    $_SESSION["problems"] = [];
    $_SESSION["problemTypeId"] = "";
    $_SESSION["problemId"] = "";
    header("location: problem.php");
}

if (isset($_GET["delete_problem_item"])) {
    // get index from delete_item action
    $index = $_GET["delete_problem_item"];
    // set carts variable from $_SESSION["carts"]
    $problems = $_SESSION["problems"];
    unset($problems[$index]);
    $problems = array_values($problems);
    var_dump($problems);
    $_SESSION["problems"] = $problems;
    header("location: problem.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งปัญหา</title>
</head>

<body>
    <?php include("./navbar.php") ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-2 col-sm-12">
                <label for="problem_type" class="mt-2">ประเภทปัญหา</label>
            </div>
            <div class="col-md-4 col-sm-12">
                <select id="problem_type" class="form-select">
                    <option <?php if ($_SESSION["problemTypeId"] == "" || $_SESSION["problemTypeId"] == null) {
                                echo "selected";
                            } else {
                                echo "disabled";
                            } ?>>-เลือกประเภทปัญหา-</option>
                    <?php
                    $sql = "SELECT * FROM problem_type";
                    $query = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <option value="<?php echo $row["id"] ?>" <?php if ($_SESSION["problemTypeId"] == $row["id"]) echo "selected" ?>><?php echo $row["probType_name"] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 mt-2">
                <a style="float: right;" class="text-danger" href="<?php $_SERVER["PHP_SELF"] ?>?clear_problem=0">ยกเลิกรายการทั้งหมด</a>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 col-sm-12">
                <h6>--- รายการปัญหา ---</h6>
                <table id="table-problem" class="table table-hover mt-2">
                    <thead class="text-center">
                        <th width="10%">ลำดับ</th>
                        <th width="30%">ชื่อปัญหา</th>
                        <th width="40%">รายละเอียด</th>
                        <th width="10%">ราคา</th>
                        <th width="10%">#</th>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 col-sm-12">
                <?php
                if (count($_SESSION["problems"]) > 0) {
                    $i = 0;
                ?>
                    <h6>--- ปัญหาที่เลือก ---</h6>
                    <table id="table-problem-select" class="table table-hover table-striped mt-2">
                        <thead class="text-center">
                            <th width="5%">ลำดับ</th>
                            <th width="15%">ชื่อประเภทปัญหา</th>
                            <th width="20%">ชื่อปัญหา</th>
                            <th width="40%">รายละเอียด</th>
                            <th width="10%">ราคา</th>
                            <th width="10%">#</th>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($_SESSION["problems"] as $val) { ?>
                                <tr>
                                    <td><?php echo ($i + 1) ?></td>
                                    <td><?php echo $val["probType_name"] ?></td>
                                    <td><?php echo $val["prob_name"] ?></td>
                                    <td><?php echo $val["prob_detail"] ?></td>
                                    <td><?php echo number_format($val["prob_price"]) ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-outline-danger" href="<?php $_SERVER["PHP_SELF"] ?>?delete_problem_item=<?php echo $i ?>"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                            <?php $i++;
                            } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
        <!-- Modal Submit -->
        <div class="modal fade" id="modalProblem" tabindex="-1" tabindex="-1" aria-labelledby="modalProblemLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แจ้งปัญหา</h5>
                    </div>
                    <div class="modal-body text-center">
                        <div class="mb-3">
                            <span class="fs-5">คุณต้องการแจ้งปัญหาใช่หรือไม่ ?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form action="./api/addProblem.php" method="post">
                            <input type="hidden" value="<?php echo $_SESSION["cus_id"] ?>" name="cus_id">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-success">ยืนยัน</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Submit -->
    </div>
</body>
<?php
include("./../js/jquery.php");
include("./../js/ajax.php");
include("./../js/sweetalert.php");
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<script>
    $(document).ready(() => {
        let typeId = "<?php echo @$_SESSION["problemTypeId"] ?>";
        let dataProblem = <?php echo @json_encode($_SESSION["problems"]); ?>;
        console.log(dataProblem)

        if (typeId) {
            $.ajax({
                url: "api/getProblemByType.php",
                method: "POST",
                data: JSON.stringify({
                    problem_type: typeId
                }),
                async: false,
                success: (response) => {
                    let data = JSON.parse(response)
                    let table = ''
                    $.each(data, (index, value) => {
                        let price = numeral(Number(value?.prob_price)).format('0,0')
                        let chk = dataProblem?.some(v => Number(v?.prob_id) === Number(value?.prob_id))
                        if (chk) {
                            console.log("fetch true")
                            table += '<tr class="data text-center table-success">'
                        } else {
                            console.log("fetch false ", dataProblem[index]?.prob_id, " ", value?.prob_id)
                            table += '<tr class="data text-center">'
                        }
                        table += '<td>' + (index + 1) + '</td>'
                        table += '<td>' + value?.prob_name + '</td>'
                        table += '<td>' + value?.prob_detail + '</td>'
                        table += '<td>' + price + '</td>'
                        if (chk) {
                            table += '<td><span class="badge bg-warning">เลือกแล้ว</span></td>'
                        } else {
                            table += '<td><a href="<?php $_SERVER["PHP_SELF"] ?>?add_problem=' + value?.prob_id + '&type=' + value?.probType_id + '" class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i></a></td>'
                        }
                        table += '</tr>'
                    })
                    $("#table-problem tbody").append(table)
                    const buttonModal = '<button data-bs-toggle="modal" type="button" data-bs-target="#modalProblem" class="btn btn-dark position-absolute top-0 end-0 mt-3" style="width: 10rem;">แจ้งปัญหา</button>';
                    $('#table-problem tfoot').addClass("position-relative").append(buttonModal);
                },
                error: (error) => {
                    console.log({
                        error
                    })
                }
            })
        }
    })
    $("#problem_type").change((e) => {
        const typeId = e.target.value;
        let dataProblem = <?php echo @json_encode($_SESSION["problems"]); ?>;
        $(".data").remove();

        $.ajax({
            url: "api/getProblemByType.php",
            method: "POST",
            data: JSON.stringify({
                problem_type: typeId
            }),
            async: false,
            success: (response) => {
                let data = JSON.parse(response)
                let table = ''
                $.each(data, (index, value) => {
                    let price = numeral(Number(value?.prob_price)).format('0,0')
                    let chk = dataProblem?.some(v => Number(v?.prob_id) === Number(value?.prob_id))
                    if (chk) {
                        table += '<tr class="data text-center table-success">'
                    } else {
                        table += '<tr class="data text-center">'
                    }
                    table += '<td>' + (index + 1) + '</td>'
                    table += '<td>' + value?.prob_name + '</td>'
                    table += '<td>' + value?.prob_detail + '</td>'
                    table += '<td>' + price + '</td>'
                    if (chk) {
                        table += '<td><span class="badge bg-danger">เลือกแล้ว</span></td>'
                    } else {
                        table += '<td><a href="<?php $_SERVER["PHP_SELF"] ?>?add_problem=' + value?.prob_id + '&type=' + value?.probType_id + '" class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i></a></td>'
                    }
                    table += '</tr>'
                })
                $("#table-problem tbody").append(table)
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
if (@$_SESSION['problem'] == "success") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "สำเร็จ',";
    $swal .= "text: '" . "แจ้งปัญหาสำเร็จ', icon: 'success', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['problem'] = "";
} else if (@$_SESSION['problem'] == "error") {
    $swal = "";
    $swal .= "<script>";
    $swal .= "Swal.fire({";
    $swal .= "title: '" . "ไม่สำเร็จ',";
    $swal .= "text: '" . "แจ้งปัญหาไม่สำเร็จ', icon: 'error', confirmButtonText: 'ตกลง'})";
    $swal .= "</script>";
    echo @$swal;
    @$_SESSION['problem'] = "";
}
?>

</html>