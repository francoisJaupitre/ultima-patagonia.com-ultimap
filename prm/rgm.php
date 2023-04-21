<?php
$rgm = array();
$rq_ctg = sel_prm("*","prm_rgm");
while($dt_ctg = ftc_ass($rq_ctg)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$rgm[$uid_lgg][$dt_ctg['id']] = $dt_ctg['nom_'.$uid_lgg];}
	}
}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($rgm[$uid_lgg]);}
}
?>