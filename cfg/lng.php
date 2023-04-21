<?php
$dt_usr = ftc_ass(sel_prm("id,id_agt,ip,mmbr","prm_usr","log",$_SERVER['REMOTE_USER']));
if($dt_usr['ip']=='0' or $dt_usr['ip']==$_SERVER['REMOTE_ADDR']){
	$aut['mmbr'] = $dt_usr['mmbr'];
	$id_usr = $dt_usr['id'];
	$dt_pys = ftc_ass(sel_prm("lgg","prm_pays INNER JOIN prm_agt ON prm_pays.id=prm_agt.id_pays","prm_agt.id",$dt_usr['id_agt']));
	$lgg_pys = $dt_pys['lgg'];
	if($dt_usr['mmbr']){
		$dt_cfg = ftc_ass(sel_quo("lng","cfg_usr","id_usr",$id_usr));
		$id_lng = $dt_cfg['lng'];
	}
}
?>
