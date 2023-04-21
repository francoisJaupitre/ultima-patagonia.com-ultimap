<?php
include("../prm/fct.php");
$id_hbr = $_POST['id_hbr'];
$id_prs = $_POST['id_prs'];
$id_chm = $_POST['id_chm'];
$id_rgm = $_POST['id_rgm'];
$id_vll = $_POST['id_vll'];
insert("cat_prs_hbr",array("id_prs","id_hbr","id_vll","id_chm","rgm"),array($id_prs,$id_hbr,$id_vll,$id_chm,$id_rgm));
?>