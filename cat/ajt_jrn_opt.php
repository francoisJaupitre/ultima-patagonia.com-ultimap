<?php
include("../prm/fct.php");
$id_jrn = $_POST['id_jrn'];
$id_mdl = $_POST['id_mdl'];
$ord_jrn = $_POST['ord'];
if($ord_jrn == 0) {
  $max_jrn = ftc_num(select("MAX(ord)","cat_mdl_jrn","id_mdl",$id_mdl));
  $ord_jrn = $max_jrn[0];
}
insert('cat_mdl_jrn',array("id_mdl","id_jrn","ord","opt"),array($id_mdl,$id_jrn,$ord_jrn,0));
?>
