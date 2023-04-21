<?php
include("../prm/fct.php");
include("../prm/aut.php");
$obj = $_POST['obj'];
$dat = $_POST['dat'];
$nom_nat = $_POST['nom_nat'];
$dt = explode('/',$dat);
$date = $dt[2].'-'.$dt[1].'-'.$dt[0];
if($nom_nat=='*') {$nom_nat='';}
if($obj=='ecr') {insert("fin_ecr",array("date","nature"),array($date,$nom_nat));}
elseif($obj=='bdg') {
	$dt_dat = ftc_ass(sel_quo("date","fin_ecr","id",$_POST['id_sup']));
	insert("fin_bdg",array("id_ecr","mois"),array($_POST['id_sup'],date("Y-m",strtotime($dt_dat['date']))."-1"));
	}
else{insert("fin_".$obj,"id_ecr",$_POST['id_sup']);}
?>
