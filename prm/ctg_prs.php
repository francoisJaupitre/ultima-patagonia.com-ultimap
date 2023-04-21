<?php
$ctg_prs = array();
$rq_ctg = sel_prm("*","prm_ctg_prs");
while($dt_ctg = ftc_ass($rq_ctg)){
	foreach($lgg as $uid => $uid_lgg){
		if($lngg[$uid]){$ctg_prs[$uid_lgg][$dt_ctg['id']] = $dt_ctg['nom_'.$uid_lgg];}
		}
	$mrk_srv_ctg_prs[$dt_ctg['id']] = $dt_ctg['mrk_srv'];
	$doc_srv_ctg_prs[$dt_ctg['id']] = $dt_ctg['doc_srv'];
	}
foreach($lgg as $uid => $uid_lgg){
	if($lngg[$uid]){asort($ctg_prs[$uid_lgg]);}
	}
?>
