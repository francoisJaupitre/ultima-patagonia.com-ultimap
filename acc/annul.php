<?php
if(is_numeric($_POST["id"])) {
	include("../prm/fct.php");
	upd_quo("dev_crc","cnf","0",$_POST["id"]);
}
?>
