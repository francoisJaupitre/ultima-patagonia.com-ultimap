<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_hbr_chm_trf_ssn']) and $data['id_hbr_chm_trf_ssn'] > 0)
{
	include("../../prm/fct.php");
  delete('cat_hbr_chm_trf_ssn', "id", $data['id_hbr_chm_trf_ssn']);
}
?>
