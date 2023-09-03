<?php //DELETE AN ACCOMODATION REGIME IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_hbr_rgm']) and $data['id_hbr_rgm'] > 0)
{
	include("functions.php");
	$rq_sel_trf = sel_quo('id', 'cat_hbr_rgm_trf', 'id_rgm', $data['id_hbr_rgm']);
	while($dt_sel_trf = ftc_ass($rq_sel_trf))
	{
		delete('cat_hbr_rgm_trf', 'id', $dt_sel_trf['id']);
		delete('cat_hbr_rgm_trf_ssn', 'id_trf', $dt_sel_trf['id']);
	}
	$dt_hbr = ftc_ass(sel_quo("id_hbr", "cat_hbr_rgm", "id", $data['id_hbr_rgm']));
	delete('cat_hbr_rgm', 'id', $data['id_hbr_rgm']);
	$rq_chm = sel_quo("id", "cat_hbr_chm", "id_hbr", $dt_hbr['id_hbr']);
	while($dt_chm = ftc_ass($rq_chm))
	{
		echo $dt_chm['id'].'|';
	}
}
?>
