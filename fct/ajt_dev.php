<?php
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/crr.php");
include("../cfg/ctg_clt.php");
$alt = $err = $err_crc = $err_mdl = $err_jrn = $err_prs = $err_hbr = $err_srv = "";
$txt = simplexml_load_file('../dev/txt.xml');
$dt_clt = ftc_ass(sel_quo("*","cat_clt","id",1));
$id_ctg_clt = $dt_clt['id_ctg'];
$id_crr_crc = $dt_clt['crr'];
$dt_cfg = ftc_ass(sel_quo("*","cfg_ctg_clt","id",$id_ctg_clt));
$com_ctg = $dt_cfg['com'];
$mrq_hbr_ctg = $dt_cfg['mrq_hbr'];
$frs_ctg = $dt_cfg['frs'];
$ty_mrq_ctg = $dt_cfg['ty_mrq'];
if(isset($_POST['url'])) {
	$url = explode('&',rawurldecode($_POST['url']));
  foreach($url as $u) {
		$key = substr($u,0,strpos($u,'='));
		$value = substr($u,strpos($u,'=')+1);
		if($key == 'uid_crc') {
			$obj = 'crc';
			$uid = $value;
			$data_web[$obj][$uid]['uid'] = $uid;
		}
		elseif($key == 'uid_mdl') {
			$obj = 'mdl';
			$uid = $value;
			$data_web[$obj][$uid]['uid'] = $uid;
		}
		elseif($key == 'id_opt_jrn') {$data_web[$obj][$uid]['id_opt_jrn'][] = $value;}
		elseif($key == 'id_sel_jrn') {$id_sel_jrn = $value;}
		elseif($key == 'id_opt_prs') {$data_web[$obj][$uid]['id_opt_prs'][$id_sel_jrn][] = $value;}
		else{$data_web[$key] = $value;}
	}
	$dt_crc['groupe'] = $data_web['nom'];
	$id_cat_crc = 0;
	$dt_crc['periode'] = $data_web['periode'];
	$nombre = $data_web['nombre'];
	unset($obj);
}
else{
	$id_cat_crc = $_POST['id_cat'];
	$dt_crc = ftc_ass(sel_quo("nom,titre,dsc","cat_crc INNER JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc",array("lgg","cat_crc.id"),array($id_lgg,$id_cat_crc)));
	$dt_crc['groupe'] = $_POST['nom'];
}
$id_grp = insert("grp_dev",array("id_clt","nomgrp","usr"),array("1",$dt_crc['groupe'],$id_usr));
$dt_crc['id_grp'] = $id_grp;
$dt_crc['version'] = '1';
$dt_crc['com'] = $com_ctg;
$dt_crc['mrq_hbr'] = $mrq_hbr_ctg;
$dt_crc['frs'] = $frs_ctg;
$dt_crc['ty_mrq'] = $ty_mrq_ctg;
$dt_crc['crr'] = $id_crr_crc;
$dt_crc['lgg'] = $id_lgg;
$dt_crc['dt_dev'] = date("Y-m-d");
$dt_crc['usr'] = $id_usr;
$dt_crc['vue_dbl'] = 1;
$dt_crc['vue_vols'] = 1;
$dt_crc['vue_opt'] = 1;
$dt_crc['vue_trf'] = 1;
$date = '0000-00-00';
$ord_jrn = 1;
if($id_cat_crc > 0) {
	$dt_crc['id_cat'] = $id_cat_crc;
	$id_dev_crc = insert("dev_crc",array_keys($dt_crc),array_values($dt_crc),$id_usr,1,1,1);
	$trf_mdl = 0;
	include("../dev/ins_crc.php");
}
else{
	$data_crc = $dt_crc;
	$id_rmn = 0;
	$vue = 1;
	if(isset($data_web['crc'])) {
		$trf_mdl = 0;
		foreach($data_web['crc'] as $uid => $data_uid) {
			$dt_crc_txt = ftc_ass(sel_quo("id_crc,titre,nom,alerte","cat_crc_txt INNER  JOIN cat_crc ON cat_crc_txt.id_crc = cat_crc.id",array("lgg","web_uid"),array($id_lgg,$data_uid['uid'])));
			$id_cat_crc = $data_crc['id_cat'] = $dt_crc_txt['id_crc'];
			$alt_crc = $dt_crc_txt['alerte'];
			unset($dt_crc_txt['id_crc'],$dt_crc_txt['alerte']);
			$dt_crc = $data_crc + $dt_crc_txt;
			$id_dev_crc = insert("dev_crc",array_keys($dt_crc),array_values($dt_crc),$id_usr,1,1,1);
			$dt_crc['alerte'] = $alt_crc;
			include("../dev/ins_crc.php");
			$bss = explode(',',$nombre);
			foreach($bss as $base) {
				$dt_cfg = ftc_ass(sel_whe("mrq","cfg_mrq","bs_min <=".$base." AND bs_max >=".$base." AND id_ctg_clt=".$id_ctg_clt));
				insert("dev_crc_bss",array("id_crc","base","vue","mrq"),array($id_dev_crc,$base,$vue,$dt_cfg['mrq']));
				$rq_mdl = sel_quo("id","dev_mdl","id_crc",$id_dev_crc);
				while($dt_mdl = ftc_ass($rq_mdl)) {
					$id_dev_mdl = $dt_mdl['id'];
					include("../dev/ajt_trf_srv.php");
				}
			}
			$ids_dev_crc[] = $id_dev_crc;
		}
	}
	if(isset($data_web['mdl'])) {
		$ord_mdl = $fus = 0;
		$trf_mdl = 1;
		$ord_jrn_ant = 1;
		unset($dt_crc['id_cat'],$dt_crc['nom'],$dt_crc['titre'],$dt_crc['alerte']);
		$id_dev_crc = insert("dev_crc",array_keys($dt_crc),array_values($dt_crc),$id_usr,1,1,1);
		foreach($data_web['mdl'] as $uid => $data_uid) {
			$dt_cat_mdl_txt = ftc_ass(sel_quo("id_mdl","cat_mdl_txt",array("lgg","web_uid"),array($id_lgg,$data_uid['uid'])));
			$id_cat_mdl = $dt_cat_mdl_txt['id_mdl'];
			$ord_mdl++;
			include("../dev/ins_mdl.php");
			$bss = explode(',',$nombre);
			foreach($bss as $base) {
				$dt_cfg = ftc_ass(sel_whe("mrq","cfg_mrq","bs_min <=".$base." AND bs_max >=".$base." AND id_ctg_clt=".$id_ctg_clt));
				insert("dev_mdl_bss",array("id_mdl","base","vue","mrq"),array($id_dev_mdl,$base,$vue,$dt_cfg['mrq']));
				include("../dev/ajt_trf_srv.php");
			}
		}
		$ids_dev_crc[] = $id_dev_crc;
	}
	if($err_mrq) {$err .= $txt->err->mrq_bss->$id_lng."\n";}
	if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
	if(isset($err_crr)) {
		$err .= $txt->err->crr->$id_lng."\n";
		foreach($err_crr as $nom) {$err .= "-> ".$nom."\n";}
		$err .= "\n";
	}
	if(isset($lst_nvtrf)) {
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom) {$err .= "-> ".$nom."\n";}
		unset($lst_nvtrf);
	}
}
if(isset($ids_dev_crc)) {$id_dev_crc = implode('|',$ids_dev_crc);}
echo $id_dev_crc."||".$err."||".$alt;
?>
