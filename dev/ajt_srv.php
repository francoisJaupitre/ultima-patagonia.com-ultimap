<?php
$id_cat_srv = $_POST['id_cat_srv'];
$id_dev_prs = $_POST['id_dev_prs'];
$vll_srv = $_POST['vll_srv'];
$ctg_srv = $_POST['ctg_srv'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$opt_srv = 1;
$resrv = 0;
$alt = $err = $err_srv = '';
if($id_cat_srv==0){
	$dt_dev_prs = ftc_ass(select("id_jrn","dev_prs","id",$id_dev_prs));
	$dt_dev_jrn = ftc_ass(select("id_mdl","dev_jrn","id",$dt_dev_prs['id_jrn']));
	$dt_dev_mdl = ftc_ass(select("id_crc,trf","dev_mdl","id",$dt_dev_jrn['id_mdl']));
	$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
	$id_crr_crc = $dt_dev_crc['crr'];
	$cur = 1;
	$id_crr = $id_crr_crc;
	include("clc_crr.php");
	$id_dev_srv = insert("dev_srv",array("id_prs","id_vll","ctg","crr","taux","sup","opt"),array($id_dev_prs,$vll_srv,$ctg_srv,1,$taux,$sup,1));
	if($dt_dev_mdl['trf']==1){$rq_bss = select("id,base","dev_mdl_bss","id_mdl",$dt_dev_jrn['id_mdl'],"base");}
	else{$rq_bss = select("id, base","dev_crc_bss","id_crc",$dt_dev_mdl['id_crc'],"base");}
	while($dt_bss = ftc_ass($rq_bss)){insert("dev_srv_trf",array("id_srv","base"),array($id_dev_srv,$dt_bss['base']));}
}
else{
	$dt_dev_prs = ftc_ass(select("id_jrn","dev_prs","id",$id_dev_prs));
	$id_dev_jrn = $dt_dev_prs['id_jrn'];
	$dt_dev_jrn = ftc_ass(select("id_mdl,date","dev_jrn","id",$id_dev_jrn));
	$id_dev_mdl = $dt_dev_jrn['id_mdl'];
	$date = $dt_dev_jrn['date'];
	$dt_dev_mdl = ftc_ass(select("id_crc","dev_mdl","id",$id_dev_mdl));
	$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
	$id_crr_crc = $dt_dev_crc['crr'];
	include("ins_srv.php");
	if($err_srv != ''){$err = $txt->err->srv->$id_lng.$err_srv;}
	if(isset($lst_nvtrf)){
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom){$err .= "-> ".$nom."\n";}
	}
	echo $err."|".$alt;
}
?>
