<?php //DELETE AN ACCOMODATION REGIME RATE SEASON IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_hbr_rgm_trf_ssn']) and $data['id_hbr_rgm_trf_ssn'] > 0)
{
	include("functions.php");
  delete('cat_hbr_rgm_trf_ssn', 'id', $data['id_hbr_rgm_trf_ssn']);
}
?>
