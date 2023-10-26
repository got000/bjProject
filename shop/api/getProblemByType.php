<?php 
    @session_start();
    @header("content-type:application/json;charset=utf-8");
    @header('Content-Type: text/html; charset=UTF-8');
    @header("Access-Control-Allow-Origin: *");
    @header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
    include("./../../config/config.php");
?>
<?php 
    //input
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $content = @file_get_contents('php://input');
        $json_data = @json_decode($content, true);
        $problem_type =   $json_data['problem_type'];

        $_SESSION["problemTypeId"] = $problem_type;
    }
?>
<?php 
    //process
    $data = array();
    $sql_type = "SELECT * FROM problem_type WHERE id='".$problem_type."' LIMIT 1";
    $query_type = mysqli_query($con, $sql_type);
    $fetch_type = mysqli_fetch_assoc($query_type);

    $sql = "SELECT * FROM problems WHERE probType_id='".$problem_type."'";
    $query = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($query)){
        $data[] = array(
            "probType_id" => $fetch_type["id"],
            "probType_name" => $fetch_type["probType_name"],
            "prob_id" => $row["id"],
            "prob_name" => $row["prob_name"],
            "prob_price" => $row["prob_price"],
            "prob_detail" => $row["prob_detail"]
        );
    }

    echo json_encode($data);
?>