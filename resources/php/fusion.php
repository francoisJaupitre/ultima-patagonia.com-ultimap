<?php //MAKE LAST DAY OF A MODULE AND FIRST DAY OF THE NEXT ONE GET SAME ORDER NUMBER AND DATE
$request = file_get_contents("php://input");
$data = json_decode($request, true);
include("functions.php");
include("../../prm/aut.php");
if(isset($data['val']) and isset($data['id_dev_mdl']) and $data['id_dev_mdl'] > 0 and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0)
{
	$val = $data["val"];
	$id_dev_mdl = $data["id_dev_mdl"];
	$id_dev_crc = $data["id_dev_crc"];
	$dt = ftc_ass(sel_quo("ord, fus", "dev_mdl", "id", $id_dev_mdl));
	$ord_mdl = $dt['ord'];
	$fus_mdl = $dt['fus'];
	$flg_msg = false;
	if($val == 1 and $fus_mdl == 0)
	{
		$rq_mdl = sel_quo("id, ord", "dev_mdl", "id_crc", $id_dev_crc);
		while($dt_mdl = ftc_ass($rq_mdl))
		{
			if($dt_mdl['ord'] > $ord_mdl)
			{
				$rq_jrn = sel_quo("id, ord, date", "dev_jrn", "id_mdl", $dt_mdl['id']);
				while($dt_jrn = ftc_ass($rq_jrn))
				{
					$date = $dt_jrn['date'];
					if($date != '0000-00-00')
					{
						$date = date ('Y-m-d', strtotime ("-1 days $date"));
						$flg_msg = true;
					}
					upd_noq("dev_jrn", array("ord", "date"), array("ord-1", "'".$date."'"), $dt_jrn['id']);
				}
			}
		}
		upd_noq("dev_crc", "duree", "duree-1", $id_dev_crc);
	}elseif($fus_mdl == 1)
	{
		$rq_mdl = sel_quo("id, ord", "dev_mdl", "id_crc", $id_dev_crc);
		while($dt_mdl = ftc_ass($rq_mdl))
		{
			if($dt_mdl['ord'] > $ord_mdl)
			{
				$rq_jrn = sel_quo("id, ord, date", "dev_jrn", "id_mdl", $dt_mdl['id']);
				while($dt_jrn = ftc_ass($rq_jrn))
				{
					$date = $dt_jrn['date'];
					if($date != '0000-00-00')
					{
						$date = date ('Y-m-d', strtotime ("+1 days $date"));
						$flg_msg = true;
					}
					upd_noq("dev_jrn", array("ord", "date"), array("ord+1", "'".$date."'"), $dt_jrn['id']);
				}
			}
		}
		upd_noq("dev_crc", "duree", "duree+1", $id_dev_crc);
	}
	upd_quo("dev_mdl", "fus", $val, $id_dev_mdl);
	if($flg_msg)
	{
		$txt = simplexml_load_file('../../dev/txt.xml');
		$qa = array((string)$txt->alt_fus->$id_lng);
		echo json_encode($qa);
	}
}
?>
