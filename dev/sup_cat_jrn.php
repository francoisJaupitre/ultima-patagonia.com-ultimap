<?php
upd_quo('dev_jrn','id_cat',"0",$id_dev_jrn);
$dt_jrn = ftc_ass(select("id_mdl","dev_jrn","id",$id_dev_jrn));
$id_dev_mdl = $dt_jrn['id_mdl'];
include("sup_cat_mdl.php");
?>
