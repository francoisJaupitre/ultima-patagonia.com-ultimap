<?php
$res_srv = $col_res_srv = $src_frn_res_srv = $maj_grp_res_srv = array();
$rq_res_srv = sel_prm("*","prm_res_srv");
while($dt_res_srv = ftc_ass($rq_res_srv)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$res_srv[$uid_lgg][$dt_res_srv['id']] = $dt_res_srv['nom_'.$uid_lgg];}
	}
	$col_res_srv[$dt_res_srv['id']] = $dt_res_srv['col'];
	$src_frn_res_srv[$dt_res_srv['id']] = $dt_res_srv['src_frn'];
	if($dt_res_srv['maj_grp']){$maj_grp_res_srv[] = $dt_res_srv['id'];}
}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($res_srv[$uid_lgg]);}
}
?>
