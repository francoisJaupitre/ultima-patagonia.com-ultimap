<?php
$id_cat_prs = $_POST['id_cat_prs'];
$id_dev_jrn = $_POST['id_dev_jrn'];
$ord_prs = $_POST['ord_prs'];
$id_lgg = $_POST['lgg'];
$cnf = $_POST['cnf'];
$txt = simplexml_load_file('txt.xml');
if($_POST['ctg_prs']>0) {$ctg_prs = $_POST['ctg_prs'];}
else{$ctg_prs = 0;}
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$dt_jrn = ftc_ass(sel_quo("id_mdl,id_cat,date,ord","dev_jrn","id",$id_dev_jrn));
$id_dev_mdl = $dt_jrn['id_mdl'];
$id_cat_jrn = $dt_jrn['id_cat'];
$date = $dt_jrn['date'];
$ord_jrn = $dt_jrn['ord'];
$alt = $err = $err_prs = $err_hbr = $err_srv = '';
$ant_prs = 0;
if($ord_prs == -1) {
	$opt_prs = 0;
	$max_prs = ftc_num(sel_quo("MAX(ord)","dev_prs","id_jrn",$id_dev_jrn));
	$ord_prs = $max_prs[0] + 1;
	if($id_cat_jrn !=0) {
		$rq_cat = sel_quo("ord","cat_jrn_prs",array("id_jrn","id_prs"),array($id_cat_jrn,$id_cat_prs));
		while($dt_cat = ftc_ass($rq_cat)) {
			$rq_jrn_prs = sel_whe("id_prs,ord","cat_jrn_prs","ord >".$dt_cat['ord']." AND id_jrn=".$id_cat_jrn,"ord DESC","DISTINCT");
			while($dt_jrn_prs = ftc_ass($rq_jrn_prs)) {
				//$flg = true;
				$rq_dev_prs = sel_quo("id,id_cat,ord","dev_prs","id_jrn",$id_dev_jrn,"ord DESC");
				while($dt_dev_prs = ftc_ass($rq_dev_prs)) {
					if($dt_dev_prs['id_cat']==$dt_jrn_prs['id_prs']/* and $flg*/) {
						upd_noq("dev_prs","ord","ord+1",$dt_dev_prs['id']);
						//$flg = false;
						$ord_prs = $dt_dev_prs['ord'];
						$ant_prs = $dt_dev_prs['id'];
					}
				}
			}
		}
	}
}
elseif($ord_prs == 0) {
	if($cnf<1) {$opt_prs = 1;}
	else{$opt_prs = 0;}
	$max_prs = ftc_num(sel_quo("MAX(ord)","dev_prs","id_jrn",$id_dev_jrn));
	$ord_prs = $max_prs[0] + 1;
}
else{$opt_prs = 0;}
$dt_dev_mdl = ftc_ass(sel_quo("id_crc,trf","dev_mdl","id",$id_dev_mdl));
$dt_dev_crc = ftc_ass(sel_quo("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
$id_crr_crc = $dt_dev_crc['crr'];
if($dt_dev_mdl['trf']) {$rq_rmn = sel_quo("id","dev_mdl_rmn",array("nr","id_mdl"),array("1",$id_dev_mdl));}
else{$rq_rmn = sel_quo("id","dev_crc_rmn",array("nr","id_crc"),array("1",$dt_dev_mdl['id_crc']));}
$dt_rmn = ftc_ass($rq_rmn);
if(!empty($dt_rmn['id'])) {$id_rmn=$dt_rmn['id'];}
else{$id_rmn=0;}
if($id_cat_prs>0) {
	include("ins_prs.php");
	if($err_prs != '') {$err .= $txt->err->prs->$id_lng.$err_prs."\n";}
	if($err_hbr != '') {$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";}
	if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
	if(isset($lst_nvtrf)) {
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom) {$err .= "-> ".$nom."\n";}
	}
}
else{$id_dev_prs = insert("dev_prs",array("id_jrn","id_rmn","ord","opt","ctg"),array($id_dev_jrn,$id_rmn,$ord_prs,$opt_prs,$ctg_prs));}
echo $id_dev_prs."|".$ant_prs."|".$ord_prs."|".$err."|".$alt;
?>
