<?php
require __DIR__ . '/../vendor/autoload.php';
require ('pdf/fpdf.php');
use Utel\Util\DataSource;
//use Utel\Util\Coche;
//use Utel\Util\Config;
class PDF extends FPDF{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('img/logo2.jpg',5,2,60);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(30);
    
        // Título
        $this->Cell(200,10,utf8_decode(' Padron vehícular'),0,0,'C');
        // Salto de línea
        $this->Ln(30);

    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina'.$this->PageNo().'/{nb}',0,0,'C');
    }
} 


    $dbcon = DataSource::getConnection();
    if (isset($dbcon)) {
        $sentencia = $dbcon->prepare("SELECT * FROM vehiculos");
        $sentencia->execute();
        $padron = $sentencia->fetchALL(PDO::FETCH_NAMED);
   
    

    $pdf = new PDF('L','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',5);
   

    
        $pdf->Cell(5,5,'ID'  ,1,0,'C',0);
        $pdf ->Cell(12,5, 'INVENTARIO',1,0,'C',0);
        $pdf ->Cell(20,5, 'SERIE',1,0,'C',0);
        $pdf ->Cell(40,5, utf8_decode('VEHÍCULO'),1,0,'C',0);
        $pdf ->Cell(15,5, 'MARCA',1,0,'C',0);
        $pdf ->Cell(5,5,'MOD',1,0,'C',0);
        $pdf ->Cell(10,5, 'PLACA',1,0,'C',0);
        $pdf ->Cell(20,5, 'COLOR',1,0,'C',0);
        $pdf ->Cell(60,5, 'ASIGNADO',1,0,'C',0);
        $pdf ->Cell(40,5, 'RESGUARDO',1,0,'C',0);
        $pdf ->Cell(55,5, 'OBSERVACIONES',1,1,'C',0); 
        foreach($padron as $usr):
$pdf->Cell(5,5,$usr['id']  ,1,0,'C',0);
$pdf->Cell(12,5, $usr['num_inventario'],1,0,'C',0);
$pdf->Cell(20,5, $usr['serie'],1,0,'C',0);
$pdf->Cell(40,5, $usr['vehiculo'],1,0,'C',0);
$pdf->Cell(15,5, $usr['marca'],1,0,'C',0);
$pdf->Cell(5,5, $usr['modelo'],1,0,'C',0);
$pdf->Cell(10,5, $usr['placa'],1,0,'C',0);
$pdf->Cell(20,5, $usr['color'],1,0,'C',0);
$pdf->Cell(60,5, $usr['asignado'],1,0,'C',0);
$pdf->Cell(40,5, $usr['resguardo'],1,0,'C',0);
$pdf->Cell(55,5, utf8_decode ($usr['observaciones']),1,1,'C',0);
endforeach;
$pdf->Output();
//require Config::getView('pdf.view.php');

    }  
?>






