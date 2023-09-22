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
        $district =   $json_data['district'];
    }
?>
<?php 
    //process
    $data = array();
    $sql = "SELECT * FROM districts WHERE id='".$district."' LIMIT 1";
    $query = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($query)){
        $data = array(
            "zip_code" => $row["zip_code"]
        );
    }

    echo json_encode($data);
?>