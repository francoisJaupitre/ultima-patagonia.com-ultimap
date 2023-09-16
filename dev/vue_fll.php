<?php
if(isset($_POST['cbl']) and isset($_POST['src']) and isset($_POST['obj']) and isset($_POST['id'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$cbl = $_POST['cbl'];
	$src = upnoac(rawurldecode($_POST['src']));
	$obj = $_POST['obj'];
	$id = $_POST['id'];
	if($obj=='grp'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(select("id_grp,id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
		$clt_crc = $dt_crc['id_clt'];
		$grp_crc = $dt_crc['id_grp'];
		include("vue_lst_grp.php");
	}
	elseif($obj=='clt'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(select("id_clt,id_grp","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
		$grp_crc = $dt_crc['id_grp'];
		$clt_crc = $dt_crc['id_clt'];
		include("../cfg/clt.php");
		include("vue_lst_clt.php");
	}
	elseif($obj=='lgg'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(select("lgg","dev_crc","id",$id_dev_crc));
		$lgg_crc = $dt_crc['lgg'];
		include("vue_lst_lgg.php");
	}
	elseif($obj=='crr'){
		$dt_crr = ftc_ass(select("crr","dev_crc","id",$id));
		$id_crr_crc = $dt_crr['crr'];
		$id_dev_crc = $id;
		include("../cfg/crr.php");
		include("vue_lst_crr.php");
	}
	elseif($obj=='hbr_def'){
		include("../cfg/hbr_def.php");
		include("vue_lst_hbr_def.php");
	}
	elseif(substr($obj,0,12)=='crc_pax_room'){
		$dt_rmn_pax = ftc_ass(select("id,room","dev_crc_rmn_pax","id",substr($obj,12)));
		include("../prm/room.php");
		include("vue_lst_room.php");
	}
	elseif($obj=='crc_pax'){
		$id_dev_crc = $id;
		$dt_crc = ftc_ass(select("id_grp","dev_crc","id",$id_dev_crc));
		$grp_crc = $dt_crc['id_grp'];
		$rq_pax = select("id_pax","dev_crc_pax","id_crc",$id_dev_crc);
		while($dt_pax = ftc_ass($rq_pax)){$lst_pax[] = $dt_pax['id_pax'];}
		include("vue_lst_pax.php");
	}
	elseif(substr($obj,0,7)=='crc_rgn'){
		$id_dev_crc = substr($obj,7);
		$id_rgn = $id;
		include("../cfg/rgn.php");
		include("vue_lst_rgn.php");
	}
	elseif(substr($obj,0,3)=='mdl'){
		if($cbl=='crc'){
			$id_dev_crc = substr($obj,3);
			$id_rgn = $id;
			$dt_cat_crc = ftc_ass(select("id_cat","dev_crc","id",$id_dev_crc));
			$id_cat_crc = $dt_cat_crc['id_cat'];
			include("vue_lst_mdl.php");
		}
		elseif(substr($obj,0,7)=='mdl_vll'){
			$id_dev_mdl = substr($obj,7);
			$id_vll = $id;
			$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
			while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
			include("../cfg/vll.php");
			unset($ids_rgn);
			include("vue_lst_vll.php");
		}
		elseif(substr($obj,0,12)=='mdl_pax_room'){
			$dt_rmn_pax = ftc_ass(select("id,room","dev_mdl_rmn_pax","id",substr($obj,12)));
			include("../prm/room.php");
			include("vue_lst_room.php");
		}
		elseif(substr($obj,0,7)=='mdl_pax'){
			$id_dev_mdl = substr($obj,7);
			$id_dev_crc = $id;
			$dt_crc = ftc_ass(select("id_grp","dev_crc","id",$id_dev_crc));
			$grp_crc = $dt_crc['id_grp'];
			$rq_pax = select("id_pax","dev_mdl_pax","id_mdl",$id_dev_mdl);
			while($dt_pax = ftc_ass($rq_pax)){$lst_pax[] = $dt_pax['id_pax'];}
			include("vue_lst_pax.php");
		}
		elseif(substr($obj,0,7)=='mdl_rgn'){
			$id_dev_mdl = substr($obj,7);
			$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
			while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
			include("../cfg/rgn.php");
			include("vue_lst_rgn.php");
		}
	}
	elseif(substr($obj,0,11)=='vll_jrn_rpl'){
		$id_sel_jrn = substr($obj,11);
		$id_vll = $id;
		$dt_jrn = ftc_ass(sel_quo("id_cat,id_mdl","dev_jrn","id",$id_sel_jrn));
		$id_cat_jrn = $dt_jrn['id_cat'];
		if($id_cat_jrn > 0){
			$ids_rgn = array();
			$rq_vll = sel_quo("id_rgn","cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id","id_jrn",$id_cat_jrn);
			while($dt_vll = ftc_ass($rq_vll)){$ids_rgn[] = $dt_vll['id_rgn'];}
		}
		else{
			$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$dt_jrn['id_mdl']);
			while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
		}
		include("../cfg/vll.php");
		unset($ids_rgn);
		include("vue_lst_vll.php");
	}
	elseif(substr($obj,0,3)=='jrn'){
		if(substr($obj,0,7)=='jrn_rpl'){
			$ids = explode('__',$id);
			$id_vll = $ids[0];
			$jrn_rpl_id_cat = explode('_',$ids[1]);
			$id = $id_sel_jrn = substr($obj,7);
			$dt_jrn = ftc_ass(sel_quo("dev_jrn.ord,id_mdl,dev_mdl.id_cat","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_sel_jrn));
			$ord_jrn = $dt_jrn['ord'];
			$id_dev_mdl = $dt_jrn['id_mdl'];
			$id_cat_mdl = $dt_jrn['id_cat'];
			include("vue_lst_jrn.php");
		}
		elseif(substr($obj,0,11)=='jrn_mdl_opt'){
			$id_dev_mdl = substr($obj,11);
			$dt_mdl = ftc_ass(sel_quo("id_cat","dev_mdl","id",$id_dev_mdl));
			$id_cat_mdl = $dt_mdl['id_cat'];
			if($id_cat_mdl > 0){include("vue_lst_jrn_mdl_opt.php");}
		}
		elseif(substr($obj,0,7)=='jrn_mdl'){
			$id_vll = $id;
			$id = $id_dev_mdl = substr($obj,7);
			$dt_cat_mdl = ftc_ass(sel_quo("id_cat","dev_mdl","id",$id_dev_mdl));
			$id_cat_mdl = $dt_cat_mdl['id_cat'];
			include("vue_lst_jrn.php");
		}
		elseif(substr($obj,0,7)=='jrn_vll'){
			$id_dev_jrn = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_prs = $ids[1];
			include("../cfg/vll.php");
			include("vue_lst_vll.php");
		}

		elseif($cbl=='jrn_opt'){
			$ids = explode('__',substr($obj,7));
			$id_dev_mdl = $ids[0];
			$ord_jrn = $ids[1];
			$id_sel_jrn = $ids[2];
			$dt_jrn = ftc_ass(select("dev_jrn.id_cat AS id_cat_jrn,dev_mdl.id_cat AS id_mdl","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_mdl.id=".$id_dev_mdl." AND dev_jrn.ord",$ord_jrn));
			$id_cat_jrn_sel = $dt_jrn['id_cat_jrn'];
			$id_cat_mdl =  $dt_jrn['id_mdl'];
			$jrn_opt_id_cat = explode('_',$id);
			include("vue_lst_jrn_opt.php");
		}
		elseif($cbl=='jrn'){
			$id_dev_jrn = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_prs = $ids[1];
			if(substr($obj,0,7)=='jrn_vll'){
				include("../cfg/vll.php");
				include("vue_lst_vll.php");
			}
			elseif(substr($obj,0,7)=='jrn_ctg'){
				include("../prm/ctg_prs.php");
				include("vue_lst_ctg_prs.php");
			}
		}
	}
	elseif(substr($obj,0,7)=='pic_rgn'){
		$id_dev_jrn = substr($obj,7);
		$id_rgn = $id;
		include("../cfg/rgn.php");
		include("vue_lst_rgn.php");
	}
	elseif(substr($obj,0,3)=='prs'){
		if($cbl=='jrn'){
			$id_dev_jrn = substr($obj,3);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_prs = $ids[1];
			$dt_cat_jrn = ftc_ass(select("id_cat,id_mdl","dev_jrn","id",$id_dev_jrn));
			$id_cat_jrn = $dt_cat_jrn['id_cat'];
			$id_dev_mdl = $dt_cat_jrn['id_mdl'];
			include("vue_lst_prs.php");
		}
		elseif($cbl=='prs_prs_opt'){
			$ids = explode('__',substr($obj,11));
			$id_dev_jrn = $ids[0];
			$ord_prs = $ids[1];
			$id_ant_prs = $ids[2];
			$dt_prs = ftc_ass(select("dev_prs.id_cat AS id_cat_prs,dev_prs.ctg,dev_jrn.id_cat AS id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","dev_jrn.id=".$id_dev_jrn." AND dev_prs.ord",$ord_prs));
			$id_cat_prs_sel = $dt_prs['id_cat_prs'];
			$id_cat_jrn =  $dt_prs['id_jrn'];
			$id_ctg_prs_sel = $dt_prs['ctg'];
			$prs_opt_id_cat = explode('_',$id);
			include("vue_lst_prs_prs_opt.php");
		}
		elseif($cbl=='prs_jrn_opt'){
			$id_dev_jrn = substr($obj,11);
			$dt_jrn = ftc_ass(select("id_cat","dev_jrn","id",$id_dev_jrn));
			$id_cat_jrn = $dt_jrn['id_cat'];
			include("vue_lst_prs_jrn_opt.php");
		}
		elseif(substr($obj,0,7)=='prs_res'){
			$id_dev_prs = substr($obj,7);
			$dt_prs = ftc_ass(select("id_jrn,id_cat,res,ord","dev_prs","id",$id_dev_prs));
			$id_dev_jrn = $dt_prs['id_jrn'];
			$id_cat_prs = $dt_prs['id_cat'];
			$id_res_prs = $dt_prs['res'];
			$ord_prs = $dt_prs['ord'];
			include("../prm/res_prs.php");
			include("vue_lst_res_prs.php");
			}
		elseif(substr($obj,0,7)=='prs_vll'){
			$id_dev_prs = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_srv = $ids[1];
			$id_rgm = $ids[2];
			$id_hbr = $ids[3];
			include("../cfg/vll.php");
			include("vue_lst_vll.php");
			}
		elseif(substr($obj,0,7)=='prs_ctg'){
			$id_dev_prs = substr($obj,7);
			$dt_prs = ftc_ass(sel_quo("ctg","dev_prs","id",$id_dev_prs));
			$id_ctg_prs = $dt_prs['ctg'];
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_srv = $ids[1];
			$id_rgm = $ids[2];
			$id_hbr = $ids[3];
			include("../prm/ctg_srv.php");
			include("vue_lst_ctg_srv.php");
		}
		elseif(substr($obj,0,7)=='prs_srv'){
			$id_dev_prs = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_srv = $ids[1];
			include("vue_lst_srv.php");
		}
		elseif(substr($obj,0,7)=='prs_rgm'){
			$id_dev_prs = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_ctg_srv = $ids[1];
			$id_rgm = $ids[2];
			$id_hbr = $ids[3];
			include("../prm/rgm.php");
			include("vue_lst_rgm.php");
		}
		elseif(substr($obj,0,7)=='prs_hbr'){
			$id_dev_hbr = 0;
			$id_dev_prs = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
			$id_ctg_srv = 1;
			include("vue_lst_hbr.php");
		}
		elseif(substr($obj,0,7)=='prs_chm'){
			$id_dev_hbr = 0;
			$id_dev_prs = substr($obj,7);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
			$id_ctg_srv = 1;
			include("vue_lst_chm.php");
		}
	}
	elseif(substr($obj,0,7)=='ctg_prs'){
		$id_dev_prs = substr($obj,7);
		$dt_prs = ftc_ass(select("ctg","dev_prs","id",$id_dev_prs));
		$id_ctg_prs = $dt_prs['ctg'];
		include("../prm/ctg_prs.php");
		include("vue_lst_ctg_prs.php");
	}
	elseif(substr($obj,0,3)=='srv'){
		if(substr($obj,0,7)=='srv_vll'){
			$id_dev_srv = substr($obj,7);
			$dt_srv = ftc_ass(select("id_vll","dev_srv","id",$id_dev_srv));
			$id_vll = $dt_srv['id_vll'];
			include("../cfg/vll.php");
			include("vue_lst_vll.php");
			}
		elseif(substr($obj,0,7)=='srv_ctg'){
			$id_dev_srv = substr($obj,7);
			$dt_srv = ftc_ass(select("ctg","dev_srv","id",$id_dev_srv));
			$id_ctg_srv = $dt_srv['ctg'];
			include("../prm/ctg_srv.php");
			include("vue_lst_ctg_srv.php");
		}
		elseif(substr($obj,0,7)=='srv_crr'){
			$id_dev_srv = substr($obj,7);
			$dt_srv = ftc_ass(select("crr","dev_srv","id",$id_dev_srv));
			$id_crr = $dt_srv['crr'];
			include("../cfg/crr.php");
			include("vue_lst_crr.php");
		}
		elseif(substr($obj,0,7)=='srv_res'){
			$id_dev_srv = substr($obj,7);
			$dt_srv = ftc_ass(select("res,id_prs,id_frn","dev_srv","id",$id_dev_srv));
			$id_res = $dt_srv['res'];
			$id_dev_prs = $dt_srv['id_prs'];
			include("../prm/res_srv.php");
			include("vue_lst_res_srv.php");
			}
		elseif(substr($obj,0,11)=='srv_pay_crr'){
			$id_srv_pay = substr($obj,11);
			$dt_srv_pay = ftc_ass(select("crr","dev_srv_pay","id",$id_srv_pay));
			$id_crr = $dt_srv_pay['crr'];
			include("../cfg/crr.php");
			include("vue_lst_crr.php");
		}
	}
	elseif(substr($obj,0,3)=='frn'){
			$id_dev_srv = substr($obj,3);
			$dt_srv = ftc_ass(select("id_frn,dev_srv.ctg,id_vll,date","dev_srv INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id_dev_srv));
			$id_frn = $dt_srv['id_frn'];
			$id_ctg_srv = $dt_srv['ctg'];
			$id_vll = $dt_srv['id_vll'];
			$date_jrn = $dt_srv['date'];
			include("vue_lst_frn.php");
		}
	elseif(substr($obj,0,3)=='hbr'){
		if(substr($obj,0,7)=='hbr_vll'){
			$id_dev_hbr = substr($obj,7);
			$dt_hbr = ftc_ass(select("id_vll","dev_hbr","id",$id_dev_hbr));
			$id_vll = $dt_hbr['id_vll'];
			include("../cfg/vll.php");
			include("vue_lst_vll.php");
			}
		elseif(substr($obj,0,7)=='hbr_rgm'){
			$id_dev_hbr = substr($obj,7);
			$dt_hbr = ftc_ass(select("rgm","dev_hbr","id",$id_dev_hbr));
			$id_rgm = $dt_hbr['rgm'];
			include("../prm/rgm.php");
			include("vue_lst_rgm.php");
		}
		elseif(substr($obj,0,7)=='hbr_hbr'){
			$id_dev_hbr = substr($obj,7);
			$id_hbr = $id;
			$dt_hbr = ftc_ass(select("id_vll,rgm,id_prs","dev_hbr","id",$id_dev_hbr));
			$id_vll = $dt_hbr['id_vll'];
			$id_rgm = $dt_hbr['rgm'];
			$id_dev_prs = $dt_hbr['id_prs'];
			include("vue_lst_hbr.php");
		}
		elseif(substr($obj,0,7)=='hbr_chm'){
			$id_dev_hbr = substr($obj,7);
			$id_hbr = $id;
			$id_chm = -1;
			$dt_hbr = ftc_ass(select("id_vll,rgm,id_prs","dev_hbr","id",$id_dev_hbr));
			$id_vll = $dt_hbr['id_vll'];
			$id_rgm = $dt_hbr['rgm'];
			$id_dev_prs = $dt_hbr['id_prs'];
			include("vue_lst_chm.php");
		}
		elseif(substr($obj,0,7)=='hbr_res'){
			$id_dev_hbr = substr($obj,7);
			$dt_hbr = ftc_ass(select("res,id_prs,id_cat,id_cat_chm,rgm","dev_hbr","id",$id_dev_hbr));
			$id_res = $dt_hbr['res'];
			$id_dev_prs = $dt_hbr['id_prs'];
			$id_cat_hbr = $dt_hbr['id_cat'];
			$id_cat_chm = $dt_hbr['id_cat_chm'];
			$id_rgm = $dt_hbr['rgm'];
			include("../prm/res_srv.php");
			include("vue_lst_res_srv.php");
			}
		elseif(substr($obj,0,11)=='hbr_pay_crr'){
			$id_hbr_pay = substr($obj,11);
			$dt_hbr_pay = ftc_ass(select("crr","dev_hbr_pay","id",$id_hbr_pay));
			$id_crr = $dt_hbr_pay['crr'];
			include("../cfg/crr.php");
			include("vue_lst_crr.php");
		}
		elseif(substr($obj,0,11)=='hbr_opt_hbr'){
			$id_dev_hbr = 0;
			$id_dev_prs = substr($obj,11);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
			include("vue_lst_hbr.php");
		}
		elseif(substr($obj,0,11)=='hbr_opt_chm'){
			$id_dev_hbr = 0;
			$id_dev_prs = substr($obj,11);
			$ids = explode("_",$id);
			$id_vll = $ids[0];
			$id_rgm = $ids[1];
			$id_hbr = $ids[2];
			include("vue_lst_chm.php");
		}
	}
	elseif(substr($obj,0,7)=='chm_crr'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(select("crr_chm","dev_hbr","id",$id_dev_hbr));
		$id_crr = $dt_hbr['crr_chm'];
		include("../cfg/crr.php");
		include("vue_lst_crr.php");
	}
	elseif(substr($obj,0,7)=='rgm_crr'){
		$id_dev_hbr = substr($obj,7);
		$dt_hbr = ftc_ass(select("crr_rgm","dev_hbr","id",$id_dev_hbr));
		$id_crr = $dt_hbr['crr_rgm'];
		include("../cfg/crr.php");
		include("vue_lst_crr.php");
	}
}
?>
