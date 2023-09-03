<?php //CREATE A NEW GROUP IN QUOTATION GROUP SELECT LIST
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['nom']) and !empty($data['nom']) isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0 and isset($data['id_clt']) and $data['id_clt'] > 0)
{
  include("functions.php");
  $id_grp = insert("grp_dev", array("id_clt", "nomgrp", "usr"), array($data['id_clt'], $data['nom'], $id_usr));
  upd_quo("dev_crc", "id_grp", $id_grp, $data['id_dev_crc']);
}
?>
