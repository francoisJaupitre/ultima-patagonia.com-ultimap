<?php //MOVE A QUOTATION ELEMENT FROM ITS PARENT TO PREVIOUS OR NEXT PARENT
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['obj']) and isset($data['id']) and $data['id'] > 0)
{
	$id = $data["id"];
	$obj = $data["obj"];
	include("functions.php");
	include("../../cfg/lng.php");
	$txt = simplexml_load_file('../../dev/txt.xml');
	$rsp = '';
	if($obj == 'mdl')
	{
		$dt_mdl = ftc_ass(sel_quo("ord, fus, id_crc", "dev_mdl", "id", $id));
		$ord_mdl = $dt_mdl['ord'] - 1;
		$fus_mdl = $dt_mdl['fus'];
		$id_crc = $dt_mdl['id_crc'];
		$old_rgn = $new_rgn = array();
		$rq_mdl_rgn = sel_quo("id_rgn", "dev_mdl_rgn", "id_mdl", $id);
		while($dt_mdl_rgn = ftc_ass($rq_mdl_rgn))
		{
			$old_rgn[] = $dt_mdl_rgn['id_rgn'];
		}
		unset($dt_mdl, $dt_mdl_rgn);
		$dt_mdl = ftc_ass(sel_quo("id, fus, trf", "dev_mdl", array("ord", "id_crc"), array($ord_mdl, $id_crc)));
		if(!$dt_mdl['fus'] and !$dt_mdl['trf'])
		{
			$id_mdl = $dt_mdl['id'];
			upd_var_quo("dev_jrn", "id_mdl", $id_mdl, "id_mdl", $id);
			upd_quo("dev_mdl", array("fus", "id_cat"), array($fus_mdl, "NULL"), $id_mdl);
			upd_quo("dev_mdl", array("fus", "id_cat"), array($fus_mdl, "NULL"), $id);
			$rq_mdl_rgn = sel_quo("id_rgn", "dev_mdl_rgn", "id_mdl", $id_mdl);
			while($dt_mdl_rgn = ftc_ass($rq_mdl_rgn))
			{
				$new_rgn[] = $dt_mdl_rgn['id_rgn'];
			}
			foreach ($old_rgn as $id_rgn)
			{
				if(!in_array($id_rgn, $new_rgn))
				{
					insert("dev_mdl_rgn", array("id_mdl", "id_rgn"), array($id_mdl, $id_rgn));
				}
			}
			$rsp = '1';
		}else{
			$rsp = $txt->trsf1->$id_lng;
		}
	}elseif($obj == 'jrnavt')
	{
		$dt_jrn = ftc_ass(sel_quo("id_mdl, id_cat", "dev_jrn", "id", $id));
		$id_cat_jrn = $dt_jrn['id_cat'];
		$dt_mdl = ftc_ass(sel_quo("ord, id_crc", "dev_mdl", "id", $dt_jrn['id_mdl']));
		$ord_mdl = $dt_mdl['ord'] - 1;
		$id_crc = $dt_mdl['id_crc'];
		if($id_cat_jrn > 0)
		{
			$rgn_jrn = array();
			$rq_vll = sel_quo("id_rgn", "cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id", "id_jrn", $id_cat_jrn);
			while($dt_vll = ftc_ass($rq_vll))
			{
				$rgn_jrn[] = $dt_vll['id_rgn'];
			}
		}
		unset($dt_mdl);
		$dt_mdl = ftc_ass(sel_quo("id, fus, trf", "dev_mdl", array("ord", "id_crc"), array($ord_mdl, $id_crc)));
		if(!$dt_mdl['fus'] and !$dt_mdl['trf'])
		{
			$id_mdl = $dt_mdl['id'];
			upd_quo("dev_jrn", "id_mdl", $id_mdl, $id);
			upd_quo("dev_mdl", "id_cat", "NULL", $id_mdl);
			upd_quo("dev_mdl", "id_cat", "NULL", $dt_jrn['id_mdl']);
			if(isset($rgn_jrn))
			{
				$rq_mdl_rgn = sel_quo("id_rgn", "dev_mdl_rgn", "id_mdl", $id_mdl);
				while($dt_mdl_rgn = ftc_ass($rq_mdl_rgn))
				{
					$new_rgn[] = $dt_mdl_rgn['id_rgn'];
				}
				foreach ($rgn_jrn as $id_rgn)
				{
					if(!in_array($id_rgn, $new_rgn))
					{
						insert("dev_mdl_rgn", array("id_mdl", "id_rgn"), array($id_mdl, $id_rgn));
					}
				}
			}
			$rsp = '1';
		}else{
			$rsp = $txt->trsf1->$id_lng;
		}
	}elseif($obj == 'jrnapr')
	{
		$dt_jrn = ftc_ass(sel_quo("id_mdl, id_cat", "dev_jrn", "id", $id));
		$id_cat_jrn = $dt_jrn['id_cat'];
		$dt_mdl = ftc_ass(sel_quo("ord, id_crc", "dev_mdl", "id", $dt_jrn['id_mdl']));
		$ord_mdl = $dt_mdl['ord'] + 1;
		$id_crc = $dt_mdl['id_crc'];
		if($id_cat_jrn > 0)
		{
			$rgn_jrn = array();
			$rq_vll = sel_quo("id_rgn", "cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id", "id_jrn", $id_cat_jrn);
			while($dt_vll = ftc_ass($rq_vll))
			{
				$rgn_jrn[] = $dt_vll['id_rgn'];
			}
		}
		unset($dt_mdl);
		$dt_mdl = ftc_ass(sel_quo("id, trf", "dev_mdl", array("ord", "id_crc"), array($ord_mdl, $id_crc)));
		if(!$dt_mdl['trf'])
		{
			$id_mdl = $dt_mdl['id'];
			upd_quo("dev_jrn", "id_mdl", $id_mdl, $id);
			upd_quo("dev_mdl", "id_cat", "NULL", $id_mdl);
			upd_quo("dev_mdl", "id_cat", "NULL", $dt_jrn['id_mdl']);
			if(isset($rgn_jrn))
			{
				$rq_mdl_rgn = sel_quo("id_rgn", "dev_mdl_rgn", "id_mdl", $id_mdl);
				while($dt_mdl_rgn = ftc_ass($rq_mdl_rgn))
				{
					$new_rgn[] = $dt_mdl_rgn['id_rgn'];
				}
				foreach ($rgn_jrn as $id_rgn)
				{
					if(!in_array($id_rgn, $new_rgn))
					{
						insert("dev_mdl_rgn", array("id_mdl", "id_rgn"), array($id_mdl, $id_rgn));
					}
				}
			}
			$rsp = '2';
		}else{
			$rsp = $txt->trsf2->$id_lng;
		}
	}elseif($obj == 'prsavt')
	{
		$dt_prs = ftc_ass(sel_quo("id_jrn, ord", "dev_prs", "id", $id));
		$dt = ftc_ass(sel_quo("ord, id_mdl", "dev_jrn", "id", $dt_prs['id_jrn']));
		$ord_jrn = $dt['ord'] - 1;
		$id_mdl = $dt['id_mdl'];
		$rq_jrn = sel_quo("id", "dev_jrn", array("ord", "id_mdl"), array($ord_jrn, $id_mdl));
		if(num_rows($rq_jrn) > 0)
		{
			$dt_jrn = ftc_ass($rq_jrn);
			$id_jrn = $dt_jrn['id'];
			$max_prs = ftc_num(sel_quo("MAX(ord)", "dev_prs", "id_jrn", $id_jrn));
			upd_quo("dev_prs", "id_jrn", $id_jrn, $id);
			if($max_prs[0] > 0)
			{
				$ord_prs = $max_prs[0] + 1;
			}else{
				$ord_prs = 1;
			}
			upd_quo("dev_prs", "ord", $ord_prs, $id);
			upd_quo("dev_jrn", "id_cat", "NULL", $id_jrn);
			upd_quo("dev_jrn", "id_cat", "NULL", $dt_prs['id_jrn']);
			upd_var_noq("dev_prs", "ord", "ord - 1", "ord > ".$dt_prs['ord']." AND id_jrn", $dt_prs['id_jrn']);
			$rsp = '3';
		}
	}elseif($obj == 'prsapr')
	{
		$dt_prs = ftc_ass(sel_quo("id_jrn, ord", "dev_prs", "id", $id));
		$dt = ftc_ass(sel_quo("ord, id_mdl", "dev_jrn", "id", $dt_prs['id_jrn']));
		$ord_jrn = $dt['ord'] + 1;
		$id_mdl = $dt['id_mdl'];
		$rq_jrn = sel_quo("id", "dev_jrn", array("ord", "id_mdl"), array($ord_jrn, $id_mdl));
		if(num_rows($rq_jrn) > 0)
		{
			$dt_jrn = ftc_ass($rq_jrn);
			$id_jrn = $dt_jrn['id'];
			$max_prs = ftc_num(sel_quo("MAX(ord)", "dev_prs", "id_jrn", $id_jrn));
			upd_quo("dev_prs", "id_jrn", $id_jrn, $id);
			if($max_prs[0] > 0)
			{
				$ord_prs = $max_prs[0] + 1;
			}else{
				$ord_prs = 1;
			}
			upd_quo("dev_prs", "ord", $ord_prs, $id);
			upd_quo("dev_jrn", "id_cat", "NULL", $id_jrn);
			upd_quo("dev_jrn", "id_cat", "NULL", $dt_prs['id_jrn']);
			upd_var_noq("dev_prs", "ord", "ord-1", "ord>".$dt_prs['ord']." AND id_jrn", $dt_prs['id_jrn']);
			$rsp = '4';
		}
	}
	$qa = array((string)$rsp);
	echo json_encode($qa);
}
?>
