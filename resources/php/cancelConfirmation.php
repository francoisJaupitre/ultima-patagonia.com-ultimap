<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data["id"]))
{
	include("../../prm/fct.php");
	upd_quo("dev_crc","cnf","0",$data["id"]);
}
?>
