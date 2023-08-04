<?php
if($id_cat_jrn>0)
{
	$dt_cat_jrn = ftc_ass(sel_quo('nom, titre, dsc','cat_jrn INNER JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn',array('lgg', 'cat_jrn.id'), array($id_lgg, $id_cat_jrn)));
	if(empty($dt_cat_jrn['nom']))
	{
		unset($dt_cat_jrn['nom']);
	}
	if(empty($dt_cat_jrn['titre']))
	{
		unset($dt_cat_jrn['titre']);
		$err_jrn .= $dt_dev_jrn['nom'].",\n";
	}
	if(empty($dt_cat_jrn['dsc']))
	{
		unset($dt_cat_jrn['dsc']);
	}
	if(!empty($dt_cat_jrn))
	{
		upd_quo('dev_jrn', array_keys($dt_cat_jrn), array_values($dt_cat_jrn), $id_dev_jrn);
	}
}
$rq_dev_prs = sel_quo('id, id_cat, nom', 'dev_prs', 'id_jrn', $id_dev_jrn);
while($dt_dev_prs = ftc_ass($rq_dev_prs))
{
	$id_dev_prs = $dt_dev_prs['id'];
	$id_cat_prs = $dt_dev_prs['id_cat'];
	include("updatePrsText.php");
}
?>
