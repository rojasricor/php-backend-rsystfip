<?php

namespace RSystfip;

include_once 'fpdf/fpdf.php';

use FPDF;

class PdfController extends FPDF
{
  function renderTitle($title)
  {
    $this->SetTextColor(0, 0, 0);
    $this->SetFont('Arial', 'B', 16);
    $this->Cell(0, 10, utf8_decode($title), 0, 1, 'C');
    $this->Ln();
  }

  function Header()
  {
    //Institutional logotype
    $this->Image('img/admin_avatar.png', 8, 5, 25, 25, 'png', 'https://www.itfip.edu.co');
    //Arial bold 15
    $this->SetFont('Arial', '', 8);
    //Movernos a la derecha
    $this->Cell(65);
    //Título
    $this->Cell(60, 10, utf8_decode('RSystfip / Report between ' . $_GET['start'] . ' and ' . $_GET['end'] . '.'), 0, 0, 'C');
    //Salto de línea
    $this->Ln(20);
  }

  function Footer()
  {
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    //Número de página
    $this->Cell(0, 10, utf8_decode('Page ') . $this->PageNo() . '/{nb} - RSystfip', 0, 0, 'C');
  }

  /**
   * [$widths description]
   * @var [type]
   */
  var $widths;
  var $aligns;

  function SetWidths($w)
  {
    //Set the array of column widths
    $this->widths=$w;
  }

  function SetAligns($a)
  {
    //Set the array of column alignments
    $this->aligns=$a;
  }

  function Row($data,$setX)
  {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
      $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h,$setX);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      $this->Rect($x,$y,$w,$h,'DF');
      //Print the text
      $this->MultiCell($w,5,$data[$i],0,$a);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function CheckPageBreak($h, $setX)
  {
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger){
      $this->AddPage($this->CurOrientation);
      $this->SetX($setX);

      $this->SetFont('Arial','B',15);
      $this->Cell(15, 7, 'No.', 'B', 0, 'C', 0);
      $this->Cell(40, 7, 'Nombres', 'B', 0, 'C', 0);
      $this->Cell(27, 7, utf8_decode('Categoría'), 'B', 0, 'C', 0);
      $this->Cell(40, 7, 'Facultad', 'B', 0, 'C', 0);
      $this->Cell(70, 7, 'Asunto', 'B', 0, 'C', 0);
      $this->SetFont('Arial', '', 12);
    }

    if ($setX == 100) {
      $this->SetX(100);
    } else {
      $this->SetX($setX);
    }
  }

  function NbLines($w,$txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
      $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
      $c=$s[$i];
      if($c=="\n")
      {
        $i++;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
        continue;
      }
      if($c==' ')
        $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax)
      {
        if($sep==-1)
        {
          if($i==$j)
            $i++;
        }
        else
          $i=$sep+1;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
      }
      else
        $i++;
    }
    return $nl;
  }
}
