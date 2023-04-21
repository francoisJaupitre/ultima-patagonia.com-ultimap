<?php
$css = array();
$actf_css = array();
$cfg_crr_css = array();
$dvs_css = array();
$sld_css = array();
$rq_css = sel_quo("*","fin_css","","","css");
while($dt_css = ftc_ass($rq_css)){
	$css[$dt_css['id']] = $dt_css['css'];
	$actf_css[$dt_css['id']] = $dt_css['actif'];
	$cfg_crr_css[$dt_css['id']] = $dt_css['crr'];
	$dvs_css[$dt_css['id']] = $dt_css['dvs'];
	$sld_css[$dt_css['id']] = $dt_css['sld'];
}
?>
