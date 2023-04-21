<?php
$prm_crr_nom = $prm_crr_dcm = $cfg_crr_nom = $cfg_crr_sp = $cfg_crr_tx = $cfg_crr_txf = $cfg_crr_inv = $cfg_crr_dcm = $cfg_crr_id = array();

//remplacer par insert? (premiere utilisation)
$cfg_crr_nom[1] = "USD";
$cfg_crr_sp[1] = $cfg_crr_dcm[1] = 0;
$cfg_crr_tx[1] = $cfg_crr_txf[1] = 1;
$rq_prm_crr = sel_prm("id,crr,sym,dcm","prm_crr");
while($dt_prm_crr = ftc_ass($rq_prm_crr)) {
	$prm_crr_nom[$dt_prm_crr['id']] = $dt_prm_crr['crr'];
	$prm_crr_dcm[$dt_prm_crr['id']] = $dt_prm_crr['dcm'];
}
$rq_cfg_crr = sel_quo("*","cfg_crr","","","taux");
while($dt_cfg_crr = ftc_ass($rq_cfg_crr)) {
	$cfg_crr_nom[$dt_cfg_crr['id_crr']] = $prm_crr_nom[$dt_cfg_crr['id_crr']];
	$cfg_crr_sp[$dt_cfg_crr['id_crr']] = $dt_cfg_crr['sup'];
	$cfg_crr_tx[$dt_cfg_crr['id_crr']] = $dt_cfg_crr['taux'];
	$cfg_crr_txf[$dt_cfg_crr['id_crr']] = $dt_cfg_crr['tauxf'];
	$cfg_crr_inv[$dt_cfg_crr['id_crr']] = $dt_cfg_crr['id'];
	$cfg_crr_dcm[$dt_cfg_crr['id_crr']] = $dt_cfg_crr['dcm'];
	$cfg_crr_id[$dt_cfg_crr['id']] = $dt_cfg_crr['id_crr'];
}
?>
