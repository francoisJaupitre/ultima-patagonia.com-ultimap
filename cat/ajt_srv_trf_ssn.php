<?php
include("../prm/fct.php");
$id_srv_trf = $_POST['id_srv_trf'];
$id_srv = $_POST['id_srv'];
$max = ftc_ass(select("MAX(dt_max) AS dt_max,cat_srv_trf_ssn.id","cat_srv_trf_ssn INNER JOIN cat_srv_trf ON cat_srv_trf_ssn.id_trf = cat_srv_trf.id","cat_srv_trf.id_srv",$id_srv));
if(!empty($max['id'])) {
	if($max['dt_max']!='0000-00-00') {
		$date = $max['dt_max'];
		$date = date ('Y-m-d', strtotime ("+1 days $date"));
		}
	else{$date='0000-00-00';}
	insert('cat_srv_trf_ssn',array("id_trf","dt_min"),array($id_srv_trf,$date));
}
else{insert('cat_srv_trf_ssn',"id_trf",$id_srv_trf);}
?>