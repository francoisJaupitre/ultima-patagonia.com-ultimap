<?php
include("../prm/fct.php");
$obj = $_POST['obj'];
$id = $_POST['id'];
if($obj=='fac'){
	delete("cmp_itm","id_fac",$id);
}
delete("cmp_".$obj,"id",$id);
?>