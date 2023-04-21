<?php
$cbl = $_POST['cbl'];
$val = $_POST['val'];
$id = $_POST['id'];
include("../prm/fct.php");
if($cbl=='srv'){upd_var_quo("dev_srv_trf","est",$val,"id_srv",$id);}
elseif($cbl=='hbr'){upd_quo("dev_hbr",array("est_chm","est_rgm"),array($val,$val),$id);}
?>
