<?
$id_grp = $_POST['id_grp'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/clt.php");
include("../cfg/lng.php");
$dt_grp = ftc_ass(sel_quo("nomgrp,id_clt","grp_dev","id",$id_grp));
$grp = $dt_grp['nomgrp'];
$clt_grp = $dt_grp['id_clt'];
$nom_tab = $txt->grp->$id_lng.': ';
if(!empty($grp)){$nom_tab .= $grp;}
else{$nom_tab .= $clt[$clt_grp];}
$nb_pax = ftc_ass(sel_quo("COUNT(*) as total","grp_pax",array("id_grp","prt"),array($id_grp,1)));
if($nb_pax['total']>0){$nom_tab .= ' x'.$nb_pax['total'];}
echo mb_substr(stripslashes($nom_tab),0,30,'UTF-8');
if(mb_strlen($nom_tab,'UTF-8')>30){echo '...';}
?>
