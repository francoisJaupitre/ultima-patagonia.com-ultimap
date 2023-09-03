<?php //MANAGE SERVICE DATAS IN A QUOTATION
$dt_srv = ftc_ass(sel_quo("*", "cat_srv", "id", $id_cat_srv));
if($dt_srv['res'] == 1)
{
	$resrv = 0;
}else{
	$resrv = 6;
}
$cur = $id_crr_srv = 1;
$id_crr = $id_crr_crc;
include("calculateCrrRates.php");
$id_dev_srv = insert(
	"dev_srv",
	array("id_prs", "id_cat", "id_vll", "ctg", "lgg", "crr", "taux", "sup", "nom", "opt", "res"),
	array($id_dev_prs, $id_cat_srv, $dt_srv['id_vll'], $dt_srv['ctg'], $dt_srv['lgg'], 1, $taux, $sup, $dt_srv['nom'], $opt_srv, $resrv)
);
if(!empty($dt_srv['alerte']))
{
	$alt['srv'.$id_cat_srv] = $dt_srv['nom'].' : '.$dt_srv['alerte'];
}
$bss = array();
$err_bss = '';
$dt_min = $dt_max = '0000-00-00';
$dt_dev_mdl = ftc_ass(sel_quo("id_crc, trf, ptl", "dev_mdl", "id", $id_dev_mdl));
$dt_dev_crc = ftc_ass(sel_quo("ptl, crr", "dev_crc", "id", $dt_dev_mdl['id_crc']));
$id_crr_crc = $dt_dev_crc['crr'];
if($dt_dev_mdl['trf'])
{
	$rq_bss = sel_quo("id, base", "dev_mdl_bss", "id_mdl", $id_dev_mdl, "base");
	$ptl = $dt_dev_mdl['ptl'];
}else{
	$rq_bss = sel_quo("id, base", "dev_crc_bss", "id_crc", $dt_dev_mdl['id_crc'], "base");
	$ptl = $dt_dev_crc['ptl'];
}
if(!is_null($rq_bss) and num_rows($rq_bss) > 0)
{
	while($dt_bss = ftc_ass($rq_bss))
	{
		$bss[$dt_bss['id']] = $dt_bss['base'];
	}
	if($date != '0000-00-00')
	{
		$dt_trf1 = ftc_all(sel_quo(
			"*",
			"cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf",
			"id_srv",
			$id_cat_srv)
		);
	}
	$dt_trf2 = ftc_all(sel_quo(
		"*",
		"cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf",
		array("def", "id_srv"),
		array(1, $id_cat_srv),
		"dt_max DESC")
	);
	foreach($bss as $id_bss => $base)
	{
		$id_dev_trf = insert("dev_srv_trf", array("id_srv", "base"), array($id_dev_srv, $base));
		include("updateSrvRates.php");
	}
	if($flg_trf)
	{
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		upd_quo(
			"dev_srv",
			array("crr", "taux", "sup", 'dt_min', 'dt_max', 'id_frn'),
			array($cur, $taux, $sup, $dt_min, $dt_max, $dt_trf['id_frn']),
			$id_dev_srv
		);
	}else{
		upd_quo(
			'dev_srv',
			array('dt_min', 'dt_max', 'id_frn'),
			array($dt_min, $dt_max, $dt_trf['id_frn']),
			$id_dev_srv
		);
	}
	if($err_bss != '')
	{
		$dt = ftc_ass(sel_quo("nom", "dev_srv", "id", $id_dev_srv));
		$err_srv .= $dt['nom'].', '.$txt->bss->$id_lng.' : '.$err_bss."\n";
	}
}
?>
