<?php
$id_cat_mdl = $_POST['id_cat_mdl'];
$id_rgn = $_POST['id_rgn'];
$id_dev_crc = $_POST['id_dev_crc'];
$id_lgg = $_POST['lgg'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$max_mdl = ftc_num(select("MAX(ord)","dev_mdl","id_crc",$id_dev_crc));
$i = $ord_mdl = $max_mdl[0] + 1;
$max_date = "0000-00-00";
$max_ord = $max_fus = 0;
$alt = $err = $err_mdl = $err_jrn = $err_prs = $err_hbr = $err_srv = '';
$flg_mdl = false;
$flg_plus = true;
while(!$flg_mdl and $i>1) {
	$i--;
	$dt_jrn = ftc_ass(sel_quo("MAX(dev_jrn.ord) AS ord,MAX(date) as date,fus","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",array("id_crc","dev_mdl.ord"),array($id_dev_crc,$i)));
	if(!is_null($dt_jrn['ord'])) {$flg_mdl = true;}
}
if($flg_mdl) {
	$max_date = $dt_jrn['date'];
	$max_ord = $dt_jrn['ord'];
	if($dt_jrn['fus']) {$flg_plus = false;}
}
$date='0000-00-00';
if(!$flg_plus) {
	$ord_jrn = $max_ord;
	if($max_date != '0000-00-00') {$date = $max_date;}
}
else{
	$ord_jrn = $max_ord + 1;
	if($max_date != '0000-00-00') {$date = date ('Y-m-d', strtotime ("+1 days $max_date"));}
}
if($id_cat_mdl != 0) {
	$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$id_dev_crc));
	$id_crr_crc = $dt_dev_crc['crr'];
	$dt_rmn = ftc_ass(select("id","dev_crc_rmn","nr=1 AND id_crc",$id_dev_crc));
	if(!empty($dt_rmn['id'])) {$id_rmn = $dt_rmn['id'];}
	else{$id_rmn = 0;}
	$trf_mdl = $fus = 0;
	$obj = 'mdl';
	$ord_jrn_ant = 1;
	include("ins_mdl.php");
	if($err_mdl != '') {$err .= $txt->err->mdl->$id_lng.$err_mdl."\n";}
	if($err_jrn != '') {$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";}
	if($err_prs != '') {$err .= $txt->err->prs->$id_lng.$err_prs."\n";}
	if($err_hbr != '') {$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";}
	if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
	if(isset($lst_nvtrf)) {
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom) {$err .= "-> ".$nom."\n";}
	}
}
else{
	$id_dev_mdl = insert("dev_mdl",array("id_crc","ord","col","vue_dbl"),array($id_dev_crc,$ord_mdl,1,1));
	insert("dev_mdl_rgn",array("id_mdl","id_rgn"),array($id_dev_mdl,$id_rgn));
}
echo $id_dev_mdl."|".$err."|".$alt;
?>
