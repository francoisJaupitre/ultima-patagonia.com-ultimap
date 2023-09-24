<?php //APPLY CONFIRMATION STATE TO A QUOTATION
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0)
{
	$id_dev_crc = $data['id_dev_crc'];
	include("functions.php");
	include("../../prm/aut.php");
	include("../../cfg/crr.php");
	$flg_opt = false;
	$flg_pax = true;
	upd_quo("dev_crc", "cnf", 1, $id_dev_crc);
	$dt_crc = ftc_ass(sel_quo("dt_cnf, crr, id_grp", "dev_crc", "id", $id_dev_crc));
	$id_crr_crc = $dt_crc['crr'];
	$id_grp = $dt_crc['id_grp'];
	if($dt_crc['dt_cnf'] == '0000-00-00')
	{
		$dat_cnf = date("Y-m-d");
		upd_quo("dev_crc", array("dt_cnf", "vue_opt"), array($dat_cnf, '0'), $id_dev_crc);
	}else{
		$dat_cnf = $dt_crc['dt_cnf'];
	}
	$rq_mdl = sel_quo("id, trf", "dev_mdl", "id_crc", $id_dev_crc, "ord");
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$id_dev_mdl = $dt_mdl['id'];
		if($dt_mdl['trf'])
		{
			$nb_rmn_mdl = ftc_ass(sel_quo("COUNT(*) as total", "dev_mdl_rmn", "id_mdl", $id_dev_mdl));
			if($nb_rmn_mdl['total'] == 0)
			{
				$id_rmn_mdl = insert("dev_mdl_rmn", "id_mdl", $id_dev_mdl);
			}
			else{
				$dt_rmn = ftc_ass(sel_quo("id", "dev_mdl_rmn", "id_mdl", $id_dev_mdl));
				$id_rmn_mdl = $dt_rmn['id'];
			}
			upd_var_quo(
				"dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",
				"id_rmn",
				$id_rmn_mdl,
				array("id_rmn", "id_mdl"),
				array(0, $id_dev_mdl)
			);
		}elseif($flg_pax)
		{
			$nb_rmn_crc = ftc_ass(sel_quo("COUNT(*) as total", "dev_crc_rmn", "id_crc", $id_dev_crc));
			if($nb_rmn_crc['total'] == 0)
			{
				$id_rmn_crc = insert("dev_crc_rmn", "id_crc", $id_dev_crc, 1);
			}else{
				$dt_rmn = ftc_ass(sel_quo("id", "dev_crc_rmn", "id_crc", $id_dev_crc));
				$id_rmn_crc = $dt_rmn['id'];
			}
			upd_var_quo(
				"dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",
				"id_rmn",
				$id_rmn_crc,
				array("id_rmn", "id_mdl"),
				array(0, $id_dev_mdl)
			);
			$flg_pax = false;
		}else{
			upd_var_quo(
				"dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",
				"id_rmn",
				$id_rmn_crc,
				array("id_rmn", "id_mdl"),
				array(0, $id_dev_mdl)
			);
		}
		$rq_jrn = sel_quo("id, ord, date, opt", "dev_jrn", "id_mdl", $id_dev_mdl, "ord");
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			$id_dev_jrn = $dt_jrn['id'];
			if($dt_jrn['ord'] == 1)
			{
				$dat_jr1 = $dt_jrn['date'];
			}
			if($dt_jrn['opt'])
			{
				$rq_prs = sel_quo("id, res, opt, ctg", "dev_prs", "id_jrn", $id_dev_jrn);
				while($dt_prs = ftc_ass($rq_prs))
				{
					if(
						$dt_prs['ctg'] == 1
						or $dt_prs['ctg'] == 9
						or $dt_prs['ctg'] == 11
						or $dt_prs['ctg'] == 12
						or $dt_prs['ctg']== 17
					)
					{
							if(!isset($dat_nt1))
							{
								$dat_nt1 = $dt_jrn['date'];
							}
							$dat_nt0 = $dt_jrn['date'];
					}
					$id_dev_prs = $dt_prs['id'];
					if(!$dt_prs['opt'])
					{
						$flg_opt = true;
					}
					elseif($dt_prs['res'] == 0)
					{
						upd_quo(
							"dev_prs",
							array("res", "dt_res", "taux", "sup"),
							array(1, date("Y-m-d"), $cfg_crr_tx[$id_crr_crc], $cfg_crr_sp[$id_crr_crc]),
							$id_dev_prs
						);
						$rq_hbr = sel_quo("id, opt", "dev_hbr", "id_prs", $id_dev_prs);
						while($dt_hbr = ftc_ass($rq_hbr))
						{
							if($dt_hbr['opt'])
							{
								upd_quo("dev_hbr", "sel", "1", $dt_hbr['id']);
							}else{
								upd_quo("dev_hbr", "sel", "NULL", $dt_hbr['id']);
							}
						}
						$rq_srv = sel_quo("id, id_cat", "dev_srv", "id_prs", $id_dev_prs);
						while($dt_srv = ftc_ass($rq_srv))
						{
							$dt_cat_srv = ftc_ass(sel_quo("res", "cat_srv", "id", $dt_srv['id_cat']));
							if($dt_cat_srv['res'] == 0)
							{
								upd_quo("dev_srv", "res", "6", $dt_srv['id']);
							}
						}
					}
				}
			}
		}
	}
	$dt_grp = ftc_ass(sel_quo("id_clt", "grp_dev", "id", $id_grp));
	$dt_clt = ftc_ass(sel_quo("id_ctg", "cat_clt", "id", $dt_grp['id_clt']));
	$rq_tsk = sel_quo("*", "cfg_tsk", "", "", "ord");
	while($dt_tsk = ftc_ass($rq_tsk))
	{
		if(
				$dt_tsk['ctg_clt'] == 0
				or ($dt_tsk['ctg_clt'] > 0 and $dt_tsk['ctg_clt'] == $dt_clt['id_ctg'])
				or ($dt_tsk['ctg_clt'] < 0 and abs($dt_tsk['ctg_clt']) != $dt_clt['id_ctg'])
			)
		{
			$nb = $dt_tsk['delai'];
			if($dt_tsk['ref'] == 1)
			{
				$dat_ref = $dat_cnf;
			}elseif($dt_tsk['ref'] == 2)
			{
				$dat_ref = $dat_jr1;
			}elseif($dt_tsk['ref'] == 3)
			{
				$dat_ref = $dat_nt1;
			}elseif($dt_tsk['ref'] == 4)
			{
				$dat_ref = $dat_nt0;
			}
			if($nb < 0)
			{
				$date = date ('Y-m-d', strtotime ("$nb days $dat_ref"));
			}else{
				$date = date ('Y-m-d', strtotime ("+$nb days $dat_ref"));
			}
			if($date < date("Y-m-d"))
			{
				$date = date("Y-m-d");
			}
			$rq = sel_quo(
				"id",
				"grp_tsk",
				array("id_grp", "nom"),
				array($id_grp, $dt_tsk['nom'])
			);
			if(num_rows($rq) == 0)
			{
				insert(
					"grp_tsk",
					array("id_grp", "date", "nom", "respon", "usr", "dt_grp"),
					array($id_grp, $date, $dt_tsk['nom'], $id_usr, $id_usr, date("Y-m-d"))
				);
			}
		}
	}
	if($flg_opt)
	{
		$txt = simplexml_load_file('../../dev/txt.xml');
		$msg = $txt->alt_cnf->$id_lng;
		$qa = array(1, (string)$msg);
	}else{
		$qa = array(0);
	}
	echo json_encode($qa);
}
?>
