<?php
if(isset($_GET['act']) and isset($_GET['melfr']) and isset($_GET['subj']) and isset($_GET['bccrt']) and isset($_GET['from'])){
	include("../prm/fct.php");
	include("../prm/aut.php");
	$subj = $_GET['subj'];
	$from = $_GET['melfr'];
	$act = $_GET['act'];
	if(isset($_GET['atxt'])){$atxt = $_GET['atxt'];}
	if(isset($_GET['att'])){$att = $_GET['att'];}
	if(isset($_GET['melto'])){$melto = $_GET['melto'];}
	$ccrt = $_GET['bccrt'];
	include("../resources/php/eml.php");
	if(file_exists($file)) {
	  header('Content-Description: File Transfer');
	  header('Content-Type: application/octet-stream');
	  header('Content-Disposition: attachment; filename="'.basename($file).'"');
	  header('Expires: 0');
	  header('Cache-Control: must-revalidate');
	  header('Pragma: public');
	  header('Content-Length: ' . filesize($file));
	  readfile($file);
	  exit;
	}
}
?>
