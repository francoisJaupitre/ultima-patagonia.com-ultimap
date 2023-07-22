<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_frn']))
{
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	$id_dev_srv = $data['id_dev_srv'];
	$res = $data['res'];
	$cnf = $data['cnf'];
	$txt = simplexml_load_file('../xml/searchTxt.xml');
	if($res > -2 and $res < 6 and $id_dev_srv > 0)
	{
		$xmlTxt0 = 'src_frn1';
		$xmlTxt1 = 'src_frn2';
	}else if($res == 0 and $id_dev_srv == 0)
	{
		$xmlTxt0 = 'src_frn3';
		$xmlTxt1 = 'src_frn4';
	}
	$rq_mdl = sel_quo("id","dev_mdl","id_crc",$data['id_dev_crc']);
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$rq_jrn = sel_quo("id","dev_jrn",array("opt","id_mdl"),array("1",$dt_mdl['id']));
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			if(!isset($data['cnf']) or $data['cnf'] > 0)
			{
				$rq_prs = sel_quo("id","dev_prs",array("res","id_jrn"),array("1",$dt_jrn['id']));
			}else{
				$rq_prs = sel_quo("id","dev_prs",array("opt","id_jrn"),array("1",$dt_jrn['id']));
			}
			while($dt_prs = ftc_ass($rq_prs))
			{
				$rq_srv = sel_quo("id,id_frn,res","dev_srv","opt=1 AND id_prs",$dt_prs['id']);
				while($dt_srv = ftc_ass($rq_srv))
				{
					if($dt_srv['id_frn'] == $data['id_frn'] and (($dt_srv['res'] != $res and $dt_srv['res'] != -1 and $dt_srv['res'] != 6 and $dt_srv['id'] != $id_dev_srv) or ($res == 0 and $id_dev_srv == 0)))
					{
						$arr[] = $dt_srv['id'];
					}
				}
			}
		}
	}
	if(isset($arr))
	{
		$msg[] = $txt->$xmlTxt0->$id_lng." ".count($arr)." ".$txt->$xmlTxt1->$id_lng;
		if($res == 0 and $id_dev_srv == 0 and $cnf > 0)
		{
			$msg[] = (string)$txt->cnf->$id_lng;
		}
		$qa = array_merge($msg,$arr);
		echo json_encode($qa);
	}else{
		echo 0;
	}
}
?>
