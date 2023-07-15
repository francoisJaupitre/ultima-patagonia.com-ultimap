<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_frn']))
{
	include("../../prm/fct.php");
	$id_dev_srv_ctg = $data['id_dev_srv_ctg'];
	$id_dev_srv_vll = $data['id_dev_srv_vll'];
	$id_dev_srv = $data['id_dev_srv'];
	$id_dev_crc = $data['id_dev_crc'];
	if($id_dev_srv_ctg > 0 and $id_dev_srv_vll > 0){
		$src = 0;
	}else{
		$dt_src_srv = ftc_ass(sel_quo("id_vll,ctg","dev_srv","id",$id_dev_srv));
		$id_dev_srv_ctg = $dt_src_srv['ctg'];
		$id_dev_srv_vll = $dt_src_srv['id_vll'];
		$src = $data['id_frn'];
	}
	$dt_crc = ftc_ass(sel_quo("cnf","dev_crc","id",$id_dev_crc));
	$rq_mdl = sel_quo("id","dev_mdl","id_crc",$id_dev_crc);
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$rq_jrn = sel_quo("id","dev_jrn",array("opt","id_mdl"),array("1",$dt_mdl['id']));
		while($dt_jrn = ftc_ass($rq_jrn))
		{
		if($dt_crc['cnf']>0)
		{
			$rq_prs = sel_quo("id","dev_prs",array("res","id_jrn"),array("1",$dt_jrn['id']));
		}else{
			$rq_prs = sel_quo("id","dev_prs","id_jrn",$dt_jrn['id']);
		}
			while($dt_prs = ftc_ass($rq_prs)){
				$rq_srv = sel_quo("id,id_frn,id_vll,ctg,res","dev_srv",array("opt","id_prs"),array("1",$dt_prs['id']));
				while($dt_srv = ftc_ass($rq_srv)){
					if($dt_srv['id_vll'] == $id_dev_srv_vll and $dt_srv['ctg'] == $id_dev_srv_ctg and $dt_srv['id'] != $id_dev_srv and ($dt_srv['res'] == 0 or $dt_srv['res'] == 6) and $dt_srv['id_frn'] == $src)
					{
						$arr[] = $dt_srv['id'];
					}
				}
			}
		}
	}
	if(isset($arr))
	{
		echo json_encode($arr);
	}else{
		echo 0;
	}
}
?>
