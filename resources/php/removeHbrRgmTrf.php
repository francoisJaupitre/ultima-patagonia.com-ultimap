<?php //DELETE AN ACCOMODATION REGIME RATE IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_hbr_rgm_trf']) and $data['id_hbr_rgm_trf'] > 0)
{
	include("functions.php");
  delete('cat_hbr_rgm_trf', 'id', $data['id_hbr_rgm_trf']);
  delete('cat_hbr_rgm_trf_ssn', 'id_trf', $data['id_hbr_rgm_trf']);
}
?>
