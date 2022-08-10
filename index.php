<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Setting for the Localhost Machine
$servername = "localhost";
$username = "root";
$password = "";
$db = "rich7963";

try
{
  $conn = new PDO("mysql:host=$servername;dbname=$db",$username,$password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT * from wsac_generatorBilling WHERE id='1'";
$result = $conn->query($sql);
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



function insert_cell($pdf,$Y,$X,$text)
{
    $pdf -> SetY($Y);
    $pdf -> SetX($X);
    $pdf->Cell(0,5,$text,0,0,'L');
    
}

// PDF Object


require_once('fpdf/fpdf.php');
require_once('fpdf/wordwrap.php');
//require_once('FPDI/autoload.php');
//require_once('FPDI/Fpdi.php');
//use \setasign\Fpdi\Fpdi;
//$pdf = new Fpdi();
//$pdf->setSourceFile('source_templates/template.jpg');
//$tplidx = $pdf->importPage(1, '/MediaBox');
//$pdf->AddPage();
//$pdf->useTemplate($tplidx, 10, 10, 90);


// PDF Object
$pdf = new PDF(); 
$pdf->AddPage();
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


$filename='output'.".pdf";
$pdf->Output($filename,'I');
?>
