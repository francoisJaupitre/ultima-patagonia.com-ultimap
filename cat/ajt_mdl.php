<?php
include("../prm/fct.php");
$id_mdl = $_POST['id_mdl'];
$id_crc = $_POST['id_crc'];
$max = ftc_num(select("MAX(ord)","cat_crc_mdl","id_crc",$id_crc));
$ord_mdl = $max[0] + 1;
insert('cat_crc_mdl',array("id_crc","id_mdl","ord"),array($id_crc,$id_mdl,$ord_mdl));
?>