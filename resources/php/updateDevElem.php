<?php //GET QUOTATION ELEMENTS FROM CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['obj']) and isset($data['lgg']) and $data['lgg'] > 0 and isset($data['id']) and $data['id'] > 0)
{
	include("functions.php");
	include("../../cfg/crr.php");
	include("../../cfg/lng.php");
	$txt = simplexml_load_file('../xml/updateTxt.xml');
	$obj = $data['obj'];
	$id_lgg = $data['lgg'];
	$alt = array();
	$err = $err_mdl = $err_jrn = $err_prs = $err_hbr = $err_srv = '';
	switch($obj)
	{
		case 'crc':
			$id_dev_crc = $data['id'];
			$dt_dev_crc = ftc_ass(sel_quo("id_cat, crr", "dev_crc", "id", $id_dev_crc));
			$id_cat_crc = $dt_dev_crc['id_cat'];
			$id_crr_crc = $dt_dev_crc['crr'];
			$dt_rmn = ftc_ass(sel_quo("id", "dev_crc_rmn", array("nr", "id_crc"), array(1, $id_dev_crc)));
			if(!empty($dt_rmn['id']))
			{
				$id_rmn = $dt_rmn['id'];
			}else{
				$id_rmn = 0;
			}
			if($id_cat_crc > 0)
			{
				$dt_jrn = ftc_ass(sel_quo(
					"MIN(date) as date",
					"dev_jrn RIGHT JOIN (SELECT id, MIN(ord) AS ord FROM dev_mdl WHERE id_crc = ".$id_dev_crc." GROUP BY id) t ON dev_jrn.id_mdl = t.id"
				));
				$min_date = $dt_jrn['date'];
				$rq_sel_mdl = sel_quo("id, fus", "dev_mdl", "id_crc", $id_dev_crc);
				while($dt_sel_mdl = ftc_ass($rq_sel_mdl))
				{
					$id_dev_mdl = $dt_sel_mdl['id'];
					if($dt_sel_mdl['fus'])
					{
						upd_noq('dev_crc', 'duree', 'duree-1', $id_dev_crc);
					}
					include("../../dev/sup_mdl.php");
				}
				$date = $min_date;
				$ord_jrn = 1;
				$trf_mdl = 0;
				$ord_jrn_ant = 1;
				$rq_crc_mdl = sel_quo("*", "cat_crc_mdl", "id_crc", $id_cat_crc, "ord");
				while($dt_crc_mdl = ftc_ass($rq_crc_mdl))
				{
					$id_cat_mdl = $dt_crc_mdl['id_mdl'];
					$ord_mdl = $dt_crc_mdl['ord'];
					$fus = $dt_crc_mdl['fus'];
					include("setMdlData.php");
					if($fus)
					{
						$ord_jrn--;
						if($date != '0000-00-00')
						{
							$date = date ('Y-m-d', strtotime ("-1 days $date"));
						}
					}
				}
			}
			break;
		case 'mdl':
			$id_dev_mdl = $data['id'];
			$dt_dev_mdl = ftc_ass(sel_quo(
				"dev_mdl.id_cat, crr, id_crc, ord, fus",
				"dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id",
				"dev_mdl.id",
				$id_dev_mdl
			));
			$ord_mdl = $dt_dev_mdl['ord'];
			$id_cat_mdl = $dt_dev_mdl['id_cat'];
			$id_crr_crc = $dt_dev_mdl['crr'];
			$id_dev_crc = $dt_dev_mdl['id_crc'];
			if($dt_dev_mdl['fus'])
			{
				$flg_moins = true;
			}
			$dt_rmn = ftc_ass(sel_quo("id", "dev_mdl_rmn", array("nr", "id_mdl"), array(1, $id_dev_mdl)));
			if(!empty($dt_rmn['id']))
			{
				$id_rmn = $dt_rmn['id'];
			}else{
				$id_rmn = 0;
			}
			if($id_cat_mdl > 0)
			{
				$dt_jrn = ftc_ass(sel_quo("MIN(ord) as ord, MIN(date) as date", "dev_jrn", "id_mdl", $id_dev_mdl));
				$date = $dt_jrn['date'];
				$ord_jrn = $dt_jrn['ord'];
				$rq_sel_jrn = sel_quo("id, opt", "dev_jrn", "id_mdl", $id_dev_mdl);
				while($dt_sel_jrn = ftc_ass($rq_sel_jrn))
				{
					$id_dev_jrn = $dt_sel_jrn['id'];
					include("../../dev/sup_jrn.php");
					if($dt_sel_jrn['opt'])
					{
						upd_noq('dev_crc', 'duree', 'duree-1', $id_dev_crc);
					}
				}
				$dt_cat_mdl = ftc_ass(sel_quo("sel_mdl_jrn", "cat_mdl", "id", $id_cat_mdl));
				if(!empty($dt_cat_mdl['sel_mdl_jrn']))
				{
					$sel_mdl_jrn = explode(", ", $dt_cat_mdl['sel_mdl_jrn']);
				}else{
					unset($sel_mdl_jrn);
				}
				$rq_mdl_jrn = sel_quo("*", "cat_mdl_jrn", "id_mdl", $id_cat_mdl, "ord");
				while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn))
				{
					if($dt_mdl_jrn['opt'] or isset($sel_mdl_jrn) and in_array($dt_mdl_jrn['id_jrn'], $sel_mdl_jrn))
					{
						$id_cat_jrn = $dt_mdl_jrn['id_jrn'];
						$opt_jrn = 1;
						include("setJrnData.php");
						upd_noq('dev_crc', 'duree', 'duree+1', $id_dev_crc);
						if($date != '0000-00-00')
						{
							$date = date ('Y-m-d', strtotime ("+1 days $date"));
						}
						$ord_jrn++;
					}
				}
				if($flg_moins)
				{
					upd_noq('dev_crc', 'duree', 'duree-1', $id_dev_crc);
					if($date != '0000-00-00')
					{
						$date = date('Y-m-d', strtotime ("-1 days $date"));
					}
					$ord_jrn--;
				}
				$rq_mdl = sel_whe("id, ord, fus", "dev_mdl", "ord >".$ord_mdl." AND id_crc = ".$id_dev_crc, "ord");
				while($dt_mdl = ftc_ass($rq_mdl))
				{
					$rq_jrn = sel_quo("id, ord, date", "dev_jrn", "id_mdl", $dt_mdl['id'], "ord");
					while($dt_jrn = ftc_ass($rq_jrn))
					{
						if($dt_jrn['date'] != '0000-00-00' and $dt_jrn['date'] != $date)
						{
							upd_noq("dev_jrn", array("ord", "date"), array($ord_jrn, $date), $dt_jrn['id']);
							$result = upd_var_noq(
								"dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id",
								"dev_srv.res",
								"3",
								"(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",
								$dt_jrn['id']
							);
							$result = upd_var_noq(
								"dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id",
								"dev_hbr.res",
								"3",
								"(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",
								$dt_jrn['id']
							);
						}else{
							upd_noq("dev_jrn", "ord", $ord_jrn, $dt_jrn['id']);
						}
						if($date != '0000-00-00')
						{
							$date = date ('Y-m-d', strtotime ("+1 days $date"));
						}
						$ord_jrn++;
					}
					$err_ord .= $dt_mdl['ord'].', ';
					if($dt_mdl['fus'])
					{
						if($date != '0000-00-00')
						{
							$date = date('Y-m-d', strtotime ("-1 days $date"));
						}
						$ord_jrn--;
					}
				}
			}
			break;
		case 'jrn':
			$id_dev_jrn = $data['id'];
			$dt_jrn = ftc_ass(sel_quo("id_cat, id_mdl, ord, date", "dev_jrn", "id", $id_dev_jrn));
			$id_cat_jrn = $dt_jrn['id_cat'];
			$id_dev_mdl = $dt_jrn['id_mdl'];
			$dt_dev_mdl = ftc_ass(sel_quo("id_crc, trf", "dev_mdl", "id", $id_dev_mdl));
			$dt_dev_crc = ftc_ass(sel_quo("crr", "dev_crc", "id", $dt_dev_mdl['id_crc']));
			$id_crr_crc = $dt_dev_crc['crr'];
			if($dt_dev_mdl['trf'])
			{
				$rq_rmn = sel_quo("id", "dev_mdl_rmn", array("nr", "id_mdl"), array(1, $id_dev_mdl));
			}else{
				$rq_rmn = sel_quo("id", "dev_crc_rmn", array("nr", "id_crc"), array(1, $dt_dev_mdl['id_crc']));
			}
			$dt_rmn = ftc_ass($rq_rmn);
			if(!empty($dt_rmn['id']))
			{
				$id_rmn = $dt_rmn['id'];
			}else{
				$id_rmn = 0;
			}
			if($id_cat_jrn > 0)
			{
				$date = $dt_jrn['date'];
				$ord_jrn = $dt_jrn['ord'];
				$rq_sel_prs = sel_quo("id, id_cat", "dev_prs", "id_jrn", $id_dev_jrn);
				while($dt_sel_prs = ftc_ass($rq_sel_prs))
				{
					$id_dev_prs = $dt_sel_prs['id'];
					$flg_sup_elem = true;
					$rq_jrn_prs = sel_quo("id_prs", "cat_jrn_prs", "id_jrn", $id_cat_jrn);
					while($dt_jrn_prs = ftc_ass($rq_jrn_prs))
					{
						if($dt_jrn_prs['id_prs'] == $dt_sel_prs['id_cat'])
						{
							$flg_sup_elem = false;
						}
					}
					if($flg_sup_elem)
					{
						include("../../dev/sup_prs.php");
					}
				}
				$ord_prs = $ord_ant = 0;
				$rq_jrn_prs = sel_quo("*", "cat_jrn_prs", "id_jrn", $id_cat_jrn, "ord, opt DESC");
				while($dt_jrn_prs = ftc_ass($rq_jrn_prs))
				{
					$opt_prs = $dt_jrn_prs['opt'];
					$ord_ant = $dt_jrn_prs['ord'];
					$id_cat_prs = $dt_jrn_prs['id_prs'];
					$rq_sel_prs = sel_quo("id, ord", "dev_prs", array("id_cat", "id_jrn"), array($id_cat_prs, $id_dev_jrn));
					if(!num_rows($rq_sel_prs))
					{
						$flg_ins_elem = true;
						$rq_opt_prs = sel_quo("id_prs", "cat_jrn_prs", array("ord", "opt", "id_jrn"), array($ord_ant, "0", $id_cat_jrn));
						while($dt_opt_prs = ftc_ass($rq_opt_prs))
						{
							$rq_dev_prs = sel_quo("id_cat", "dev_prs", "id_jrn", $id_dev_jrn);
							while($dt_dev_prs = ftc_ass($rq_dev_prs))
							{
								if($dt_dev_prs['id_cat'] == $dt_opt_prs['id_prs'])
								{
									$flg_ins_elem = false;
								}
							}
						}
						if($flg_ins_elem and ($opt_prs or (!$opt_prs and $dt_jrn_prs['ord'] != $ord_ant)))
						{
							$ord_prs++;
						}
					}else{
						$flg_ins_elem = false;
						$ord_prs++;
						$ord_old[] = $id_cat_prs;
						$ord_new[] = $ord_prs;
						$dt_sel_prs = ftc_ass($rq_sel_prs);
						if($dt_sel_prs['ord'] != $ord_prs)
						{
							upd_quo("dev_prs", "ord", $ord_prs, $dt_sel_prs['id']);
						}
					}
					if($flg_ins_elem and $opt_prs)
					{
						include("setPrsData.php");
					}else{
						foreach($ord_old as $i => $ord_upd)
						{
							upd_var_quo("dev_prs", "ord", $ord_new[$i], array("id_cat", "id_jrn"), array($ord_upd, $id_dev_jrn));
						}
					}
				}
			}
			break;
		case 'prs':
			$id_dev_prs = $data['id'];
			$dt_prs = ftc_ass(sel_quo("id_cat, id_jrn", "dev_prs", "id", $id_dev_prs));
			$id_cat_prs = $dt_prs['id_cat'];
			if($id_cat_prs > 0)
			{
				$dt_jrn = ftc_ass(sel_quo("id_mdl, ord, date", "dev_jrn", "id", $dt_prs['id_jrn']));
				$id_dev_mdl = $dt_jrn['id_mdl'];
				$dt_dev_mdl = ftc_ass(sel_quo("id_crc", "dev_mdl", "id", $id_dev_mdl));
				$dt_dev_crc = ftc_ass(sel_quo("crr", "dev_crc", "id", $dt_dev_mdl['id_crc']));
				$id_crr_crc = $dt_dev_crc['crr'];
				$ord_jrn = $dt_jrn['ord'];
				$date = $dt_jrn['date'];
				$rq_sel_srv = sel_quo("id", "dev_srv", "id_prs", $id_dev_prs);
				while($dt_sel_srv = ftc_ass($rq_sel_srv))
				{
					delete("dev_srv", "id", $dt_sel_srv['id']);
					delete("dev_srv_trf", "id_srv", $dt_sel_srv['id']);
					delete("dev_srv_pay", "id_srv", $dt_sel_srv['id']);
				}
				$rq_sel_hbr = sel_quo("id", "dev_hbr", "id_prs", $id_dev_prs);
				while($dt_sel_hbr = ftc_ass($rq_sel_hbr))
				{
					delete("dev_hbr", "id", $dt_sel_hbr['id']);
					delete("dev_hbr_pay", "id_hbr", $dt_sel_hbr['id']);
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
						include("setHbrData.php");
					}
					$flg_opt = false;
					$rq_opt = sel_quo("id, opt", "dev_hbr", "id_prs", $id_dev_prs);
					while($dt_opt = ftc_ass($rq_opt))
					{
						if($dt_opt['opt'])
						{
							$flg_opt = true;
						}
					}
					if(!$flg_opt)
					{
						upd_quo("dev_hbr", "opt", "1", $id_dev_hbr);
					}
				}
			}
			break;
	}
	if($err_mdl != '')
	{
		$err .= $txt->err->mdl->$id_lng.$err_mdl."\n";
	}
	if($err_jrn != '')
	{
		$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";
	}
	if($err_prs != '')
	{
		$err .= $txt->err->prs->$id_lng.$err_prs."\n";
	}
	if($err_hbr != '')
	{
		$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";
	}
	if($err_srv != '')
	{
		$err .= $txt->err->srv->$id_lng.$err_srv."\n";
	}
	if(isset($lst_nvtrf))
	{
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom)
		{
			$err .= "-> ".$nom."\n";
		}
	}
	$qa = array($err, implode(",\n", $alt));
	echo json_encode($qa);
}
?>
