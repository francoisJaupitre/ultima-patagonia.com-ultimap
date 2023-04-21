<?php
include("../prm/fct.php");
$id_hbr_chm_trf = $_POST['id_hbr_chm_trf'];
$id_hbr_chm  = $_POST['id_hbr_chm'];
$max = ftc_ass(select("MAX(dt_max) AS dt_max,cat_hbr_chm_trf_ssn.id","cat_hbr_chm_trf_ssn INNER JOIN cat_hbr_chm_trf ON cat_hbr_chm_trf_ssn.id_trf = cat_hbr_chm_trf.id","cat_hbr_chm_trf.id_chm",$id_hbr_chm));
if(!empty($max['id'])) {
	$date = $max['dt_max'];
	if($date!='0000-00-00') {$date = date ('Y-m-d', strtotime ("+1 days $date"));}
	else{$date='0000-00-00';}
	insert('cat_hbr_chm_trf_ssn',array("id_trf","dt_min"),array($id_hbr_chm_trf,$date));
}
else{insert('cat_hbr_chm_trf_ssn',"id_trf",$id_hbr_chm_trf);}
?>