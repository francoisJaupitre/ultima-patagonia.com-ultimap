<?php
upd_quo('dev_mdl','id_cat',"0",$id_dev_mdl);
$dt_mdl = ftc_ass(select("id_crc","dev_mdl","id",$id_dev_mdl));
$id_dev_crc = $dt_mdl['id_crc'];
include("sup_cat_crc.php");
?>
