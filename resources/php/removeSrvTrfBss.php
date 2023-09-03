<?php //DELETE A SERVICE RATE BASIS IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_srv_trf_bss']) and $data['id_srv_trf_bss'] > 0)
{
	include("functions.php");
  delete('cat_srv_trf_bss', "id", $data['id_srv_trf_bss']);
}
?>
