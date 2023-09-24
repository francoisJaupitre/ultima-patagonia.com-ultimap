<?php //GET OTHERS SERVICES WHEN USER CHANGE A SERVICE SUPPLIER OR A RESERVATION STATE FROM A QUOTATION OR OPERATIONS
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['id_frn'])
	and isset($data['param'])
	and isset($data['id_dev_srv']) and $data['id_dev_srv'] > 0
	and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0
	and isset($data['cnf'])
)
{
	include("functions.php");
	$params = json_decode($data['param'], true);
	if(isset($params['res']))
	{
		$xmlTxt0 = 'src_srv4';
		$xmlTxt1 = 'src_srv3';
	}elseif($params['ctg'] > 0 and $params['vll'] > 0)
	{
		$xmlTxt0 = 'src_srv1';
		$xmlTxt1 = 'src_srv0';
		$id_ctg = $params['ctg'];
		$id_vll = $params['vll'];
		$src = 0;
	}else{
		$xmlTxt0 = 'src_srv2';
		$xmlTxt1 = 'src_srv0';
		$dt_src_srv = ftc_ass(sel_quo("id_vll, ctg", "dev_srv", "id", $data['id_dev_srv']));
		$id_ctg = $dt_src_srv['ctg'];
		$id_vll = $dt_src_srv['id_vll'];
		$src = $data['id_frn'];
	}
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
				$rq_prs = sel_quo("id", "dev_prs", "id_jrn", $dt_jrn['id']);
			}
			while($dt_prs = ftc_ass($rq_prs))
			{
				$rq_srv = sel_quo("id, id_frn, id_vll, ctg, res", "dev_srv", array("opt", "id_prs"), array("1", $dt_prs['id']));
				while($dt_srv = ftc_ass($rq_srv))
				{
					if(
						(
							isset($params['res'])
							and $dt_srv['id_frn'] == $data['id_frn']
							and $dt_srv['res'] != $params['res']
							and $dt_srv['res'] != -1
							and $dt_srv['res'] != 6
							and $dt_srv['id'] != $data['id_dev_srv']
						) or (
							!isset($params['res'])
							and $dt_srv['id_vll'] == $id_vll
							and $dt_srv['ctg'] == $id_ctg
							and $dt_srv['id'] != $data['id_dev_srv']
							and ($dt_srv['res'] == 0 or $dt_srv['res'] == 6)
							and $dt_srv['id_frn'] == $src
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
		$qa = array_merge($msg, $arr);
		echo json_encode($qa);
	}else{
		echo 0;
	}
}
?>
