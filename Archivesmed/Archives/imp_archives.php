<?php
define('FPDF_FONTPATH','./inc/font/');
require('./inc/fpdf.php');
//require('./inc/fonctions.php');
//require ('archives_inc.php');


function getMois(&$month){
$mois["January"] = "Janvier";
$mois["February"] = "Février";
$mois["March"] = "Mars";
$mois["April"] = "Avril";
$mois["May"] = "Mai";
$mois["June"] = "Juin";
$mois["July"] = "Juillet";
$mois["August"] = "Août";
$mois["September"] = "Septembre";
$mois["October"] = "Octobre";
$mois["November"] = "Novembre";
$mois["December"] = "Décembre";
return $mois[$month];
}

class PDF extends FPDF
{
//En-tête
	function Header()
	{
	global $header;
	global $sw;
	global $mois;
	//Logo
	$this->Image('./inc/images/ch_cahors.jpg',10,10,20,0,'','index.php');
	$this->SetFont('Arial','B',24);
	$this->SetTextColor(0,90,180);
	$this->Cell(50,15);
	$this->Cell(180,15,'',0,0,'C');
	$this->SetFont('Arial','I',8);
	//Date
	$today = getdate(); 
	$month = $today['month']; 
	$mday = $today['mday']; 
	$year = $today['year']; 
	$ce_jour = $mday." ".$mois." ".$year;
	$this->Cell(50,15,'Edité le '.$ce_jour,0,0,'R');
	$this->Ln(20);
	//Couleurs, épaisseur du trait et police grasse
	$this->SetFillColor(255,255,255);
	$this->SetTextColor(255,255,255);
	$this->SetDrawColor(255,255,255);
	$this->SetLineWidth(0);
	$this->SetFont('Arial','B',35);
	$this->Cell(1);
	for($i=0;$i<count($header);$i++)
		{
		$this->Cell($sw[$i],7,$header[$i],1,0,'C',1);
    }
     $this->Ln();
	$this->Ln();
	}

//Pied de page
	function Footer()
	{
	//Positionnement à 1,5 cm du bas
	$this->SetY(-15);
	//Police Arial italique 8
	$this->SetFont('Arial','I',8);
	//Numéro de page
	//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF();
$pdf->AliasNbPages(); 
$pdf->Free;
$pdf->Open();
//date en français
$month = Date(F);
$mois=getMois($month);
//entete de colonnes
$header=array("");

$ligne=array("",$NOM,$PRENOM,$NPP);
//largeur des colonnes
$sw=array(270);

//orientation (L = paysage P = portrait)
$pdf->AddPage('L');
//nombre de lignes par page
$nblig=3;

//connexion à la base
include ("./inc/connexion.php");

    $pdf->SetFillColor(255,255,255);
	//$pdf->SetFillColor(205,230,255);
    $pdf->SetTextColor(0);
	$pdf->SetFont('Arial','',48);
  	$fill=0;
	//$pdf->FancyTable($header,$sw);*/

      /*$fieldnpp=mysql_result($id,$nLine,"npp");
	  $fieldnom=mysql_result($id,$nLine,"nom");
      $fieldprenom=mysql_result($id,$nLine,"prenom");*/

	  //remplissage du tableau
		$pdf->Cell(1);
    	$pdf->Cell($sw[$i],15,$ligne[0],0,0,'C',$fill);
      	$pdf->Ln();
		$fill=!$fill;
        $pdf->Cell($sw[$i],15,$ligne[1],0,0,'C',$fill);
      	$pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
		$fill=!$fill;
        //police
        $pdf->SetFont('Arial','I',36);
        $pdf->Cell($sw[$i],15,$ligne[2],0,0,'C',$fill);
      	$pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        //$pdf->Ln();
		$fill=!$fill;
        $pdf->SetFont('Arial','',28);
        $pdf->Cell(100,15,"IPP:",0,0,'R',$fill);
        $pdf->SetFont('Arial','',48);
        $pdf->Cell(170,15,$ligne[3],0,0,'L',$fill);
      	$pdf->Ln();
		$fill=!$fill;

//edition du document
$pdf->Output();
$pdf->close();
?>
