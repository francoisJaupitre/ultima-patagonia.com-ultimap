<?php
include("../prm/fct.php");
$id_prs_srv = $_POST['id_prs_srv'];
delete('cat_prs_srv',"id",$id_prs_srv);
?>