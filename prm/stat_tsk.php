<?php
$stat_tsk = $col_stat_tsk = array();
$rq_stat = sel_prm("*","prm_stat_tsk");
while($dt_stat = ftc_ass($rq_stat)){
	foreach($lgg as $uid => $uid_lgg){
		if(isset($dt_stat['nom_'.$uid_lgg])){$stat_tsk[$uid_lgg][$dt_stat['id']] = $dt_stat['id'].' - '.$dt_stat['nom_'.$uid_lgg];}
	}
	$col_stat_tsk[$dt_stat['id']] = $dt_stat['col'];
}
foreach($lgg as $uid => $uid_lgg){
	if(isset($stat_tsk[$uid_lgg])){asort($stat_tsk[$uid_lgg]);}
}
?>
