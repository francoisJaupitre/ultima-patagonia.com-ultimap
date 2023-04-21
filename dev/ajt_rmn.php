<?php
$cbl=$_POST['cbl'];
include("../prm/fct.php");
if($cbl=='crc'){
	$id_dev_crc = $_POST['id'];
	$rq_bss_crc = select("base", "dev_crc_bss","vue=1 AND id_crc",$id_dev_crc);
	$num_bss_crc = num_rows($rq_bss_crc);
	$dt_bss_crc = ftc_ass($rq_bss_crc);
	$bss_crc = $dt_bss_crc['base'];
	$dt_crc = ftc_ass(select("ptl","dev_crc","id",$id_dev_crc));
	if($dt_crc['ptl']){$bss_crc++;}
	$max_rmn = ftc_ass(select("MAX(nr),id","dev_crc_rmn","id_crc",$id_dev_crc));
	$nr = $max_rmn['MAX(nr)']+1;
	$id_rmn = $max_rmn['id'];
	$nb_pax = ftc_ass(select("COUNT(id)","dev_crc_rmn_pax","id_rmn",$id_rmn));
	if($max_rmn['MAX(nr)']>0 and $nb_pax['COUNT(id)'] == $bss_crc){
		$dt_rmn = ftc_ass(select("*","dev_crc_rmn","id",$id_rmn));
		unset($dt_rmn['id']);
		$dt_rmn['nr'] = $nr;
		insert("dev_crc_rmn",array_keys($dt_rmn),array_values($dt_rmn));
	}
	else{
		if($num_bss_crc!=1){echo 1;}
		else{
			$id_rmn = insert("dev_crc_rmn",array("id_crc","nr"),array($id_dev_crc,$nr));
			upd_var_quo("dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl=dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","id_rmn",$id_rmn,array("id_rmn","id_crc"),array(0,$id_dev_crc));
		}
	}
}
elseif($cbl=='mdl'){
	$id_dev_mdl = $_POST['id'];
	$rq_bss_mdl = select("base", "dev_mdl_bss","vue=1 AND id_mdl",$id_dev_mdl);
	$num_bss_mdl = num_rows($rq_bss_mdl);
	$dt_bss_mdl = ftc_ass($rq_bss_mdl);
	$bss_mdl = $dt_bss_mdl['base'];
	$dt_mdl = ftc_ass(select("ptl","dev_mdl","id",$id_dev_mdl));
	if($dt_mdl['ptl']){$bss_mdl++;}
	$max_rmn = ftc_ass(select("MAX(nr),id","dev_mdl_rmn","id_mdl",$id_dev_mdl));
	$nr = $max_rmn['MAX(nr)']+1;
	$id_rmn = $max_rmn['id'];
	$nb_pax = ftc_ass(select("COUNT(id)","dev_mdl_rmn_pax","id_rmn",$id_rmn));
	if($max_rmn['MAX(nr)']>0 and $nb_pax['COUNT(id)'] == $bss_mdl){
		$dt_rmn = ftc_ass(select("*","dev_mdl_rmn","id",$id_rmn));
		unset($dt_rmn['id']);
		$dt_rmn['nr'] = $nr;
		insert("dev_mdl_rmn",array_keys($dt_rmn),array_values($dt_rmn));
	}
	else{
		if($num_bss_mdl!=1){echo 1;}
		else{
			$id_rmn = insert("dev_mdl_rmn",array("id_mdl","nr"),array($id_dev_mdl,$nr));
			upd_var_quo("dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","id_rmn",$id_rmn,array("id_rmn","id_mdl"),array(0,$id_dev_mdl));
		}
	}
}
?>
