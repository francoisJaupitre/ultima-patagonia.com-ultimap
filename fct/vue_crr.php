<?php
$request = file_get_contents("php://input");
if(!empty($request))
{
  $data = json_decode($request, true);
  $id = $data['id'];
	include("../prm/fct.php");
  include("../cfg/crr.php");
  $dt_crc = ftc_ass(sel_quo("crr", "dev_crc", "id", $id));
}
echo ' '.$prm_crr_nom[$dt_crc['crr']]
?>
