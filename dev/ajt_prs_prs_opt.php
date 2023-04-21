<?php
include("../prm/fct.php");
$dt_prs = ftc_ass(select("id_jrn,ord","dev_prs","id",$_POST['id_dev_prs']));
echo $dt_prs['id_jrn'].'_'.$dt_prs['ord'];
?>