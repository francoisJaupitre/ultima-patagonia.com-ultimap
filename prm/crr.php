<?php
$prm_crr_nom = $prm_crr_sym = $prm_crr_dcm = $prm_crr_ttr = array();
$rq_prm_crr = sel_prm("*","prm_crr");
while($dt_prm_crr = ftc_ass($rq_prm_crr)){
	$prm_crr_nom[$dt_prm_crr['id']] = $dt_prm_crr['crr'];
	$prm_crr_sym[$dt_prm_crr['id']] = $dt_prm_crr['sym'];
	$prm_crr_dcm[$dt_prm_crr['id']] = $dt_prm_crr['dcm'];
	if(isset($lgg)){
		foreach($lgg as $i => $uid_lgg){$prm_crr_ttr[$uid_lgg][$dt_prm_crr['id']] = $dt_prm_crr['nom_'.$uid_lgg];}
	}
}
if(isset($lgg)){
	foreach($lgg as $i => $uid_lgg){asort($prm_crr_ttr[$uid_lgg]);}
}
?>
