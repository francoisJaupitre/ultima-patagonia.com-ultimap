<?php
if($id_cat_hbr>0)
{
	$dt_cat_hbr = ftc_ass(sel_quo('id_vll, ctg, nom','cat_hbr', 'id', $id_cat_hbr));
	upd_quo('dev_hbr', array_keys($dt_cat_hbr), array_values($dt_cat_hbr), $id_dev_hbr);
}
if($id_cat_chm>0)
{
	$dt_cat_chm = ftc_ass(sel_quo('*', 'cat_hbr_chm', 'id', $id_cat_chm));
	upd_quo('dev_hbr', 'nom_chm', $dt_cat_chm['nom'], $id_dev_hbr);
}
?>
