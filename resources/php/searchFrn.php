<?php //GET OTHERS SUPPLIER SERVICES WHEN USER UPDATE ALL RATES FROM QUOTATIONS
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['id_frn']) and $data['id_frn'] > 0
	and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0
	and isset($data['cnf'])
)
{
	include("functions.php");
	$xmlTxt0 = 'src_frn1';
	$xmlTxt1 = 'src_frn0';
	$rq_mdl = sel_quo("id", "dev_mdl", "id_crc", $data['id_dev_crc']);
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$rq_jrn = sel_quo("id", "dev_jrn", array("opt", "id_mdl"), array("1", $dt_mdl['id']));
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			if($data['cnf'] > 0)
			{
				$rq_prs = sel_quo("id", "dev_prs", array("res", "id_jrn"), array("1", $dt_jrn['id']));
			}else{
				$rq_prs = sel_quo("id", "dev_prs", array("opt", "id_jrn"), array("1", $dt_jrn['id']));
			}
			while($dt_prs = ftc_ass($rq_prs))
			{
				$rq_srv = sel_quo("id, id_frn, res", "dev_srv", array("opt", "id_prs"), array("1", $dt_prs['id']));
				while($dt_srv = ftc_ass($rq_srv))
				{
					if($dt_srv['id_frn'] == $data['id_frn'])
					{
						$arr[] = $dt_srv['id'];
					}
				}
			}
		}
	}
	if(isset($arr))
	{
		include("../../prm/aut.php");
		$txt = simplexml_load_file('../xml/searchTxt.xml');
		$msg[] = $txt->$xmlTxt0->$id_lng." ".count($arr)." ".$txt->$xmlTxt1->$id_lng;
		if($data['res'] == 0 and $data['id_dev_srv'] == 0 and $data['cnf'] > 0)
		{
			$msg[] = (string)$txt->cnf->$id_lng;
		}
		$qa = array_merge($msg, $arr);
		echo json_encode($qa);
	}else{
		echo 0;
	}
}
?>
