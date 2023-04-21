<?php
include("../prm/fct.php");
$id_hbr_rgm = $_POST['id_hbr_rgm'];
$rq_sel_trf = select('id','cat_hbr_rgm_trf','id_rgm',$id_hbr_rgm);
while($dt_sel_trf = ftc_ass($rq_sel_trf)) {
	delete('cat_hbr_rgm_trf',"id",$dt_sel_trf['id']);
	delete('cat_hbr_rgm_trf_ssn',"id_trf",$dt_sel_trf['id']);
}	
$dt_hbr = ftc_ass(select("id_hbr","cat_hbr_rgm","id",$id_hbr_rgm));
delete('cat_hbr_rgm',"id",$id_hbr_rgm);
$rq_chm = select("id","cat_hbr_chm","id_hbr",$dt_hbr['id_hbr']);
while($dt_chm = ftc_ass($rq_chm)) {echo $dt_chm['id'].'|';}
?>