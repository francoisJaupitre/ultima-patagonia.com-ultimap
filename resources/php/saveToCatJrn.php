<?php
$rq_jrn = sel_whe(
	"dev_prs.id_cat AS id_cat_prs, dev_prs.id_cat",
	"dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",
	"id_jrn = ".$id_dev_jrn." GROUP BY id_cat_prs HAVING COUNT(dev_prs.id_cat) > 1");
if(num_rows($rq_jrn) > 0)
{
	$id_cat_jrn = 0;
}else{
	$id_cat_jrn = insert('cat_jrn', array('nom', 'dt_cat', 'usr'), array($nom_jrn, date("Y-m-d"), $id_usr));
	insert(
		"cat_jrn_txt",
		array("id_jrn", "lgg", "titre", "dsc"),
		array($id_cat_jrn, $id_lgg, $dt_sel_jrn['titre'], $dt_sel_jrn['dsc'])
	);
	upd_quo("dev_jrn", array("id_cat", "nom"), array($id_cat_jrn, $nom_jrn), $id_dev_jrn);
	$rq_sel_prs = sel_quo("id, id_cat, ctg, nom, titre, dsc, opt, ord", "dev_prs", "id_jrn", $id_dev_jrn, "ord");
	while($dt_sel_prs = ftc_ass($rq_sel_prs))
	{
		$id_cat_prs = $dt_sel_prs['id_cat'];
		$opt_prs = $dt_sel_prs['opt'];
		$ord_prs = $dt_sel_prs['ord'];
		if($id_cat_prs == 0)
		{
			$id_dev_prs = $dt_sel_prs['id'];
			if(empty($dt_sel_prs['nom']))
			{
				$nom_prs = $nom_jrn.' / '.$txt->prs->$id_lng.' '.$ord_prs;;
				if(!$opt_prs)
				{
					$nom_prs .= ' '.$txt->opt->$id_lng;
				}
			}else{
				$nom_prs = $dt_sel_prs['nom'];
			}
			include("saveToCatPrs.php");
		}
		insert(
			"cat_jrn_prs",
			array("id_jrn", "id_prs", "ord", "opt"),
			array($id_cat_jrn, $id_cat_prs, $ord_prs, $opt_prs)
		);
	}
}
?>
