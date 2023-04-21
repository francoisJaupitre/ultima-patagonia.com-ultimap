<?php
if(is_numeric($_POST["id"])){
	include("../prm/fct.php");
	$id = $_POST['id'];
	$dt_sel = ftc_ass(sel_quo("cnf","dev_crc","id",$id));
	if($dt_sel['cnf'] == 2){$upd = 1;}
	else{$upd = '0';}
	upd_quo("dev_crc","cnf",$upd,$id);
}
?>
