<?php
$flg_err_crc = false;
$rq_sel_mdl = select("id,id_cat,nom,titre,dsc,fus","dev_mdl","id_crc",$id_dev_crc,"ord");
$ord_mdl = 1;
while($dt_sel_mdl = ftc_ass($rq_sel_mdl)){
	$id_cat_mdl = $dt_sel_mdl['id_cat'];
	$fus_mdl = $dt_sel_mdl['fus'];
	if($id_cat_mdl==0){
		$id_dev_mdl = $dt_sel_mdl['id'];
		if($dt_sel_mdl['nom']=='' or empty($dt_sel_mdl['nom'])){$nom_mdl = $nom_crc.' / '.$txt->mdl->$id_lng.' '.$ord_mdl;}
		else{$nom_mdl = $dt_sel_mdl['nom'];}
		include("grd_mdl.php");
	}
	if($id_cat_mdl > 0){
		$mdl_id[] = $id_cat_mdl;
		$mdl_ord[] = $ord_mdl;
		$mdl_fus[] = $fus_mdl;
		$ord_mdl++;
	}
	else{
		$flg_err_crc = true;
		$id_cat_crc = 0;
	}
}
if(!$flg_err_crc){
	$id_cat_crc = insert("cat_crc",array("nom",'dt_cat','usr'),array($nom_crc,date("Y-m-d"),$id_usr));
	insert("cat_crc_txt",array("id_crc","lgg","titre","dsc"),array($id_cat_crc,$id_lgg,$dt_sel_crc['titre'],$dt_sel_crc['dsc']));
	upd_quo("dev_crc",array("id_cat","nom"),array($id_cat_crc,$nom_crc),$id_dev_crc);
	if(isset($mdl_id)){
		foreach($mdl_id as $i => $mdl_id_cat){insert("cat_crc_mdl",array("id_crc","id_mdl","ord","fus"),array($id_cat_crc,$mdl_id_cat,$mdl_ord[$i],$mdl_fus[$i]));}
		unset($mdl_id,$mdl_ord,$mdl_fus);
	}
}
?>
