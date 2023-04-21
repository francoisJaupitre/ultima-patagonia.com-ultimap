<?php
include("../prm/fct.php");
$dt_jrn = ftc_ass(select("id_mdl,ord","dev_jrn","id",$_POST['id_dev_jrn']));
echo $dt_jrn['id_mdl'].'_'.$dt_jrn['ord'];
?>
