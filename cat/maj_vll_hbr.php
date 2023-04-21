<?php
include("../prm/fct.php");
$id_vll = $_POST["id_vll"];
$id_rgm = $_POST["id_rgm"];
$id_hbr_def = $_POST["hbr_def"];
$id_hbr = $_POST["id_hbr"];
$id_chm = $_POST["id_chm"];
$dt_vll_hbr = ftc_ass(select("id","cat_vll_hbr","id_vll=".$id_vll." AND hbr_def=".$id_hbr_def." AND rgm",$id_rgm));
if(empty($dt_vll_hbr['id'])) {insert("cat_vll_hbr",array("id_vll","rgm","hbr_def","id_hbr","id_chm"),array($id_vll,$id_rgm,$id_hbr_def,$id_hbr,$id_chm));}
else{upd_quo("cat_vll_hbr",array("id_hbr","id_chm"),array($id_hbr,$id_chm),$dt_vll_hbr['id']);}
?>
