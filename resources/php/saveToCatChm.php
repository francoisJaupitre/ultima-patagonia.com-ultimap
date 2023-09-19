<?php
$dt_rgm = ftc_ass(sel_quo("id", "cat_hbr_rgm", array("id_hbr", "rgm"), array($id_cat_hbr, $id_rgm)));
if(empty($dt_rgm['id']))
{
	$id_cat_chm = insert("cat_hbr_chm", array("id_hbr", "nom", "rgm"), array($id_cat_hbr, $nom_chm, $id_rgm));
	upd_quo("dev_hbr", array("id_cat_chm", "nom_chm"), array($id_cat_chm, $nom_chm), $id_dev_hbr);
}else{
	$id_cat_chm = insert("cat_hbr_chm", array("id_hbr", "nom", "rgm"), array($id_cat_hbr, $nom_chm, 0));
	upd_quo("dev_hbr", array("id_cat_chm", "nom_chm", "crr_rgm"), array($id_cat_chm, $nom_chm, 1), $id_dev_hbr);
}
?>
