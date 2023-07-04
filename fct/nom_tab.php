<?php
$id = $_POST['id'];
$obj = $_POST['obj'];
$cbl = $_POST['cbl'];
$txt = simplexml_load_file('../resources/xml/mainTxt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/clt.php");
include("../cfg/lng.php");
if($cbl=='dev'){
	$dt_crc = ftc_ass(sel_quo("groupe,version,titre,id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id));
	$nom = $dt_crc['groupe'];
	$vrs = $dt_crc['version'];
	$ttr_crc = $dt_crc['titre'];
	$clt_crc = $dt_crc['id_clt'];
}
elseif($cbl=='crc' or $cbl=='mdl'){
	$dt = ftc_ass(sel_quo("nom","cat_".$cbl,"id",$id));
	$nom = $dt['nom'];
}
if($obj=='trf'){$nom_tab = $txt->trf->trf->$id_lng.': ';}
elseif($obj=='prg'){$nom_tab = $txt->prg->prg->$id_lng.': ';}
elseif($obj=='rbk'){$nom_tab = $txt->prg->rbk->$id_lng.': ';}
if(!empty($nom)){$nom_tab .= $nom;}
elseif(!empty($ttr_crc)){$nom_tab .= $ttr_crc;}
else{$nom_tab .= $clt[$clt_crc];}
if(!empty($vrs)){$nom_tab .= ' V'.$vrs;}
echo mb_substr(stripslashes($nom_tab),0,30,'UTF-8');
if(mb_strlen($nom_tab,'UTF-8')>30){echo '...';}
?>
