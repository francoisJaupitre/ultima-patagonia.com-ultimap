<?php
$res_prs = array();
$col_res_prs = array();
$rq_res_prs = sel_prm("*", "prm_res_prs");
while($dt_res_prs = ftc_ass($rq_res_prs))
{
	foreach($lgg as $i => $uid_lgg)
	{
		if($lngg[$i])
		{
			$res_prs[$uid_lgg][$dt_res_prs['id']] = $dt_res_prs['nom_'.$uid_lgg];
		}
	}
	$col_res_prs[$dt_res_prs['id']] = $dt_res_prs['col'];
}
foreach($lgg as $i => $uid_lgg)
{
	if($lngg[$i])
	{
		asort($res_prs[$uid_lgg]);
	}
}
?>
