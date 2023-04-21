<?php
upd_quo('dev_srv','id_cat',"0",$id_dev_srv);
$dt_srv = ftc_ass(select("id_prs","dev_srv","id",$id_dev_srv));
$id_dev_prs = $dt_srv['id_prs'];
include("sup_cat_prs.php");
?>
