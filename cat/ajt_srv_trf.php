<?php
include("../prm/fct.php");
$id_srv = $_POST['id_srv'];
$max_ssn = ftc_ass(select("MAX(dt_max) AS dt_max,cat_srv_trf_ssn.id AS id_ssn, cat_srv_trf.id AS id_trf","cat_srv_trf_ssn INNER JOIN cat_srv_trf ON cat_srv_trf_ssn.id_trf = cat_srv_trf.id","cat_srv_trf.id_srv",$id_srv));
if(!empty($max_ssn['id_ssn'])) {
	if($max_ssn['dt_max']!='0000-00-00') {
		$date = $max_ssn['dt_max'];
		$date = date ('Y-m-d', strtotime ("+1 days $date"));
		}
	else{$date='0000-00-00';}

	$dt_trf = ftc_ass(select("crr","cat_srv_trf","id",$max_ssn['id_trf']));
	if($dt_trf['crr']>0) {$id_srv_trf = insert("cat_srv_trf",array("id_srv","crr"),array($id_srv,$dt_trf['crr']));}
	else{$id_srv_trf = insert("cat_srv_trf",array("id_srv","crr"),array($id_srv,1));}
}
else{
	$id_srv_trf = insert("cat_srv_trf",array("id_srv","crr"),array($id_srv,1));
	$date='0000-00-00';
}
insert('cat_srv_trf_ssn',array("id_trf","dt_min"),array($id_srv_trf,$date));
//ci-dessus pareil que saveTable
$min_bss = ftc_ass(select("MIN(bs_max) AS bs_max,cat_srv_trf_bss.id AS id_bss","cat_srv_trf_bss INNER JOIN cat_srv_trf ON cat_srv_trf_bss.id_trf = cat_srv_trf.id","cat_srv_trf.id_srv",$id_srv));
if(!empty($min_bss['id_bss'])) {
	$dt_bss = ftc_ass(select("clc,id_frn","cat_srv_trf_bss","id",$min_bss['id_bss']));
	insert('cat_srv_trf_bss',array("id_trf","bs_min","bs_max","clc","id_frn"),array($id_srv_trf,1,$min_bss['bs_max'],$dt_bss['clc'],$dt_bss['id_frn']));
}
else{insert('cat_srv_trf_bss',array("id_trf","bs_min","bs_max"),array($id_srv_trf,1,1));}
?>
