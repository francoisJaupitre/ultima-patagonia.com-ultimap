<?php
include("../prm/fct.php");
include("../prm/aut.php");
$id_hbr_chm = $_POST['id_hbr_chm'];

$max = ftc_ass(select("MAX(dt_max) AS dt_max,cat_hbr_chm_trf_ssn.id,crr,est","cat_hbr_chm_trf_ssn INNER JOIN cat_hbr_chm_trf ON cat_hbr_chm_trf_ssn.id_trf = cat_hbr_chm_trf.id","cat_hbr_chm_trf.id_chm",$id_hbr_chm));
if(!empty($max['id'])) {
	$id_hbr_chm_trf = insert('cat_hbr_chm_trf',array("id_chm","crr","est",'dt_cat','usr'),array($id_hbr_chm,$max['crr'],$max['est'],date("Y-m-d"),$id_usr));
	$date = $max['dt_max'];
	if($date!='0000-00-00') {$date = date ('Y-m-d', strtotime ("+1 days $date"));}
	else{$date='0000-00-00';}
	insert('cat_hbr_chm_trf_ssn',array("id_trf","dt_min"),array($id_hbr_chm_trf,$date));
}
else{
	$id_hbr_chm_trf = insert('cat_hbr_chm_trf',array("id_chm","crr",'dt_cat','usr'),array($id_hbr_chm,1,date("Y-m-d"),$id_usr));
	insert('cat_hbr_chm_trf_ssn',"id_trf",$id_hbr_chm_trf);
}
?>
