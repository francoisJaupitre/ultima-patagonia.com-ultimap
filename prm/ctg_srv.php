<?php
$ctg_srv = array();
$rq_ctg = sel_prm("*","prm_ctg_srv");
while($dt_ctg = ftc_ass($rq_ctg)){
	foreach($lgg as $uid => $uid_lgg){
		if($lngg[$uid]){$ctg_srv[$uid_lgg][$dt_ctg['id']] = $dt_ctg['nom_'.$uid_lgg];}
	}
	$mrk_nom_ctg_srv[$dt_ctg['id']] = $dt_ctg['mrk_nom'];
	$mrk_ctg_ctg_srv[$dt_ctg['id']] = $dt_ctg['mrk_ctg'];
	$guia_ctg_srv[$dt_ctg['id']] = $dt_ctg['guia'];
	$srv_ctg_srv[$dt_ctg['id']] = $dt_ctg['srv'];
	$lgg_ctg_srv[$dt_ctg['id']] = $dt_ctg['lgg'];
}
foreach($lgg as $uid => $uid_lgg){
	if($lngg[$uid]){asort($ctg_srv[$uid_lgg]);}
}
?>
