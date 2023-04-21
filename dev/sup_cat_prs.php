<?php
upd_quo('dev_prs','id_cat',"0",$id_dev_prs);
$dt_prs = ftc_ass(select("id_jrn","dev_prs","id",$id_dev_prs));
$id_dev_jrn = $dt_prs['id_jrn'];
include("sup_cat_jrn.php");
?>
