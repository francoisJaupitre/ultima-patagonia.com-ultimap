<?php
$rq_dev_jrn = select("id,date,ord","dev_jrn","id_mdl",$id_dev_mdl,"ord");
while($dt_dev_jrn = ftc_ass($rq_dev_jrn)){
	$id_dev_jrn = $dt_dev_jrn['id'];
	$date = $dt_dev_jrn['date'];
	$ord_jrn = $dt_dev_jrn['ord'];
	include("act_trf_jrn.php");
}
?>