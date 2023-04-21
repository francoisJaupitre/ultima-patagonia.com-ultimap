<?php
$id_cat_prs = insert("cat_prs",array("ctg","nom","jours",'dt_cat','usr'),array($dt_sel_prs['ctg'],$nom_prs,1,date("Y-m-d"),$id_usr));
insert("cat_prs_txt",array("id_prs","lgg","titre","dsc"),array($id_cat_prs,$id_lgg,$dt_sel_prs['titre'],$dt_sel_prs['dsc']));
upd_quo("dev_prs",array("id_cat","nom"),array($id_cat_prs,$nom_prs),$id_dev_prs);
$rq_dev_srv = select("id,id_cat,nom,id_vll,ctg,lgg,opt","dev_srv","id_prs",$id_dev_prs);
while($dt_dev_srv = ftc_ass($rq_dev_srv)){
	$id_dev_srv = $dt_dev_srv['id'];
	$id_cat_srv = $dt_dev_srv['id_cat'];
	$opt_srv = $dt_dev_srv['opt'];
	if($id_cat_srv==0){
		$id_vll = $dt_dev_srv['id_vll'];
		$ctg = $dt_dev_srv['ctg'];
		$lgg_ctg = $dt_dev_srv['lgg'];
		if($dt_dev_srv['nom']=='' or empty($dt_dev_srv['nom'])){$nom_srv = $nom_jrn.' / '.$txt->srv->$id_lng;}
		else{$nom_srv = $dt_dev_srv['nom'];}
		include("grd_srv.php");
	}
	insert("cat_prs_srv",array("id_prs","id_srv","opt"),array($id_cat_prs,$id_cat_srv,$opt_srv));
}
$rq_dev_hbr = select("id,id_cat,id_cat_chm,nom,nom_chm,id_vll,rgm","dev_hbr","id_prs",$id_dev_prs);
while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
	$id_dev_hbr = $dt_dev_hbr['id'];
	$id_cat_hbr = $dt_dev_hbr['id_cat'];
	$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
	$id_vll = $dt_dev_hbr['id_vll'];
	$id_rgm = $dt_dev_hbr['rgm'];
	if($id_cat_hbr==0){
		if($dt_dev_hbr['nom']=='' or empty($dt_dev_hbr['nom'])){$nom_hbr = $nom_jrn.' / '.$txt->hbr->$id_lng;}
		else{$nom_hbr = $dt_dev_hbr['nom'];}
		if($dt_dev_hbr['chm']='' or empty($dt_dev_hbr['chm'])){$nom_chm = $nom_hbr.' / '.$txt->chm->$id_lng;}
		else{$nom_chm = $dt_dev_hbr['chm'];}
		include("grd_hbr.php");
	}
	elseif($id_cat_hbr!=-1 and $id_cat_chm==0){
		if($dt_dev_hbr['chm']='' or empty($dt_dev_hbr['chm'])){$nom_chm = $dt_dev_hbr['nom'].' / '.$txt->chm->$id_lng;}
		else{$nom_chm = $dt_dev_hbr['chm'];}
		include("grd_chm.php");
	}
	insert("cat_prs_hbr",array("id_prs","id_hbr","id_chm","id_vll","rgm"),array($id_cat_prs,$id_cat_hbr,$id_cat_chm,$id_vll,$id_rgm));
}
?>
