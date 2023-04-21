<?php
if(is_numeric($_POST["id"])){
	include("../prm/fct.php");
	include("../cfg/crr.php");
	$id = $_POST["id"];
	$cbl = $_POST["cbl"];
	$dt_pay = ftc_ass(sel_quo("date,liq,crr,id_".$cbl,"dev_".$cbl."_pay","id",$id));
	$dat = $dt_pay['date'];
	$liq = $dt_pay['liq'];
	$prm_crr_nom = $dt_pay['crr'];
	if($cbl=='hbr'){
		$dt_hbr = ftc_ass(sel_quo("dev_hbr.id_cat,dev_hbr.nom,id_grp,dev_prs.opt","(((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","dev_hbr.id",$dt_pay['id_hbr']));
		$id_grp = $dt_hbr['id_grp'];
		$opt = $dt_hbr['opt'];
		if($dt_hbr['id_cat']>0){
			$dt_cat = ftc_ass(sel_quo("nom,id_frn,frs,notfrs","cat_hbr","id",$dt_hbr['id_cat']));
			if($dt_cat['id_frn']>0){
				$dt_frn = ftc_ass(sel_quo("nom,frs,notfrs","cat_frn","id",$dt_cat['id_frn']));
				$nat = $dt_frn['nom'];
				$frs = $dt_frn['frs'];
				$notfrs = $dt_frn['notfrs'];
			}
			else{
				$nat = $dt_cat['nom'];
				$frs = $dt_cat['frs'];
				$notfrs = $dt_cat['notfrs'];
			}
		}
		else{
			$nat = $dt_hbr['nom'];
			$frs = 0;
		}
	}
	else{
		$dt_dev = ftc_ass(sel_quo("id_frn,id_grp,dev_prs.opt","(((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","dev_srv.id",$dt_pay['id_srv']));
		$id_grp = $dt_dev['id_grp'];
		$opt = $dt_dev['opt'];
		$dt_frn = ftc_ass(sel_quo("nom,frs,notfrs","cat_frn","id",$dt_dev['id_frn']));
		$nat = $dt_frn['nom'];
		$frs = $dt_frn['frs'];
		$notfrs = $dt_frn['notfrs'];
	}
	if($dat=='0000-00-00'){$dat = date("Y-m-d");}
	$id_ecr = insert("fin_ecr",array("date","nature"),array($dat,$nat));
	if($cbl == 'hbr'){$id_pst = 3;}
	else{$id_pst = 1;}
	$mois = date("Y-m",strtotime($dat)).'-01';
	$dvs = -$liq;
	if($cfg_crr_sp[$prm_crr_nom]){$liq *= $cfg_crr_txf[$prm_crr_nom];}
	else{$liq /= $cfg_crr_txf[$prm_crr_nom];}
	$dtt = -$liq;
	if($opt){insert("fin_bdg",array("id_ecr","id_pst","id_grp","mois","dtt"),array($id_ecr,$id_pst,$id_grp,$mois,$dtt));}
	else{insert("fin_bdg",array("id_ecr","id_pst","id_grp","mois","chg"),array($id_ecr,$id_pst,$id_grp,$mois,$liq));}
	insert("fin_trs",array("id_ecr","sld","dvs"),array($id_ecr,$dtt,$dvs));
	if($frs>0){
		if($opt){insert("fin_bdg",array("id_ecr","id_pst","id_grp","mois","dtt","dsc"),array($id_ecr,"2",$id_grp,$mois,$dtt*$frs,$notfrs));}
		else{insert("fin_bdg",array("id_ecr","id_pst","id_grp","mois","chg","dsc"),array($id_ecr,"2",$id_grp,$mois,$liq*$frs,$notfrs));}
		insert("fin_trs",array("id_ecr","sld","dvs"),array($id_ecr,$dtt*$frs,$dvs*$frs));
	}
	upd_quo("dev_".$cbl."_pay","fin","1",$id);
}
?>
