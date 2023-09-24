<?php //MANAGE PRESTATION DATAS IN A QUOTATION
$dt_prs = ftc_ass(sel_quo(
	"ctg, nom, titre, dsc, alerte",
	"cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg = ".$id_lgg,
	"cat_prs.id",
	$id_cat_prs
));
$id_dev_prs = insert(
	"dev_prs",
	array("id_jrn", "id_cat", "id_rmn", "ctg", "nom", "titre", "dsc", "ord", "opt"),
	array($id_dev_jrn, $id_cat_prs, $id_rmn, $dt_prs['ctg'], $dt_prs['nom'], $dt_prs['titre'], $dt_prs['dsc'], $ord_prs, $opt_prs)
);
if(empty($dt_prs['titre']))
{
	$err_prs .= $dt_prs['nom']."\n";
}
if(!empty($dt_prs['alerte']))
{
	$alt['prs'.$id_cat_hbr] = $dt_prs['nom'].' : '.$dt_prs['alerte'];
}
$rq_prs_srv = sel_quo("*", "cat_prs_srv", "id_prs", $id_cat_prs);
while($dt_prs_srv = ftc_ass($rq_prs_srv))
{
	$id_cat_srv = $dt_prs_srv['id_srv'];
	$opt_srv = $dt_prs_srv['opt'];
	include("setSrvData.php");
}
$rq_prs_hbr = sel_quo("*", "cat_prs_hbr", "id_prs", $id_cat_prs, "opt DESC");
while($dt_prs_hbr = ftc_ass($rq_prs_hbr))
{
	$id_cat_hbr = $dt_prs_hbr['id_hbr'];
	$id_hbr_rgm = $dt_prs_hbr['rgm'];
	$cur = 1;
	$id_crr = $id_crr_crc;
	include("calculateCrrRates.php");
	$id_dev_hbr = insert(
		"dev_hbr",
		array("id_prs", "id_cat", "id_vll", "opt", "rgm", "crr_chm", "taux_chm", "sup_chm"),
		array($id_dev_prs, $id_cat_hbr, $dt_prs_hbr['id_vll'], $dt_prs_hbr['opt'], $id_hbr_rgm, 1, $taux, $sup)
	);
	if($id_cat_hbr != -1)
	{
		$id_cat_chm = $dt_prs_hbr['id_chm'];
		$sel = $res = 0;
		$dt_res = '0000-00-00';
		$rva = '';
		include("setHbrData.php");
	}
	$flg_opt = false;
	$rq_opt = sel_quo("id", "dev_hbr", array("id_prs", "opt"), array($id_dev_prs, 1));
	if(num_rows($rq_opt) == 0)
	{
		upd_quo("dev_hbr", "opt", "1", $id_dev_hbr);
	}
}
?>
