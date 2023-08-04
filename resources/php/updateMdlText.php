<?php
if($id_cat_mdl != 0)
{
	$dt_cat_mdl = ftc_ass(sel_quo('nom,titre,dsc','cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl', array('lgg', 'cat_mdl.id'), array($id_lgg ,$id_cat_mdl)));
	if(empty($dt_cat_mdl['nom']))
	{
		$err_mdl .= $ord_mdl.",\n";
	}
	if(!isset($dt_cat_mdl['titre']))
	{
		$dt_cat_mdl['titre']=='';
	}
	if(!isset($dt_cat_mdl['dsc']))
	{
		$dt_cat_mdl['dsc']=='';
	}
	upd_quo('dev_mdl', array_keys($dt_cat_mdl), array_values($dt_cat_mdl), $id_dev_mdl);
}
$rq_dev_jrn = sel_quo('id, id_cat, nom', 'dev_jrn', 'id_mdl', $id_dev_mdl);
while($dt_dev_jrn = ftc_ass($rq_dev_jrn))
{
	$id_dev_jrn = $dt_dev_jrn['id'];
	$id_cat_jrn = $dt_dev_jrn['id_cat'];
	include("updateJrnText.php");
}
?>
