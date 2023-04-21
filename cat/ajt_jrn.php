<?php
include("../prm/fct.php");
$id_jrn = $_POST['id_jrn'];
$id_mdl = $_POST['id_mdl'];
$max = ftc_num(select("MAX(ord)","cat_mdl_jrn","id_mdl",$id_mdl));
$ord_jrn = $max[0] + 1;
insert('cat_mdl_jrn',array("id_mdl","id_jrn","ord","opt"),array($id_mdl,$id_jrn,$ord_jrn,1));
?>