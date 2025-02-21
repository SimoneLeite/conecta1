<?php
require('fpdf/fpdf.php'); // Certifique-se de que a pasta tem esse nome exato!

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Teste FPDF funcionando!');
$pdf->Output();
?>
