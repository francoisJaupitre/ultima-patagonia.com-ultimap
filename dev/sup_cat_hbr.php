<?php
upd_quo('dev_hbr',array('id_cat','id_cat_chm'),array("0","0"),$id_dev_hbr);
$dt_hbr = ftc_ass(select("id_prs","dev_hbr","id",$id_dev_hbr));
$id_dev_prs = $dt_hbr['id_prs'];
include("sup_cat_prs.php");
?>
