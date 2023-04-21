<?php
$id=$_POST['id'];
$obj=$_POST['obj'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/lng.php");
switch($_POST['obj']) {
	case 'crc_clt':
		delete('cat_crc_clt',"id",$id);
		break;
	case 'mdl_rgn':
		delete('cat_mdl_rgn',"id",$id);
		break;
	case 'jrn_vll':
		$dt_jrn = ftc_ass(select("id_jrn, ord","cat_jrn_vll","id",$id));
		if(!empty($dt_jrn['id_jrn'])) {
			$id_jrn = $dt_jrn['id_jrn'];
			$ord = $dt_jrn['ord'];
			$rq_vll = select("id, ord","cat_jrn_vll","id_jrn",$id_jrn);
			while($dt_vll = ftc_ass($rq_vll)) {
				if($dt_vll['ord'] > $ord) {upd_noq("cat_jrn_vll","ord","ord-1",$dt_vll['id']);}
			}
			delete('cat_jrn_vll',"id",$id);
		}
		break;
	case 'jrn_pic':
		delete('cat_jrn_pic',"id",$id);
		break;
	case 'jrn_lieu':
		$dt_jrn = ftc_ass(select("id_jrn, ord","cat_jrn_lieu","id",$id));
		if(!empty($dt_jrn['id_jrn'])) {
			$id_jrn = $dt_jrn['id_jrn'];
			$ord = $dt_jrn['ord'];
			$rq_lieu = select("id, ord","cat_jrn_lieu","id_jrn",$id_jrn);
			while($dt_lieu = ftc_ass($rq_lieu)) {
				if($dt_lieu['ord'] > $ord) {upd_noq("cat_jrn_lieu","ord","ord-1",$dt_lieu['id']);}
			}
			delete('cat_jrn_lieu',"id",$id);
		}
		break;
	case 'prs_lieu':
		$dt_prs = ftc_ass(select("id_prs, ord","cat_prs_lieu","id",$id));
		if(!empty($dt_prs['id_prs'])) {
			$id_prs = $dt_prs['id_prs'];
			$ord = $dt_prs['ord'];
			$rq_lieu = select("id, ord","cat_prs_lieu","id_prs",$id_prs);
			while($dt_lieu = ftc_ass($rq_lieu)) {
				if($dt_lieu['ord'] > $ord) {upd_noq("cat_prs_lieu","ord","ord-1",$dt_lieu['id']);}
			}
			delete('cat_prs_lieu',"id",$id);
		}
		break;
	case 'hbr_pay':
		delete('cat_hbr_pay',"id",$id);
		break;
	case 'frn_vll':
		$dt_frn_vll = ftc_ass(select("id_frn,id_vll","cat_frn_vll","id",$id));
		$dt_srv_trf = ftc_ass(select("id_srv","cat_srv_trf_bss INNER JOIN (cat_srv_trf INNER JOIN cat_srv ON cat_srv_trf.id_srv = cat_srv.id) ON cat_srv_trf_bss.id_trf = cat_srv_trf.id","id_vll =".$dt_frn_vll['id_vll']." AND id_frn",$dt_frn_vll['id_frn']));
		if(empty($dt_srv_trf['id_srv'])) {delete('cat_frn_vll',"id",$id);}
		else{echo $txt->del_frn_vll->$id_lng;}
		break;
	case 'frn_ctg_srv':
		$dt_frn_ctg_srv = ftc_ass(select("id_frn,ctg_srv","cat_frn_ctg_srv","id",$id));
		$dt_srv_trf = ftc_ass(select("id_srv","cat_srv_trf_bss INNER JOIN (cat_srv_trf INNER JOIN cat_srv ON cat_srv_trf.id_srv = cat_srv.id) ON cat_srv_trf_bss.id_trf = cat_srv_trf.id","ctg =".$dt_frn_ctg_srv['ctg_srv']." AND id_frn",$dt_frn_ctg_srv['id_frn']));
		if(empty($dt_srv_trf['id_srv'])) {delete('cat_frn_ctg_srv',"id",$id);}
		else{echo $txt->del_frn_ctg->$id_lng;}
		break;
	case 'frn_pay':
		delete('cat_frn_pay',"id",$id);
		break;
}
?>
