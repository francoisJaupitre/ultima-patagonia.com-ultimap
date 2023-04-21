<?php
include("../prm/fct.php");
include("../prm/aut.php");
$cbl = $_POST['cbl'];
$id = $_POST['id'];
$id_lgg = $_POST['id_lgg'];
$id_txt = insert('cat_'.$cbl.'_txt',array("id_".$cbl,"lgg"),array($id,$id_lgg));
if($cbl=='crc' or $cbl=='mdl' or $cbl=='jrn' or $cbl=='prs' or $cbl=='vll') {upd_quo('cat_'.$cbl.'_txt',array("dt_txt","usr"),array(date("Y-m-d H:i:s"),$id_usr),$id_txt);}
?>
