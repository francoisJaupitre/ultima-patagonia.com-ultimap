<?php
include("../prm/fct.php");
$id_prs_hbr = $_POST['id_prs_hbr'];
delete('cat_prs_hbr',"id",$id_prs_hbr);
?>
