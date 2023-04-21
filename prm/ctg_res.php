<?php
$ctg_res = array();
$rq_ctg = sel_prm("*","prm_ctg_res");
while($dt_ctg = ftc_ass($rq_ctg)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$ctg_res[$uid_lgg][$dt_ctg['id']] = $dt_ctg['nom_'.$uid_lgg];}
		}
	}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($ctg_res[$uid_lgg]);}
	}
?>