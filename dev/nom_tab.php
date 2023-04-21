<?php
$id_dev_crc = $_POST['id_dev_crc'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/clt.php");
include("../cfg/lng.php");
$dt_crc = ftc_ass(select("cnf,groupe,version,titre,id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
$cnf = $dt_crc['cnf'];
$grp = $dt_crc['groupe'];
$vrs = $dt_crc['version'];
$ttr_crc = $dt_crc['titre'];
$clt_crc = $dt_crc['id_clt'];
if($cnf>0){$nom_tab = $txt->cnf->$id_lng.': ';}
else{$nom_tab = $txt->dev->$id_lng.': ';}
if(!empty($grp)){$nom_tab .= $grp;}
elseif(!empty($ttr_crc)){$nom_tab .= $ttr_crc;}
else{$nom_tab .= $clt[$clt_crc];}
$nom_tab .= ' V'.$vrs;
echo mb_substr(stripslashes($nom_tab),0,30,'UTF-8');
if(mb_strlen($nom_tab,'UTF-8')>30){echo '...';}
?>