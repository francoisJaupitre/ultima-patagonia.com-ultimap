<?php
if(isset($_POST['obj'])){
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	if(isset($_POST['col'])){$col = $_POST['col'];}
	$cnf = $_POST['cnf'];
	$id_dev_crc  = $_POST['id_dev_crc'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	if($obj=='crc_grp'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("id_clt,id_grp","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
		$grp_crc = $dt_crc['id_grp'];
		$clt_crc = $dt_crc['id_clt'];
		$flg_grp=true;
		$rq_grp_crc = sel_quo("dev_crc_pax.id","dev_crc_pax","id_crc",$id_dev_crc);
		if(num_rows($rq_grp_crc)>0){$flg_grp=false;}
		elseif($flg_grp){
			$rq_grp_mdl = sel_quo("dev_mdl_pax.id","dev_mdl_pax INNER JOIN dev_mdl ON dev_mdl_pax.id_mdl=dev_mdl.id","id_crc",$id_dev_crc);
			if(num_rows($rq_grp_mdl)>0){$flg_grp=false;}
			elseif($flg_grp){
				include("../prm/res_srv.php");
				$rq_grp_srv = sel_whe("dev_srv.id","dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_srv ON dev_prs.id=dev_srv.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl","dev_srv.res IN (".implode(',',$maj_grp_res_srv).") AND id_crc =".$id_dev_crc);
				if(num_rows($rq_grp_srv)>0){$flg_grp=false;}
				elseif($flg_grp){
					$rq_grp_hbr = sel_whe("dev_hbr.id","dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_hbr ON dev_prs.id=dev_hbr.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl","dev_hbr.res IN (".implode(',',$maj_grp_res_srv).") AND id_crc =".$id_dev_crc);
					if(num_rows($rq_grp_hbr)>0){$flg_grp=false;}
				}
			}
		}
		include("vue_crc_grp.php");
	}
	elseif($obj=='clt_crc'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("id_clt,id_grp","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
		$clt_crc = $dt_crc['id_clt'];
		$grp_crc = $dt_crc['id_grp'];
		$rq_grp = sel_quo("id","dev_crc","id_grp",$grp_crc);
		if(num_rows($rq_grp)>1){$flg_clt=false;}
		else{$flg_clt=true;}
		include("../cfg/clt.php");
		include("vue_crc_clt.php");
	}
	elseif($obj=='crc_lgg'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("lgg","dev_crc","id",$id_dev_crc));
		$lgg_crc = $dt_crc['lgg'];
		include("vue_crc_lgg.php");
	}
	elseif($obj=='crc_ty_mrq'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("ty_mrq","dev_crc","id",$id_dev_crc));
		$ty_mrq = $dt_crc['ty_mrq'];
		include("../prm/ty_mrq.php");
		include("vue_crc_ty_mrq.php");
	}
	elseif($obj=='crc_com'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("ty_mrq,com","dev_crc","id",$id_dev_crc));
		$ty_mrq = $dt_crc['ty_mrq'];
		$com_crc = $dt_crc['com'];
		include("vue_crc_com.php");
	}
	elseif($obj=='crc_mrq_hbr'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("ty_mrq,mrq_hbr","dev_crc","id",$id_dev_crc));
		$ty_mrq = $dt_crc['ty_mrq'];
		$mrq_hbr_crc = $dt_crc['mrq_hbr'];
		include("vue_crc_mrq_hbr.php");
	}
	elseif($obj=='crc_crr'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(sel_quo("crr","dev_crc","id",$id_dev_crc));
		$id_crr_crc = $dt_crc['crr'];
		include("../cfg/crr.php");
		include("vue_crc_crr.php");
	}
	elseif($obj=='crc_err_rmn'){
		$dt_crc = ftc_ass(sel_quo("sgl,dbl_mat,dbl_twn,tpl_mat,tpl_twn,qdp,ptl,psg","dev_crc","id",$id));
		$rq_bss_crc = sel_quo("base","dev_crc_bss",array("vue","id_crc"),array("1",$id));
		if(num_rows($rq_bss_crc)==1){
			$dt_bss_crc = ftc_ass($rq_bss_crc);
			if($dt_crc['sgl'] + ($dt_crc['dbl_mat'] + $dt_crc['dbl_twn']) * 2 + ($dt_crc['tpl_mat'] + $dt_crc['tpl_twn']) * 3 + $dt_crc['qdp'] * 4 != $dt_bss_crc['base'] + $dt_crc['ptl'] - $dt_crc['psg']) {echo $txt->err->rmn->$id_lng;}
		}
	}
	elseif(substr($obj,0,7)=='crc_rgn'){
		$id_dev_crc = substr($obj,7);
		$id_rgn = $id;
		$dt_cat_crc = ftc_ass(sel_quo("id_cat","dev_crc","id",$id_dev_crc));
		$id_cat_crc = $dt_cat_crc['id_cat'];
		$cbl = 'crc';
		include("../cfg/rgn.php");
		include("vue_crc_rgn.php");
	}
	elseif(substr($obj,0,11)=='crc_rmn_pax'){
		$ids = explode('_',substr($obj,11));
		$id_rmn = $ids[0];
		$id_pax = $ids[1];
		$cbl = 'crc';
		include("../prm/room.php");
		include("vue_rmn_pax.php");
	}
	elseif(substr($obj,0,12)=='crc_pax_room'){
		$dt_rmn_pax = ftc_ass(sel_quo("id,id_rmn,id_pax,room,nc","dev_crc_rmn_pax","id",$id));
		$id_rmn = $dt_rmn_pax['id_rmn'];
		$id_pax = $dt_rmn_pax['id_pax'];
		$cbl = 'crc';
		include("../prm/room.php");
		include("vue_pax_room.php");
	}
	elseif(substr($obj,0,11)=='mdl_err_rmn'){
		$dt_mdl = ftc_ass(sel_quo("sgl,dbl_mat,dbl_twn,tpl_mat,tpl_twn,qdp,ptl,psg","dev_mdl","id",$id));
		$rq_bss_mdl = sel_quo("base","dev_mdl_bss",array("vue","id_mdl"),array("1",$id));
		if(num_rows($rq_bss_mdl)==1){
			$dt_bss_mdl = ftc_ass($rq_bss_mdl);
			if($dt_mdl['sgl'] + ($dt_mdl['dbl_mat'] + $dt_mdl['dbl_twn']) * 2 + ($dt_mdl['tpl_mat'] + $dt_mdl['tpl_twn']) * 3 + $dt_mdl['qdp'] * 4 != $dt_bss_mdl['base'] + $dt_mdl['ptl'] - $dt_mdl['psg']) {echo $txt->err->rmn->$id_lng;}
		}
	}
	elseif(substr($obj,0,7)=='jrn_jrn'){
		$id_sel_jrn = substr($obj,7);
		$dt_jrn = ftc_ass(sel_quo("id_mdl,ord","dev_jrn","id",$id_sel_jrn));
		$id_dev_mdl = $dt_jrn['id_mdl'];
		$ord_jrn = $dt_jrn['ord'];
		$rq_jrn = sel_quo("id_cat","dev_jrn",array("id_mdl","ord"),array($id_dev_mdl,$ord_jrn));
		while($dt_jrn = ftc_ass($rq_jrn)){$jrn_rpl_id_cat[] = $dt_jrn['id_cat'];}
		include("vue_jrn_rpl.php");
	}
	elseif(substr($obj,0,7)=='rpl_jrn'){
		$id_sel_jrn = substr($obj,7);
		$dt_jrn = ftc_ass(sel_quo("id_mdl,ord","dev_jrn","id",$id_sel_jrn));
		$id_dev_mdl = $dt_jrn['id_mdl'];
		$ord_jrn = $dt_jrn['ord'];
		$rq_jrn = sel_quo("id_cat","dev_jrn",array("id_mdl","ord"),array($id_dev_mdl,$ord_jrn));
		while($dt_jrn = ftc_ass($rq_jrn)){$jrn_rpl_id_cat[] = $dt_jrn['id_cat'];}
		include("vue_rpl_jrn.php");
	}
	elseif(substr($obj,0,7)=='opt_jrn'){
		$id_sel_jrn = substr($obj,7);
		$dt_jrn = ftc_ass(sel_quo("id_mdl,ord","dev_jrn","id",$id_sel_jrn));
		$id_dev_mdl = $dt_jrn['id_mdl'];
		$ord_jrn = $dt_jrn['ord'];
		$rq_jrn = sel_quo("id_cat","dev_jrn",array("id_mdl","ord"),array($id_dev_mdl,$ord_jrn));
		while($dt_jrn = ftc_ass($rq_jrn)){$jrn_opt_id_cat[] = $dt_jrn['id_cat'];}
		include("vue_opt_jrn.php");
	}
	elseif(substr($obj,0,7)=='jrn_rpl'){
		$id_sel_jrn = substr($obj,7);
		$dt_jrn = ftc_ass(sel_quo("id_mdl,dev_jrn.ord,dev_mdl.id_cat AS id_cat_mdl,dev_jrn.id_cat AS id_cat_jrn","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_sel_jrn));
		$ord_jrn = $dt_jrn['ord'];
		$id_dev_mdl = $dt_jrn['id_mdl'];
		$id_cat_mdl = $dt_jrn['id_cat_mdl'];
		$id_cat_jrn = $dt_jrn['id_cat_jrn'];
		if($id_cat_jrn > 0){
			$ids_rgn = array();
			$rq_vll = sel_quo("id_rgn","cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id","id_jrn",$id_cat_jrn);
			while($dt_vll = ftc_ass($rq_vll)){$ids_rgn[] = $dt_vll['id_rgn'];}
		}
		include("../cfg/vll.php");
		unset($ids_rgn);
		if($id!=0){$jrn_rpl_id_cat = explode('_',$id);}
		include("vue_jrn_rpl.php");
	}
	elseif(substr($obj,0,7)=='jrn_opt'){
		$ids = explode('__',substr($obj,7));
		$id_dev_mdl = $ids[0];
		$ord_jrn = $ids[1];
		$id_sel_jrn = $ids[2];
		$dt_jrn = ftc_ass(sel_quo("dev_jrn.id_cat AS id_cat_jrn,dev_mdl.id_cat AS id_mdl","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",array("dev_mdl.id","dev_jrn.ord"),array($id_dev_mdl,$ord_jrn)));
		$id_cat_jrn_sel = $dt_jrn['id_cat_jrn'];
		$id_cat_mdl =  $dt_jrn['id_mdl'];
		$jrn_opt_id_cat = explode('_',$id);
		include("vue_jrn_opt.php");
	}
	elseif(substr($obj,0,11)=='vll_jrn_rpl'){
		$ids = explode('__',$id);
		$id_vll = $ids[0];
		$jrn_rpl_id_cat = explode('_',$ids[1]);
		$id_sel_jrn = substr($obj,11);
		$dt_jrn = ftc_ass(sel_quo("id_mdl,dev_jrn.ord,dev_mdl.id_cat AS id_cat_mdl,dev_jrn.id_cat AS id_cat_jrn","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_sel_jrn));
		$id_dev_mdl = $dt_jrn['id_mdl'];
		$id_cat_mdl = $dt_jrn['id_cat_mdl'];
		$ord_jrn = $dt_jrn['ord'];
		$id_cat_jrn = $dt_jrn['id_cat_jrn'];
		if($id_cat_jrn > 0){
			$ids_rgn = array();
			$rq_vll = sel_quo("id_rgn","cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id","id_jrn",$id_cat_jrn);
			while($dt_vll = ftc_ass($rq_vll)){$ids_rgn[] = $dt_vll['id_rgn'];}
		}
		else{
			$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
			while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
		}
		include("../cfg/vll.php");
		unset($ids_rgn);
		include("vue_jrn_vll.php");
	}
	elseif(substr($obj,0,7)=='mdl_vll'){
		$id_dev_mdl = substr($obj,7);
		$id_vll = $id;
		$dt_mdl = ftc_ass(sel_quo("id_cat","dev_mdl","id",$id_dev_mdl));
		$id_cat_mdl = $dt_mdl['id_cat'];
		$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
		while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
		include("../cfg/vll.php");
		unset($ids_rgn);
		include("vue_mdl_vll.php");
	}
	elseif(substr($obj,0,11)=='mdl_rmn_pax'){
		$ids = explode('_',substr($obj,11));
		$id_rmn = $ids[0];
		$id_pax = $ids[1];
		$cbl = 'mdl';
		include("../prm/room.php");
		include("vue_rmn_pax.php");
	}
	elseif(substr($obj,0,12)=='mdl_pax_room'){
		$dt_rmn_pax = ftc_ass(sel_quo("id,id_rmn,id_pax,room,nc","dev_mdl_rmn_pax","id",$id));
		$id_rmn = $dt_rmn_pax['id_rmn'];
		$id_pax = $dt_rmn_pax['id_pax'];
		$cbl = 'mdl';
		include("../prm/room.php");
		include("vue_pax_room.php");
	}
	elseif(substr($obj,0,7)=='pic_rgn'){
		$id_dev_jrn = substr($obj,7);
		$id_rgn = $id;
		$dt_pic = ftc_ass(sel_quo("id_pic","dev_jrn","id",$id_dev_jrn));
		$id_pic = $dt_pic['id_pic'];
		include("../cfg/rgn.php");
		include("vue_pic_rgn.php");
	}
	elseif(substr($obj,0,11)=='jrn_vll_ctg'){
		$id_dev_jrn = substr($obj,11);
		if(strpos($id,'_')!== false){
			$ids = explode("_",$id);
			if(!empty($ids[0])) {$id_vll = $ids[0];}
			else{$id_vll = 0;}
			if(!empty($ids[1])) {$id_ctg_prs = $ids[1];}
			else{$id_ctg_prs = 0;}
		}
		else{$id_vll = $id_ctg_prs = 0;}
		$dt_jrn = ftc_ass(sel_quo("id_cat,id_mdl","dev_jrn","id",$id_dev_jrn));
		$id_cat_jrn = $dt_jrn['id_cat'];
		$id_dev_mdl = $dt_jrn['id_mdl'];
		include("../prm/ctg_prs.php");
		include("../cfg/vll.php");
		include("vue_jrn_vll_ctg.php");
	}
	elseif(substr($obj,0,11)=='jrn_mdl_opt'){
		$id_dev_mdl = substr($obj,11);
		$dt_mdl = ftc_ass(sel_quo("id_cat","dev_mdl","id",$id_dev_mdl));
		$id_cat_mdl = $dt_mdl['id_cat'];
		if($id_cat_mdl>0){include("vue_jrn_mdl_opt.php");}
	}
	elseif(substr($obj,0,11)=='prs_ctg_prs'){
		$id_dev_prs = $id;
		$dt_prs = ftc_ass(sel_quo("id_cat,ctg","dev_prs","id",$id_dev_prs));
		$id_cat_prs = $dt_prs['id_cat'];
		$id_ctg_prs = $dt_prs['ctg'];
		$rq_srv = sel_quo("id","dev_srv","id_prs",$id_dev_prs);
		$nb_srv = num_rows($rq_srv);
		$rq_hbr = sel_quo("id","dev_hbr","id_prs",$id_dev_prs);
		$nb_hbr = num_rows($rq_hbr);
		include("../prm/ctg_prs.php");
		include("vue_prs_ctg_prs.php");
	}
	elseif(substr($obj,0,7)=='prs_res'){
		$id_dev_prs = $id;
		$dt_prs = ftc_ass(sel_quo("id_jrn,id_cat,res,dt_res,taux,ord","dev_prs","id",$id_dev_prs));
		$id_dev_jrn = $dt_prs['id_jrn'];
		$id_cat_prs = $dt_prs['id_cat'];
		$id_res_prs = $dt_prs['res'];
		$dt_res_prs = $dt_prs['dt_res'];
		$tx_prs = $dt_prs['taux'];
		$ord_prs = $dt_prs['ord'];
		include("../prm/res_prs.php");
		include("vue_prs_res.php");
	}
	elseif(substr($obj,0,7)=='prs_rmn'){
		$id_dev_prs = $id;
		$dt_prs = ftc_ass(sel_quo("id_rmn,trf,id_mdl,id_crc","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","dev_prs.id",$id_dev_prs));
		$trf_mdl = $dt_prs['trf'];
		$id_dev_mdl = $dt_prs['id_mdl'];
		$id_dev_crc = $dt_prs['id_crc'];
		include("vue_prs_rmn.php");
	}
	elseif(substr($obj,0,11)=='prs_vll_ctg'){
		$id_dev_prs = substr($obj,11);
		$dt_prs = ftc_ass(sel_quo("ctg","dev_prs","id",$id_dev_prs));
		$id_ctg_prs = $dt_prs['ctg'];
		if(strpos($id,'_')!== false){
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_srv = $ids[1];
			$id_rgm = $ids[2];
			$id_hbr = $ids[3];
		}
		else{$id_vll = $id_ctg_srv = $id_rgm = $id_hbr = 0;}
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		include("vue_prs_vll_ctg.php");
	}
	elseif(substr($obj,0,7)=='prs_hbr'){
		$id_dev_prs = substr($obj,7);
		$id_dev_hbr = 0;
		$ids = explode("_",$id);
		$id_vll = $ids[0];
		$id_rgm = $ids[1];
		$id_hbr = $ids[2];
		$cbl = 'hbr_opt';
		include("vue_prs_hbr.php");
	}
	elseif(substr($obj,0,11)=='opt_prs_prs'){
		$id = substr($obj,11);
		$ids = explode("_",$id);
		$id_dev_jrn = $ids[0];
		$ord_prs = $ids[1];
		$rq_prs = sel_quo("id_cat","dev_prs",array("id_jrn","ord"),array($id_dev_jrn,$ord_prs));
		while($dt_prs = ftc_ass($rq_prs)){$prs_opt_id_cat[] = $dt_prs['id_cat'];}
		$dt_ant_prs = ftc_ass(sel_quo("id","dev_prs",array("id_jrn","ord"),array($id_dev_jrn,$ord_prs),"opt DESC,nom,id"));
		$id_ant_prs = $dt_ant_prs['id'];
		include("vue_opt_prs_prs.php");
	}
	elseif(substr($obj,0,11)=='prs_prs_opt'){
		$ids = explode('__',substr($obj,11));
		$id_dev_jrn = $ids[0];
		$ord_prs = $ids[1];
		$id_ant_prs = $ids[2];
		$dt_prs = ftc_ass(sel_quo("dev_prs.id_cat AS id_cat_prs,dev_prs.ctg,dev_jrn.id_cat AS id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",array("dev_jrn.id","dev_prs.ord"),array($id_dev_jrn,$ord_prs)));
		$id_cat_prs_sel = $dt_prs['id_cat_prs'];
		$id_cat_jrn =  $dt_prs['id_jrn'];
		$id_ctg_prs_sel = $dt_prs['ctg'];
		$prs_opt_id_cat = explode('_',$id);
		include("vue_prs_prs_opt.php");
	}
	elseif(substr($obj,0,11)=='prs_jrn_opt'){
		$id_dev_jrn = substr($obj,11);
		$dt_jrn = ftc_ass(sel_quo("id_cat","dev_jrn","id",$id_dev_jrn));
		$id_cat_jrn = $dt_jrn['id_cat'];
		if($id_cat_jrn>0){include("vue_prs_jrn_opt.php");}
	}
	elseif(substr($obj,0,7)=='srv_vll'){
		$id_dev_srv = substr($obj,7);
		$dt_srv = ftc_ass(sel_quo("id_vll","dev_srv","id",$id_dev_srv));
		$id_vll = $dt_srv['id_vll'];
		include("../cfg/vll.php");
		include("vue_srv_vll.php");
	}
	elseif(substr($obj,0,7)=='srv_ctg'){
		$id_dev_srv = substr($obj,7);
		$dt_srv = ftc_ass(sel_quo("ctg","dev_srv","id",$id_dev_srv));
		$id_ctg_srv = $dt_srv['ctg'];
		include("../prm/ctg_srv.php");
		include("vue_srv_ctg_srv.php");
	}
	elseif(substr($obj,0,7)=='srv_crr'){
		$id_dev_srv = substr($obj,7);
		$dt_srv = ftc_ass(sel_quo("crr,taux","dev_srv","id",$id_dev_srv));
		$id_crr_srv = $dt_srv['crr'];
		$tx_srv = $dt_srv['taux'];
		include("../cfg/crr.php");
		include("vue_srv_crr.php");
	}
	elseif(substr($obj,0,7)=='srv_frn'){
		$id_dev_srv = substr($obj,7);
		$dt_srv = ftc_ass(sel_quo("dev_srv.res,dev_srv.ctg,id_vll,id_frn,date","dev_srv INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id_dev_srv));
		$date_jrn = $dt_srv['date'];
		$id_ctg_srv = $dt_srv['ctg'];
		$id_vll = $dt_srv['id_vll'];
		include("vue_srv_frn.php");
	}
	elseif(substr($obj,0,7)=='srv_res'){
		$id_dev_srv = substr($obj,7);
		$dt_srv = ftc_ass(sel_quo("dev_srv.res,id_prs,id_frn,rva,dev_prs.ctg","dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id_dev_srv));
		$id_dev_prs = $dt_srv['id_prs'];
		$id_ctg_prs = $dt_srv['ctg'];
		include("../prm/res_srv.php");
		include("vue_srv_res.php");
	}
	elseif(substr($obj,0,11)=='srv_pay_pay'){
		$id_dev_srv = substr($obj,11);
		include("../cfg/crr.php");
		include("vue_srv_pay.php");
	}
	elseif(substr($obj,0,11)=='srv_pay_crr'){
		$id_srv_pay = substr($obj,11);
		$dt_srv_pay = ftc_ass(sel_quo("crr","dev_srv_pay","id",$id_srv_pay));
		include("../cfg/crr.php");
		include("vue_srv_pay_crr.php");
	}
	elseif(substr($obj,0,11)=='com_srv_trf'){
		$dt_trf = ftc_ass(sel_quo("trf_rck,trf_net","dev_srv_trf","id",$id));
		$trf_rck = $dt_trf['trf_rck'];
		$trf_net = $dt_trf['trf_net'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,7)=='hbr_vll'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(sel_quo("id_vll","dev_hbr","id",$id_dev_hbr));
		$id_vll = $dt_hbr['id_vll'];
		include("../cfg/vll.php");
		include("vue_hbr_vll.php");
	}
	elseif(substr($obj,0,7)=='hbr_rgm'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(sel_quo("rgm","dev_hbr","id",$id_dev_hbr));
		$id_rgm = $dt_hbr['rgm'];
		include("../prm/rgm.php");
		include("vue_hbr_rgm.php");
	}
	elseif(substr($obj,0,7)=='hbr_hbr'){
		$id_dev_hbr = substr($obj,7);
		if($id=="_1"){$id_hbr = -1;}
		else{$id_hbr = $id;}
		$dt_hbr = ftc_ass(sel_quo("nom","cat_hbr","id",$id_hbr));
		$nom_hbr = $dt_hbr['nom'];
		$dt_hbr = ftc_ass(sel_quo("id_vll,rgm,id_prs,opt","dev_hbr","id",$id_dev_hbr));
		$id_vll = $dt_hbr['id_vll'];
		$id_rgm = $dt_hbr['rgm'];
		$id_dev_prs = $dt_hbr['id_prs'];
		$opt_hbr = $dt_hbr['opt'];
		include("vue_hbr_hbr.php");
	}
	elseif(substr($obj,0,7)=='hbr_chm'){
		$id_dev_hbr = substr($obj,7);
		if($id=="_1"){$id_hbr = -1;}
		else{$id_hbr = $id;}
		$id_chm = -1;
		$dt_hbr = ftc_ass(sel_quo("id_vll,rgm,nom_chm,crr_rgm,id_prs","dev_hbr","id",$id_dev_hbr));
		$id_vll = $dt_hbr['id_vll'];
		$id_rgm = $dt_hbr['rgm'];
		$nom_chm = $dt_hbr['nom_chm'];
		$id_dev_prs = $dt_hbr['id_prs'];
		include("../prm/rgm.php");
		include("vue_hbr_chm.php");
	}
	elseif(substr($obj,0,7)=='chm_crr'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(sel_quo("crr_chm,taux_chm","dev_hbr","id",$id_dev_hbr));
		$id_crr_chm = $dt_hbr['crr_chm'];
		$tx_chm = $dt_hbr['taux_chm'];
		include("../cfg/crr.php");
		include("vue_hbr_chm_crr.php");
	}
	elseif(substr($obj,0,7)=='rgm_crr'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(sel_quo("crr_rgm,taux_rgm","dev_hbr","id",$id_dev_hbr));
		$id_crr_rgm = $dt_hbr['crr_rgm'];
		$tx_rgm = $dt_hbr['taux_rgm'];
		include("../cfg/crr.php");
		include("vue_hbr_rgm_crr.php");
	}
	elseif(substr($obj,0,7)=='hbr_res'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(sel_quo("res,id_prs,id_cat,id_cat_chm,rgm,rva","dev_hbr","id",$id_dev_hbr));
		$id_dev_prs = $dt_hbr['id_prs'];
		$id_cat_hbr = $dt_hbr['id_cat'];
		$id_cat_chm = $dt_hbr['id_cat_chm'];
		$id_rgm = $dt_hbr['rgm'];
		include("../prm/res_srv.php");
		include("vue_hbr_res.php");
	}
	elseif(substr($obj,0,11)=='hbr_pay_pay'){
		$id_dev_hbr = substr($obj,11);
		include("../cfg/crr.php");
		include("vue_hbr_pay.php");
	}
	elseif(substr($obj,0,11)=='hbr_pay_crr'){
		$id_hbr_pay = substr($obj,11);
		$dt_hbr_pay = ftc_ass(sel_quo("crr","dev_hbr_pay","id",$id_hbr_pay));
		include("../cfg/crr.php");
		include("vue_hbr_pay_crr.php");
	}
	elseif(substr($obj,0,10)=='com_db_chm'){
		$dt_hbr = ftc_ass(sel_quo("db_rck_chm,db_net_chm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['db_rck_chm'];
		$trf_net = $dt_hbr['db_net_chm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_sg_chm'){
		$dt_hbr = ftc_ass(sel_quo("sg_rck_chm,sg_net_chm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['sg_rck_chm'];
		$trf_net = $dt_hbr['sg_net_chm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_tp_chm'){
		$dt_hbr = ftc_ass(sel_quo("tp_rck_chm,tp_net_chm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['tp_rck_chm'];
		$trf_net = $dt_hbr['tp_net_chm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_qd_chm'){
		$dt_hbr = ftc_ass(sel_quo("qd_rck_chm,qd_net_chm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['qd_rck_chm'];
		$trf_net = $dt_hbr['qd_net_chm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_db_rgm'){
		$dt_hbr = ftc_ass(sel_quo("db_rck_rgm,db_net_rgm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['db_rck_rgm'];
		$trf_net = $dt_hbr['db_net_rgm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_sg_rgm'){
		$dt_hbr = ftc_ass(sel_quo("sg_rck_rgm,sg_net_rgm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['sg_rck_rgm'];
		$trf_net = $dt_hbr['sg_net_rgm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_tp_rgm'){
		$dt_hbr = ftc_ass(sel_quo("tp_rck_rgm,tp_net_rgm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['tp_rck_rgm'];
		$trf_net = $dt_hbr['tp_net_rgm'];
		include("vue_trf_com.php");
	}
	elseif(substr($obj,0,10)=='com_qd_rgm'){
		$dt_hbr = ftc_ass(sel_quo("qd_rck_rgm,qd_net_rgm","dev_hbr","id",$id));
		$trf_rck = $dt_hbr['qd_rck_rgm'];
		$trf_net = $dt_hbr['qd_net_rgm'];
		include("vue_trf_com.php");
	}
	elseif($obj=='inf'){
		$dt_cat = ftc_ass(sel_quo("info","cat_".$col,"id",$id));
		if(empty($dt_cat['info'])){echo '[no info]';}
		else{echo '['.$dt_cat['info'].']';}
	}
	else{
		$dt = ftc_ass(sel_quo($col,'dev_'.$obj,'id',$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])){echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($col=='heure'){echo date("H:i",strtotime($dt[$col]));}
		elseif($col=='mrq' or $col=='com' or $col=='mrq_hbr' or $col=='frs'){echo number_format($dt[$col]*100,2,'.','');}
		elseif($col=='trf_rck' or $col=='trf_net'){
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(sel_quo("crr","dev_srv INNER JOIN dev_srv_trf ON dev_srv.id = dev_srv_trf.id_srv","dev_srv_trf.id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr']],'.','');
		}
		elseif($col=='sg_rck_chm' or $col=='sg_net_chm' or $col=='db_rck_chm' or $col=='db_net_chm' or $col=='tp_rck_chm' or $col=='tp_net_chm' or $col=='qd_rck_chm' or $col=='qd_net_chm'){
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(sel_quo("crr_chm","dev_".$obj,"id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr_chm']],'.','');
		}
		elseif($col=='sg_rck_rgm' or $col=='sg_net_rgm' or $col=='db_rck_rgm' or $col=='db_net_rgm' or $col=='tp_rck_rgm' or $col=='tp_net_rgm' or $col=='qd_rck_rgm' or $col=='qd_net_rgm'){
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(sel_quo("crr_rgm","dev_".$obj,"id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr_rgm']],'.','');
		}
		elseif($col=='liq'){
			include("../cfg/crr.php");
			$dt_crr = ftc_ass(sel_quo("crr","dev_".$obj,"id",$id));
			echo number_format($dt[$col],$prm_crr_dcm[$dt_crr['crr']],'.','');
		}
		elseif($dt[$col]!='0000-00-00' or $dt[$col]=='0'){echo stripslashes($dt[$col]);}
	}
}
?>
