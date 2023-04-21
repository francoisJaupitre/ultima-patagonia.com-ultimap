<?php
if(isset($_POST['cbl']) and isset($_POST['src']) and isset($_POST['obj']) and isset($_POST['id'])) {
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$cbl = $_POST['cbl'];
	$src = upnoac(rawurldecode($_POST['src']));
	$obj = $_POST['obj'];
	$id = $_POST['id'];
	if(substr($obj,0,3)=='lgg') {
		$id_chm = substr($obj,3);
		if($id_chm>0) {
			$id = $id_chm;
			$cbl_chm = "_chm";
		}
		else{$cbl_chm = '';}
		$rq_txt = select("*","cat_".$cbl.$cbl_chm."_txt","id_".$cbl.$cbl_chm,$id,"lgg");
		while($dt_txt = ftc_ass($rq_txt)) {$lgg_exist[] = $dt_txt['lgg'];}
		include("../prm/lgg.php");
		include("vue_lst_lgg.php");
	}
	elseif($obj=='clt') {
		$rq_clt = select("id,id_clt","cat_crc_clt","id_crc",$id);
		while($dt_clt = ftc_ass($rq_clt)) {$lst_clt[] = $dt_clt['id_clt'];}
		include("../cfg/clt.php");
		include("vue_lst_clt.php");
	}
	elseif($obj=='rgn') {
		if($cbl=='crc') {$id_rgn = $id;}
		elseif($cbl=='mdl') {
			$rq_rgn = select("id,id_rgn","cat_mdl_rgn","id_mdl",$id);
			while($dt_rgn = ftc_ass($rq_rgn)) {$lst_rgn[] = $dt_rgn['id_rgn'];}
		}
		include("../cfg/rgn.php");
		include("vue_lst_rgn.php");
	}
	elseif($obj=='mdl') {
		if($cbl=='crc') {$id_rgn = $id;}
		include("vue_lst_mdl.php");
	}
	elseif(substr($obj,0,3)=='vll') {
		if($cbl=='jrn_prs' or $cbl=='prs') {
			$ids  = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		elseif($cbl=='srv') {
			$dt_srv = ftc_ass(select("id_vll","cat_srv","id",$id));
			$id_vll = $dt_srv['id_vll'];
		}
		elseif($cbl=='hbr') {
			$dt_hbr = ftc_ass(select("id_vll","cat_hbr","id",$id));
			$id_vll = $dt_hbr['id_vll'];
		}
		elseif($cbl=='lieu') {
			$dt_lieu = ftc_ass(select("id_vll","cat_lieu","id",$id));
			$id_vll = $dt_lieu['id_vll'];
		}
		else{
			$id_vll = $id;
			if(substr($cbl,0,3)=='pic') {
				$id = substr($cbl,3);
				$cbl = 'pic';
			}
		}
		include("../cfg/vll.php");
		include("vue_lst_vll.php");
	}
	elseif($obj=='jrn') {
		if($cbl=='mdl') {$id_vll = $id;}
		if(substr($cbl,0,3)=='pic') {
			$id_vll = substr($cbl,3);
			$cbl = 'pic';
		}
		include("vue_lst_jrn.php");
	}
	elseif(substr($obj,0,7)=='jrn_opt') {
		$ids = explode("__",substr($obj,7));
		$id_jrn_sel = $ids[0];
		$ord_jrn = $ids[1];
		$jrn_opt_id = explode('_',$id);
		include("vue_lst_jrn_opt.php");
	}
	elseif($obj=='ctg_prs') {
		if($cbl=='jrn_prs') {
			$ids  = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		elseif($cbl=='prs') {$dt_prs = ftc_ass(select("ctg","cat_prs","id",$id));}
		else{$id_ctg = $id;}
		include("../prm/lgg.php");
		include("../prm/ctg_prs.php");
		include("vue_lst_ctg_prs.php");
	}
	elseif($obj=='prs') {
		if($cbl=='jrn_prs') {
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		include("vue_lst_prs.php");
	}
	elseif(substr($obj,0,7)=='prs_opt') {
		$ids = explode("__",substr($obj,7));
		$id_prs_sel = $ids[0];
		$ord_prs = $ids[1];
		$ctg_opt = $ids[2];
		$prs_opt_id = explode('_',$id);
		include("vue_lst_prs_opt.php");
	}
	elseif($obj=='lieu') {
		include("../cfg/lieu.php");
		include("vue_lst_lieu.php");
	}
	elseif($obj=='ctg_srv') {
		if($cbl=='prs') {
			$ids  = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		elseif($cbl=='srv') {
			$dt_srv = ftc_ass(select("ctg","cat_srv","id",$id));
			$id_ctg = $dt_srv['ctg'];
		}
		else{$id_ctg = $id;}
		include("../prm/lgg.php");
		include("../prm/ctg_srv.php");
		include("vue_lst_ctg_srv.php");
	}
	elseif($obj=='ctg_lgg') {
		$dt_srv = ftc_ass(select("ctg,lgg","cat_srv","id",$id));
		include("../prm/lgg.php");
		include("../prm/ctg_srv.php");
		include("vue_lst_ctg_lgg.php");
	}
	elseif($obj=='srv') {
		if($cbl=='prs') {
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		include("vue_lst_srv.php");
	}
	elseif(substr($obj,0,3)=='rgm') {
		if($cbl=='prs') {
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
		}
		elseif($cbl=='hbr') {
			$cbl_rgm = substr($obj,4,3);
			$id_chm = substr($obj,7);
			if($cbl_rgm == 'chm') {$dt_chm = ftc_ass(select("rgm","cat_hbr_chm","id",$id_chm));}
			elseif($cbl_rgm == 'hbr') {
				$rq_chm = select("rgm","cat_hbr_chm","id_hbr",$id,"","DISTINCT");
				while($dt_chm = ftc_ass($rq_chm)) {$rgm_exist['chm'][] = $dt_chm['rgm'];}
			}
			$rq_rgm = select("rgm","cat_hbr_rgm","id_hbr",$id,"","DISTINCT");
			while($dt_rgm = ftc_ass($rq_rgm)) {$rgm_exist['hbr'][] = $dt_rgm['rgm'];}
		}
		include("../prm/lgg.php");
		include("../prm/rgm.php");
		include("vue_lst_rgm.php");
	}
	elseif(substr($obj,0,3)=='hbr') {
		if($cbl=='prs') {
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
		}
		elseif($cbl=='vll') {
			$ids = explode("_",substr($obj,3));
			$id_hbr_def = $ids[0];
			$id_rgm = $ids[1];
			$dt_vll_hbr = ftc_ass(select("id_hbr","cat_vll_hbr","id_vll=".$id." AND hbr_def=".$id_hbr_def." AND rgm",$id_rgm));
			$id_hbr = $dt_vll_hbr['id_hbr'];
		}
		include("vue_lst_hbr.php");
	}
	elseif(substr($obj,0,3)=='chm') {
		if($cbl=='prs') {
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
		}
		elseif($cbl=='vll') {
			$ids = explode("_",substr($obj,3));
			$id_hbr_def = $ids[0];
			$id_rgm = $ids[1];
			$dt_vll_hbr = ftc_ass(select("id_hbr,id_chm","cat_vll_hbr","id_vll=".$id." AND hbr_def=".$id_hbr_def." AND rgm",$id_rgm));
			$id_hbr = $dt_vll_hbr['id_hbr'];
			$id_chm = $dt_vll_hbr['id_chm'];
		}
		include("vue_lst_chm.php");
	}
	elseif(substr($obj,0,3)=='crr') {
		if($cbl=='clt') {
			$dt_clt = ftc_ass(select("crr","cat_clt","id",$id));
		}
		elseif($cbl=='srv') {
			$id_trf = substr($obj,3);
			$dt_trf = ftc_ass(select("crr","cat_srv_trf","id",$id_trf));
		}
		elseif($cbl=='hbr') {
			$cbl_crr = substr($obj,4,3);
			$id_trf = substr($obj,7);
			if($cbl_crr == 'chm') {
				$dt_trf = ftc_ass(select("crr,id_chm","cat_hbr_chm_trf","id",$id_trf));
				$id_chm = $dt_trf['id_chm'];
			}
			else{$dt_trf = ftc_ass(select("crr","cat_hbr_rgm_trf","id",$id_trf));}
		}
		include("../cfg/crr.php");
		include("vue_lst_crr.php");
	}
	elseif(substr($obj,0,3)=='frn') {
		if($cbl=='srv') {
			$id_bss = substr($obj,3);
			$dt_bss = ftc_ass(select("id_frn","cat_srv_trf_bss","id",$id_bss));
			$id_frn = $dt_bss['id_frn'];
			$dt_srv = ftc_ass(select("id_vll,ctg","cat_srv","id",$id));
			$id_ctg = $dt_srv['ctg'];
			$id_vll = $dt_srv['id_vll'];
		}
		elseif($cbl=='hbr') {
			$dt_hbr = ftc_ass(select("id_vll,id_frn","cat_hbr","id",$id));
			$id_frn = $dt_hbr['id_frn'];
			$id_vll = $dt_hbr['id_vll'];
		}
		include("vue_lst_frn.php");
	}
	elseif($obj=='ctg_hbr') {
		$dt_hbr = ftc_ass(select("ctg","cat_hbr","id",$id));
		include("../prm/lgg.php");
		include("../cfg/ctg_hbr.php");
		include("vue_lst_ctg_hbr.php");
	}
	elseif($obj=='bnq') {
		if($cbl=='hbr') {
			$dt_hbr = ftc_ass(select("id_bnq","cat_hbr","id",$id));
			$id_bnq_hbr = $dt_hbr['id_bnq'];
		}
		else{$dt_frn = ftc_ass(select("id_bnq","cat_frn","id",$id));}
		include("../prm/lgg.php");
		include("../prm/pays.php");
		include("../cfg/bnq.php");
		include("vue_lst_bnq.php");
	}
	elseif($obj=='ctg_clt') {
		$dt_clt = ftc_ass(select("id_ctg","cat_clt","id",$id));
		include("../cfg/ctg_clt.php");
		include("vue_lst_ctg_clt.php");
	}
	elseif($obj=='pays') {
		if($cbl=='vll') {$dt_vll = ftc_ass(select("id_pays","cat_vll","id",$id));}
		elseif($cbl=='bnq') {$dt_vll = ftc_ass(select("id_pays","cat_bnq","id",$id));}
		include("../prm/lgg.php");
		include("../prm/pays.php");
		include("vue_lst_pays.php");
	}
}
?>
