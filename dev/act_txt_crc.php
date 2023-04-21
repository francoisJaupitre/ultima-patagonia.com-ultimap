<?php
if($id_cat_crc!=0){
	$dt_cat_crc = ftc_ass(select('nom,titre,dsc','cat_crc INNER JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc','lgg='.$id_lgg.' AND cat_crc.id',$id_cat_crc));
	if(empty($dt_cat_crc['nom'])){unset($dt_cat_crc['nom']);}
	if(empty($dt_cat_crc['titre'])){
		unset($dt_cat_crc['titre']);
		$err_crc = $dt_cat_crc['nom'].",\n";
	}
	if(empty($dt_cat_crc['dsc'])){unset($dt_cat_crc['dsc']);}
	if(!empty($dt_cat_crc)){upd_quo('dev_crc',array_keys($dt_cat_crc),array_values($dt_cat_crc),$id_dev_crc);}
}
$rq_dev_mdl = select('id,id_cat,nom,ord','dev_mdl','id_crc',$id_dev_crc);
while($dt_dev_mdl = ftc_ass($rq_dev_mdl)){
	$id_dev_mdl = $dt_dev_mdl['id'];
	$id_cat_mdl = $dt_dev_mdl['id_cat'];
	$ord_mdl = $dt_dev_mdl['ord'];
	include("act_txt_mdl.php");
}
?>
