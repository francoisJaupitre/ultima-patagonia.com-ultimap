<?php
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
$obj = $_POST['obj'];
$id_lgg = $_POST['lgg'];
if($obj=='crc'){
	$id_dev_crc = $_POST['id'];
	$nom_crc = $_POST['nom'];
	$dt_sel_crc = ftc_ass(select("titre, dsc","dev_crc","id",$id_dev_crc));
	include("grd_crc.php");
	echo $id_cat_crc;
}
elseif($obj=='mdl'){
	$id_dev_mdl = $_POST['id'];
	$nom_mdl = $_POST['nom'];
	$dt_sel_mdl = ftc_ass(select("titre, dsc","dev_mdl","id",$id_dev_mdl));
	include("grd_mdl.php");
	echo $id_cat_mdl;
}
elseif($obj=='jrn'){
	$id_dev_jrn = $_POST['id'];
	$nom_jrn = $_POST['nom'];
	$dt_sel_jrn = ftc_ass(select("titre,dsc","dev_jrn","id",$id_dev_jrn));
	include("grd_jrn.php");
	echo $id_cat_jrn;
}
elseif($obj=='prs'){
	$id_dev_prs = $_POST['id'];
	$nom_prs = $_POST['nom'];
	$dt_sel_prs = ftc_ass(select("ctg,titre,dsc","dev_prs","id",$id_dev_prs));
	include("grd_prs.php");
	echo $id_cat_prs;
}
elseif($obj=='srv'){
	$id_dev_srv = $_POST['id'];
	$nom_srv = $_POST['nom'];
	if($id_dev_srv>0){
		$dt_srv = ftc_ass(select("id_vll,ctg,lgg","dev_srv","id",$id_dev_srv));
		$id_vll = $dt_srv['id_vll'];
		$ctg = $dt_srv['ctg'];
		$lgg_ctg = $dt_srv['lgg'];
	}
	else{
		$id_vll = $_POST['id_vll'];
		$ctg = $_POST['ctg'];
		$lgg_ctg = 0;
	}
	include("grd_srv.php");
	echo $id_cat_srv;
}
elseif($obj=='hbr'){
	$id_dev_hbr = $_POST['id'];
	$nom_hbr = $_POST['nom'];
	$nom_chm = $_POST['nom_chm'];
	if(empty($nom_chm)){$nom_chm='Standard';}
	$dt_sel_hbr = ftc_ass(select("id_vll,rgm","dev_hbr","id",$id_dev_hbr));
	$id_rgm = $dt_sel_hbr['rgm'];
	include("grd_hbr.php");
	echo $id_cat_hbr;
}
elseif($obj=='chm'){
	$id_dev_hbr = $_POST['id'];
	$nom_chm = $_POST['nom'];
	$id_cat_hbr = $_POST['id_cat_hbr'];
	$dt_sel_hbr = ftc_ass(select("rgm","dev_hbr","id",$id_dev_hbr));
	$id_rgm = $dt_sel_hbr['rgm'];
	include("grd_chm.php");
	echo 1;
}
?>
