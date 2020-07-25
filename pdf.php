<?php
require 'lib/tfpdf/tfpdf.php';
require 'php/config.php';
require 'php/exceptions.class.php';
require 'php/functions.php';

$Error  = new ExceptionHandler($DeployType == "beta");
$Db = new Mysqli($MySQL_host, $MySQL_username, $MySQL_password, $MySQL_database);
if ($Db->connect_errno) {
	$Error->fatal("Database connection failed");
}

$code = isset($_GET['code']) ? strtoupper($_GET['code']) : "";

/* Code validity check */
if (checkCode($code, $Db) !== true) {
	exit();
}

$kaart = getCard($code, $Db);





$linesFontSizes = array(1 => 31, 2 => 15, 3 => 9, 4 => 7, 5 => 5, 6 => 4, 7 => 3);
$linesLineHeights = array(1 => 11.3/1, 2 => 11.3/2, 3 => 11.3/3, 4 => 11.3/4, 5 => 11.3/5, 6 => 11.3/6, 7 => 11.3/7);

function ptToMm($pt) {
	return $pt*0.35277777;
}

function determineLines(&$kaart, $pdf, $textWidth) {
	global $linesFontSizes, $linesLineHeights;

	for ($l = 1; $l <= 7; $l++) {
		$pdf->SetFont('PTSans','B',$linesFontSizes[$l]);
		foreach ($kaart as $song) {
			if ($pdf->MultiCellCountLines($textWidth, $linesLineHeights[$l], $song[0], 0, "C", false) > $l) {
				continue 2;
			}
		}
		$pdf->SetFont('PTSans','',$linesFontSizes[$l]);
		foreach ($kaart as $song) {
			if ($pdf->MultiCellCountLines($textWidth, $linesLineHeights[$l], $song[1], 0, "C", false) > $l) {
				continue 2;
			}
		}
		break;
	}

	$pdf->SetFont('PTSans','B',$linesFontSizes[$l]);
	foreach ($kaart as $i => $song) {
		$kaart[$i]['indent'] = $l - $pdf->MultiCellCountLines($textWidth, $linesLineHeights[$l], $song[0], 0, "C", false);
	}

	return $l;
}

/*
function predictLines($pdf, $width, $text) {
	$words = explode(' ', $text);
	$wlens = array();
	foreach ($words as $word) {
		$wlens[] = $pdf->GetStringWidth(utf8_decode($word));
	}
	$spclen = $pdf->GetStringWidth(' ');

	$clen = 0;
	foreach ($wlens as $wlen) {
		if ($clen + $spclen + $wlen > $width) {

		}
	}
}*/

$pdf = new tFPDF();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
$pdf->AddFont('PTSans','','PTSans-Regular.ttf',true);
$pdf->AddFont('PTSans','B','PTSans-Bold.ttf',true);



$pdf->AddPage('P','A5');

$pdf->SetFont('PTSans','B', 30);
$pdf->Cell(0, 11, 'MuziekBingo', 0, 2, 'C');
//$pdf->Ln();

$pdf->SetFont('PTSans','', 18);
$pdf->Cell(0, 7, 'Playlist — ' . $code, 0, 2, 'C');
$pdf->Ln();


$baseSz = 25.6;
$textWidth = 23.6;
$lines = determineLines($kaart, $pdf, $textWidth);
$fontSize = $linesFontSizes[$lines];
$lineheight = $linesLineHeights[$lines];

$baseX = $pdf->getX(); $baseY = $pdf->getY();
# Tabel
$i = 0;
for ($y = 0; $y < 5; $y++) {
	for ($x = 0; $x < 5; $x++) {
		$pdf->Cell($baseSz, $baseSz, "", 1);
	}
	$pdf->Ln();
}

$pdf->SetFont('PTSans','B', $fontSize);
$i = 0;
for ($y = 0; $y < 5; $y++) {
	for ($x = 0; $x < 5; $x++) {
		$pdf->SetXY($baseX + $x * $baseSz + 1, $baseY + $y * $baseSz + 1 + $lineheight*$kaart[$i]['indent']);
		$pdf->MultiCell($textWidth, $lineheight, $kaart[$i][0], 0, "C", false);
		$i++;
	}
}

$pdf->SetFont('PTSans','', $fontSize);
$i = 0;
for ($y = 0; $y < 5; $y++) {
	for ($x = 0; $x < 5; $x++) {
		$pdf->SetXY($baseX + $x * $baseSz + 1, $baseY + $y * $baseSz + 13.3);
		$pdf->MultiCell($textWidth, $lineheight, $kaart[$i][1], 0, "C", false);
		$i++;
	}
}

$pdf->SetXY(10, 130 + $baseY);
$pdf->SetFont('PTSans','', 11);
$pdf->SetTextColor(100,100,100);
$pdf->Write(4, "Generated on " . date("Y/m/d") . " on ");
$pdf->Write(4, "recordbingo.com", "https://recordbingo.com");
$pdf->Write(4, ". Generate an interactive card on ");
$pdf->Write(4, "recordbingo.com/c/" . $code, "https://recordbingo.com/c/" . $code);
$pdf->Write(4, ".");
$pdf->SetTextColor(0,0,0);

$pdf->Output();
?>
