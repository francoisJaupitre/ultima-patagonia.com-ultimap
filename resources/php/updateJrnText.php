<?php //GET DAY TEXTS FROM CATALOG TO QUOTATION
if($id_cat_jrn > 0)
{
	$dt_cat_jrn = ftc_ass(sel_quo(
		'nom, titre, dsc, id_pic',
		'cat_jrn
			LEFT JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn AND lgg = '.$id_lgg.'
			LEFT JOIN cat_jrn_pic ON cat_jrn.id = cat_jrn_pic.id_jrn',
		'cat_jrn.id',
		$id_cat_jrn
	));
	if(empty($dt_cat_jrn['titre']))
	{
		unset($dt_cat_jrn['titre']);
		$err_jrn .= $dt_cat_jrn['nom']."\n";
	}
	if(empty($dt_cat_jrn['dsc']))
	{
		unset($dt_cat_jrn['dsc']);
	}
	if($dt_cat_jrn['id_pic'] == 0)
	{
		unset($dt_cat_jrn['id_pic']);
	}
	upd_quo('dev_jrn', array_keys($dt_cat_jrn), array_values($dt_cat_jrn), $id_dev_jrn);
}
$rq_dev_prs = sel_quo('id, id_cat, nom', 'dev_prs', 'id_jrn', $id_dev_jrn);
while($dt_dev_prs = ftc_ass($rq_dev_prs))
{
	$id_dev_prs = $dt_dev_prs['id'];
	$id_cat_prs = $dt_dev_prs['id_cat'];
	include("updatePrsText.php");
}
?>
