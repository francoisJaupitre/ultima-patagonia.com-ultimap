<?php
$obj = $_POST['obj'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$err_hbr = $err_srv = '';
if($obj == 'crc'){
	$id_dev_crc = $_POST['id'];
	$dt_dev_crc = ftc_ass(select("ptl,crr","dev_crc","id",$id_dev_crc));
	$id_crr_crc = $dt_dev_crc['crr'];
	$rq_dev_mdl = select("id,trf,ptl","dev_mdl","id_crc",$id_dev_crc,"ord");
	while($dt_dev_mdl = ftc_ass($rq_dev_mdl)){
		$id_dev_mdl = $dt_dev_mdl['id'];
		unset($bss);
		if($dt_dev_mdl['trf']==1){
			$rq_bss = select("id,base","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
			$ptl = $dt_dev_mdl['ptl'];
		}
		else{
			$rq_bss = select("id,base","dev_crc_bss","id_crc",$id_dev_crc,"base");
			$ptl = $dt_dev_crc['ptl'];
		}
		while($dt_bss = ftc_ass($rq_bss)){$bss[$dt_bss['id']] = $dt_bss['base'];}
		include("act_trf_mdl.php");
	}
}
elseif($obj == 'mdl'){
	$id_dev_mdl = $_POST['id'];
	$dt_dev_mdl = ftc_ass(select("id_crc,trf,ptl","dev_mdl","id",$id_dev_mdl));
	$dt_dev_crc = ftc_ass(select("ptl,crr","dev_crc","id",$dt_dev_mdl['id_crc']));
	$id_crr_crc = $dt_dev_crc['crr'];
	unset($bss);
	if($dt_dev_mdl['trf']==1){
		$rq_bss = select("id,base","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		$ptl = $dt_dev_mdl['ptl'];
	}
	else{
		$rq_bss = select("id,base","dev_crc_bss","id_crc",$dt_dev_mdl['id_crc'],"base");
		$ptl = $dt_dev_crc['ptl'];
	}
	while($dt_bss = ftc_ass($rq_bss)){$bss[$dt_bss['id']] = $dt_bss['base'];}
	include("act_trf_mdl.php");
}
elseif($obj == 'jrn'){
	$id_dev_jrn = $_POST['id'];
	$id_dev_mdl = $_POST['id_sup'];
	$dt_dev_jrn = ftc_ass(select('date,ord','dev_jrn','id',$id_dev_jrn));
	$date = $dt_dev_jrn['date'];
	$ord_jrn = $dt_dev_jrn['ord'];
	$dt_dev_mdl = ftc_ass(select("id_crc,trf,ptl","dev_mdl","id",$id_dev_mdl));
	$dt_dev_crc = ftc_ass(select("ptl,crr","dev_crc","id",$dt_dev_mdl['id_crc']));
	$id_crr_crc = $dt_dev_crc['crr'];
	unset($bss);
	if($dt_dev_mdl['trf']==1){
		$rq_bss = select("id,base","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		$ptl = $dt_dev_mdl['ptl'];
	}
	else{
		$rq_bss = select("id,base","dev_crc_bss","id_crc",$dt_dev_mdl['id_crc'],"base");
		$ptl = $dt_dev_crc['ptl'];
	}
	while($dt_bss = ftc_ass($rq_bss)){$bss[$dt_bss['id']] = $dt_bss['base'];}
	include("act_trf_jrn.php");
}
elseif($obj == 'prs'){
	$id_dev_prs = $_POST['id'];
	$id_dev_jrn = $_POST['id_sup'];
	$dt_dev_jrn = ftc_ass(select('id_mdl,date,ord','dev_jrn','id',$id_dev_jrn));
	$date = $dt_dev_jrn['date'];
	$ord_jrn = $dt_dev_jrn['ord'];
	$id_dev_mdl = $dt_dev_jrn['id_mdl'];
	$dt_dev_mdl = ftc_ass(select("id_crc,trf,ptl","dev_mdl","id",$id_dev_mdl));
	$dt_dev_crc = ftc_ass(select("ptl,crr","dev_crc","id",$dt_dev_mdl['id_crc']));
	$id_crr_crc = $dt_dev_crc['crr'];
	if($dt_dev_mdl['trf']==1){
		$rq_bss = select("id,base","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		$ptl = $dt_dev_mdl['ptl'];
	}
	else{
		$rq_bss = select("id,base","dev_crc_bss","id_crc",$dt_dev_mdl['id_crc'],"base");
		$ptl = $dt_dev_crc['ptl'];
	}
	while($dt_bss = ftc_ass($rq_bss)){$bss[$dt_bss['id']] = $dt_bss['base'];}
	include("act_trf_prs.php");
}
elseif($obj == 'srv' or $obj == 'frn_all'){
	$ids = explode("_",$_POST['id']);
	foreach($ids as $id_dev_srv){
		$dt_dev_srv = ftc_ass(select('id_cat,id_prs,crr','dev_srv','id',$id_dev_srv));
		$id_cat_srv = $dt_dev_srv['id_cat'];
		$id_crr_srv = $dt_dev_srv['crr'];
		$dt_dev_prs = ftc_ass(select('id_jrn','dev_prs','id',$dt_dev_srv['id_prs']));
		$dt_dev_jrn = ftc_ass(select('id_mdl,date','dev_jrn','id',$dt_dev_prs['id_jrn']));
		$dt_dev_mdl = ftc_ass(select("id_crc,trf,ptl","dev_mdl","id",$dt_dev_jrn['id_mdl']));
		$dt_dev_crc = ftc_ass(select("ptl,crr","dev_crc","id",$dt_dev_mdl['id_crc']));
		$id_crr_crc = $dt_dev_crc['crr'];
		if($id_cat_srv > 0){
			$date = $dt_dev_jrn['date'];
			$id_dev_mdl = $dt_dev_jrn['id_mdl'];
			if($date!='0000-00-00'){$dt_trf1 = ftc_all(select("*","cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf","id_srv",$id_cat_srv));}
			$dt_trf2 = ftc_all(select("*","cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf","def=1 and id_srv",$id_cat_srv,"dt_max DESC"));
			$err_bss = '';
			$dt_min=$dt_max='0000-00-00';
			if($dt_dev_mdl['trf']==1){
				$rq_bss = select("id, base", "dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
				$ptl = $dt_dev_mdl['ptl'];
			}
			else{
				$rq_bss = select("id,base","dev_crc_bss","id_crc",$dt_dev_mdl['id_crc'],"base");
				$ptl = $dt_dev_crc['ptl'];
			}
			if(num_rows($rq_bss)>0){
				while($dt_bss = ftc_ass($rq_bss)){$bss[$dt_bss['id']] = $dt_bss['base'];}
				$flg_crr = false;
				foreach($bss as $id_bss => $base){
					$dt_dev_trf = ftc_ass(select("id","dev_srv_trf","id_srv=".$id_dev_srv." and base",$base));
					if(!empty($dt_dev_trf['id'])){$id_dev_trf = $dt_dev_trf['id'];}
					else{$id_dev_trf = insert("dev_srv_trf",array("id_srv","base"),array($id_dev_srv,$base));}
					include("act_trf_srv.php");
				}
				if($flg_crr){
					$id_crr = $id_crr_crc;
					include("clc_crr.php");
					upd_quo("dev_srv",array("crr","taux","sup",'dt_min','dt_max'),array($cur,$taux,$sup,$dt_min,$dt_max),$id_dev_srv);
				}
				else{upd_quo('dev_srv',array('dt_min','dt_max'),array($dt_min,$dt_max),$id_dev_srv);}
				if($err_bss!=''){
					$err_srv .= '-> '.$txt->jour->$id_lng.' '.$ord_jrn;
					if($date!='0000-00-00'){$err_srv .= ' | '.date("d/m/Y",strtotime($date));}
					if($obj != 'frn_all'){
						$dt_srv = ftc_ass(select("nom","dev_srv","id",$id_dev_srv));
						$err_srv .= ' : '.$dt_srv['nom'];
					}
					$err_srv .= ', '.$txt->bss->$id_lng.' : '.$err_bss."\n";
				}
			}
		}
		else{
			$cur = $id_crr_srv;
			$id_crr = $id_crr_crc;
			include("clc_crr.php");
			upd_quo("dev_srv",array("taux","sup"),array($taux,$sup),$id_dev_srv);
			if($date!='0000-00-00'){$err_srv .= '-> '.date("d/m/Y",strtotime($date)).' : '.$dt_dev_srv['nom']."\n";}
			else{$err_srv .= '-> '.$txt->jour->$id_lng.' '.$ord_jrn.' : '.$dt_dev_srv['nom']."\n";}
		}
	}
}
elseif($obj == 'hbr' or $obj == 'hbr_all'){
	$ids = explode("_",$_POST['id']);
	foreach($ids as $id_dev_hbr){
		$dt_dev_hbr = ftc_ass(select('id_cat,id_cat_chm,id_prs,rgm,crr_chm,crr_rgm','dev_hbr','id',$id_dev_hbr));
		$id_cat_hbr = $dt_dev_hbr['id_cat'];
		$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
		$id_hbr_rgm = $dt_dev_hbr['rgm'];
		$id_crr_chm = $dt_dev_hbr['crr_chm'];
		$id_crr_rgm = $dt_dev_hbr['crr_rgm'];
		$dt_dev_prs = ftc_ass(select('id_jrn','dev_prs','id',$dt_dev_hbr['id_prs']));
		$dt_dev_jrn = ftc_ass(select('ord,date,id_mdl','dev_jrn','id',$dt_dev_prs['id_jrn']));
		$dt_dev_mdl = ftc_ass(select("id_crc","dev_mdl","id",$dt_dev_jrn['id_mdl']));
		$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
		$id_crr_crc = $dt_dev_crc['crr'];
		$date = $dt_dev_jrn['date'];
		$ord_jrn = $dt_dev_jrn['ord'];
		if($id_cat_hbr > 0 and $id_cat_chm > 0){
			$dt_cat_hbr = ftc_ass(select("id_frn,frs","cat_hbr","id",$id_cat_hbr));
			include("act_trf_hbr.php");
		}
		else{
			$cur = $dt_dev_hbr['crr_chm'];
			$id_crr = $id_crr_crc;
			include("clc_crr.php");
			upd_quo("dev_hbr",array("taux_chm","sup_chm"),array($taux,$sup),$id_dev_hbr);
			if($dt_dev_hbr['crr_rgm']>0){
				$cur = $dt_dev_hbr['crr_rgm'];
				$id_crr = $id_crr_crc;
				include("clc_crr.php");
				upd_quo("dev_hbr",array("taux_rgm","sup_rgm"),array($taux,$sup),$id_dev_hbr);
			}
		}
		if($id_cat_hbr > 0){
			$dt_cat_hbr = ftc_ass(select("nvtrf,nom","cat_hbr","id",$id_cat_hbr));
			if($dt_cat_hbr['nvtrf'] and !in_array($dt_cat_hbr['nom'],$lst_nvtrf)){$lst_nvtrf[] = $dt_cat_hbr['nom'];}
		}
	}
}
$err = '';
if($err_hbr != ''){
	$err .= $txt->err->hbr->$id_lng."\n";
	$err .= $err_hbr."\n\n";
}
if($err_srv != ''){
	$err .= $txt->err->srv->$id_lng."\n";
	$err .= $err_srv."\n\n";
}
if(isset($lst_nvtrf)){
	$err .= $txt->err->nvtrf->$id_lng."\n";
	foreach($lst_nvtrf as $nom){$err .= "-> ".$nom."\n";}
}
if($err != ''){echo $err;}
else{echo 1;}
?>
