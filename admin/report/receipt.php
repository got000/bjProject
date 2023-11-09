<?php
    require_once('./files/tcpdf.php');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "senior_project";
    $conn = new mysqli($servername, $username, $password);
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");

    $id = $_GET['order_id'];

    $pdf = new TCPDF('P', 'mm', array('210', '297'), true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Bom');
    $pdf->SetTitle('ใบเสร็จรับเงิน');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->SetFont('thsarabun', '', 14);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(10, 5, 10, true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 0);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    $pdf->AddPage();
    $pdf->SetLineStyle(array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    $x = 5;
    $y = 5;
    $h = 160;
    // $img_h = 32;
    // $img_w = 32;
    $sm_w = 10;
    $lg_w = 22;
    $md_w = 22;
    $img_h = -3;
    $img_w = -3;
    $table_width = 196;
    $table_height = 260;
    $offset= 15;
    $x_offset = 40;
    $sql = "SELECT * FROM systems LIMIT 1";
    $result = $conn->query($sql);
    $fetch = $result->fetch_assoc();
    $pdf->Image('./../uploads/systems/'.$fetch["stru_logo"], 10, $y + 10, 40, 100, '', '', '', false, 300, '', false, false, 0, 0, false, false);
    $pdf->SetFont('thsarabun', 'b', 14);
    $pdf->SetXY($x, $y);

    $pdf->SetXY(0, $y + 10);

    
    $sql = "SELECT 
                o.order_id, 
                o.order_date, 
                o.order_status, 
                o.order_type, 
                c.cus_name, 
                c.cus_tel, 
                c.cus_zip_code, 
                c.cus_address, 
                p.id, 
                a.id, 
                d.id, 
                p.name_th as province, 
                a.name_th as amphure, 
                d.name_th as district 
            FROM 
                orders o 
            LEFT JOIN 
                customers c ON o.cus_id = c.cus_id 
            LEFT JOIN 
                provinces p ON c.cus_province = p.id 
            LEFT JOIN 
                amphures a ON c.cus_amphur = a.id 
            LEFT JOIN 
                districts d ON c.cus_district = d.id 
            WHERE 
                o.id = '".$id."' 
            LIMIT 1";
    $result = $conn->query($sql);

    $order_id = "";
    $order_date = "";
    $order_status = "";
    $order_type = "";
    $cus_name = "";
    $cus_tel = "";
    $cus_zip_code = "";
    $cus_address = "";
    $province = "";
    $amphure = "";
    $district = "";

    while($row = $result->fetch_assoc()){
        $order_id = $row["order_id"];
        $order_date = $row["order_date"];
        $order_status = $row["order_status"];
        $order_type = $row["order_type"];
        $cus_name = $row["cus_name"];
        $cus_tel = $row["cus_tel"];
        $cus_zip_code = $row["cus_zip_code"];
        $cus_address = $row["cus_address"];
        $province = $row["province"];
        $amphure = $row["amphure"];
        $district = $row["district"];
    }

    $pdf->SetXY($x+$img_h+$x_offset+33, $y+=20-$offset);
    $pdf->SetFont('thsarabun', 'b', 30);
    $pdf->SetTextColor(45, 179, 216);
    $pdf->Write(0, $fetch["stru_name"], '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY($x+$img_h+$x_offset+33, $y+=20);

    $address = explode(",", $fetch["stru_add"]);
    
    $pdf->SetFont('thsarabun', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Write(0, $address[0], '', 0, 'L', true, 0, false, false, 0);
    
    $pdf->SetXY($x+$img_h+$x_offset+33, $y+=5);
    $pdf->Write(0, $address[1], '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY($x+$img_h+$x_offset+33, $y+=5);
    // $pdf->Write(0, 'โทร. 064-5636594, 0864232639 เลขประจำตัวผู้เสียภาษี 3901100206511', '', 0, 'L', true, 0, false, false, 0);

    $pdf->SetXY($x+$img_h+$x_offset+33, $y+=15);
    $pdf->RoundedRect($x+75, $y-5 , 55, 15, 3, '0101', null, array("color" => array(45, 179, 216)));

    $pdf->SetXY($x+$img_h+$x_offset+48+5, $y-2);
    $pdf->SetFont('thsarabun', 'b', 18);
    $pdf->Write(0, 'ใบเสร็จรับเงิน', '', 0, 'L', true, 0, false, false, 0);

    $pdf->SetXY($x+10, $y+15);
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Write(0, 'นามลูกค้า', '', 0, 'L', true, 0, false, false, 0);
    
    $pdf->SetXY($x + 28, $y+14.5);
    $pdf->SetFont('thsarabun', 'b', 15);
    $pdf->Write(0, @$cus_name, '', 0, 'L', true, 0, false, false, 0);

    $pdf->SetXY($x + 10, $y+21.5);
    $pdf->SetFont('thsarabun', '', 14);
    $pdf->Write(0, 'ที่อยู่', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY($x+ 10, $y+34.5);
    $pdf->Write(0, 'วันที่', '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetFont('thsarabun', 'b', 14);
    $pdf->SetXY($x+22, $y+21.5);
    $pdf->Write(0, $cus_address, '', 0, 'L', true, 0, false, false, 0);
    $pdf->SetXY($x+22, $y+28);
    $pdf->Write(0, 'ต.'.$district.' อ.'.$amphure.' จ.'.$province.' '.$cus_zip_code.' โทร.'.$cus_tel , '', 0, 'L', true, 0, false, false, 0);
    
    $pdf->SetXY($x+22, $y+34.5);
    $pdf->Write(0, @date("d/m/Y", strtotime($order_date)), '', 0, 'L', true, 0, false, false, 0);

    $pdf->setColor(0,0,0);
    $pdf->SetFont('thsarabun', 'b', 14);
    $pdf->Ln();
    $pdf->Cell(25, 10, "ลำดับที่", 1, 0, 'C');
    $pdf->Cell(70, 10, "รายการ", 1, 0, 'C');
    $pdf->Cell(20, 10, "จำนวน", 1, 0, 'C');
    $pdf->Cell(35, 10, "ราคาต่อหน่วย", 1, 0, 'C');
    $pdf->Cell(40, 10, "จำนวนเงิน", 1, 0, 'C');
    $pdf->Ln();
    $pdf->SetFont('thsarabun', '', 14);

    $i=0;
    $sumPrice = 0;
    $totalSumPrice = 0;
    $yFooter = 35;

    $table = "";
    if((int)$order_type == 1){
        $table = "products";
    }else{
        $table = "problems";
    }

    $sql = "SELECT * FROM order_detail od LEFT JOIN $table p ON od.pro_id = p.id WHERE od.order_id='".$id."'";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        $pdf->Cell(25, 10, ($i+1), 1, 0, 'C');
        $pdf->Cell(70, 10, (int)$order_type == 1 ? $row["pro_name"] : $row["prob_name"], 1, 0, 'L');
        $pdf->Cell(20, 10, $row["odetail_amount"], 1, 0, 'R');
        $pdf->Cell(35, 10, (int)$order_type == 1 ? number_format($row["pro_price"]) : number_format($row["prob_price"]), 1, 0, 'R');
        $pdf->Cell(40, 10, (int)$order_type == 1 ? number_format((float)$row["pro_price"] * (int)$row["odetail_amount"]) : number_format((float)$row["prob_price"] * (int)$row["odetail_amount"]), 1, 0, 'R');
        $pdf->Ln();

        if((int)$order_type == 1){
            $totalSumPrice += (float)$row["pro_price"] * (int)$row["odetail_amount"];
        }else{
            $totalSumPrice += (float)$row["prob_price"] * (int)$row["odetail_amount"];
        }

        $i++;
    }
    
    $pdf->SetLineStyle(array('width' => 0.75, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
    $pdf->SetFont('thsarabun', 'b', 14);
    $pdf->Cell(150, 10, "ยอดสินค้ารวม", 1,0, 'C');
    $pdf->Cell(40, 10, @number_format($totalSumPrice), 1, 0, 'R');
    $pdf->Ln();

    $pdf->SetXY($pdf->GetX(), $pdf->GetY() + $yFooter);
    $pdf->Cell(95, 10, "ลูกค้า", 0,0, 'C');
    $pdf->Cell(95, 10, "ชื่อเจ้าของ", 0,0, 'C');
    
    $pdf->Ln();
    $pdf->Cell(95, 10, "(ผู้รับสินค้า)", 0,0, 'C');
    $pdf->Cell(95, 10, "(ผู้รับเงิน)", 0,0, 'C');
    
;
date_default_timezone_set("Asia/Bangkok");
//ออกใบเสร็จ
$pdf->Output('ใบเสร็จรับเงิน_'.@$customer_name.'_'.date("Y-m-d H:i").'.pdf', 'I');

//============================================================+
// แปลงเลขเป็นตัวอักษร
//============================================================+
function Convert($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".","");
    $pt = strpos($amount_number , ".");
    $number = $fraction = "";
    if ($pt === false) 
        $number = $amount_number;
    else
    {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }
    
    $ret = "";
    $baht = ReadNumber ($number);
    if ($baht != "")
        $ret .= $baht . "บาท";
    
    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else 
        $ret .= "ถ้วน";
    return $ret;
}
 
function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000)
    {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }
    
    $divider = 100000;
    $pos = 0;
    while($number > 0)
    {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : 
            ((($divider == 10) && ($d == 1)) ? "" :
            ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}

//============================================================+
// END OF FILE
//============================================================+
