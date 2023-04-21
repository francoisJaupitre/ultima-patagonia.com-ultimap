<?php
$rq_sel_srv = select("id","dev_srv","id_prs",$id_dev_prs);
while($dt_sel_srv = ftc_ass($rq_sel_srv)){
	delete("dev_srv","id",$dt_sel_srv['id']);
	delete("dev_srv_trf","id_srv",$dt_sel_srv['id']);
	delete("dev_srv_pay","id_srv",$dt_sel_srv['id']);
}
$rq_sel_hbr = select("id","dev_hbr","id_prs",$id_dev_prs);
while($dt_sel_hbr = ftc_ass($rq_sel_hbr)){
	delete("dev_hbr","id",$dt_sel_hbr['id']);
	delete("dev_hbr_pay","id_hbr",$dt_sel_hbr['id']);
}
delete("dev_prs","id",$id_dev_prs);
?>
