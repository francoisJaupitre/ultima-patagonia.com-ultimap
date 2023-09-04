<?php //INSERT HIDDEN DAY IN QUOTATION
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['id_dev_mdl']) and $data['id_dev_mdl'] > 0
	and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0
	and isset($data['ord_jrn'])
	and isset($data['nbj'])
	)
{
  include("functions.php");
	$nbj = $data['nbj'];
	$max_date = "0000-00-00";
	$max_ord = 0;
	$err = $err_ord = '';
	$dt_mdl = ftc_ass(sel_quo("ord", "dev_mdl", "id", $data['id_dev_mdl']));
	$ord_mdl = $dt_mdl['ord'];
	$flg_plus = true;
	if($data['ord_jrn'] == 0)
	{
		$dt_jrn = ftc_ass(sel_quo("MAX(ord) AS ord, MAX(date) as date", "dev_jrn", "id_mdl", $data['id_dev_mdl']));
		if(!is_null($dt_jrn['ord']))
		{
			$max_date = $dt_jrn['date'];
			$max_ord = $dt_jrn['ord'];
		}elseif($ord_mdl != 1)
		{
			$i = $ord_mdl;
			$flg_mdl = false;
			while(!$flg_mdl and $i > 1)
			{
				$i--;
				$dt_jrn = ftc_ass(sel_quo(
					"MAX(dev_jrn.ord) AS ord, MAX(date) as date, fus",
					"dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",
					array("dev_mdl.ord", "id_crc"),
					array($i, $data['id_dev_crc'])
				));
				if(!is_null($dt_jrn['ord']))
				{
					$flg_mdl = true;
				}
			}
			if($flg_mdl)
			{
				$max_date = $dt_jrn['date'];
				$max_ord = $dt_jrn['ord'];
				if($i == $ord_mdl-1 and $dt_jrn['fus'] == 1)
				{
					$flg_plus = false;
				}
			}
		}else{
			$dt_jrn = ftc_ass(sel_quo(
				"MIN(dev_jrn.ord) AS ord, MIN(date) as date",
				"dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",
				"id_crc",
				$data['id_dev_crc']
			));
			if(!is_null($dt_jrn['ord']))
			{
				$min_date = $max_date = $dt_jrn['date'];
				if($max_date != '0000-00-00')
				{
					$max_date = date ('Y-m-d', strtotime ("-1 days $max_date"));
				}
			}
		}
		$rq_mdl = sel_whe("id, ord, fus", "dev_mdl", "ord > ".$ord_mdl." AND id_crc = ".$data['id_dev_crc'], "ord");
		while($dt_mdl = ftc_ass($rq_mdl))
		{
			$rq_jrn = sel_quo("id, ord, date", "dev_jrn", "id_mdl", $dt_mdl['id']);
			while($dt_jrn = ftc_ass($rq_jrn))
			{
				$date = $dt_jrn['date'];
				if($date != '0000-00-00')
				{
					$date = date ('Y-m-d', strtotime ("+$nbj days $date"));
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
				}
				upd_noq("dev_jrn", array("ord", "date"), array("ord+$nbj", "'".$date."'"), $dt_jrn['id']);
			}
			$err_ord .= $dt_mdl['ord'].', ';
		}
		if($flg_plus)
		{
			$ord_jrn = $max_ord + 1;
			if($max_date!="0000-00-00")
			{
				$date = date ('Y-m-d', strtotime ("+1 days $max_date"));
			}else{
				$date = '0000-00-00';
			}
		}else{
			$ord_jrn = $max_ord;
			$date = $max_date;
		}
		for($j = 0; $j < intval($nbj); $j++)
		{
			insert("dev_jrn", array("id_mdl", "id_cat", "ord", "date", "opt"), array($data['id_dev_mdl'], '-1', $ord_jrn, $date, '1'));
			if($date != '0000-00-00')
			{
				$date = date ('Y-m-d', strtotime ("+1 days $date"));
			}
			$ord_jrn++;
		}
		if($err_ord != '')
		{
			$txt = simplexml_load_file('../xml/updateTxt.xml');
			include("../../cfg/lng.php");
			$err = $txt->err->alrt->$id_lng.$err_ord.$txt->err->alrt2->$id_lng;
		}
		upd_noq('dev_crc', 'duree', 'duree+'.$nbj, $data['id_dev_crc']);
	}else{
		$dt_jrn = ftc_ass(sel_quo("date", "dev_jrn", array("id_mdl", "ord"), array($data['id_dev_mdl'], $data['ord_jrn'])));
		insert(
			"dev_jrn",
			array("id_mdl", "id_cat", "ord", "date", "opt"),
			array($data['id_dev_mdl'], '-1', $data['ord_jrn'], $dt_jrn['date'], '0')
		);
	}
	if($err != '')
	{
		$qa = array($err);
	}else{
		$qa = array(1);
	}
	echo json_encode($qa);
}
?>
