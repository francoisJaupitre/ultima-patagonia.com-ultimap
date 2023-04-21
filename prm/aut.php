<?php
$dt_usr = ftc_ass(sel_prm("*","prm_usr","log",$_SERVER['REMOTE_USER']));
if($dt_usr['ip']=='0' or $dt_usr['ip']==$_SERVER['REMOTE_ADDR']){
	$aut['mmbr'] = $dt_usr['mmbr'];
	if($aut['mmbr']){
		$qui = $dt_usr['qui'];
		$dat_fin = $dt_usr['dat_fin'];
		$aut['adm_cat'] = $dt_usr['adm_cat'];
		$aut['adm_dev'] = $dt_usr['adm_dev'];
		$aut['adm_fin'] = $dt_usr['adm_fin'];
		$aut['adm_res'] = $dt_usr['adm_res'];
		$aut['cmp'] = $dt_usr['cmp'];
		$aut['crm'] = $dt_usr['crm'];
		$aut['crr'] = $dt_usr['crr'];
		$aut['fin'] = $dt_usr['fin'];
		$aut['mrq'] = $dt_usr['mrq'];
		$aut['tsk'] = $dt_usr['tsk'];
		$aut['web'] = $dt_usr['web'];
		$agence = $dt_usr['id_agt'];
		$dt_prm = ftc_ass(sel_prm("id_pays,lgg,timezone,agent","prm_pays INNER JOIN prm_agt ON prm_pays.id=prm_agt.id_pays","prm_agt.id",$agence));
		$id_pys = $dt_prm['id_pays'];
		$lgg_pys = $dt_prm['lgg'];
		$dir = $dt_prm['agent'];
		date_default_timezone_set($dt_prm['timezone']);
		$dt_cfg = ftc_ass(sel_quo("*","cfg_usr","id_usr",$dt_usr['id']));
		if(!empty($dt_cfg['id'])){
			$id_cfg_usr = $dt_cfg['id'];
			$id_usr = $dt_cfg['id_usr'];
			$id_lng = $dt_cfg['lng'];
			$id_lgg = $dt_cfg['lgg'];
			$mel_usr = $dt_cfg['mail'];
			if(isset($id_dev_crc)){$dt_usr_dev = ftc_ass(sel_quo("usr,cnf","dev_crc","id",$id_dev_crc));}
			elseif(isset($id_grp) and $id_grp>0 and !isset($cnf)){$dt_usr_dev = ftc_ass(sel_quo("usr","grp_dev","id",$id_grp));$cnf=0;}
			if($aut['adm_res'] or (isset($cnf) and $cnf!=2 and $cnf!=-1 and $id_usr==$dt_usr_dev['usr'])){$aut['res'] = true; }
			else{$aut['res'] = false;}
			if($aut['adm_dev'] or ( isset($cnf) and $cnf!=2 and $cnf!=-1 and $id_usr==$dt_usr_dev['usr'])){$aut['dev'] = true;}
			else{$aut['dev'] = false;}
			if(isset($cbl_cat)){$dt_usr_cat = ftc_ass(sel_quo("usr","cat_".$cbl_cat,"id",$id_cat));}
			if($aut['adm_cat'] or $id_usr==$dt_usr_cat['usr']){$aut['cat'] = true;}
			else{$aut['cat'] = false;}
		}
	}
	else{include("../logout.php");}
}
?>
