<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['cbl']) and isset($data['id']) and $data['id'] > 0)
{
	include("../../prm/fct.php");
  delete('cat_'.$data['cbl'].'_txt', "id", $data['id']);
}
?>
