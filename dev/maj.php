<?php
include("../prm/fct.php");
$tab=$_POST["tab"];
$col=$_POST["col"];
$val=$_POST["val"];
$id=$_POST["id"];
$car = substr(trim($val),0,1);
if($col=='date' or $col=='dt_min' or $col=='dt_max' or $col=='dt_min_chm' or $col=='dt_max_chm' or $col=='dt_min_rgm' or $col=='dt_max_rgm' or $col=='dob' or $col=='exp') {
	if($val!='') {
		$dt = explode('/',$val);
		if(!isset($dt[2]) or $dt[2]=='') {
			if(strtotime(date("Y").'-'.$dt[1].'-'.$dt[0])>=strtotime(date("Y-m-d"))) {$y=date("Y");}
			else{$y=date("Y")+1;}
		}
		else{$y=$dt[2];}
		$val = $y.'-'.$dt[1].'-'.$dt[0];
	}
	else{$val='0000-00-00';}
}
elseif((is_numeric($car) or $car == '(' or $car == ')' or $car == '=' or $car == '+' or $car == '-') and $col!='nom' and $col!='titre' and $col!='dsc' and $col!='notes' and $col!='rva' and $col!='info' and $col!='nc' and $tab!='dev_crc' and $tab!='dev_crc_bss' and $tab!='dev_mdl' and $tab!='dev_mdl_bss') {
	/*$val = str_replace(' ','',$val);
	$val = trim(preg_replace('/\t+/', '', $val));*/
	$val = preg_replace('/\s+/', '', $val);
	$len = strlen($val);
	$val = str_replace('=','+',$val);
	$i = 0;
	$flg = true;
	while($i < $len and $flg) {
		$car = substr($val,$i,1);
		if(is_numeric($car) or $car == '(' or $car == ')' or $car == '+' or $car == '-' or $car == '*' or $car == '/' or $car == '.' or $car == ',') {$flg = true;}
		else{$flg = false;}
		$i++;
	}
	if($flg) {
		$code = '$val='.str_replace(',','.',$val).';';
		if(@eval('return true;' . $code)) {eval($code);}
		else{
			echo $txt->errval->$id_lng;
			return;
		}
		$val=round($val,2);
	}
}
if($tab=='grp_dev' and $col=='id_clt') {
	$id_dev_crc = $id;
	$dt_crc = ftc_ass(select("id_grp","dev_crc","id",$id_dev_crc));
	$dt_clt = ftc_ass(select('id_ctg,crr,com,mrq_hbr,frs,ty_mrq','cat_clt INNER JOIN cfg_ctg_clt ON cat_clt.id_ctg = cfg_ctg_clt.id','cat_clt.id',$val));
	$id = $dt_crc['id_grp'];
	$id_crr_crc = $dt_clt['crr'];
	$id_ctg_clt = $dt_clt['id_ctg'];
	unset($dt_clt['id_ctg']);
	upd_quo('dev_crc',array_keys($dt_clt),array_values($dt_clt),$id_dev_crc);
	$rq_bss_crc = select("id,base","dev_crc_bss","id_crc",$id_dev_crc);
	while($dt_bss_crc = ftc_ass($rq_bss_crc)) {
		$dt_mrq = ftc_ass(select("mrq","cfg_mrq","bs_min <=".$dt_bss_crc['base']." AND bs_max >=".$dt_bss_crc['base']." AND id_ctg_clt",$id_ctg_clt));
		upd_quo('dev_crc_bss','mrq',$dt_mrq['mrq'],$dt_bss_crc['id']);//remplacer par id_ctg_clt dans dev_crc
	}
	$rq_bss_mdl = select("dev_mdl_bss.id,base","dev_mdl_bss INNER JOIN dev_mdl ON dev_mdl_bss.id_mdl = dev_mdl.id","id_crc",$id_dev_crc);
	while($dt_bss_mdl = ftc_ass($rq_bss_mdl)) {
		$dt_mrq = ftc_ass(select("mrq","cfg_mrq","bs_min <=".$dt_bss_mdl['base']." AND bs_max >=".$dt_bss_mdl['base']." AND id_ctg_clt",$id_ctg_clt));
		upd_quo('dev_mdl_bss','mrq',$dt_mrq['mrq'],$dt_bss_mdl['id']);//remplacer par id_ctg_clt dans dev_mdl
	}
	include("act_crr_crc.php");
}
elseif($tab=='dev_crc') {
	if(($col=='com' or $col=='mrq_hbr' or $col=='frs' or $col=='sgl' or $col=='dbl_mat' or $col=='dbl_twn' or $col=='tpl_mat' or $col=='tpl_twn' or $col=='qdp') and $val<0) {return;}
	elseif($col=='version' and $val<1) {return;}
	elseif($col=='id_grp') {
		$dt_grp = ftc_ass(select("id_clt","grp_dev","id",$val));
		$dt_clt = ftc_ass(select('id_ctg,crr,com,mrq_hbr,frs,ty_mrq','cat_clt INNER JOIN cfg_ctg_clt ON cat_clt.id_ctg = cfg_ctg_clt.id','cat_clt.id',$dt_grp['id_clt']));
		$id_dev_crc = $id;
		$id_crr_crc = $dt_clt['crr'];
		$id_ctg_clt = $dt_clt['id_ctg'];
		unset($dt_clt['id_ctg']);
		upd_quo('dev_crc',array_keys($dt_clt),array_values($dt_clt),$id);
		$rq_bss_crc = select("id,base","dev_crc_bss","id_crc",$id_dev_crc);
		while($dt_bss_crc = ftc_ass($rq_bss_crc)) {
			$dt_mrq = ftc_ass(select("mrq","cfg_mrq","bs_min <=".$dt_bss_crc['base']." AND bs_max >=".$dt_bss_crc['base']." AND id_ctg_clt",$id_ctg_clt));
			upd_quo('dev_crc_bss','mrq',$dt_mrq['mrq'],$dt_bss_crc['id']);//remplacer par id_ctg_clt dans dev_crc
		}
		$rq_bss_mdl = select("dev_mdl_bss.id,base","dev_mdl_bss INNER JOIN dev_mdl ON dev_mdl_bss.id_mdl = dev_mdl.id","id_crc",$id_dev_crc);
		while($dt_bss_mdl = ftc_ass($rq_bss_mdl)) {
			$dt_mrq = ftc_ass(select("mrq","cfg_mrq","bs_min <=".$dt_bss_mdl['base']." AND bs_max >=".$dt_bss_mdl['base']." AND id_ctg_clt",$id_ctg_clt));
			upd_quo('dev_mdl_bss','mrq',$dt_mrq['mrq'],$dt_bss_mdl['id']);//remplacer par id_ctg_clt dans dev_mdl
		}
		include("act_crr_crc.php");
		$dt_crc = ftc_ass(select("id_grp","dev_crc","id",$id_dev_crc));
		$id_grp = $dt_crc['id_grp'];
		$rq_crc = select("id","dev_crc","id_grp",$id_grp);
		$rq_pax = select("id","grp_pax","id_grp",$id_grp);
		$rq_res = select("id","grp_res","id_grp",$id_grp);
		$rq_tsk = select("id","grp_tsk","id_grp",$id_grp);
		if(num_rows($rq_crc)==1 and num_rows($rq_pax)==0 and num_rows($rq_res)==0 and num_rows($rq_tsk)==0) {delete("grp_dev","id",$id_grp);}
	}
	if($col=='psg' and $val==1) {upd_quo("dev_crc","vue_sgl","1",$id);}
	elseif($col=='ptl' and $val==0) {upd_quo("dev_crc","psg","0",$id);}
	elseif($col=='vue_sgl') {upd_quo("dev_crc","sgl","0",$id);}
	elseif($col=='vue_dbl') {upd_quo("dev_crc",array("dbl_mat","dbl_twn"),array("0","0"),$id);}
	elseif($col=='vue_tpl') {upd_quo("dev_crc",array("tpl_mat","tpl_twn"),array("0","0"),$id);}
	elseif($col=='vue_qdp') {upd_quo("dev_crc","qdp","0",$id);}
	elseif($col=='sgl' or $col=='dbl_mat' or $col=='dbl_twn' or $col=='tpl_mat' or $col=='tpl_twn' or $col=='qdp') {upd_var_noq("dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_mdl.id = dev_jrn.id_mdl) ON dev_jrn.id = dev_prs.id_jrn) ON dev_prs.id = dev_hbr.id_prs","dev_hbr.res","3","(dev_hbr.res=1 OR dev_hbr.res=2) AND trf!=1  AND id_crc",$id);}
	elseif($col=='crr') {
		$id_dev_crc = $id;
		$id_crr_crc = $val;
		include("act_crr_crc.php");
		upd_var_quo("dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_mdl.id = dev_jrn.id_mdl) ON dev_jrn.id = dev_prs.id_jrn",array("taux","sup"),array($cfg_crr_tx[$id_crr_crc],$cfg_crr_sp[$id_crr_crc]),"id_crc",$id);//taux pour vue_res_crc (costos al momento de confirmar) -> reset pour eviter bug si chg de crr apres cnf (nouvelle version)
	}
}
elseif($tab=='dev_crc_bss') {
	if($col=='vue') {
		$dt_crc = ftc_ass(select('cnf,id_crc','dev_crc INNER JOIN dev_crc_bss ON dev_crc.id = dev_crc_bss.id_crc','dev_crc_bss.id',$id));
		if($dt_crc['cnf']>0) {upd_var_quo("dev_crc_bss","vue","0","id_crc",$dt_crc['id_crc']);}
		upd_var_noq("dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_mdl.id = dev_jrn.id_mdl) ON dev_jrn.id = dev_prs.id_jrn) ON dev_prs.id = dev_srv.id_prs","dev_srv.res","3","(dev_srv.res=1 OR dev_srv.res=2) AND trf=0 AND id_crc",$dt_crc['id_crc']);
	}
	elseif($col=='mrq' and ($val>=1 or $val<0)) {return;}
}
elseif($tab=='dev_mdl') {
	if($col=='trf') {
		$id_dev_mdl = $id;
		$dt_mdl = ftc_ass(select("id_crc","dev_mdl","id",$id_dev_mdl));
		$id_dev_crc = $dt_mdl['id_crc'];
		$bss_crc = $vue_bss = $mrq_bss = array();
		$rq_bss_crc = select("*","dev_crc_bss","id_crc",$id_dev_crc);
		while($dt_bss_crc = ftc_ass($rq_bss_crc)) {
			$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
			$vue_bss[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			$mrq_bss[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
		}
		if($val==1) {
			foreach($bss_crc as $id_bss => $base) {insert("dev_mdl_bss",array("id_mdl","base","vue","mrq"),array($id_dev_mdl,$base,$vue_bss[$id_bss],$mrq_bss[$id_bss]));}
			$dt_dev_crc = ftc_ass(select("vue_sgl,vue_dbl,vue_tpl,vue_qdp,ptl,psg,sgl,dbl_mat,dbl_twn,tpl_mat,tpl_twn,qdp,com,mrq_hbr","dev_crc","id",$id_dev_crc));
			upd_quo("dev_mdl",array_keys($dt_dev_crc),array_values($dt_dev_crc),$id_dev_mdl);
		}
		else{
			include("../cfg/crr.php");
			$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$id_dev_crc));
			$id_crr_crc = $dt_dev_crc['crr'];
			$bss_mdl = array();
			$rq_bss_mdl = select("id,base,vue","dev_mdl_bss","id_mdl",$id_dev_mdl);
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)) {$bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];}
			foreach($bss_mdl as $base) {
				if(!in_array($base,$bss_crc)) {include("sup_trf_srv.php");}
			}
			foreach($bss_crc as $base) {
				if(!in_array($base,$bss_mdl)) {include("ajt_trf_srv.php");}
			}
			delete("dev_mdl_bss","id_mdl",$id_dev_mdl);
			upd_quo("dev_mdl",array("vue_sgl","vue_dbl","vue_tpl","vue_qdp","ptl","psg","sgl","dbl_mat","dbl_twn","tpl_mat","tpl_twn","qdp","com","mrq_hbr"),array("0","0","0","0","0","0","0","0","0","0","0","0","0","0"),$id_dev_mdl);
		}
		if($val==1) {$dt = ftc_ass(select("id","dev_mdl_rmn","nr=1 AND id_mdl",$id_dev_mdl));}
		else{$dt = ftc_ass(select("id","dev_crc_rmn","nr=1 AND id_crc",$id_dev_crc));}
		if(empty($dt['id'])) {upd_var_quo("dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","id_rmn","0","id_mdl",$id_dev_mdl);}
		else{upd_var_quo("dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","id_rmn",$dt['id'],"id_mdl",$id_dev_mdl);}
	}
	elseif($col=='psg' and $val==1) {upd_quo("dev_mdl","vue_sgl","1",$id);}
	elseif($col=='ptl' and $val==0) {upd_quo("dev_mdl","psg","0",$id);}
	elseif($col=='vue_sgl') {upd_quo("dev_mdl","sgl","0",$id);}
	elseif($col=='vue_dbl') {upd_quo("dev_mdl",array("dbl_mat","dbl_twn"),array("0","0"),$id);}
	elseif($col=='vue_tpl') {upd_quo("dev_mdl",array("tpl_mat","tpl_twn"),array("0","0"),$id);}
	elseif($col=='vue_qdp') {upd_quo("dev_mdl","qdp","0",$id);}
	elseif($col=='sgl' or $col=='dbl_mat' or $col=='dbl_twn' or $col=='tpl_mat' or $col=='tpl_twn' or $col=='qdp') {
		upd_var_noq("dev_hbr INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_jrn.id = dev_prs.id_jrn) ON dev_prs.id = dev_hbr.id_prs","dev_hbr.res","3","(dev_hbr.res=1 OR dev_hbr.res=2) AND id_mdl",$id);
	}
}
elseif($tab=='dev_mdl_bss') {
	if($col=='vue') {
		$dt_crc = ftc_ass(select('cnf,id_mdl','dev_crc INNER JOIN (dev_mdl INNER JOIN dev_mdl_bss ON dev_mdl.id = dev_mdl_bss.id_mdl) ON dev_crc.id = dev_mdl.id_crc','dev_mdl_bss.id',$id));
		if($dt_crc['cnf']>0) {upd_var_quo("dev_mdl_bss","vue","0","id_mdl",$dt_crc['id_mdl']);}
		upd_var_noq("dev_srv INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_jrn.id = dev_prs.id_jrn) ON dev_prs.id = dev_srv.id_prs","dev_srv.res","3","(dev_srv.res=1 OR dev_srv.res=2) AND id_mdl",$dt_crc['id_mdl']);
	}
	elseif($col=='mrq' and ($val>=1 or $val<0)) {return;}
}
elseif($tab=='dev_jrn' and $col=='opt') {
	$dt_ord_jrn = ftc_ass(sel_quo("ord","dev_jrn","id",$id));
	$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("id_mdl","opt","ord"),array($_POST["id_sup"],1,$dt_ord_jrn['ord'])));
	upd_quo("dev_jrn","opt","0",$dt_jrn['id']);
}
elseif($tab=='dev_prs') {
	if($col=='opt') {
		$id_dev_jrn = $_POST["id_sup"];
		$dt_ord_prs = ftc_ass(select("ord","dev_prs","id",$id));
		$ord_prs = $dt_ord_prs['ord'];
		$dt_prs = ftc_ass(select("id","dev_prs","id_jrn = ".$id_dev_jrn." and opt = 1 and ord",$ord_prs));
		upd_quo("dev_prs","opt","0",$dt_prs['id']);
	}
	else if($col=='heure' or $col=='info') {
		$dt_prs = ftc_ass(select("heure,info","dev_prs","id",$id));
		if(!is_null($dt_prs[$col]) and !empty($dt_prs[$col])) {
			$result = upd_var_noq("dev_srv","res","3","(res=-2 OR res=1 OR res=2) AND id_prs",$id);
			echo $result."->res_srv_chg";
			$result = upd_var_noq("dev_hbr","res","3","(res=-2 OR res=1 OR res=2) AND id_prs",$id);
			echo $result."->res_hbr_chg";
		}
	}
	else if($col=='res' and $val==1) {
		include("../cfg/crr.php");
		$id_dev_crc =
		$dt_crc = ftc_ass(select("crr","dev_crc INNER JOIN (dev_mdl INNER JOIN (dev_jrn INNER JOIN dev_prs ON dev_prs.id_jrn = dev_jrn.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_mdl.id_crc = dev_crc.id","dev_prs.id",$id));
		$id_crr_crc = $dt_crc['crr'];
		upd_quo("dev_prs",array("dt_res","taux","sup"),array(date("Y-m-d"),$cfg_crr_tx[$id_crr_crc],$cfg_crr_sp[$id_crr_crc]),$id);//taux pour vue_res_crc (costos al momento de confirmar)
	}
}
elseif($tab=='dev_srv') {
	if($col=='id_vll' or $col=='ctg') {upd_quo("dev_srv","id_frn","0",$id);}
	elseif($col=='res') {
		upd_quo("dev_srv","dt_res",date("Y-m-d"),$id);
		$dt_res = ftc_ass(select("id_grp,id_frn","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id));
		$rq_res = select("id","grp_res","id_grp=".$dt_res['id_grp']." AND id_frn",$dt_res['id_frn']);
		if(num_rows($rq_res)==0) {insert("grp_res",array("id_grp","id_frn"),array($dt_res['id_grp'],$dt_res['id_frn']));}
	}
	elseif($col=='crr') {
		$dt_srv = ftc_ass(select("dev_crc.crr","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id));
		$id_crr_crc = $dt_srv['crr'];
		$cur = $val;
		include("../cfg/crr.php");
		$id_crr = $id_crr_crc;
		include("clc_crr.php");
		upd_quo("dev_srv",array("taux","sup"),array($taux,$sup),$id);
	}
	elseif($col=='id_frn') {upd_var_quo("dev_srv_pay","fin","-1",array("fin","id_srv"),array("1",$id));}
}
elseif($tab=='dev_srv_trf' and ($col=='trf_net' or $col=='trf_rck')) {upd_quo("dev_srv_trf","est","0",$id);}
elseif($tab=='dev_srv_pay') {
	if($col=='pay' and $val=='1') {
		include("../cfg/crr.php");
		$dt_pay = ftc_ass(select("crr","dev_srv_pay","id",$id));
		upd_quo("dev_srv_pay",array("taux","sup"),array($cfg_crr_txf[$dt_pay['crr']],$cfg_crr_sp[$dt_pay['crr']]),$id);
	}
	elseif ($col != 'pay') {
		$dt = ftc_ass(select("fin","dev_srv_pay","id",$id));
		if($dt['fin']==1) {upd_quo("dev_srv_pay","fin","-1",$id);}
		if($col=='crr') {
			include("../cfg/crr.php");
			upd_quo("dev_srv_pay",array("taux","sup"),array($cfg_crr_txf[$val],$cfg_crr_sp[$val]),$id);
		}
	}
}
elseif($tab=='dev_hbr') {
	if($col == 'opt') {
		if($_POST["id_sup"]>0) {$id_dev_prs = $_POST["id_sup"];}
		else{
			$dt_hbr = ftc_ass(select("id_prs","dev_hbr",'id',$id));
			$id_dev_prs = $dt_hbr['id_prs'];
		}
		upd_var_noq("dev_hbr","opt","0","id!=".$id." AND id_prs",$id_dev_prs);
	}
	elseif($col == 'sel') {
		if($_POST["id_sup"]>0) {$id_dev_prs = $_POST["id_sup"];}
		else{
			$dt_hbr = ftc_ass(select("id_prs","dev_hbr",'id',$id));
			$id_dev_prs = $dt_hbr['id_prs'];
		}
		upd_var_noq("dev_hbr","sel","0","id!=".$id." AND id_prs",$id_dev_prs);
	}
	elseif($col == 'id_cat' and $val == '-1') {upd_quo('dev_hbr','id_cat_chm','-1',$id);}
	elseif($col=='res') {
		upd_quo("dev_hbr","dt_res",date("Y-m-d"),$id);
		$dt_res = ftc_ass(select("id_grp,dev_hbr.id_cat","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",$id));
		if($dt_res['id_cat']>0) {
			$rq_res = select("id","grp_res","id_grp=".$dt_res['id_grp']." AND id_hbr",$dt_res['id_cat']);
			if(num_rows($rq_res)==0) {insert("grp_res",array("id_grp","id_hbr"),array($dt_res['id_grp'],$dt_res['id_cat']));}
		}
	}
	elseif($col=='crr_chm') {
		$dt_hbr = ftc_ass(select("dev_crc.crr","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",$id));
		$id_crr_crc = $dt_hbr['crr'];
		$cur = $val;
		include("../cfg/crr.php");
		$id_crr = $id_crr_crc;
		include("clc_crr.php");
		upd_quo("dev_hbr",array("taux_chm","sup_chm"),array($taux,$sup),$id);
	}
	elseif($col=='crr_rgm') {
		$dt_hbr = ftc_ass(select("dev_crc.crr","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",$id));
		$id_crr_crc = $dt_hbr['crr'];
		$cur = $val;
		include("../cfg/crr.php");
		$id_crr = $id_crr_crc;
		include("clc_crr.php");
		upd_quo("dev_hbr",array("taux_rgm","sup_rgm"),array($taux,$sup),$id);
	}
}
elseif($tab=='dev_hbr_pay') {
	if($col=='pay' and $val=='1') {
		include("../cfg/crr.php");
		$dt_pay = ftc_ass(select("crr","dev_hbr_pay","id",$id));
		upd_quo("dev_hbr_pay",array("taux","sup"),array($cfg_crr_txf[$dt_pay['crr']],$cfg_crr_sp[$dt_pay['crr']]),$id);
	}
	elseif ($col != 'pay') {
		$dt = ftc_ass(select("fin","dev_hbr_pay","id",$id));
		if($dt['fin']==1) {upd_quo("dev_hbr_pay","fin","-1",$id);}
		if($col=='crr') {
			include("../cfg/crr.php");
			upd_quo("dev_hbr_pay",array("taux","sup"),array($cfg_crr_txf[$val],$cfg_crr_sp[$val]),$id);
		}
	}
}
if($col=='titre' or $col=='dsc') {
	$val = str_replace(array("[","{"),"(",$val);
	$val = str_replace(array("]","}"),")",$val);
}
if($col=='heure' and $val=='') {$res = upd_nul('dev_prs','heure',$id);}
else{$res = upd_quo($tab,$col,trim($val),$id);}
echo $res;
?>
