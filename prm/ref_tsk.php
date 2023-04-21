<?php
$ref_tsk = array();
$rq_ref = sel_prm("*","prm_ref_tsk");
while($dt_ref = ftc_ass($rq_ref)){
	foreach($lgg as $uid => $uid_lgg){$ref_tsk[$uid_lgg][$dt_ref['id']] = $dt_ref['nom_'.$uid_lgg];}
	}
foreach($lgg as $uid => $uid_lgg){asort($ref_tsk[$uid_lgg]);}
?>