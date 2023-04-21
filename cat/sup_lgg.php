<?php
include("../prm/fct.php");
$cbl = $_POST['cbl'];
$id = $_POST['id'];
delete('cat_'.$cbl.'_txt',"id",$id);
?>