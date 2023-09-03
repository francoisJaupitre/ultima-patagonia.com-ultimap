<?php //GET DAY RATES FROM CATALOG
$rq_dev_prs = sel_quo('id, id_cat', 'dev_prs', 'id_jrn', $id_dev_jrn);
while($dt_dev_prs = ftc_ass($rq_dev_prs))
{
	$id_dev_prs = $dt_dev_prs['id'];
	include("updatePrsRates.php");
}
?>
