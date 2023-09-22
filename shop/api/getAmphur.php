<?php 
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
        $province =   $json_data['province'];
    }
?>
<?php 
    //process
    $data = array();
    $sql = "SELECT * FROM amphures WHERE province_id='".$province."'";
    $query = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($query)){
        $data[] = array(
            "id" => $row["id"],
            "name_th" => $row["name_th"],
        );
    }

    echo json_encode($data);
?>