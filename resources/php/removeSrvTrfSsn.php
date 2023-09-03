<?php //DELETE A SERVICE RATE SEASON IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_srv_trf']) and $data['id_srv_trf'] > 0 and isset($data['id_srv_trf_ssn']) and $data['id_srv_trf_ssn'] > 0)
{
	include("functions.php");
	$rq_srv_trf = sel_quo("id", "cat_srv_trf_ssn", "id_trf", $data['id_srv_trf']);
	if(num_rows($rq_srv_trf) > 1)
	{
		$dt_ssn = ftc_ass(sel_whe("id", "cat_srv_trf_ssn", "dt_min = (SELECT MIN(dt_min) FROM cat_srv_trf_ssn WHERE id_trf = ".$data['id_srv_trf'].") AND id_trf = ".$data['id_srv_trf']));
		if($dt_ssn['id'] == $data['id_srv_trf_ssn'])
		{
			echo 0;
		}else{
			echo 1;
		}
		delete('cat_srv_trf_ssn', "id", $data['id_srv_trf_ssn']);
	}else{
		delete('cat_srv_trf_ssn', "id", $data['id_srv_trf_ssn']);
		echo 0;
	}
}
?>
