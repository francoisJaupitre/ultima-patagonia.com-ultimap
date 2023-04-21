<?php
$id_dev_hbr = $_POST['id_dev_hbr'];
$id_cat_hbr = $_POST['id_cat_hbr'];
$id_cat_chm = $_POST['id_cat_chm'];
$id_hbr_vll = $_POST['id_hbr_vll'];
$id_hbr_rgm = $_POST['id_hbr_rgm'];
$sel = $_POST['sel'];
$res = $_POST['res'];
$dt_res = $_POST['dt_res'];
if($_POST['rva']!='undefined'){$rva = $_POST['rva'];}
else{$rva = "";}
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$alt = $err = $err_hbr = "";
if($id_dev_hbr == 0){$id_dev_prs = $_POST['id_dev_prs'];}
else{
	$dt_dev_hbr = ftc_ass(select("id_prs","dev_hbr","id",$id_dev_hbr));
	$id_dev_prs = $dt_dev_hbr['id_prs'];
}
$dt_dev_prs = ftc_ass(select("id_jrn","dev_prs","id",$id_dev_prs));
$dt_dev_jrn = ftc_ass(select("date,ord,id_mdl","dev_jrn","id",$dt_dev_prs['id_jrn']));
$date = $dt_dev_jrn['date'];
$ord_jrn = $dt_dev_jrn['ord'];
$dt_dev_mdl = ftc_ass(select("id_crc","dev_mdl","id",$dt_dev_jrn['id_mdl']));
$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
$id_crr_crc = $dt_dev_crc['crr'];
$cur = 1;
$id_crr = $id_crr_crc;
include("../fct/clc_crr.php");
if($id_cat_hbr==-2 or ($id_cat_chm==-2 and $id_dev_hbr>0)){
	upd_quo("dev_prs",array("titre","dsc","res"),array("","","-1"),$id_dev_prs);
	upd_quo(
		"dev_hbr",
		array("crr_chm","taux_chm","sup_chm","est_chm","dt_min_chm","dt_max_chm","db_rck_chm","db_net_chm","sg_rck_chm","sg_net_chm","tp_rck_chm","tp_net_chm","qd_rck_chm","qd_net_chm","crr_rgm","taux_rgm","sup_rgm","est_rgm","dt_min_rgm","dt_max_rgm","db_rck_rgm","db_net_rgm","sg_rck_rgm","sg_net_rgm","tp_rck_rgm","tp_net_rgm","qd_rck_rgm","qd_net_rgm"),
		array(1,$taux,$sup,"NULL","0000-00-00","0000-00-00","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL","0000-00-00","0000-00-00","NULL","NULL","NULL","NULL","NULL","NULL","NULL","NULL"),
		$id_dev_hbr
	);
}
elseif($id_dev_hbr==0){$id_dev_hbr = insert("dev_hbr",array("id_prs","id_vll","rgm","crr_chm","taux_chm","sup_chm","sel","res","dt_res","rva"),array($id_dev_prs,$id_hbr_vll,$id_hbr_rgm,1,$taux,$sup,$sel,$res,$dt_res,$rva));}
if($id_cat_hbr < 0){upd_quo("dev_hbr","id_cat",$id_cat_hbr,$id_dev_hbr);}
elseif($id_cat_hbr == 0){upd_quo("dev_hbr","id_cat","NULL",$id_dev_hbr);}
else{
	include("act_hbr.php");
	if($err_hbr != ""){$err = $txt->err->hbr->$id_lng.$err_hbr;}
	if(isset($lst_nvtrf)){
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom){$err .= "-> ".$nom."\n";}
	}
	echo $err."|".$alt;
}
$flg_opt = false;
$rq_opt = select("id,opt","dev_hbr","id_prs",$id_dev_prs);
while($dt_opt = ftc_ass($rq_opt)){
	if($dt_opt['opt']){$flg_opt = true;}
}
if(!$flg_opt){upd_quo("dev_hbr","opt","1",$id_dev_hbr);}
?>
