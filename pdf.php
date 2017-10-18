<?php 

use setasign\Fpdi;

require_once('vendor/autoload.php');
require_once('helper.php');

$filename   = "eabr4.pdf";
$source_dir = "./pdf/sources/";
$dest_dir   = "./pdf/split/";
$source_file = $source_dir.$filename;

$dest_dir   = $dest_dir ? $dest_dir : './';
$new_path   = preg_replace('/[\/]+/', '/', $dest_dir.'/'.substr($filename, 0, strrpos($filename, '/')));

if (!is_dir($new_path))
{
	mkdir($new_path, 0777, true);
}

$pdf = new Fpdi\Fpdi();
$pdf->AddPage();
$pages = $pdf->setSourceFile($source_file);
for ($page = 1; $page <= $pages; $page++) {
	
	$new_pdf = new Fpdi\Fpdi();
	$new_pdf->AddPage();
	$new_pdf->setSourceFile($source_file);
	$new_pdf->useTemplate($new_pdf->importPage($page));

	try {
		$new_filename = './pdf/split/'.str_replace('.pdf', '', $filename).'_'.$page.".pdf";
		$new_pdf->Output($new_filename, "F");
		echo "Page ".$page." split into ".$new_filename."<br />\n";
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
$pdf->close();