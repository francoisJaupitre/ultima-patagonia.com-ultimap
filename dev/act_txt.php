<?php
$obj = $_POST['obj'];
$id_lgg = $_POST['lgg'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/lng.php");
$err_crc = '';
$err_mdl = '';
$err_jrn = '';
$err_prs = '';
if($obj == 'crc'){
	$id_dev_crc = $_POST['id'];
	$dt_dev_crc = ftc_ass(select('id_cat,nom','dev_crc','id',$id_dev_crc));
	$id_cat_crc = $dt_dev_crc['id_cat'];
	include("act_txt_crc.php");
}
if($obj == 'mdl'){
	$id_dev_mdl = $_POST['id'];
	$dt_dev_mdl = ftc_ass(select('id_cat,nom,ord','dev_mdl','id',$id_dev_mdl));
	$id_cat_mdl = $dt_dev_mdl['id_cat'];
	$ord_mdl = $dt_dev_mdl['ord'];
	include("act_txt_mdl.php");
}
elseif($obj == 'jrn'){
	$id_dev_jrn = $_POST['id'];
	$dt_dev_jrn = ftc_ass(select('id_cat,nom','dev_jrn','id',$id_dev_jrn));
	$id_cat_jrn = $dt_dev_jrn['id_cat'];
	include("act_txt_jrn.php");
}
elseif($obj == 'prs'){
	$id_dev_prs = $_POST['id'];
	$dt_dev_prs = ftc_ass(select('id_cat,nom','dev_prs','id',$id_dev_prs));
	$id_cat_prs = $dt_dev_prs['id_cat'];
	include("act_txt_prs.php");
}
elseif($obj == 'srv'){
	$id_dev_srv = $_POST['id'];
	$dt_dev_srv = ftc_ass(select('id_cat','dev_srv','id',$id_dev_srv));
	$id_cat_srv = $dt_dev_srv['id_cat'];
	include("act_txt_srv.php");
}
elseif($obj == 'hbr'){
	$id_dev_hbr = $_POST['id'];
	$dt_dev_hbr = ftc_ass(select('id_cat,id_cat_chm','dev_hbr','id',$id_dev_hbr));
	$id_cat_hbr = $dt_dev_hbr['id_cat'];
	$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
	include("act_txt_hbr.php");
}
$err = '';
if($err_crc != ''){$err .= $txt->err->crc->$id_lng.$err_crc."\n";}
if($err_mdl != ''){$err .= $txt->err->mdl->$id_lng.$err_mdl."\n";}
if($err_jrn != ''){$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";}
if($err_prs != ''){$err .= $txt->err->prs->$id_lng.$err_prs;}
if($err != ''){echo $err;}
else{echo 1;}
?>
