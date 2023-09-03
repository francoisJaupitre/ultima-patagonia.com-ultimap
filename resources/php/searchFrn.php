<?php //GET SOME SUPPLIER SERVICES IN QUOTATIONS AND OPERATIONS
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_frn']) and $data['id_frn'] > 0 and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0  and isset($data['id_dev_srv'])  and isset($data['res'])  and isset($data['cnf']))
{
	include("functions.php");
	if($data['res'] > -2 and $data['res'] < 6 and $data['id_dev_srv'] > 0)
	{
		$xmlTxt0 = 'src_frn1';
		$xmlTxt1 = 'src_frn2';
	}else if($data['res'] == 0 and $data['id_dev_srv'] == 0)
	{
		$xmlTxt0 = 'src_frn3';
		$xmlTxt1 = 'src_frn4';
	}
	$rq_mdl = sel_quo("id", "dev_mdl", "id_crc", $data['id_dev_crc']);
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$rq_jrn = sel_quo("id", "dev_jrn", array("opt", "id_mdl"), array("1", $dt_mdl['id']));
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			if(!isset($data['cnf']) or $data['cnf'] > 0)
			{
				$rq_prs = sel_quo("id", "dev_prs", array("res", "id_jrn"), array("1", $dt_jrn['id']));
			}else{
				$rq_prs = sel_quo("id", "dev_prs", array("opt", "id_jrn"), array("1", $dt_jrn['id']));
			}
			while($dt_prs = ftc_ass($rq_prs))
			{
				$rq_srv = sel_quo("id, id_frn, res", "dev_srv", "opt = 1 AND id_prs", $dt_prs['id']);
				while($dt_srv = ftc_ass($rq_srv))
				{
					if(
						$dt_srv['id_frn'] == $data['id_frn']
						and (
							($dt_srv['res'] != $data['res'] and $dt_srv['res'] != -1 and $dt_srv['res'] != 6 and $dt_srv['id'] != $data['id_dev_srv'])
							or
							($data['res'] == 0 and $data['id_dev_srv'] == 0)
						)
					)
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
