<?php
include("../prm/fct.php");
$id_grp = $_POST['id_grp'];
$dt_pax = ftc_ass(sel_quo("MAX(ord) AS ord","grp_pax","id_grp",$id_grp));
$ord = $dt_pax['ord']+1;
insert("grp_pax",array("id_grp","ord"),array($id_grp,$ord));
?>