<?php //GET SERVICE TEXTS FROM CATALOG TO QUOTATION
if($id_cat_srv > 0)
{
	$dt_cat_srv = ftc_ass(sel_quo('id_vll, ctg, lgg, nom', 'cat_srv', 'id', $id_cat_srv));
	upd_quo('dev_srv', array_keys($dt_cat_srv), array_values($dt_cat_srv), $id_dev_srv);
}
?>
