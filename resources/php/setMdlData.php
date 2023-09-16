<?php //MANAGE MODULE DATAS IN A QUOTATION
$dt_mdl = ftc_ass(sel_quo(
	"*",
	"cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg = ".$id_lgg,
	"cat_mdl.id",
	$id_cat_mdl
));
$id_dev_mdl = insert(
	"dev_mdl",
	array("id_crc", "id_cat", "nom", "ord", "titre", "dsc", "col", "fus", "vue_dbl", "trf"),
	array($id_dev_crc, $id_cat_mdl, $dt_mdl['nom'], $ord_mdl, $dt_mdl['titre'], $dt_mdl['dsc'], 1, $fus, 1, $trf_mdl)
);
if(isset($obj) and $obj == 'mdl' and !empty($dt_mdl['sel_mdl_jrn']))
{
	$sel_mdl_jrn = explode(',', $dt_mdl['sel_mdl_jrn']);
}else{
	unset($sel_mdl_jrn);
}
if(empty($dt_mdl['titre']))
{
	$err_mdl .= $dt_mdl['nom']."\n";
}
if(!empty($dt_mdl['alerte']))
{
	$alt['mdl'.$id_cat_mdl] = $dt_mdl['nom'].' : '.$dt_mdl['alerte'];
}
$rq_rgn = sel_quo("id_rgn", "cat_mdl_rgn", "id_mdl", $id_cat_mdl, "", "DISTINCT");
while($dt_rgn = ftc_ass($rq_rgn))
{
	insert("dev_mdl_rgn", array("id_mdl", "id_rgn"), array($id_dev_mdl, $dt_rgn['id_rgn']));
}
$ir_rmn = 0;
$opt_jrn = 1;
$flg_sel = false;
$rq_mdl_jrn = sel_quo("*", "cat_mdl_jrn", "id_mdl", $id_cat_mdl, "ord");
while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn))
{
	if(
		$dt_mdl_jrn['opt']
		or isset($sel_mdl_jrn) and in_array($dt_mdl_jrn['id_jrn'], $sel_mdl_jrn)
		or isset($data_uid['id_opt_jrn']) and in_array($dt_mdl_jrn['id_jrn'], $data_uid['id_opt_jrn'])
		or isset($sel_crc_jrn) and in_array($dt_mdl_jrn['id_jrn'], $sel_crc_jrn)
	)
	{
		$opt_jrn = 1;
		if($dt_mdl_jrn['opt'])
		{
			$flg_sel = false;
		}elseif(isset($sel_crc_jrn) and in_array($dt_mdl_jrn['id_jrn'], $sel_crc_jrn))
		{
			if($flg_sel and $dt_mdl_jrn['ord'] == $ord_jrn_ant)
			{
				$opt_jrn = 0;
				$flg_sel = false;
			}else{
				$flg_sel = true;
			}
		}elseif(isset($data_uid['id_opt_jrn']) and in_array($dt_mdl_jrn['id_jrn'], $data_uid['id_opt_jrn']))
		{
			if($flg_sel and $dt_mdl_jrn['ord'] == $ord_jrn_ant)
			{
				upd_quo("dev_jrn", "opt", "0", $id_dev_jrn);
				if($date != '0000-00-00')
				{
					$date = date ('Y-m-d', strtotime ("-1 days $date"));
				}
				upd_noq('dev_crc', 'duree', 'duree-1', $id_dev_crc);
				$ord_jrn--;
				$flg_sel = false;
			}else{
				$flg_sel = true;
			}
		}
		$ord_jrn_ant = $dt_mdl_jrn['ord'];
		$id_cat_jrn = $dt_mdl_jrn['id_jrn'];
		include("setJrnData.php");
		if($err_jrn != '')
		{
			$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";
		}
		$err_jrn = '';
		if($opt_jrn)
		{
			if($date != '0000-00-00')
			{
				$date = date ('Y-m-d', strtotime ("+1 days $date"));
			}
			upd_noq('dev_crc', 'duree', 'duree+1', $id_dev_crc);
			$ord_jrn++;
		}
	}
}
?>
