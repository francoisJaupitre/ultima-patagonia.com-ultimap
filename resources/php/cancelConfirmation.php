<?php //UNDO CONFIRMATION STATE IN A QUOTATION
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data["id"]) and $data["id"] > 0)
{
	include("functions.php");
	upd_quo("dev_crc", "cnf", "0", $data["id"]);
}
?>
