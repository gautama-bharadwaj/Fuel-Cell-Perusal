

<?php
session_start();
$R=$_POST['R'];
$F=$_POST['F'];
$z=$_POST['z'];
$T=$_POST['T'];
$alpha=$_POST['alpha'];
$i0=$_POST['i0'];
$il=$_POST['il'];
$Rohmic=$_POST['Rohmic'];
$PH2=$_POST['PH2'];
$PO2=$_POST['PO2'];
$nact = $_SESSION['nact'];
$nohm = $_SESSION['nohm'];
$Vfuel= $_SESSION['vfuel'];
$nconc = $_SESSION['nconc'];
$Power= $_SESSION['Power'];
$i= $_SESSION['i'];
$s=$_SESSION['s'];
$Enernst=$_SESSION['Enernst'];

require('fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('Images/fcp_logo.png',10,6,20);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Text(80,10,'FUEL CELL PERUSAL');
    $this->Line(80,11,135,11);
    $this->Line(80,12,135,12);
    // Line break
    $this->Ln(30);
    $t=time();
    $this->SetFont('Arial','',8);
    $this->Text(180,10,date('Y-m-d',$t));

}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}


}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);


$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,5,'VERSION USED: v2.0.1',0,1);
$pdf->Line(10,45,50,45);
$pdf->Ln(10);
$pdf->Cell(100,5,'INPUT PARAMETERS:',0,1);
$pdf->Line(10,60,65,60);
$pdf->Ln(5);//main heading
//input table
$width_cell=array(80,70,40);
$pdf->SetFillColor(193,229,252); // Background color of header 
$pdf->Cell($width_cell[0],10,'PARAMETERS',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],10,'VALUES',1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],10,'UNITS',1,1,'C',true); // Third header column 

//// header is over ///////

$pdf->SetFont('Arial','',10);
// First row of data 
$pdf->Cell($width_cell[0],10,'UNIVERSAL GAS  CONSTANT (R)',1,0,false); // First column of row 1 
$pdf->Cell($width_cell[1],10,$R,1,0,false); // Second column of row 1 
$pdf->Cell($width_cell[2],10,'J/mol K',1,1,false); // Third column of row 1 
 
//  First row of data is over 
//  Second row of data 
$pdf->Cell($width_cell[0],10,'FARADAY CONSTANT',1,0,false); // First column of row 2 
$pdf->Cell($width_cell[1],10,$F,1,0,false); // Second column of row 2
$pdf->Cell($width_cell[2],10,'As/mol',1,1,false); // Third column of row 2
 
//   Sedond row is over 
//  Third row of data
$pdf->Cell($width_cell[0],10,'NUMBER OF ELECTRONS',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$z,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'---',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'TEMPERATURE',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$T,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'K',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'CHARGE TRANSFER COEFFICIENT alpha',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$alpha,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'---',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'EXCHANGE CURRENT DENSITY',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$i0,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'A/cm2',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'LIMITING CURRENT DENSITY',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$il,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'A/cm2',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'RESISTANCE(Rohmic)',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$Rohmic,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'Ohms',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'PARTIAL PRESSURE OF HYDROGEN(PH2)',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$PH2,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'Bar',1,1,false); // Third column of row 3

$pdf->Cell($width_cell[0],10,'PARTIAL PRESSURE OF HYDROGEN(PO2)',1,0,false); // First column of row 3
$pdf->Cell($width_cell[1],10,$PO2,1,0,false); // Second column of row 3
$pdf->Cell($width_cell[2],10,'Bar',1,1,false); // Third column of row 3
$pdf->Ln(20);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(100,5,'OUTPUTS',0,1);
$pdf->Line(10,200,35,200);
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$width_cell=array(80,70,40);
 // Background color of header 
$pdf->Cell($width_cell[0],10,'NERNST VOLTAGE',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],10,$Enernst,1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],10,'V',1,1,'C',true);

$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(100,5,'RESULTS',0,1);
$pdf->Line(10,45,35,45);
$pdf->SetFont('Arial','',10);
$pdf->Ln(5);
$pdf->SetFont('Arial','',6);
$width_cell=array(30,30,30,40,30,30);
$pdf->SetFillColor(193,229,252); // Background color of header 
$pdf->Cell($width_cell[0],8,'FUEL CELL CURRENT(A)',1,0,'C',true); // First header column 
$pdf->Cell($width_cell[1],8,'ACTIVATION LOSSES(V)',1,0,'C',true); // Second header column
$pdf->Cell($width_cell[2],8,'OHMIC LOSSES(V)',1,0,'C',true);
$pdf->Cell($width_cell[3],8,'CONCENTRATION LOSSES(V)',1,0,'C',true);
$pdf->Cell($width_cell[4],8,'FUEL CELL VOLTAGE(V)',1,0,'C',true);
$pdf->Cell($width_cell[5],8,'FUEL CELL POWER(W)',1,1,'C',true);
// Third header column 

//// header is over ///////
for($j=0; $j<=$s;$j=$j+1)
{   
$pdf->SetFont('Arial','',10);
// First row of data 
$pdf->Cell($width_cell[0],8,$i[$j],1,0); // row 1 
$pdf->Cell($width_cell[1],8,$nact[$j],1,0); // row 1 
$pdf->Cell($width_cell[2],8,$nohm[$j],1,0); //  row 1 
$pdf->Cell($width_cell[3],8,$nconc[$j],1,0);
$pdf->Cell($width_cell[4],8,$Vfuel[$j],1,0);
$pdf->Cell($width_cell[5],8,$Power[$j],1,1);
}

$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,5,'GRAPHS OBTAINED:',0,1);
$pdf->Line(10,45,60,45);
$pdf->Image('Chart_images/1a.png',8,60,200);
$pdf->Image('Chart_images/1b.png',8,150,200);
$pdf->AddPage();
$pdf->Image('Chart_images/1c.png',8,60,200);
$pdf->Image('Chart_images/1d.png',8,150,200);
/*$pdf = new FPDF();
$pdf->AddPage();*/


/*for($i=0; $i< 10; $i++){

    $pdf->SetFont('Arial', "B", 12);
    $pdf->Cell(40, 10, "asd");


}
$pdf->Output();


}
/*$pdf->Cell(190,5,'PARAMETERS',1,1);

$pdf->Line(105,65,105,120);
$pdf->Cell(190,5,$R,1,1);


$pdf->Cell(190,5,'Faraday Constant F:',1,1);


$pdf->Cell(190,5,'No. of electrons in rxn z:',1,1);


$pdf->Cell(190,5,'Temperature T:',1,1);


$pdf->Cell(190,5,'Charge coefficient alpha:',1,1);


$pdf->Cell(190,5,'Cell Area:',1,1);


$pdf->Cell(190,5,'Pressure:',1,1);


$pdf->Cell(190,5,'Partial pressure of H2:',1,1);


$pdf->Cell(190,5,'Partial pressure of O2:',1,1);


$pdf->Cell(190,5,'Partial pressure H2o:',1,1);

$pdf->Ln(10);
$pdf->Cell(100,5,'INPUT PARAMETERS FROM POLARISATION CURVE:',0,1);
$pdf->Cell(190,5,'V1:',1,1);

$pdf->Cell(190,5,'Vmin:',1,1);


$pdf->Cell(190,5,'Vnom:',1,1);


$pdf->Cell(190,5,'Imax:',1,1);


$pdf->Cell(190,5,'Imax:',1,1);


$pdf->Cell(190,5,'Inom:',1,1);


$pdf->Cell(190,5,'Eoc:',1,1);

*/

$pdf->Output();

?>

