<?php
$room = $cpc_room = array();
$rq_room = sel_prm("*","prm_room");
while($dt_room = ftc_ass($rq_room)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$room[$uid_lgg][$dt_room['id']] = $dt_room['nom_'.$uid_lgg];}
	}
	$cpc_room[$dt_room['id']] = $dt_room['cpc'];
}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($room[$uid_lgg]);}
}
?>