<?php
$rq_usr = sel_prm("prm_usr.id,log,qui,lgg","prm_usr INNER JOIN (prm_agt INNER JOIN prm_pays ON prm_agt.id_pays = prm_pays.id) ON prm_usr.id_agt = prm_agt.id","actif=1 AND id_agt",$agence);
while($dt_usr = ftc_ass($rq_usr)){
	if($dt_usr['log']==$_SERVER['REMOTE_USER']){
	//	$flg_log = true;
		$id_lgg_frn = $dt_usr['lgg'];
		$id_usr = $dt_usr['id'];
	}
	$lst_usr[$dt_usr['id']] = $dt_usr['qui'];
}
/*if(!$flg_log){
	include("../logout.php");
	return;
}*/
$dt_cfg = ftc_ass(sel_quo("*","cfg_usr","id_usr",$id_usr));
if(!empty($dt_cfg['id'])){
	$id_usr = $dt_cfg['id_usr'];
	$id_lng = $dt_cfg['lng'];
	$id_lgg = $dt_cfg['lgg'];
}
else{
	include("../logout.php");
	return;
}
?>
