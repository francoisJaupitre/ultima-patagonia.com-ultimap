<?php
include("../prm/fct.php");
include("../cfg/css.php");
$id_ecr = $_POST['id'];
$obj = $_POST['obj'];
$dt_ecr = ftc_ass(sel_quo("*","fin_ecr","id",$id_ecr));
$date = $dt_ecr['date'];
if($obj=="d") {$date = date ('Y-m-d', strtotime ("+1 days $date"));}
elseif($obj=="m") {$date = date ('Y-m-d', strtotime ("+1 months $date"));}
elseif($obj=="Y") {$date = date ('Y-m-d', strtotime ("+1 years $date"));}
$dt_ecr['date'] = $date;
unset($dt_ecr['id']);
$id_ecr_new = insert("fin_ecr",array_keys($dt_ecr),array_values($dt_ecr));
$rq_trs = sel_quo("id","fin_trs","id_ecr",$id_ecr);
while($dt_trs = ftc_ass($rq_trs)) {
	$id_trs = $dt_trs['id'];
	$dt_trs = ftc_ass(sel_quo("*","fin_trs","id",$id_trs));
	if(!$actf_css[$dt_trs['id_css']]) {$dt_trs['id_css'] = 0;}
	unset($dt_trs['id']);
	$dt_trs['id_ecr'] = $id_ecr_new;
	$id_trs_new = insert("fin_trs",array_keys($dt_trs),array_values($dt_trs));
}
$rq_bdg = sel_quo("id","fin_bdg","id_ecr",$id_ecr);
while($dt_bdg = ftc_ass($rq_bdg)) {
	$id_bdg = $dt_bdg['id'];
	$dt_bdg = ftc_ass(sel_quo("*","fin_bdg","id",$id_bdg));
	$mois = $dt_bdg['mois'];
if($obj=="m") {$mois = date ('Y-m', strtotime ("+1 months $mois"))."-1";}
elseif($obj=="Y") {$mois = date ('Y-m', strtotime ("+1 years $mois"))."-1";}
	$dt_bdg['mois'] = $mois;
	$dt_bdg['id_ecr']= $id_ecr_new;
	unset($dt_bdg['id']);
	$id_bdg_new = insert("fin_bdg",array_keys($dt_bdg),array_values($dt_bdg));
}
?>
