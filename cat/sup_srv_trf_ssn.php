<?php
include("../prm/fct.php");
$rq_srv_trf = select("id","cat_srv_trf_ssn","id_trf",$_POST['id_srv_trf']);
if(num_rows($rq_srv_trf)>1) {
	$dt_ssn = ftc_ass(select("id","cat_srv_trf_ssn","dt_min = (SELECT MIN(dt_min) FROM cat_srv_trf_ssn WHERE id_trf=".$_POST['id_srv_trf'].") AND id_trf",$_POST['id_srv_trf']));
	if($dt_ssn['id']==$_POST['id_srv_trf_ssn']) {echo 0;}
	else{echo 1;}
	delete('cat_srv_trf_ssn',"id",$_POST['id_srv_trf_ssn']);
}
else{
	delete('cat_srv_trf_ssn',"id",$_POST['id_srv_trf_ssn']);
	echo 0;
}
?>