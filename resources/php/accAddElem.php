<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['cbl']) and isset($data['nom'])) {
	$cbl = $data['cbl'];
	$nom = $data['nom'];//$nom = rawurldecode($data['nom']);
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	$alt = $err = "";
	switch($cbl) {
		case 'grp':
			$id_clt = $data['clt'];
			if($id_clt == 0) {$id_clt=1;}
			$id = insert("grp_dev",array("id_clt","nomgrp","usr"),array($id_clt,$nom,$id_usr));
			break;
		case 'dev':
			include("../../cfg/crr.php");
			include("../../cfg/ctg_clt.php");
			$txt = simplexml_load_file('../dev/txt.xml');
			$id_cat_crc = $data['id_cat'];
			if(isset($data['clt'])) {$id_clt = $data['clt'];}
			else{$id_clt = 0;}
			if(isset($data['grp'])) {$id_grp = $data['grp'];}
			else{$id_grp = 0;}
			$err_crc = $err_mdl = $err_jrn = $err_prs = $err_hbr = $err_srv = '';
			if($id_grp > 0) {
				$dt_grp = ftc_ass(sel_quo("id_clt","grp_dev","id",$id_grp));
				$id_clt = $dt_grp['id_clt'];
			}
			if($id_clt == 0) {$id_clt = 1;}
			$dt_clt = ftc_ass(sel_quo("*","cat_clt","id",$id_clt));
			if(!empty($dt_clt['id'])) {
				$id_crr_crc = $dt_clt['crr'];
				$dt_ctg = ftc_ass(sel_quo("*","cfg_ctg_clt","id",$dt_clt['id_ctg']));
				if(!empty($dt_ctg['id'])) {
					$com_ctg = $dt_ctg['com'];
					$mrq_hbr_ctg = $dt_ctg['mrq_hbr'];
					$frs_ctg = $dt_ctg['frs'];
					$ty_mrq_ctg = $dt_ctg['ty_mrq'];
				}
				else{
					$com_ctg = 0;
					$mrq_hbr_ctg = 0;
					$frs_ctg = 0;
					$ty_mrq_ctg = 1;
				}
			}
			else{
				$id_crr_crc = 1;
				$com_ctg = 0;
				$mrq_hbr_ctg = 0;
				$frs_ctg = 0;
				$ty_mrq_ctg = 1;
			}
			if($id_grp==0) {$id_grp = insert("grp_dev",array("id_clt","nomgrp","usr"),array($id_clt,$nom,$id_usr));}
			if($id_cat_crc==0) {$id = insert("dev_crc",array("id_grp","groupe","version","com","mrq_hbr","frs","ty_mrq","crr","lgg","dt_dev","usr","vue_dbl","vue_vols","vue_opt","vue_trf"),array($id_grp,$nom,1,$com_ctg,$mrq_hbr_ctg,$frs_ctg,$ty_mrq_ctg,$id_crr_crc,$id_lgg,date("Y-m-d"),$id_usr,1,1,1,1));}
			else{
				$dt_crc = ftc_ass(sel_quo("nom,titre,dsc","cat_crc INNER JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc",array("lgg","cat_crc.id"),array($id_lgg,$id_cat_crc)));
				$id = insert("dev_crc",array("id_grp","id_cat","groupe","nom","titre","dsc","version","com","mrq_hbr","frs","ty_mrq","crr","lgg","dt_dev","usr","vue_dbl","vue_vols","vue_opt","vue_trf"),array($id_grp,$id_cat_crc,$nom,$dt_crc['nom'],$dt_crc['titre'],$dt_crc['dsc'],1,$com_ctg,$mrq_hbr_ctg,$frs_ctg,$ty_mrq_ctg,$id_crr_crc,$id_lgg,date("Y-m-d"),$id_usr,1,1,1,1));
				$date = '0000-00-00';
				$ord_jrn = 1;
				$trf_mdl = 0;
				$id_dev_crc = $id;
				include("../../dev/ins_crc.php");
			}
			break;
		case 'crc':
			if(isset($data['clt'])) {$id_clt = $data['clt'];}
			else{$id_clt = 0;}
			$id = insert('cat_crc',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));
			if($id_clt>0) {insert('cat_crc_clt',array('id_crc','id_clt','dt_cat','usr'),array($id,$id_clt,date("Y-m-d"),$id_usr));}
			break;
		case 'mdl':
			$id_rgn = $data['rgn'];
			$id = insert('cat_mdl',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));
			if($id_rgn>0) {insert('cat_mdl_rgn',array('id_mdl','id_rgn','dt_cat','usr'),array($id,$id_rgn,date("Y-m-d"),$id_usr));}
			break;
		case 'jrn':
			$id_vll = $data['vll'];
			$id = insert('cat_jrn',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));
			if($id_vll>0) {insert('cat_jrn_vll',array('id_jrn','id_vll','ord','dt_cat','usr'),array($id,$id_vll,1,date("Y-m-d"),$id_usr));}
			break;
		case 'prs':
			$id_ctg = $data['ctg'];
			if($id_ctg>0) {$id = insert('cat_prs',array('nom','ctg','jours','dt_cat','usr'),array($nom,$ctg,1,date("Y-m-d"),$id_usr));}
			else{$id = insert('cat_prs',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));}
			break;
		case 'srv':
			$id_vll = $data['vll'];
			$id_ctg = $data['ctg'];
			if($id_vll>0) {
				if($id_ctg>0) {$id = insert('cat_srv',array('nom','id_vll','ctg','res','dt_cat','usr'),array($nom,$id_vll,$id_ctg,'1',date("Y-m-d"),$id_usr));}
				else{$id = insert('cat_srv',array('nom','id_vll','res','dt_cat','usr'),array($nom,$id_vll,'1',date("Y-m-d"),$id_usr));}
			}
			else{
				if($id_ctg>0) {$id = insert('cat_srv',array('nom','ctg','res','dt_cat','usr'),array($nom,$id_ctg,'1',date("Y-m-d"),$id_usr));}
				else{$id = insert('cat_srv',array('nom','res','dt_cat','usr'),array($nom,'1',date("Y-m-d"),$id_usr));}
			}
			break;
		case 'hbr':
			$id_vll = $data['vll'];
			$id_ctg = $data['ctg'];
			if($id_vll>0) {
				if($id_ctg>0) {$id = insert("cat_hbr",array("nom","id_vll","ctg","ctg_res",'dt_cat','usr'),array($nom,$id_vll,$id_ctg,1,date("Y-m-d"),$id_usr));}
				else{$id = insert("cat_hbr",array("nom","id_vll","ctg_res",'dt_cat','usr'),array($nom,$id_vll,1,date("Y-m-d"),$id_usr));}
			}
			else{
				if($id_ctg>0) {$id = insert("cat_hbr",array("nom","ctg","ctg_res",'dt_cat','usr'),array($nom,$id_ctg,1,date("Y-m-d"),$id_usr));}
				else{$id = insert("cat_hbr",array("nom","ctg_res",'dt_cat','usr'),array($nom,1,date("Y-m-d"),$id_usr));}
			}
			break;
		case 'clt':
			$dt_clt = ftc_ass(sel_quo("*","cfg_ctg_clt","id","2"));
			$id = insert("cat_clt",array("nom","id_ctg","crr","fac","dt_cat","usr"),array($nom,2,1,1,date("Y-m-d"),$id_usr));
			break;
		case 'frn':
			$id_vll = $data['vll'];
			$id_ctg = $data['ctg'];
			$id = insert('cat_frn',array('nom','ctg_res','dt_cat','usr'),array($nom,1,date("Y-m-d"),$id_usr));
			if($id_vll!=0) {insert('cat_frn_vll',array('id_frn','id_vll'),array($id,$id_vll));}
			if($id_ctg!=0) {insert('cat_frn_ctg_srv',array('id_frn','ctg_srv'),array($id,$id_ctg));}
			break;
		case 'rgn':
			$id = insert('cat_rgn',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));
			break;
		case 'vll':
			$id_rgn = $data['rgn'];
			if($id_rgn>0) {$id = insert('cat_vll',array('nom','id_rgn','dt_cat','usr'),array($nom,$id_rgn,date("Y-m-d"),$id_usr));}
			else{$id = insert('cat_vll',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));}
			break;
		case 'lieu':
			$id_vll = $data['vll'];
			if($id_vll>0) {$id = insert("cat_lieu",array("nom","id_vll",'dt_cat','usr'),array($nom,$id_vll,date("Y-m-d"),$id_usr));}
			else{$id = insert("cat_lieu",array("nom",'dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));}
			break;
		case 'bnq':
			$id = insert('cat_bnq',array('nom','dt_cat','usr'),array($nom,date("Y-m-d"),$id_usr));
			break;
	}
	//echo $id."|".$err."|".$alt;
	$qa = array($id, $err, $alt);
	echo json_encode($qa);
}
?>
