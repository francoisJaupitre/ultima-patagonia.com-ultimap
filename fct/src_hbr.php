<?php
include("../prm/fct.php");
$id_cat_hbr = $_POST['id_cat_hbr'];
$id_cat_chm = $_POST['id_cat_chm'];
$id_hbr_vll = $_POST['id_hbr_vll'];
$id_hbr_rgm = $_POST['id_hbr_rgm'];
$id_dev_hbr = $_POST['id_dev_hbr'];
$id_dev_prs = $_POST['id_dev_prs'];
$id_dev_crc = $_POST['id_dev_crc'];
$res = $_POST['res'];
$cnf = $_POST['cnf'];
if($id_cat_hbr == 0) {
	$dt_hbr = ftc_ass(sel_quo("id_cat,id_cat_chm,rgm","dev_hbr","id",$id_dev_hbr));
	$id_cat_hbr = $dt_hbr['id_cat'];
	$id_cat_chm = $dt_hbr['id_cat_chm'];
	$id_hbr_rgm = $dt_hbr['rgm'];
}
if($id_dev_hbr == 0 and $id_dev_prs!= 0) { //AJT OPT
	if($cnf < 1) {$dt = ftc_ass(sel_whe("id_cat,id_cat_chm,rgm,id_vll","dev_hbr","opt=1 AND id_vll > 0 AND id_prs=".$id_dev_prs));}
	else{$dt = ftc_ass(sel_whe("id_cat,id_cat_chm,rgm,id_vll","dev_hbr","sel=1 AND id_vll > 0 AND id_prs=".$id_dev_prs));}
	$id_ref_vll = $dt['id_vll'];
	$id_ref_hbr = $dt['id_cat'];
	$id_ref_chm = $dt['id_cat_chm'];
	$id_ref_rgm = $dt['rgm'];
}
$rq_mdl = sel_quo("id","dev_mdl","id_crc",$id_dev_crc);
while($dt_mdl = ftc_ass($rq_mdl)) {
	$rq_jrn = sel_quo("id","dev_jrn",array("opt","id_mdl"),array("1",$dt_mdl['id']));
	while($dt_jrn = ftc_ass($rq_jrn)) {
		$rq_prs = sel_quo("id,res,opt","dev_prs","id_jrn",$dt_jrn['id'],"","DISTINCT");
		while($dt_prs = ftc_ass($rq_prs)) {
			$flg = false;
			$rq_hbr = sel_quo("id,id_cat,id_cat_chm,id_vll,rgm,opt,sel,rgm,res","dev_hbr","id_prs",$dt_prs['id'],"opt DESC");
			while($dt_hbr = ftc_ass($rq_hbr)) {
				if($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $dt_hbr['id_vll'] == $id_hbr_vll and $dt_hbr['rgm'] == $id_hbr_rgm and $dt_hbr['id_cat'] == '-1' and $dt_hbr['id'] != $id_dev_hbr) {$arr[] = $dt_hbr['id'];} //HBR NON DEFINIS
				elseif($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $dt_hbr['id_vll'] == $id_hbr_vll and $dt_hbr['rgm'] == $id_hbr_rgm and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == '-1' and $dt_hbr['id'] != $id_dev_hbr) {$arr[] = $dt_hbr['id'];} //HBR DEFINI / CHM NON DEFINIE
				elseif($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $id_hbr_vll == 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm and $dt_hbr['id'] != $id_dev_hbr and $id_dev_prs != $dt_prs['id'] and $dt_hbr['opt'] == 0) {$arr[] = $dt_hbr['id'].'_'.$dt_prs['id'];} //SUP/SEL/OPT
				elseif($id_dev_prs!= 0 and $id_dev_hbr == 0 and $dt_prs['id'] != $id_dev_prs) { //AJT_OPT
					if((($cnf < 1 and $dt_hbr['opt'] == 1) or ($cnf > 0 and $dt_hbr['sel'] == 1)) and $dt_hbr['id_cat'] == $id_ref_hbr and $dt_hbr['id_cat_chm'] == $id_ref_chm and $dt_hbr['rgm'] == $id_ref_rgm and $dt_hbr['id_vll'] == $id_ref_vll) {$flg = true;} //AJOUTER MEME OPTION HBR
					if((($cnf < 1 and $dt_hbr['opt'] == 0) or ($cnf > 0 and $dt_hbr['sel'] == 0)) and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm) {$flg = false;} //SAUF SI EXISTE DEJA
				}
				elseif($id_dev_prs == 0 and $id_dev_hbr!= 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm and (($dt_hbr['res']!= $res and $dt_hbr['res'] != -1 and $dt_hbr['res'] != 6 and $dt_hbr['id'] != $id_dev_hbr) or ($res == 0 and $id_dev_hbr == 0))) {$arr[] = $dt_hbr['id'];} //MAJ_RES
				elseif($id_dev_prs == 0 and $id_dev_hbr == 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm) {
					if($res == 'act_trf') {$arr[] = $dt_hbr['id'];} //ACT_TRF_ALL
					elseif($res == 'sup') {$arr[] = $dt_hbr['id'].'_'.$dt_prs['id'];} //SUP_ALL
				}
			}
			if($flg) {$arr[] = $dt_prs['id'];}
		}
	}
}
if(isset($arr)) {
	$imp = implode("|",$arr);
	echo $imp;
}
else{echo 0;}
?>
