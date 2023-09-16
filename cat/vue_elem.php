<?php
if(isset($_POST['id']) and isset($_POST['obj']) and isset($_POST['col'])) {
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	if($obj=='crc_txt' and $col!='titre') {
		$cbl = 'crc';
		include("vue_crc_txt.php");
	}
	elseif(substr($obj,0,7)=='crc_web') {
		$id_crc_txt = substr($obj,7);
		$dt_txt = ftc_ass(select("id,titre,lgg,web_uid,web_mdp","cat_crc_txt","id",$id_crc_txt));
		if($aut['web']) {
			$flg_web = true;
			$rq_mdp = sel_quo("web_mdp","cat_mdl_txt INNER JOIN cat_crc_mdl ON cat_mdl_txt.id_mdl = cat_crc_mdl.id_mdl",array("id_crc","lgg"),array($id,$dt_txt['lgg']));
			if(num_rows($rq_mdp)) {
				while($dt_mdp = ftc_ass($rq_mdp)) {
					if(!strlen($dt_mdp['web_mdp'])) {$flg_web = false;}
				}
			}
			else{$flg_web = false;}
		}
		else{$flg_web = false;}
		$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = explode('.',$_SERVER['HTTP_HOST']);
		if(isset($host[2])) {unset($host[0]);}
		$url .= 'www.'.implode('.',$host).'/';
		include("vue_crc_web.php");
	}
	elseif($obj=='crc_clt') {
		$cbl = 'crc';
		include("../cfg/clt.php");
		include("vue_crc_clt.php");
	}
	elseif($obj=='crc_mdl') {
		$cbl = 'crc';
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/rgn.php");
		include("../cfg/vll.php");
		include("vue_crc_mdl.php");
	}
	elseif($obj=='crc_rgn') {
		$cbl = 'crc';
		$id_rgn = $id;
		include("../cfg/rgn.php");
		include("vue_crc_rgn.php");
	}
	elseif($obj=='crc_dev') {include("vue_crc_dev.php");}
	elseif($obj=='crc_trf') {include("vue_crc_trf.php");}
	elseif($obj=='mdl_txt' and $col!='titre') {
		$cbl = 'mdl';
		include("vue_mdl_txt.php");
	}
	elseif(substr($obj,0,7)=='mdl_web') {
		$id_mdl_txt = substr($obj,7);
		$dt_txt = ftc_ass(select("id,titre,lgg,web_uid,web_mdp","cat_mdl_txt","id",$id_mdl_txt));
		$url = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = explode('.',$_SERVER['HTTP_HOST']);
		if(isset($host[2])) {unset($host[0]);}
		$url .= 'www.'.implode('.',$host).'/';
		include("vue_mdl_web.php");
	}
	elseif($obj=='mdl_rgn') {
		$cbl = 'mdl';
		include("../cfg/rgn.php");
		include("vue_mdl_rgn.php");
	}
	elseif($obj=='mdl_jrn') {
		$cbl = 'mdl';
		$dt_mdl = ftc_ass(sel_quo("sel_mdl_jrn","cat_mdl","id",$id));
		$sel_mdl_jrn = $dt_mdl['sel_mdl_jrn'];
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		include("vue_mdl_jrn.php");
	}
	elseif($obj=='mdl_vll') {
		$cbl = 'mdl';
		$ids  = explode("_",$id);
		if(isset($ids[1])) {$id_vll = $ids[0];}
		else{$id_vll = 0;}
		include("../cfg/vll.php");
		include("vue_mdl_vll.php");
	}
	elseif($obj=='mdl_crc') {include("vue_mdl_crc.php");}
	elseif($obj=='mdl_dev') {include("vue_mdl_dev.php");}
	elseif($obj=='jrn_txt' and $col!='titre') {
		$cbl = 'jrn';
		include("vue_jrn_txt.php");
	}
	elseif($obj=='mdl_trf') {include("vue_mdl_trf.php");}
	elseif($obj=='jrn_vll') {
		include("../cfg/vll.php");
		$cbl = 'jrn';
		include("vue_jrn_vll.php");
	}
	elseif($obj=='jrn_prs') {
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		include("vue_jrn_prs.php");
	}
	elseif(substr($obj,0,7)=='jrn_opt') {
		$ids = explode('__',substr($obj,7));
		$id_jrn_sel = $ids[0];
		$ord_jrn = $ids[1];
		$jrn_opt_id = explode('_',$id);
		include("vue_mdl_jrn_opt.php");
	}
	elseif($obj=='jrn_mdl') {include("vue_jrn_mdl.php");}
	elseif($obj=='jrn_dev') {include("vue_jrn_dev.php");}
	elseif($obj=='jrn_pic') {include("vue_jrn_pic.php");}
	elseif($obj=='jrn_lieu') {
		include("../cfg/lieu.php");
		include("vue_jrn_lieu.php");
	}
	elseif($obj=='jrn_prs_vll_ctg') {
		$ids  = explode("_",$id);
		if(isset($ids[1])) {
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		$cbl='jrn_prs';
		include("../cfg/vll.php");
		include("../prm/ctg_prs.php");
		include("vue_jrn_vll_prs_ctg.php");
	}
	elseif($obj=='prs_ctg') {
		$dt_prs = ftc_ass(select("ctg","cat_prs","id",$id));
		include("../prm/ctg_prs.php");
		$cbl = 'prs';
		include("vue_prs_ctg.php");
	}
	elseif($obj=='prs_txt' and $col!='titre') {
		$cbl = 'prs';
		include("vue_prs_txt.php");
	}
	elseif($obj=='prs_lieu') {
		include("../cfg/lieu.php");
		include("vue_prs_lieu.php");
	}
	elseif($obj=='prs_srv') {
		include("../prm/ctg_srv.php");
		include("../cfg/vll.php");
		include("vue_prs_srv.php");
	}
	elseif($obj=='prs_hbr') {
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		include("vue_prs_hbr.php");
	}
	elseif(substr($obj,0,7)=='prs_opt') {
		$ids = explode('__',substr($obj,7));
		$id_prs_sel = $ids[0];
		$ord_prs = $ids[1];
		$ctg_opt = $ids[2];
		$prs_opt_id = explode('_',$id);
		include("vue_jrn_prs_opt.php");
	}
	elseif($obj=='prs_jrn') {include("vue_prs_jrn.php");}
	elseif($obj=='prs_dev') {include("vue_prs_dev.php");}
	elseif($obj=='prs_vll_ctg') {
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		$ids  = explode("_",$id);
		if(isset($ids[1])) {
			$id_vll = $ids[0];
			$id_ctg = $ids[1];
		}
		else{$id_vll = 0;}
		if(isset($ids[2])) {$id_rgm = $ids[2];}
		if(isset($ids[3])) {$id_hbr = $ids[3];}
		$cbl='prs';
		include("vue_prs_vll_ctg.php");
	}
	elseif($obj=='srv_txt' and $col!='titre') {
		$cbl = 'srv';
		include("vue_srv_txt.php");
	}
	elseif($obj=='srv_vll') {
		include("../cfg/vll.php");
		$dt_srv = ftc_ass(select("id_vll","cat_srv","id",$id));
		$cbl='srv';
		$id_vll = $dt_srv['id_vll'];
		include("vue_srv_vll.php");
	}
	elseif($obj=='srv_ctg') {
		include("../prm/ctg_srv.php");
		$dt_srv = ftc_ass(select("ctg","cat_srv","id",$id));
		$id_ctg = $dt_srv['ctg'];
		$cbl = 'srv';
		include("vue_srv_ctg.php");
	}
	elseif($obj=='srv_lgg') {
		include("../prm/ctg_srv.php");
		$dt_srv = ftc_ass(select("ctg,lgg","cat_srv","id",$id));
		include("vue_srv_lgg.php");
	}
	elseif($obj=='srv_prs') {include("vue_srv_prs.php");}
	elseif($obj=='srv_dev') {include("vue_srv_dev.php");}
	elseif($obj=='dt_srv') {
		include("../cfg/crr.php");
		$dt_srv = ftc_ass(select("id_vll,ctg,vrl","cat_srv","id",$id));
		$cbl = 'srv';
		$vrl = $dt_srv['vrl'];
		$id_ctg = $dt_srv['ctg'];
		$id_vll = $dt_srv['id_vll'];
		include("../cfg/frn.php");
		include("vue_dt_srv.php");
	}
	elseif(substr($obj,0,10)=='dt_srv_crr') {
		$id_trf = $id;
		$dt_trf = ftc_ass(select("crr,vrl","cat_srv_trf INNER JOIN cat_srv ON cat_srv_trf.id_srv = cat_srv.id","cat_srv_trf.id",$id_trf));
		$cbl = 'srv';
		$vrl = $dt_srv['vrl'];
		include("../cfg/crr.php");
		include("vue_dt_srv_crr.php");
	}
	elseif(substr($obj,0,10)=='dt_srv_com') {
		$id_bss = substr($obj,10);
		$dt_bss = ftc_ass(select("trf_rck,trf_net","cat_srv_trf_bss","id",$id_bss));
		$trf_rck = $dt_bss['trf_rck'];
		$trf_net = $dt_bss['trf_net'];
		include("vue_dt_srv_com.php");
	}
	elseif(substr($obj,0,10)=='dt_srv_frn') {
		$id_bss = substr($obj,10);
		$dt_bss = ftc_ass(select("id_frn","cat_srv_trf_bss","id",$id_bss));
		$dt_srv = ftc_ass(select("id_vll,ctg,vrl","cat_srv","id",$id));
		$id_frn = $dt_bss['id_frn'];
		$cbl = 'srv';
		$vrl = $dt_srv['vrl'];
		$id_ctg = $dt_srv['ctg'];
		$id_vll = $dt_srv['id_vll'];
		include("../cfg/frn.php");
		include("vue_dt_srv_frn.php");
	}
	elseif($obj=='hbr_txt' and $col!='titre') {
		$cbl = 'hbr';
		include("vue_hbr_txt.php");
	}
	elseif($obj=='hbr_vll') {
		include("../cfg/vll.php");
		$dt_hbr = ftc_ass(select("id_vll","cat_hbr","id",$id));
		$id_vll = $dt_hbr['id_vll'];
		$cbl = 'hbr';
		include("vue_hbr_vll.php");
	}
	elseif($obj=='hbr_ctg') {
		$dt_hbr = ftc_ass(select("ctg","cat_hbr","id",$id));
		include("../cfg/ctg_hbr.php");
		include("vue_hbr_ctg.php");
	}
	elseif($obj=='hbr_nvtrf') {
		$dt_hbr = ftc_ass(select("nvtrf","cat_hbr","id",$id));
		include("vue_hbr_nvtrf.php");
	}
	elseif($obj=='hbr_frn') {
		include("../prm/ctg_res.php");
		include("../prm/pays.php");
		include("../cfg/bnq.php");
		include("../cfg/frn.php");
		$dt_hbr = ftc_ass(select("*","cat_hbr","id",$id));
		$cbl = 'hbr';
		$vrl = $dt_hbr['vrl'];
		$id_vll = $dt_hbr['id_vll'];
		$id_frn = $dt_hbr['id_frn'];
		include("vue_hbr_frn.php");
	}
	elseif($obj=='hbr_mail') {
		$dt_hbr = ftc_ass(select("mail","cat_hbr","id",$id));
		$mel_hbr = $dt_hbr['mail'];
		include("vue_hbr_mail.php");
	}
	elseif($obj=='hbr_frt_mail') {
		$dt_hbr = ftc_ass(select("mail_frt","cat_hbr","id",$id));
		$mail_frt_hbr = $dt_hbr['mail_frt'];
		include("vue_hbr_frt_mail.php");
	}
	elseif($obj=='hbr_ctg_res') {
		$dt_hbr = ftc_ass(select("id_frn,ctg_res","cat_hbr","id",$id));
		$ctg_res_hbr = $dt_hbr['ctg_res'];
		include("../prm/ctg_res.php");
		include("vue_hbr_ctg_res.php");
	}
	elseif($obj=='hbr_bnq') {
		$dt_hbr = ftc_ass(select("id_frn,id_bnq","cat_hbr","id",$id));
		$id_bnq_hbr = $dt_hbr['id_bnq'];
		include("../prm/pays.php");
		include("../cfg/bnq.php");
		$cbl = 'hbr';
		include("vue_hbr_bnq.php");
	}
	elseif($obj=='hbr_prs') {include("vue_hbr_prs.php");}
	elseif($obj=='hbr_dev') {include("vue_hbr_dev.php");}
	elseif($obj=='hbr_pay') {
		include("../cfg/crr.php");
		include("../prm/ty_delai.php");
		include("vue_hbr_pay.php");
	}
	elseif($obj=='hbr_pay_ty_delai') {
		$dt_pay = ftc_ass(select("id,ty_delai","cat_hbr_pay","id",$id));
		include("../prm/ty_delai.php");
		include("vue_hbr_pay_ty_delai.php");
	}
	elseif($obj=='hbr_chm') {
		include("../prm/rgm.php");
		include("../cfg/crr.php");
		$dt_hbr = ftc_ass(select("vrl","cat_hbr","id",$id));
		$vrl = $dt_hbr['vrl'];
		$cbl = 'hbr';
		include("vue_hbr_chm.php");
	}
	elseif(substr($obj,0,11)=='hbr_chm_txt') {
		$id_chm = $id;
		$cbl = 'hbr';
		include("vue_hbr_chm_txt.php");
	}
	elseif(substr($obj,0,11)=='hbr_chm_rgm') {
		include("../prm/rgm.php");
		$id_chm = substr($obj,11);
		$dt_chm = ftc_ass(select("rgm","cat_hbr_chm","id",$id_chm));
		$rq_rgm = select("rgm","cat_hbr_rgm","id_hbr",$id,"","DISTINCT");
		while($dt_rgm = ftc_ass($rq_rgm)) {$rgm_exist['hbr'][] = $dt_rgm['rgm'];}
		$cbl = 'hbr';
		include("vue_hbr_chm_rgm.php");
	}
	elseif(substr($obj,0,11)=='hbr_chm_crr') {
		include("../cfg/crr.php");
		$dt_trf = ftc_ass(select("crr,id_chm","cat_hbr_chm_trf","id",$id));
		$id_trf = $id;
		$id_chm = $dt_trf['id_chm'];
		$dt_hbr = ftc_ass(select("vrl","cat_hbr","id",$id));
		$vrl = $dt_hbr['vrl'];
		$cbl = 'hbr';
		include("vue_hbr_chm_crr.php");
	}
	elseif($obj=='hbr_rgm') {
		include("../prm/rgm.php");
		include("../cfg/crr.php");
		$rq_chm = select("rgm","cat_hbr_chm","id_hbr",$id,"","DISTINCT");
		while($dt_chm = ftc_ass($rq_chm)) {$rgm_exist['chm'][] = $dt_chm['rgm'];}
		$rq_rgm = select("rgm","cat_hbr_rgm","id_hbr",$id,"","DISTINCT");
		while($dt_rgm = ftc_ass($rq_rgm)) {$rgm_exist['hbr'][] = $dt_rgm['rgm'];}
		$dt_hbr = ftc_ass(select("vrl","cat_hbr","id",$id));
		$vrl = $dt_hbr['vrl'];
		$cbl = 'hbr';
		include("vue_hbr_rgm.php");
	}
	elseif(substr($obj,0,11)=='hbr_rgm_crr') {
		include("../cfg/crr.php");
		$dt_trf = ftc_ass(select("crr","cat_hbr_rgm_trf","id",$id));
		$id_trf = $id;
		$dt_hbr = ftc_ass(select("vrl","cat_hbr","id",$id));
		$vrl = $dt_hbr['vrl'];
		$cbl = 'hbr';
		include("vue_hbr_rgm_crr.php");
	}
	elseif($obj=='clt_grp') {include("vue_clt_grp.php");}
	elseif($obj=='clt_ctg') {
		$dt_clt = ftc_ass(select("id_ctg","cat_clt","id",$id));
		include("../cfg/ctg_clt.php");
		include("vue_clt_ctg.php");
	}
	elseif($obj=='clt_crr') {
		include("../cfg/crr.php");
		$dt_clt = ftc_ass(select("crr","cat_clt","id",$id));
		$cbl = 'clt';
		include("vue_clt_crr.php");
	}
	elseif($obj=='frn_mail') {
		$dt_frn = ftc_ass(select("*","cat_frn","id",$id));
		include("vue_frn_mail.php");
	}
	elseif($obj=='frn_nvtrf') {
		$dt_frn = ftc_ass(select("nvtrf","cat_frn","id",$id));
		include("vue_frn_nvtrf.php");
	}
	elseif($obj=='frn_ctg_res') {
		$dt_frn = ftc_ass(select("ctg_res","cat_frn","id",$id));
		include("../prm/ctg_res.php");
		include("vue_frn_ctg_res.php");
	}
	elseif($obj=='frn_bnq') {
		$dt_frn = ftc_ass(select("id_bnq","cat_frn","id",$id));
		include("../prm/pays.php");
		include("../cfg/bnq.php");
		$cbl = 'frn';
		include("vue_frn_bnq.php");
	}
	elseif($obj=='frn_vll') {
		include("../cfg/vll.php");
		$cbl = 'frn';
		include("vue_frn_vll.php");
	}
	elseif($obj=='frn_ctg_srv') {
		include("../prm/ctg_srv.php");
		include("vue_frn_ctg_srv.php");
	}
	elseif($obj=='frn_pay') {
		include("../cfg/crr.php");
		include("../prm/ty_delai.php");
		include("vue_frn_pay.php");
	}
	elseif($obj=='frn_pay_ty_delai') {
		$dt_pay = ftc_ass(select("id,ty_delai","cat_frn_pay","id",$id));
		include("../prm/ty_delai.php");
		include("vue_frn_pay_ty_delai.php");
	}
	elseif($obj=='frn_dev') {include("vue_frn_dev.php");}
	elseif($obj=='frn_srv') {
		include("../prm/ctg_srv.php");
		include("../cfg/vll.php");
		include("vue_frn_srv.php");
	}
	elseif($obj=='frn_hbr') {
		include("../cfg/vll.php");
		include("vue_frn_hbr.php");
	}
	elseif($obj=='frn_dsp') {
		include("vue_frn_dsp.php");
	}
	elseif($obj=='pic_rgn') {
		$dt_pic = ftc_ass(select("id_rgn","cat_pic","id",$id));
		$cbl = 'pic';
		include("../cfg/rgn.php");
		include("vue_pic_rgn.php");
	}
	elseif($obj=='pic_jrn') {include("vue_pic_jrn.php");}
	elseif(substr($obj,0,7)=='pic_vll') {
		include("../cfg/vll.php");
		$id_vll = $id;
		$id = substr($obj,7);
		$cbl = 'pic';
		include("vue_pic_vll.php");
	}
	elseif($obj=='vll_rgn') {
		$dt_vll = ftc_ass(select("id_rgn","cat_vll","id",$id));
		$cbl = 'vll';
		include("../cfg/rgn.php");
		include("vue_vll_rgn.php");
	}
	elseif(substr($obj,0,7)=='vll_hbr') {
		$cbl = 'vll';
		$ids  = explode("_",substr($obj,7));
		$id_hbr_def = $ids[0];
		$id_rgm = $ids[1];
		$dt_vll_hbr = ftc_ass(select("id_hbr,id_chm","cat_vll_hbr","id_vll=".$id." AND hbr_def=".$id_hbr_def." AND rgm",$id_rgm));
		$id_hbr = $dt_vll_hbr['id_hbr'];
		$id_chm = $dt_vll_hbr['id_chm'];
		include("vue_vll_hbr.php");
	}
	elseif($obj=='vll_pays') {
		include("../prm/pays.php");
		$dt_vll = ftc_ass(select("id_pays","cat_vll","id",$id));
		$cbl = 'vll';
		include("vue_vll_pays.php");
	}
	elseif($obj=='vll_txt') {include("vue_vll_txt.php");}
	elseif($obj=='vll_jrn') {include("vue_vll_jrn.php");}
	elseif($obj=='lieu_txt') {include("vue_lieu_txt.php");}
	elseif($obj=='lieu_vll') {
		include("../prm/pays.php");
		include("../cfg/vll.php");
		$dt_lieu = ftc_ass(select("id_vll","cat_lieu","id",$id));
		$id_vll = $dt_lieu['id_vll'];
		$cbl = 'lieu';
		include("vue_lieu_vll.php");
	}
	elseif($obj=='lieu_prs') {
		include("../prm/ctg_prs.php");
		include("vue_lieu_prs.php");
	}
	elseif($obj=='bnq_pays') {
		include("../prm/pays.php");
		$dt_bnq = ftc_ass(select("id_pays","cat_bnq","id",$id));
		$cbl = 'bnq';
		include("vue_bnq_pays.php");
	}
	else{
		$dt = ftc_ass(select($col,'cat_'.$obj,'id',$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])) {echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($col=='duree') {echo date("H:i",strtotime($dt[$col]));}
		elseif($col=='frs') {echo number_format($dt[$col]*100,2,'.','');}
		elseif($col=='trf_rck' or $col=='trf_net') {
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(select("crr","cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf","cat_srv_trf_bss.id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr']],'.','');
		}
		elseif($col=='sg_rck' or $col=='sg_net' or $col=='db_rck' or $col=='db_net' or $col=='tp_rck' or $col=='tp_net' or $col=='qd_rck' or $col=='qd_net') {
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(select("crr","cat_".$obj,"id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr']],'.','');
		}
		elseif($dt[$col]!='0000-00-00') {echo stripslashes($dt[$col]);}
	}
}
?>
