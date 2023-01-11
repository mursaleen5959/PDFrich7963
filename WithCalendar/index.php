<?php
////////////////
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function insert_cell($pdf,$Y,$X,$text)
{
    $pdf -> SetY($Y);
    $pdf -> SetX($X);
    $pdf->Cell(0,5,$text,0,0,'L');
    
}


function wh_log($log_msg)
{
    $log_filename = "log";
    if (!file_exists($log_filename)) 
    {
        // create directory/folder uploads.
        mkdir($log_filename, 777, true);
    }
    $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
    // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
    file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
} 
//wh_log("this is my log message");

// Necessary File includes
require_once('db.php');
require_once('conf.php');
require_once('fpdf/fpdf.php');
require_once('fpdf/extension.php');


//$sql = "SELECT * from wsac_generatorBilling WHERE id='1'";
$sql = "SELECT * from wsac_generatorBilling WHERE account='{$NODE}'";
$result = $pdo->query($sql);
while ($row = $result->fetch())
{
    $account          = $row['account'];
    $fullname         = $row['firstname']." ".$row['lastname'];
    $physicaladdress  = $row['physicaladdress'];
    $physicalcity     = $row['physicalcity'];
    $physicalstate    = $row['physicalstate'];
    $physicalzipcode  = $row['physicalzipcode'];
    $duedate          = $row['duedate'];
    $physicalstate    = $row['physicalstate'];
    $lastbill         = $row['lastbill'];
    $paymentreceived  = $row['paymentreceived'];
    $balance          = $row['balance'];
    $currentcharge    = $row['currentcharge'];
    $totalcharge      = $row['totalcharge'];
    $readdate         = $row['readdate'];
    $processfee       = $row['processfee'];
    $waterusage       = $row['waterusage'];
}


ob_start();
// PDF Object
$pdf = new PDF(); 

$pdf->AddPage('P','A4');
$pdf->Image('source_template/template.jpg',0,0,210,0);
$pdf->SetFont('Arial','',11);

// White Color Cells
$pdf->SetTextColor(255,255,255);
insert_cell($pdf,79,157,$account);
$duedate = date("F d, Y", strtotime($duedate));
insert_cell($pdf,85,145,$duedate);
insert_cell($pdf,119,15,"$".$lastbill);
insert_cell($pdf,119,65,"$".$paymentreceived);
insert_cell($pdf,119,101,"$".$balance);
insert_cell($pdf,119,139,"$".$currentcharge);


// Black Color Cells
$pdf->SetTextColor(0,0,0);
insert_cell($pdf,38,125,$physicaladdress.", ".$physicalcity.", ".$physicalzipcode.", ".$physicalstate);
insert_cell($pdf,73.5,15,$fullname);
insert_cell($pdf,80.7,15,$physicaladdress);
insert_cell($pdf,87.2,15,$physicalcity.", ".$physicalstate.", ".$physicalzipcode);
insert_cell($pdf,119,179,"$".$totalcharge);
insert_cell($pdf,158,140,$waterusage." Gallons");
$readdate = date("m-d-Y", strtotime($readdate));
insert_cell($pdf,151.5,52,$readdate);
insert_cell($pdf,157.5,52,$physicaladdress);
insert_cell($pdf,170.5,52,$lastbill);
insert_cell($pdf,176.8,52,$paymentreceived);
insert_cell($pdf,182.8,52,$balance);


insert_cell($pdf,197,52,$currentcharge);
insert_cell($pdf,203,52,$processfee);
insert_cell($pdf,209,52,$totalcharge);

insert_cell($pdf,245.5,165,$account);


//$pdf->AddPage();
$pdf->SetMargins(7,7);
$pdf->SetAutoPageBreak(false, 0);
// set fill color for non-weekend holidays
$greyValue = 190;
// #5a0e1b
$pdf->SetFillColor($greyValue,$greyValue,$greyValue);
// print the calendar for a whole year
//$year = gmdate("Y");
for($i=0;$i<count($MONTH);$i++)
{
    $press_count_of_month = array();
    $sql = $pdo->prepare("SELECT * FROM `wsac_waterusagemeter` WHERE (DATE_FORMAT(`reading_time`,'%m') = {$MONTH[$i]} AND DATE_FORMAT(`reading_time`,'%Y') = {$YEAR}) AND `nodeId` = '{$NODE}'; ");
    $result = $sql->execute();
    while($row = $sql->fetch())
    {
        $day = date('d', strtotime($row['reading_time']));
        //echo $day;
        if(isset($press_count_of_month[$day]))
        {
            $press_count_of_month[$day]+=$row['pressCount'];
        }
        else{
            $press_count_of_month[$day]=$row['pressCount'];
        }
    }
    $record_day = 2;
    $date = $pdf->MDYtoJD($MONTH[$i], 1, $YEAR);
    $pdf->printMonth($date,$press_count_of_month,$record_day);
}

// //print_r(($press_count_of_month));
// $record_day = 2;
// //$value_to_fill = '';
// $date = $pdf->MDYtoJD($MONTH, 1, $YEAR);
// //wh_log("Date:".$date);
// //$pdf->printMonth($date,$value_to_fill,$record_day);
// $pdf->printMonth($date,$press_count_of_month,$record_day);


$filename="file.pdf";
header('Content-type: application/pdf');
ob_clean();
$pdf->Output('I',$filename);
