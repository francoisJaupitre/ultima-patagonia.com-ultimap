<?php
$dt_jrn = ftc_ass(sel_quo("*","cat_jrn LEFT JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn AND lgg = ".$id_lgg,"cat_jrn.id",$id_cat_jrn));
$id_dev_jrn = insert("dev_jrn",array("id_mdl","id_cat","nom","ord","date","opt","titre","dsc"),array($id_dev_mdl,$id_cat_jrn,$dt_jrn['nom'],$ord_jrn,$date,$opt_jrn,$dt_jrn['titre'],$dt_jrn['dsc']));
if(empty($dt_jrn['titre'])) {$err_jrn .= $dt_jrn['nom'].",\n";}
if(!empty($dt_jrn['alerte'])) {$alt .= $dt_jrn['nom'].' : '.$dt_jrn['alerte'].",\n";}
$ord_prs = 0;
$rq_jrn_prs = sel_quo("*","cat_jrn_prs","id_jrn",$id_cat_jrn,"ord");
while($dt_jrn_prs = ftc_ass($rq_jrn_prs)) {
	if(
		$dt_jrn_prs['opt']
		or isset($data_uid['id_opt_prs'][$id_cat_jrn]) and in_array($dt_jrn_prs['id_prs'],$data_uid['id_opt_prs'][$id_cat_jrn])
	) {
		$opt_prs = 1;
		$id_cat_prs = $dt_jrn_prs['id_prs'];
		$ord_prs++;
		include("ins_prs.php");
		if($err_prs != '') {$err .= $txt->err->prs->$id_lng.$err_prs."\n";}
		if($err_hbr != '') {$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";}
		if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
		$err_prs = $err_hbr = $err_srv = '';
	}
}
?>
