<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data["id"]))
{
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	$txt = simplexml_load_file('../../acc/txt.xml');
	$id = $data["id"];
}
if(isset($id))
{
	$dt_sel = ftc_ass(sel_quo("cnf,dt_fin,groupe,version","dev_crc","id",$id));
	if($dt_sel['cnf'] == 1)
	{
		$upd = 2;
	}else{
		$upd = -1;
		$rq_prs = sel_quo("dev_prs.id","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","dev_mdl.id_crc",$id);
		while($dt_prs = ftc_ass($rq_prs))
		{
			$rq_srv = sel_whe("id","dev_srv","res>0 AND res<4 AND id_prs=".$dt_prs['id']);
			if(num_rows($rq_srv)>0)
			{
				$err = "\n".$dt_sel['groupe'].' V'.$dt_sel['version'];
				break;
			}
			$rq_hbr = sel_whe("id","dev_hbr","id_cat!=-2 AND res>0 AND res<4 AND id_prs=".$dt_prs['id']);
			if(num_rows($rq_hbr)>0)
			{
				$err = "\n".$dt_sel['groupe'].' V'.$dt_sel['version'];
				break;
			}
		}
	}
	if(!isset($err))
	{
		if($dt_sel['cnf'] == 1 and $dt_sel['dt_fin'] == '0000-00-00')
		{
			upd_quo("dev_crc", array("cnf", "dt_fin"), array(2, date('Y-m-d')), $id);
		}else{
			upd_quo("dev_crc", "cnf", $upd, $id);
		}
	}elseif(isset($data["id"]))
	{
		echo json_encode($txt->arch_dev->$id_lng.$err);
		return;
	}
}
?>
