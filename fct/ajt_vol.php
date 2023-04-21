<?php
include("../prm/fct.php");
$id = insert("dev_vol",array("id_crc","id_v1","id_v2",$_POST['obj']),array($_POST['id_crc'],$_POST['id_v1'],$_POST['id_v2'],$_POST['val']));
echo $id;
?>
