<?php
$ctg_hbr = $rmg_hbr = array();
$rq_ctg = sel_quo("*","cfg_ctg_hbr","","","ord");
while($dt_ctg = ftc_ass($rq_ctg)){
	foreach($lgg as $uid => $uid_lgg){$ctg_hbr[$uid_lgg][$dt_ctg['id']] = $dt_ctg['nom_'.$uid_lgg];}
	$rmg_hbr[$dt_ctg['id']] = $dt_ctg['rmg'];
}
if(count($ctg_hbr)>0){
	foreach($lgg as $uid => $uid_lgg){asort($ctg_hbr[$uid_lgg]);}
}
?>
