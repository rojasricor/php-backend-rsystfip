<?php

if (!isset($_GET['start']) || !isset($_GET['end']) || !isset($_GET['category'])) {
  http_response_code(400);
  exit('bad request');
}

include_once 'session_check.php';
use app\controllers\{PeopleController as pc, StatisticsController as stc, TimeController as tc, PdfController as pdf};

$pdf = new pdf();
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetAuthor('RSystfip');
$pdf->SetCreator('FPDF Maker');

$pdf->renderTitle('Total personas agendadas:');

$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetX(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(15, 7, 'No.', 'B', 0, 'C', 0);
$pdf->Cell(40, 7, 'Nombres', 'B', 0, 'C', 0);
$pdf->Cell(27, 7, utf8_decode('Categoría'), 'B', 0, 'C', 0);
$pdf->Cell(40, 7, 'Facultad', 'B', 0, 'C', 0);
$pdf->Cell(70, 7, 'Asunto', 'B', 0, 'C', 0);
$pdf->Ln();

$pdf->SetFillColor(233, 229, 235);
$pdf->SetDrawColor(61, 61, 61);
$pdf->SetFont('Arial', '', 12);

$pdf->SetWidths(array(15,40,27,40,70));
foreach(pc::getAll() as $person) {
  $pdf->Row(array($person->id,utf8_decode($person->name),utf8_decode($person->person),utf8_decode($person->fac),utf8_decode($person->text_asunt)), '10');
}

$pdf->AddPage();
$pdf->renderTitle('Reporte entre el rango de fecha:');
$pdf->SetX(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40, 7, 'Nombres', 'B', 0, 'C', 0);
$pdf->Cell(40, 7, 'Fecha', 'B', 0, 'C', 0);
$pdf->Cell(35, 7, utf8_decode('Ag. Día'), 'B', 0, 'C', 0);
$pdf->Cell(35, 7, 'Ag. Prog.', 'B', 0, 'C', 0);
$pdf->Cell(40, 7, 'Tipo persona', 'B', 0, 'C', 0);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(40,40,35,35,40));
$reports = $_GET['category'] !== 'unset' ? stc::getPeopleWithPeopleCountWithCategory($_GET['start'], $_GET['end'], $_GET['category']) : stc::getPeopleWithPeopleCount($_GET['start'], $_GET['end']);
foreach($reports as $people) {
  $pdf->Row(array($people->name, $people->date, $people->presence_count, $people->absence_count, $people->person), '10');
}

$pdf->AddPage();
$pdf->renderTitle('Cantidad agendadas entre rango de fecha:');
$pdf->SetX(70);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50, 7, 'Tipo de persona', 'B', 0, 'C', 0);
$pdf->Cell(15, 7, 'Cantidad', 'B', 0, 'C', 0);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(50,15));
foreach(stc::getMostAgendatedByDate($_GET['start'], $_GET['end']) as $data) {
  $pdf->Row(array($data->person, $data->counts), '70');
}

$pdf->AddPage();
$pdf->renderTitle('Cantidad total agendado(a)s:');
$pdf->SetX(70);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(50, 7, 'Tipo de persona', 'B', 0, 'C', 0);
$pdf->Cell(15, 7, 'Cantidad', 'B', 0, 'C', 0);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->SetWidths(array(50,15));
foreach(stc::getMostAgendatedOfAllTime() as $data) {
  $pdf->Row(array($data->person, $data->counts), '70');
}

$pdf->Output('', 'RSystfip-Report-' . tc::todayDateTime() . '.pdf');
