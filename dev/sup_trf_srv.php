<?php
$rq_jrn = select("id","dev_jrn","id_mdl",$id_dev_mdl);
while($dt_jrn = ftc_ass($rq_jrn)){
	$id_dev_jrn = $dt_jrn['id'];
	$rq_prs = select("id","dev_prs","id_jrn",$id_dev_jrn);
	while($dt_prs = ftc_ass($rq_prs)){
		$id_dev_prs = $dt_prs['id'];
		$rq_srv = select("id","dev_srv","id_prs",$id_dev_prs);
		while($dt_srv = ftc_ass($rq_srv)){
			$id_dev_srv = $dt_srv['id'];
			delete("dev_srv_trf","base = ".$base." and id_srv",$id_dev_srv);
		}
	}
}
?>