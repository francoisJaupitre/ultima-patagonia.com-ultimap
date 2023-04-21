<?php
$cbl = 'mdl';
$dt_clt = ftc_ass(sel_quo("id_ctg,crr","cat_clt","id",1)); //clients directs
$id_ctg_clt = $dt_clt['id_ctg'];
$id_crr_clt = $dt_clt['crr'];
$hbr_def = 1; //hôtels standards si non défini
$base = 2;
unset($hbr_dup);
include("../cfg/crr.php");
include("../cfg/ctg_clt.php");
include("../fct/trf.php");
if(isset($trf_srv[$id_trf]) and isset($trf_db_hbr[$id_trf])) {$prx = $trf_srv[$id_trf][$i]+$trf_db_hbr[$id_trf]/2;}
elseif(isset($trf_srv[$id_trf][$i])) {$prx = $trf_srv[$id_trf][$i];}
elseif(isset($trf_db_hbr[$id_trf])) {$prx = $trf_db_hbr[$id_trf]/2;}
else{$prx = 0;}
if(isset($trf_db_hbr)) {unset($trf_db_hbr[$id_trf]);}
unset($trf_srv[$id_trf][$i]);
?>
