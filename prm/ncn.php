<?php
/*
$ncn = array();
$rq_ncn = sel_prm("*","prm_ncn");
while($dt_ncn = ftc_ass($rq_ncn)){$ncn[$dt_ncn['id']] = $dt_ncn['ncn'];}
*/
$ncn = array();
$rq_ncn = sel_prm("*","prm_ncn");
while($dt_ncn = ftc_ass($rq_ncn)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$ncn[$uid_lgg][$dt_ncn['id']] = $dt_ncn['nom_'.$uid_lgg];}
	}
}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($ncn[$uid_lgg]);}
}
?>