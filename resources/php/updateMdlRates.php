<?php
$rq_dev_jrn = sel_quo("id, date, ord", "dev_jrn", "id_mdl", $id_dev_mdl, "ord");
while($dt_dev_jrn = ftc_ass($rq_dev_jrn))
{
	$id_dev_jrn = $dt_dev_jrn['id'];
	$date = $dt_dev_jrn['date'];
	$ord_jrn = $dt_dev_jrn['ord'];
	include("updateJrnRates.php");
}
?>
