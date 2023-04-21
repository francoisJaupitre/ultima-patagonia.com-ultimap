<?php
$flg_err_mdl = false;
$rq_sel_jrn = select("id,id_cat,nom,titre,dsc,opt","dev_jrn","id_cat>=0 AND id_mdl",$id_dev_mdl,"ord,opt");
$ord_jrn = 1;
while($dt_sel_jrn = ftc_ass($rq_sel_jrn)){
	$id_cat_jrn = $dt_sel_jrn['id_cat'];
	$opt_jrn = $dt_sel_jrn['opt'];
	if($id_cat_jrn==0){
		$id_dev_jrn = $dt_sel_jrn['id'];
		if($dt_sel_jrn['nom']=='' or empty($dt_sel_jrn['nom'])){
			$nom_jrn = $nom_mdl.' / '.$txt->jrn->$id_lng.' '.$ord_jrn;
			if(!$opt_jrn){$nom_jrn .= ' '.$txt->opt->$id_lng;}
		}
		else{$nom_jrn = $dt_sel_jrn['nom'];}
		include("grd_jrn.php");
	}
	if($id_cat_jrn >0){
		$jrn_id[] = $id_cat_jrn;
		$jrn_ord[] = $ord_jrn;
		$jrn_opt[] = $opt_jrn;
		if($opt_jrn){$ord_jrn++;}
	}
	else{
		$flg_err_mdl = true;
		$id_cat_mdl = 0;
	}
}
if(!$flg_err_mdl){
	$id_cat_mdl = insert("cat_mdl",array("nom",'dt_cat','usr'),array($nom_mdl,date("Y-m-d"),$id_usr));
	insert("cat_mdl_txt",array("id_mdl","lgg","titre","dsc"),array($id_cat_mdl,$id_lgg,$dt_sel_mdl['titre'],$dt_sel_mdl['dsc']));
	while($dt_rgn = ftc_ass(sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl))){insert("cat_mdl_rgn",array("id_mdl","id_rgn"),array($id_cat_mdl,$dt_rgn['id_rgn']));}
	upd_quo("dev_mdl",array("id_cat","nom"),array($id_cat_mdl,$nom_mdl),$id_dev_mdl);
	if(isset($jrn_id)){
		foreach($jrn_id as $i => $jrn_id_cat){insert("cat_mdl_jrn",array("id_mdl","id_jrn","ord","opt"),array($id_cat_mdl,$jrn_id_cat,$jrn_ord[$i],$jrn_opt[$i]));}
		unset($jrn_id,$jrn_ord,$jrn_opt);
	}
}
?>
