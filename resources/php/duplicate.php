<?php //CREATE A NEW ROOM OR SERVICE RATES BASED ON EXISTING ONES
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['cbl']) and isset($data['id']))
{
	include("functions.php");
	include("../../prm/aut.php");
	$cbl = $data['cbl'];
	if($cbl == 'chm')
	{
		$id_chm = $data['id'];
		$dt_chm = ftc_ass(sel_quo("*", "cat_hbr_chm", "id", $id_chm));
		unset($dt_chm['id']);
		$dt_chm['nom'] .= '(1)';
		$id_chm_new = insert("cat_hbr_chm", array_keys($dt_chm), array_values($dt_chm));
		$rq_trf = sel_quo("*", "cat_hbr_chm_trf", "id_chm", $id_chm);
		while($dt_trf = ftc_ass($rq_trf))
		{
			$id_trf = $dt_trf['id'];
			unset($dt_trf['id']);
			$dt_trf['id_chm'] = $id_chm_new;
			$dt_trf['usr'] = $id_usr;
			$dt_trf['dt_cat'] = date("Y-m-d");
			$id_trf_new = insert("cat_hbr_chm_trf", array_keys($dt_trf), array_values($dt_trf));
			$rq_ssn = sel_quo("*", "cat_hbr_chm_trf_ssn", "id_trf", $id_trf);
			while($dt_ssn = ftc_ass($rq_ssn))
			{
				unset($dt_ssn['id']);
				$dt_ssn['id_trf'] = $id_trf_new;
				insert("cat_hbr_chm_trf_ssn", array_keys($dt_ssn), array_values($dt_ssn));
			}
		}
		$rq_txt = sel_quo("*", "cat_hbr_chm_txt", "id_hbr_chm", $id_chm);
		while($dt_txt = ftc_ass($rq_txt))
		{
			unset($dt_txt['id']);
			$dt_txt['id_hbr_chm'] = $id_chm_new;
			insert("cat_hbr_chm_txt", array_keys($dt_txt), array_values($dt_txt));
		}
	}elseif($cbl == 'trf')
	{
		$id_trf = $data['id'];
		$dt_trf = ftc_ass(sel_quo("*", "cat_srv_trf", "id", $id_trf));
		unset($dt_trf['id']);
		$dt_trf['def'] = 0;
		$id_trf_new = insert("cat_srv_trf", array_keys($dt_trf), array_values($dt_trf));
		$rq_bss = sel_quo("*", "cat_srv_trf_bss", "id_trf", $id_trf);
		while($dt_bss = ftc_ass($rq_bss))
		{
			unset($dt_bss['id']);
			$dt_bss['id_trf'] = $id_trf_new;
			insert("cat_srv_trf_bss", array_keys($dt_bss), array_values($dt_bss));
		}
		$dt_srv = ftc_ass(sel_quo("id_srv", "cat_srv_trf", "id", $id_trf));
		$max = ftc_num(sel_quo("MAX(dt_max)", "cat_srv_trf_ssn INNER JOIN cat_srv_trf ON cat_srv_trf_ssn.id_trf = cat_srv_trf.id", "cat_srv_trf.id_srv", $dt_srv['id_srv']));
		if(!empty($max[0]))
		{
			if($max[0] != '0000-00-00')
			{
				$date = date ('Y-m-d', strtotime ("+1 days $max[0]"));
			}else{
				$date='0000-00-00';
			}
			insert('cat_srv_trf_ssn', array("id_trf", "dt_min"), array($id_trf_new, $date));
		}else{
			insert('cat_srv_trf_ssn', "id_trf", $id_trf_new);
		}
	}
}
?>
