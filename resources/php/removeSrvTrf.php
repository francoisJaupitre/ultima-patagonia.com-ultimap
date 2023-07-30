<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_srv_trf']) and $data['id_srv_trf'] > 0)
{
	include("../../prm/fct.php");
  delete('cat_srv_trf', "id", $data['id_srv_trf']);
  delete('cat_srv_trf_ssn', "id_trf", $data['id_srv_trf']);
  delete('cat_srv_trf_bss', "id_trf", $data['id_srv_trf']);
}
?>
