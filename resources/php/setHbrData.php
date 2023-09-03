<?php //MANAGE ACCOMODATION DATAS IN A QUOTATION
$dt_cat_hbr = ftc_ass(sel_quo("*", "cat_hbr", "id", $id_cat_hbr));
upd_quo(
	"dev_hbr",
	array("id_cat", "id_vll", "ctg", "nom", "sel", "res", "dt_res", "rva"),
	array($id_cat_hbr, $dt_cat_hbr['id_vll'], $dt_cat_hbr['ctg'], $dt_cat_hbr['nom'], $sel, $res, $dt_res, $rva),
	$id_dev_hbr
);
if(!empty($dt_cat_hbr['alerte']))
{
	$alt['hbr'.$id_cat_hbr] = $dt_cat_hbr['nom'].' : '.$dt_cat_hbr['alerte'];
}
if($id_cat_chm == '0')
{
	upd_quo("dev_hbr", "id_cat_chm", "NULL", $id_dev_hbr);
}elseif($id_cat_chm > 0)
{
	$dt_cat_hbr_chm = ftc_ass(sel_quo("nom", "cat_hbr_chm", "id", $id_cat_chm));
	upd_quo("dev_hbr", array("id_cat_chm", "nom_chm"), array($id_cat_chm, $dt_cat_hbr_chm['nom']), $id_dev_hbr);
	if($id_cat_chm > 0)
	{
		$id_crr_chm = 1;
		$id_crr_rgm = 0;
		include("updateHbrRates.php");
	}
}else{
	upd_quo("dev_hbr", array("id_cat_chm", "nom_chm", "res"), array($id_cat_chm, "", 0), $id_dev_hbr);
}
if($dt_cat_hbr['nvtrf'] and (!isset($lst_nvtrf) or !in_array($dt_cat_hbr['nom'], $lst_nvtrf)))
{
	$lst_nvtrf[] = $dt_cat_hbr['nom'];
}
?>
