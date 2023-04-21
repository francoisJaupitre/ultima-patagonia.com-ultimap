<?php
include("../prm/fct.php");
$obj = $_POST['obj'];
if($obj == 'crc'){
	$id_dev_crc = $_POST['id'];
	include("sup_cat_crc.php");
}
elseif($obj == 'mdl'){
	$id_dev_mdl = $_POST['id'];
	include("sup_cat_mdl.php");
}
elseif($obj == 'jrn'){
	$id_dev_jrn = $_POST['id'];
	include("sup_cat_jrn.php");
}
elseif($obj == 'prs'){
	$id_dev_prs = $_POST['id'];
	include("sup_cat_prs.php");
}
elseif($obj == 'srv'){
	$id_dev_srv = $_POST['id'];
	include("sup_cat_srv.php");
}
elseif($obj == 'hbr'){
	$id_dev_hbr = $_POST['id'];
	include("sup_cat_hbr.php");
}
?>
