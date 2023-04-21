<?php
$hbr_def = array();
$rq_hbr_def = sel_quo("*","cfg_hbr_def","","","ord");
while($dt_hbr_def = ftc_ass($rq_hbr_def)){
	foreach($lgg as $uid => $uid_lgg){$hbr_def[$uid_lgg][$dt_hbr_def['id']] = $dt_hbr_def['nom_'.$uid_lgg];}
}
if(count($hbr_def)>0){
	foreach($lgg as $uid => $uid_lgg){asort($hbr_def[$uid_lgg]);}
}
?>
