<?php
include("../prm/fct.php");
$obj = $_POST['obj'];
$id = $_POST['id'];
if($obj=='ecr') {
	delete("fin_trs","id_ecr",$id);
	delete("fin_bdg","id_ecr",$id);
}
delete("fin_".$obj,"id",$id);
?>