<?php
$stat_ech = $col_stat_ech = array();
$rq_stat = sel_prm("*","prm_stat_ech");
while($dt_stat = ftc_ass($rq_stat)){
	foreach($lgg as $uid => $uid_lgg){
		if(isset($dt_stat['nom_'.$uid_lgg])){$stat_ech[$uid_lgg][$dt_stat['id']] = $dt_stat['nom_'.$uid_lgg];}
	}
	$col_stat_ech[$dt_stat['id']] = $dt_stat['col'];
}
foreach($lgg as $uid => $uid_lgg){
	if(isset($stat_ech[$uid_lgg])){asort($stat_ech[$uid_lgg]);}
}
?>
