<?php
$itm = $iva_itm = $iibb_itm = $cpt_itm = $vnt_itm = $aut_itm = $mnt_itm = array();
$rq_itm = sel_quo("*","cfg_itm","","","itm");
while($dt_itm = ftc_ass($rq_itm)){
	$itm[$dt_itm['id']] = $dt_itm['itm'];
	$iva_itm[$dt_itm['id']] = $dt_itm['iva'];
	$iibb_itm[$dt_itm['id']] = $dt_itm['iibb'];
	$cpt_itm[$dt_itm['id']] = $dt_itm['cpt'];
	$vnt_itm[$dt_itm['id']] = $dt_itm['vnt'];
	$aut_itm[$dt_itm['id']] = $dt_itm['aut'];
	$mnt_itm[$dt_itm['id']] = $dt_itm['mnt'];
	}
?>
