<?php
define('MIN_DISTANCE_FOR_NEW_MAP',2.8); //DISTANCE ENTRE 2 LIEUX POUR NOUVELLE CARTE //VALEURE ANTERIEURE 2.8 link trop long pour circuit DANON noa+atacama
$h=0;
if($cbl=='dev') {
	include("../vendor/googleAPIKey/googleAPIKey.php");
	$jawgkey = "5tgToff50LHR8AJNY5FBRXsh15kbwB1s9BkjsctoZFXrBM3tS9f1mm0urBMileyi";
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$max_mdl = ftc_num(sel_quo("MAX(ord)","dev_mdl","id_crc",$id));
	$rq_mdl = sel_quo("id,trf,fus,ord,com,mrq_hbr","dev_mdl","id_crc",$id,"ord");
}
elseif($cbl=='mdl') {
	$id_dev_mdl = $id_trf = 0;
	$dt_cfg = ftc_ass(sel_whe("mrq","cfg_mrq","bs_min <=".$base." AND bs_max >=".$base." AND id_ctg_clt=".$id_ctg_clt));
	$mrq[$id_trf][] = $dt_cfg['mrq'];
	$bss[$id_trf][] = $base;
	$ty_mrq = $ty_mrq_ctg_clt[$id_ctg_clt];
	$frs_crc = $frs_ctg_clt[$id_ctg_clt];
	$mrq_hbr = $mrq_hbr_ctg_clt[$id_ctg_clt];
	$opt_sel = 'opt';
	$rq_mdl = sel_quo("id","cat_mdl","id",$id);
}
while($dt_mdl = ftc_ass($rq_mdl)) {
	if($cbl=='dev') {
		$id_dev_mdl = $dt_mdl['id'];
		$opt_sel = 'opt';
		if($dt_mdl['trf']) {
			$rq_bss = sel_quo("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
			$id_trf = $id_dev_mdl;
			$com = $dt_mdl['com'];
			$mrq_hbr = $dt_mdl['mrq_hbr'];
		}
		else{
			$rq_bss = sel_quo("*", "dev_crc_bss","id_crc",$id,"base");
			$id_trf = 0;
			$com = $com_crc;
			$mrq_hbr = $mrq_hbr_crc;
		}
		$i=0;
		while($dt_bss = ftc_ass($rq_bss)) {
			if($dt_bss['vue'] == 1 and !isset($bss[$id_trf][$i])) {
				$bss[$id_trf][$i] = $dt_bss['base'];
				$mrq[$id_trf][$i] = $dt_bss['mrq'];
				$err_trf_srv[$id_trf][$i] = 0;
				$i++;
			}
		}
		$j=0;
		$max_jrn = ftc_num(sel_quo("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
		$rq_jrn = sel_quo("id,id_cat,ord","dev_jrn",array("opt","id_mdl"),array("1",$id_dev_mdl),"ord");
	}
	elseif($cbl=='mdl') {
		$max_jrn = ftc_num(sel_quo("MAX(ord)","cat_mdl_jrn","id_mdl",$id));
		if(!isset($sel_mdl_jrn)) {$rq_jrn = sel_quo("cat_jrn.id,ord","cat_jrn INNER JOIN cat_mdl_jrn ON cat_jrn.id = cat_mdl_jrn.id_jrn",array("id_mdl","opt"),array($id,"1"),"ord");}
		else{//prendre en compte les selection journees pour website (cat_crc_mdl)
			$whe = "id_mdl=".$id." AND (opt=1";
			foreach($sel_mdl_jrn as $id_jrn) {$whe .= " OR id_jrn=".$id_jrn;}
			$whe .= ")";
			$rq_jrn = sel_whe("cat_jrn.id,ord","cat_mdl_jrn LEFT JOIN cat_jrn ON cat_mdl_jrn.id_jrn = cat_jrn.id",$whe,"ord, opt DESC, nom");
		}
	}
	while($dt_jrn = ftc_ass($rq_jrn)) {
		$err_hbr_jrn[$id_trf][] = $dt_jrn['ord'];
		if($cbl=='dev') {
			if($dt_jrn['id_cat'] > 0 and $vue_map) {$map_jrn[]=$dt_jrn['id_cat'];}
			if(($dt_jrn['ord'] == $max_jrn[0] and ($dt_mdl['fus'] == 1 or $dt_mdl['ord'] == $max_mdl[0])) or $dt_jrn['id_cat'] == -1) {$flg_sel_hbr = true;}
			else{$flg_sel_hbr = false;}
			$ord_prs = 0;
			$rq_prs = sel_quo("id,id_cat,opt,ord,ctg,res","dev_prs","id_jrn",$dt_jrn['id'],"ord,opt DESC");
		}
		elseif($cbl=='mdl') {$rq_prs = sel_quo("cat_prs.id,ord,ctg","cat_prs INNER JOIN cat_jrn_prs ON cat_prs.id = cat_jrn_prs.id_prs",array("id_jrn","opt"),array($dt_jrn['id'],1),"ord");}
		if(isset($bss[$id_trf])) {
			foreach($bss[$id_trf] as $i => $base) {$flg_err_trf_srv[$i] = 0;}
		}
		while($dt_prs = ftc_ass($rq_prs)) {
			if($cbl=='dev') {
				$k = 0;
				$flg_sel_prs  = false;
				$id_dev_prs = $dt_prs['id'];
				$id_cat_prs = $dt_prs['id_cat'];
				if($ord_prs != $dt_prs['ord']) {
					unset($trf_srv_sel_prs,$cst_srv_sel_prs);
					$trf_db_sel_hbr = $cst_db_sel_hbr =	$trf_sg_sel_hbr = $cst_sg_sel_hbr = $trf_tp_sel_hbr = $cst_tp_sel_hbr =	$trf_qd_sel_hbr = $cst_qd_sel_hbr = 0;
					$ord_prs = $dt_prs['ord'];
				}
				if($id_trf==0) {$flg_trf_crc = true;}
			}
			else{$id_cat_prs = $dt_prs['id'];}
			if((($cbl=='mdl' or $dt_prs['opt']) and $opt_sel=='opt') or ($cbl=='dev' and $dt_prs['res']==1 and $opt_sel=='sel')) {
				unset($trf_srv_sel_prs,$cst_srv_sel_prs);
//CALCUL TARIFS SERVICES PRESTATIONS SELECTIONNEES OU CONFIRMÉES
				if($cbl=='dev') {
					if($id_cat_prs>0) {$map_prs[]=$id_cat_prs;}
					$rq_srv = sel_quo("*","dev_srv","id_prs",$id_dev_prs,"opt DESC");
				}
				elseif($cbl=='mdl') {$rq_srv = sel_quo("cat_srv.id","cat_srv INNER JOIN cat_prs_srv ON cat_srv.id = cat_prs_srv.id_srv",array("id_prs","opt"),array($dt_prs['id'],1));}
				while($dt_srv = ftc_ass($rq_srv)) {
					if($cbl=='dev') {
						$frs = $frs_crc + $dt_srv['frs'];
						$flg_sel_prs  = true;
						if($dt_srv['dt_min']!="0000-00-00") {
							$dt_min_srv = $dt_srv['dt_min'];
							$ord = $dt_jrn['ord']-1;
							if($ord>0) {$dt_min_srv = date ('Y-m-d', strtotime ("-".$ord." days $dt_min_srv"));}
							if(!isset($dt_min_crc) or $dt_min_crc < $dt_min_srv) {$dt_min_crc = $dt_min_srv;}
						}
						if($dt_srv['dt_max']!="0000-00-00") {
							$dt_max_srv = $dt_srv['dt_min'];
							$ord = $dt_jrn['ord']-1;
							if($ord>0) {$dt_max_srv = date ('Y-m-d', strtotime ("-".$ord." days $dt_max_srv"));}
							if(!isset($dt_max_crc) or $dt_max_crc > $dt_max_srv) {$dt_max_crc = $dt_max_srv;}
						}
						$cur = $dt_srv['crr'];
						$taux = $dt_srv['taux'];
						$sup = $dt_srv['sup'];
					}
					if($cbl=='mdl' or $dt_srv['opt'] == 1) {
						if(isset($bss[$id_trf])) {
							foreach($bss[$id_trf] as $i => $base) {
								$tx_mrq = $mrq[$id_trf][$i];
								if($cbl=='dev') {
									$dt_srv_trf = ftc_ass(sel_quo("trf_net,trf_rck","dev_srv_trf",array("base","id_srv"),array($base,$dt_srv['id'])));
									$net = $dt_srv_trf['trf_net'];
									$rck = $dt_srv_trf['trf_rck'];
								}
								elseif($cbl=='mdl') {
									$rq_srv_trf = sel_quo("id,crr","cat_srv_trf",array("id_srv","def"),array($dt_srv['id'],1));
									if(num_rows($rq_srv_trf)==0) {$net = 0;}
									else{
										$dt_srv_trf = ftc_ass($rq_srv_trf);
										$cur = $dt_srv_trf['crr'];
										$id_crr = $id_crr_clt;
										include("../dev/clc_crr.php");

										$dt_trf_bss = ftc_ass(sel_whe("trf_net,trf_rck,id_frn,clc","cat_srv_trf_bss","id_trf=".$dt_srv_trf['id']." AND bs_min <=".$base." AND bs_max >=".$base." AND bs_min != 0 AND bs_max != 0"));
										$net = $dt_trf_bss['trf_net'];
										$rck = $dt_trf_bss['trf_rck'];
										if($dt_trf_bss['clc']) {
											$net /= $base;
											$rck /= $base;
										}
										$dt_frn = ftc_ass(sel_quo("frs","cat_frn","id",$dt_trf_bss['id_frn']));
										$frs = $frs_crc + $dt_frn['frs'];
									}
								}
								include("clc_mrq.php");
								if(!$flg_err_trf_srv[$i]) {$flg_err_trf_srv[$i] = $err;}
								if($err and (!isset($err_sel_prs_trf_srv[$id_dev_prs][$i]) or !$err_sel_prs_trf_srv[$id_dev_prs][$i])) {$err_sel_prs_trf_srv[$id_dev_prs][$i] = $err;}
								if(isset($trf)) {
									if(isset($trf_srv_sel_prs[$i])) {$trf_srv_sel_prs[$i] += $trf;}
									else{$trf_srv_sel_prs[$i] = $trf;}
									if(isset($trf_srv[$id_trf][$i])) {$trf_srv[$id_trf][$i] += $trf;}
									else{$trf_srv[$id_trf][$i] = $trf;}
								}
								if(isset($cst)) {
									if(isset($cst_srv_sel_prs[$i])) {$cst_srv_sel_prs[$i] += $cst;}
									else{$cst_srv_sel_prs[$i] = $cst;}
									if(isset($cst_srv[$id_trf][$i])) {$cst_srv[$id_trf][$i] += $cst;}
									else{$cst_srv[$id_trf][$i] = $cst;}
								}
							}
						}
					}
					else{
						if($dt_srv['id_cat']!=0) {$opt_srv_id[$id_trf][$j] = $dt_srv['id_cat'];}
						else{$opt_srv_id[$id_trf][$j] = -$dt_srv['id'];}
						$opt_srv_jrn[$id_trf][$j] = $dt_jrn['ord'];
						if(isset($bss[$id_trf])) {
							foreach($bss[$id_trf] as $i => $base) {
								$tx_mrq = $mrq[$id_trf][$i];
								$dt_srv_trf = ftc_ass(sel_quo("trf_rck,trf_net","dev_srv_trf",array("base","id_srv"),array($base,$dt_srv['id'])));
								$net = $dt_srv_trf['trf_net'];
								$rck = $dt_srv_trf['trf_rck'];
								include("clc_mrq.php");
								$cst_opt_srv[$id_trf][$j][$i] = $cst;
								$trf_opt_srv[$id_trf][$j][$i] = $trf;
								$err_trf_opt_srv[$id_trf][$j][$i] = $err;
							}
						}
						$j++;
					}
				}
				if(isset($bss[$id_trf])) {
					foreach($bss[$id_trf] as $i => $base) {
						if($id_cat_prs>0) {
							if(isset($trf_srv_sel_prs[$i])) {
								if(isset($sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][$i])) {$sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][$i] += $trf_srv_sel_prs[$i];}
								else{$sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][$i] = $trf_srv_sel_prs[$i];}
							}
							if(isset($cst_srv_sel_prs[$i])) {
								if(isset($sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs][$i])) {$sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs][$i] += $cst_srv_sel_prs[$i];}
								else{$sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs][$i] = $cst_srv_sel_prs[$i];}
							}
						}
						else{
							if(isset($trf_srv_sel_prs[$i])) {$sel_prs_trf_srv[$id_dev_prs][$i] = $trf_srv_sel_prs[$i];}
							if(isset($cst_srv_sel_prs[$i])) {$sel_prs_cst_srv[$id_dev_prs][$i] = $cst_srv_sel_prs[$i];}
						}
					}
				}
//CALCUL TARIFS HEBERGEMENTS PRESTATIONS SELECTIONNEES OU CONFIRMÉES
				if($cbl=='dev') {$rq_hbr = sel_quo("*","dev_hbr","id_prs",$id_dev_prs,$opt_sel." DESC, ctg");}
				elseif($cbl=='mdl') {$rq_hbr = sel_quo("id_hbr,id_chm,opt,cat_prs_hbr.id_vll,rgm,frs","cat_prs_hbr LEFT JOIN cat_hbr ON cat_prs_hbr.id_hbr = cat_hbr.id","id_prs",$dt_prs['id'],$opt_sel." DESC");}
				while($dt_hbr = ftc_ass($rq_hbr)) {
					if($cbl=='dev' or $dt_hbr['id_hbr']>0) {
						$frs = $frs_crc + $dt_hbr['frs'];
						if($cbl=='dev') {
							$id_cat_hbr = $dt_hbr['id_cat'];
							$id_cat_chm = $dt_hbr['id_cat_chm'];
							$crr_chm = $dt_hbr['crr_chm'];
							$taux_chm = $dt_hbr['taux_chm'];
							$sup_chm = $dt_hbr['sup_chm'];
							$db_net_chm = $dt_hbr['db_net_chm'];
							$db_rck_chm = $dt_hbr['db_rck_chm'];
							$crr_rgm = $dt_hbr['crr_rgm'];
							$taux_rgm = $dt_hbr['taux_rgm'];
							$sup_rgm = $dt_hbr['sup_rgm'];
							$db_net_rgm = $dt_hbr['db_net_rgm'];
							$db_rck_rgm = $dt_hbr['db_rck_rgm'];
						}
						elseif($cbl=='mdl') {
							$id_cat_hbr = $dt_hbr['id_hbr'];
							$id_cat_chm = $dt_hbr['id_chm'];
							if($dt_hbr['opt']) {$flg_sel_hbr = false;}
						}
					}
					else{
						$rq_vll_hbr = sel_quo("id_hbr,id_chm","cat_vll_hbr",array("id_vll","rgm","hbr_def"),array($dt_hbr['id_vll'],$dt_hbr['rgm'],$hbr_def));
						if(num_rows($rq_vll_hbr) == 0) {
							$err_hbr_db[$id_trf][$dt_jrn['ord']] = 1;
							$id_cat_hbr = -1;
							$id_cat_chm = 0;
						}
						else{
							$flg_sel_hbr = true;
							$dt_vll_hbr = ftc_ass($rq_vll_hbr);
							$id_cat_hbr = $dt_vll_hbr['id_hbr'];
							$id_cat_chm = $dt_vll_hbr['id_chm'];
						}
					}
					if($cbl=='mdl' and $id_cat_hbr>0 and $id_cat_chm>0) {
						$flg_sel_hbr = true;
						$rq_chm_trf = sel_quo("crr,db_net,db_rck","cat_hbr_chm_trf",array("id_chm","def"),array($id_cat_chm,"1"));
						if(num_rows($rq_chm_trf) == 0) {
							$err_hbr_db[$id_trf][$dt_jrn['ord']] = 1;
							$crr_chm = $taux_chm = $sup_chm = 0;
						}
						else{
							$dt_chm_trf = ftc_ass($rq_chm_trf);
							$db_net_chm = $dt_chm_trf['db_net'];
							$db_rck_chm = $dt_chm_trf['db_rck'];
							$cur = $crr_chm = $dt_chm_trf['crr'];
							$id_crr = $id_crr_clt;
							include("../dev/clc_crr.php");
							$taux_chm = $taux;
							$sup_chm = $sup;
							$dt_hbr_chm = ftc_ass(sel_quo("rgm","cat_hbr_chm","id",$id_cat_chm));
							if($dt_hbr_chm['rgm']==$dt_hbr['rgm']) {$crr_rgm = $db_net_rgm = $db_rck_rgm = 0;}
							else{
								$rq_hbr_rgm = sel_quo("id","cat_hbr_rgm",array("id_hbr","rgm"),array($id_cat_hbr,$dt_hbr['rgm']));
								if(num_rows($rq_hbr_rgm) == 0) {
									$err_hbr_db[$id_trf][$dt_jrn['ord']] = 1;//remplacer par erreur tarifs?
									$crr_rgm = $taux_rgm = $sup_rgm = 0;
								}
								else{
									$dt_hbr_rgm = ftc_ass($rq_hbr_rgm);
									$rq_rgm_trf = sel_quo("crr,db_net,db_rck","cat_hbr_rgm_trf",array("id_rgm","def"),array($dt_hbr_rgm['id'],"1"));
									if(num_rows($rq_rgm_trf) == 0) {
										$err_hbr_db[$id_trf][$dt_jrn['ord']] = 1; //remplacer par erreur tarifs?
										$crr_rgm = $taux_rgm = $sup_rgm = 0;
									}
									else{
										$dt_rgm_trf = ftc_ass($rq_rgm_trf);
										$db_net_rgm = $dt_rgm_trf['db_net'];
										$db_rck_rgm = $dt_rgm_trf['db_rck'];
										$cur = $crr_rgm = $dt_rgm_trf['crr'];
										$id_crr = $id_crr_clt;
										include("../dev/clc_crr.php");
										$taux_rgm = $taux;
										$sup_rgm = $sup;
									}
								}
							}
						}
					}
					$flg_sel_prs  = true;
					if(isset($dt_hbr['dt_min']) and $dt_hbr['dt_min']!="0000-00-00") {
						$dt_min_hbr = $dt_hbr['dt_min'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_min_hbr = date ('Y-m-d', strtotime ("-".$ord." days $dt_min_hbr"));}
						if($dt_min_crc < $dt_min_hbr) {$dt_min_crc = $dt_min_hbr;}
					}
					if(isset($dt_hbr['dt_max']) and $dt_hbr['dt_max']!="0000-00-00") {
						$dt_max_hbr = $dt_hbr['dt_max'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_max_hbr = date ('Y-m-d', strtotime ("-".$ord." days $dt_max_hbr"));}
						if(!isset($dt_max_crc) or $dt_max_crc > $dt_max_hbr) {$dt_max_crc = $dt_max_hbr;}
					}
					if($id_cat_hbr==-1) {$err_hbr_def[$id_trf][$dt_jrn['ord']] = 1;}


					if($dt_hbr[$opt_sel]) {
						if($dt_prs['ctg']!=11 and $dt_prs['ctg']!=17) {
							if(!isset($hbr_dup[$dt_jrn['ord']])) {$hbr_dup[$dt_jrn['ord']] = $flg_dup_hbr = false;}
							else{$flg_dup_hbr = true;}
							if($cbl=='dev' and $id_cat_prs>0 and $id_cat_hbr>0) {$map_hbr[count($map_prs)-1]=$id_cat_hbr;}
							if($cbl=='dev') {$flg_sel_hbr = true;}
							$flg_tab = true;
							if($id_cat_chm>-2 and $id_cat_hbr>0) {
								if(isset($hbr_jrn[$id_cat_hbr][$id_cat_chm])) {$hbr_jrn[$id_cat_hbr][$id_cat_chm].=','.$dt_jrn['ord'];}
								else{$hbr_jrn[$id_cat_hbr][$id_cat_chm]=$dt_jrn['ord'];}
							}
							else{
								if(isset($hbr_jrn[$id_cat_hbr][$dt_hbr['id_vll']])) {$hbr_jrn[$id_cat_hbr][$dt_hbr['id_vll']].=','.$dt_jrn['ord'];}
								else{$hbr_jrn[$id_cat_hbr][$dt_hbr['id_vll']]=$dt_jrn['ord'];}
								$flg_tab = false;
							}
							if(isset($hbr_id)) {
								foreach($hbr_id as $i => $id_cat) {
									if($id_cat_hbr==$id_cat and $id_cat_chm==$chm_id[$i] and $id_cat_hbr>0 and $id_cat_chm>0) {$flg_tab=false;}
								}
							}
							if($flg_tab) {
								$hbr_id[$h]=$id_cat_hbr;
								$chm_id[$h]=$id_cat_chm;
								$vll_hbr[$h]=$dt_hbr['id_vll'];
							}
							$h++;
						}
						if($id_cat_hbr>-1 and $id_cat_chm>-2) {
							$tx_mrq = $mrq_hbr;
							$cur = $crr_chm;
							$taux = $taux_chm;
							$sup = $sup_chm;

							$net = $db_net_chm;
							$rck = $db_rck_chm;
							include("clc_mrq.php");
							$cst_db_sel_hbr = $cst;
							$trf_db_sel_hbr = $trf;
							$err_hbr_db[$id_trf][$dt_jrn['ord']] = $err;

							if($cbl=='dev') {
								$net = $dt_hbr['sg_net_chm'];
								$rck = $dt_hbr['sg_rck_chm'];
								include("clc_mrq.php");
								$cst_sg_sel_hbr = $cst;
								$trf_sg_sel_hbr = $trf;
								$err_hbr_sg[$id_trf][$dt_jrn['ord']] = $err;

								$net = $dt_hbr['tp_net_chm'];
								$rck = $dt_hbr['tp_rck_chm'];
								include("clc_mrq.php");
								if(isset($cst)) {$cst_tp_sel_hbr = $cst;}
								if(isset($trf)) {$trf_tp_sel_hbr = $trf;}
								$err_hbr_tp[$id_trf][$dt_jrn['ord']] = $err;

								$net = $dt_hbr['qd_net_chm'];
								$rck = $dt_hbr['qd_rck_chm'];
								include("clc_mrq.php");
								if(isset($cst)) {$cst_qd_sel_hbr = $cst;}
								if(isset($trf)) {$trf_qd_sel_hbr = $trf;}
								$err_hbr_qd[$id_trf][$dt_jrn['ord']] = $err;
							}

							if($crr_rgm>0) {
								$cur = $crr_rgm;
								$taux = $taux_rgm;
								$sup = $sup_rgm;

								$net = abs($db_net_rgm);
								$rck = abs($db_rck_rgm);
								include("clc_mrq.php");
								if($db_net_rgm > 0) {
									$cst_db_sel_hbr += $cst;
									$trf_db_sel_hbr += $trf;
								} else{
									$cst_db_sel_hbr -= $cst;
									$trf_db_sel_hbr -= $trf;
								}
								if(!$err_hbr_db[$id_trf][$dt_jrn['ord']]) {$err_hbr_db[$id_trf][$dt_jrn['ord']] = $err;}

								if($cbl=='dev') {
									$net = abs($dt_hbr['sg_net_rgm']);
									$rck = abs($dt_hbr['sg_rck_rgm']);
									include("clc_mrq.php");
									if($dt_hbr['sg_net_rgm'] >0) {
										$cst_sg_sel_hbr += $cst;
										$trf_sg_sel_hbr += $trf;
									} else{
										$cst_sg_sel_hbr -= $cst;
										$trf_sg_sel_hbr -= $trf;
									}
									if(!$err_hbr_sg[$id_trf][$dt_jrn['ord']]) {$err_hbr_sg[$id_trf][$dt_jrn['ord']] = $err;}

									$net = abs($dt_hbr['tp_net_rgm']);
									$rck = abs($dt_hbr['tp_rck_rgm']);
									include("clc_mrq.php");
									if($dt_hbr['tp_net_rgm'] >0) {
										$cst_tp_sel_hbr += $cst;
										$trf_tp_sel_hbr += $trf;
									} else{
										$cst_tp_sel_hbr -= $cst;
										$trf_tp_sel_hbr -= $trf;
									}
									if(!$err_hbr_tp[$id_trf][$dt_jrn['ord']]) {$err_hbr_tp[$id_trf][$dt_jrn['ord']] = $err;}

									$net = abs($dt_hbr['qd_net_rgm']);
									$rck = abs($dt_hbr['qd_rck_rgm']);
									include("clc_mrq.php");
									if($dt_hbr['qd_net_rgm'] >0) {
										$cst_qd_sel_hbr += $cst;
										$trf_qd_sel_hbr += $trf;
									} else{
										$cst_qd_sel_hbr -= $cst;
										$trf_qd_sel_hbr -= $trf;
									}
									if(!$err_hbr_qd[$id_trf][$dt_jrn['ord']]) {$err_hbr_qd[$id_trf][$dt_jrn['ord']] = $err;}
								}

							}
							if(isset($trf_db_hbr[$id_trf])) {$trf_db_hbr[$id_trf] += $trf_db_sel_hbr;}
							else{$trf_db_hbr[$id_trf] = $trf_db_sel_hbr;}
							if(isset($cst_db_hbr[$id_trf])) {$cst_db_hbr[$id_trf] += $cst_db_sel_hbr;}
							else{$cst_db_hbr[$id_trf] = $cst_db_sel_hbr;}
							if($cbl == 'dev') {
								if(isset($trf_sg_hbr[$id_trf])) {$trf_sg_hbr[$id_trf] += $trf_sg_sel_hbr;}
								else{$trf_sg_hbr[$id_trf] = $trf_sg_sel_hbr;}
								if(isset($cst_sg_hbr[$id_trf])) {$cst_sg_hbr[$id_trf] += $cst_sg_sel_hbr;}
								else{$cst_sg_hbr[$id_trf] = $cst_sg_sel_hbr;}
								if(isset($trf_tp_hbr[$id_trf])) {$trf_tp_hbr[$id_trf] += $trf_tp_sel_hbr;}
								else{$trf_tp_hbr[$id_trf] = $trf_tp_sel_hbr;}
								if(isset($cst_tp_hbr[$id_trf])) {$cst_tp_hbr[$id_trf] += $cst_tp_sel_hbr;}
								else{$cst_tp_hbr[$id_trf] = $cst_tp_sel_hbr;}
								if(isset($trf_qd_hbr[$id_trf])) {$trf_qd_hbr[$id_trf] += $trf_qd_sel_hbr;}
								else{$trf_qd_hbr[$id_trf] = $trf_qd_sel_hbr;}
								if(isset($cst_qd_hbr[$id_trf])) {$cst_qd_hbr[$id_trf] += $cst_qd_sel_hbr;}
								else{$cst_qd_hbr[$id_trf] = $cst_qd_sel_hbr;}
							}
						}
					}
					elseif(isset($dt_hbr['res']) and $dt_hbr['res']!=-1) {
						if($dt_prs['ctg']!=11 and $dt_prs['ctg']!=17) {$opt_hbr_jrn[$id_dev_mdl][] = $dt_jrn['ord'];}
						else{$opt_hbr_jrn[$id_dev_mdl][] = 0;}
						$opt_hbr_id[$id_dev_mdl][] = $id_cat_hbr;
						$opt_chm_id[$id_dev_mdl][] = $id_cat_chm;
						$opt_hbr_vll[$id_dev_mdl][] = $dt_hbr['id_vll'];
						$cur = $dt_hbr['crr_chm'];
						$taux = $dt_hbr['taux_chm'];
						$sup = $dt_hbr['sup_chm'];
						$tx_mrq = $mrq_hbr;

						$net = $dt_hbr['db_net_chm'];
						$rck = $dt_hbr['db_rck_chm'];
						include("clc_mrq.php");
						$cst_db_opt_hbr = $cst;
						$trf_db_opt_hbr = $trf;
						$flg_err_trf_db_opt_hbr = $err;

						$net = $dt_hbr['sg_net_chm'];
						$rck = $dt_hbr['sg_rck_chm'];
						include("clc_mrq.php");
						$cst_sg_opt_hbr = $cst;
						$trf_sg_opt_hbr = $trf;
						$flg_err_trf_sg_opt_hbr = $err;

						$net = $dt_hbr['tp_net_chm'];
						$rck = $dt_hbr['tp_rck_chm'];
						include("clc_mrq.php");
						$cst_tp_opt_hbr = $cst;
						$trf_tp_opt_hbr = $trf;
						$flg_err_trf_tp_opt_hbr = $err;

						$net = $dt_hbr['qd_net_chm'];
						$rck = $dt_hbr['qd_rck_chm'];
						include("clc_mrq.php");
						$cst_qd_opt_hbr = $cst;
						$trf_qd_opt_hbr = $trf;
						$flg_err_trf_qd_opt_hbr = $err;

						$cur = $dt_hbr['crr_rgm'];
						$taux = $dt_hbr['taux_rgm'];
						$sup = $dt_hbr['sup_rgm'];
						if($cur>0) {

							$net = $dt_hbr['db_net_rgm'];
							$rck = $dt_hbr['db_rck_rgm'];
							include("clc_mrq.php");
							$cst_db_opt_hbr += $cst;
							$trf_db_opt_hbr += $trf;
							if(!$flg_err_trf_db_opt_hbr) {$flg_err_trf_db_opt_hbr = $err;}

							$net = $dt_hbr['sg_net_rgm'];
							$rck = $dt_hbr['sg_rck_rgm'];
							include("clc_mrq.php");
							$cst_sg_opt_hbr += $cst;
							$trf_sg_opt_hbr += $trf;
							if(!$flg_err_trf_sg_opt_hbr) {$flg_err_trf_sg_opt_hbr = $err;}

							$net = $dt_hbr['tp_net_rgm'];
							$rck = $dt_hbr['tp_rck_rgm'];
							include("clc_mrq.php");
							$cst_tp_opt_hbr += $cst;
							$trf_tp_opt_hbr += $trf;
							if(!$flg_err_trf_tp_opt_hbr) {$flg_err_trf_tp_opt_hbr = $err;}

							$net = $dt_hbr['qd_net_rgm'];
							$rck = $dt_hbr['qd_rck_rgm'];
							include("clc_mrq.php");
							$cst_qd_opt_hbr += $cst;
							$trf_qd_opt_hbr += $trf;
							if(!$flg_err_trf_qd_opt_hbr) {$flg_err_trf_qd_opt_hbr = $err;}
						}
						$err_trf_db_opt_hbr[$id_dev_mdl][] = $flg_err_trf_db_opt_hbr;
						$err_trf_sg_opt_hbr[$id_dev_mdl][] = $flg_err_trf_sg_opt_hbr;
						$err_trf_tp_opt_hbr[$id_dev_mdl][] = $flg_err_trf_tp_opt_hbr;
						$err_trf_qd_opt_hbr[$id_dev_mdl][] = $flg_err_trf_qd_opt_hbr;
						$trf_opt_hbr_db[$id_dev_mdl][] = $trf_db_opt_hbr - $trf_db_sel_hbr;
						$cst_opt_hbr_db[$id_dev_mdl][] = $cst_db_opt_hbr - $cst_db_sel_hbr;
						$trf_opt_hbr_sg[$id_dev_mdl][] = $trf_sg_opt_hbr - $trf_sg_sel_hbr;
						$cst_opt_hbr_sg[$id_dev_mdl][] = $cst_sg_opt_hbr - $cst_sg_sel_hbr;
						$trf_opt_hbr_tp[$id_dev_mdl][] = $trf_tp_opt_hbr - $trf_tp_sel_hbr;
						$cst_opt_hbr_tp[$id_dev_mdl][] = $cst_tp_opt_hbr - $cst_tp_sel_hbr;
						$trf_opt_hbr_qd[$id_dev_mdl][] = $trf_qd_opt_hbr - $trf_qd_sel_hbr;
						$cst_opt_hbr_qd[$id_dev_mdl][] = $cst_qd_opt_hbr - $cst_qd_sel_hbr;
					}
				}
				if($id_cat_prs>0) {
					if(isset($trf_db_sel_hbr)) {
						if(isset($trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $trf_db_sel_hbr;}
						else{$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $trf_db_sel_hbr;}
					}
					if(isset($cst_db_sel_hbr)) {
						if(isset($cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $cst_db_sel_hbr;}
						else{$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $cst_db_sel_hbr;}
					}
					if($cbl=='dev') {
						if(isset($trf_sg_sel_hbr)) {
							if(isset($trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $trf_sg_sel_hbr;}
							else {$trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $trf_sg_sel_hbr;}
						}
						if(isset($cst_sg_sel_hbr)) {
							if(isset($cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $cst_sg_sel_hbr;}
							else {$cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $cst_sg_sel_hbr;}
						}
						if(isset($trf_tp_sel_hbr)) {
							if(isset($trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $trf_tp_sel_hbr;}
 							else {$trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $trf_tp_sel_hbr;}
						}
						if(isset($cst_tp_sel_hbr)) {
							if(isset($cst_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$cst_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $cst_tp_sel_hbr;}
							else {$cst_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $cst_tp_sel_hbr;}
						}
						if(isset($trf_qd_sel_hbr)) {
							if(isset($trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $trf_qd_sel_hbr;}
							else {$trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $trf_qd_sel_hbr;}
						}
						if(isset($cst_qd_sel_hbr)) {
							if(isset($cst_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs])) {$cst_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] += $cst_qd_sel_hbr;}
							else{$cst_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs] = $cst_qd_sel_hbr;}
						}
					}
				}
				else{
					if(isset($trf_db_sel_hbr)) {$trf_db_hbr_sel_prs[$id_dev_prs] = $trf_db_sel_hbr;}
					elseif(!isset($trf_db_hbr_sel_prs[$id_dev_prs])) {$trf_db_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($cst_db_sel_hbr)) {$cst_db_hbr_sel_prs[$id_dev_prs] = $cst_db_sel_hbr;}
					elseif(!isset($cst_db_hbr_sel_prs[$id_dev_prs])) {$cst_db_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($trf_sg_sel_hbr)) {$trf_sg_hbr_sel_prs[$id_dev_prs] = $trf_sg_sel_hbr;}
					elseif(!isset($trf_sg_hbr_sel_prs[$id_dev_prs])) {$trf_sg_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($cst_sg_sel_hbr)) {$cst_sg_hbr_sel_prs[$id_dev_prs] = $cst_sg_sel_hbr;}
					elseif(!isset($cst_sg_hbr_sel_prs[$id_dev_prs])) {$cst_sg_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($trf_tp_sel_hbr)) {$trf_tp_hbr_sel_prs[$id_dev_prs] = $trf_tp_sel_hbr;}
					elseif(!isset($trf_tp_hbr_sel_prs[$id_dev_prs])) {$trf_tp_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($cst_tp_sel_hbr)) {$cst_tp_hbr_sel_prs[$id_dev_prs] = $cst_tp_sel_hbr;}
					elseif(!isset($cst_tp_hbr_sel_prs[$id_dev_prs])) {$cst_tp_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($trf_qd_sel_hbr)) {$trf_qd_hbr_sel_prs[$id_dev_prs] = $trf_qd_sel_hbr;}
					elseif(!isset($trf_qd_hbr_sel_prs[$id_dev_prs])) {$trf_qd_hbr_sel_prs[$id_dev_prs] = 0;}
					if(isset($cst_qd_sel_hbr)) {$cst_qd_hbr_sel_prs[$id_dev_prs] = $cst_qd_sel_hbr;}
					elseif(!isset($cst_qd_hbr_sel_prs[$id_dev_prs])) {$cst_qd_hbr_sel_prs[$id_dev_prs] = 0;}
				}
				if($cbl=='mdl' or ($dt_prs['res']>-1 and $flg_sel_prs)) {
					if($cbl=='dev') {
						$sel_prs_id[$id_dev_mdl][] = $id_dev_prs;
						if(!isset($sel_prs_id_cat[$id_dev_mdl]) or !in_array($id_cat_prs,$sel_prs_id_cat[$id_dev_mdl]) or $id_cat_prs==0) {$sel_prs_id_cat[$id_dev_mdl][$id_dev_prs] = $id_cat_prs;}
						else{$sel_prs_id_cat[$id_dev_mdl][$id_dev_prs] = -1;}
					}
					if($id_cat_prs>0) {$sel_prs_jrn_cat[$id_dev_mdl][$id_cat_prs][] = $dt_jrn['ord'];}
					else{$sel_prs_jrn[$id_dev_prs] = $dt_jrn['ord'];}
				}
			}
			elseif($cbl=='dev' and $dt_prs['opt']!=1 and $opt_sel=='opt') {
//CALCUL TARIFS SERVICES PRESTATIONS EN OPTION
				unset($trf_srv_opt_prs,$cst_srv_opt_prs);
				$opt_prs_id[$id_trf][] = $id_dev_prs;
				if(!isset($opt_prs_id_cat[$id_trf]) or !in_array($id_cat_prs,$opt_prs_id_cat[$id_trf]) or $id_cat_prs==0) {$opt_prs_id_cat[$id_trf][$id_dev_prs] = $id_cat_prs;}
			  else{$opt_prs_id_cat[$id_trf][$id_dev_prs] = -1;}
			  if($id_cat_prs>0) {$opt_prs_jrn_cat[$id_trf][$id_cat_prs][] = $dt_jrn['ord'];}
			  else{$opt_prs_jrn[$id_dev_prs] = $dt_jrn['ord'];}
//			$opt_prs_jrn[$id_dev_prs] = $dt_jrn['ord'];
				$rq_srv = sel_quo("*","dev_srv","id_prs",$id_dev_prs);
				while($dt_srv = ftc_ass($rq_srv)) {
					$frs = $frs_crc + $dt_srv['frs'];
					if($dt_srv['dt_min']!="0000-00-00") {
						$dt_min_srv = $dt_srv['dt_min'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_min_srv = date ('Y-m-d', strtotime ("-".$ord." days $dt_min_srv"));}
						if($dt_min_crc < $dt_min_srv) {$dt_min_crc = $dt_min_srv;}
					}
					if($dt_srv['dt_max']!="0000-00-00") {
						$dt_max_srv = $dt_srv['dt_min'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_max_srv = date ('Y-m-d', strtotime ("-".$ord." days $dt_max_srv"));}
						if(!isset($dt_max_crc) or $dt_max_crc > $dt_max_srv) {$dt_max_crc = $dt_max_srv;}
					}
					$cur = $dt_srv['crr'];
					$taux = $dt_srv['taux'];
					$sup = $dt_srv['sup'];
					if($dt_srv['opt']) {
						if(isset($bss[$id_trf])) {
							foreach($bss[$id_trf] as $i => $base) {
								$tx_mrq = $mrq[$id_trf][$i];
								$dt_srv_trf = ftc_ass(sel_quo("trf_net,trf_rck","dev_srv_trf",array("base","id_srv"),array($base,$dt_srv['id'])));
								$net = $dt_srv_trf['trf_net'];
								$rck = $dt_srv_trf['trf_rck'];
								include("clc_mrq.php");
								if(isset($cst_srv_opt_prs[$i])) {$cst_srv_opt_prs[$i] += $cst;}
								else{$cst_srv_opt_prs[$i] = $cst;}
								if(isset($trf_srv_opt_prs[$i])) {$trf_srv_opt_prs[$i] += $trf;}
								else{$trf_srv_opt_prs[$i] = $trf;}
								if($err) {$err_trf_srv_opt_prs[$id_dev_prs][$i] = $err;}
							}
						}
					}
					else{
						if($dt_srv['id_cat']!=0) {$opt_srv_id_opt_prs[$id_dev_prs][$k] = $dt_srv['id_cat'];}
						else{$opt_srv_id_opt_prs[$id_dev_prs][$k] = -$dt_srv['id'];}
						if(isset($bss[$id_trf])) {
							foreach($bss[$id_trf] as $i => $base) {
								$tx_mrq = $mrq[$id_trf][$i];
								$dt_srv_trf = ftc_ass(sel_quo("trf_net,trf_rck","dev_srv_trf",array("base","id_srv"),array($base,$dt_srv['id'])));
								$net = $dt_srv_trf['trf_net'];
								$rck = $dt_srv_trf['trf_rck'];
								include("clc_mrq.php");
								if($id_cat_prs>0) {
									$cst_opt_srv_opt_prs_cat[$id_cat_prs][$k][$i] += $cst;
									$trf_opt_srv_opt_prs_cat[$id_cat_prs][$k][$i] += $trf;
									$err_trf_opt_srv_opt_prs_cat[$id_cat_prs][$k][$i] += $err;
								}
							  else{
									$cst_opt_srv_opt_prs[$id_dev_prs][$k][$i] = $cst;
									$trf_opt_srv_opt_prs[$id_dev_prs][$k][$i] = $trf;
									$err_trf_opt_srv_opt_prs[$id_dev_prs][$k][$i] = $err;
								}
							}
						}
						$k++;
					}
				}
				if(isset($bss[$id_trf])) {
					foreach($bss[$id_trf] as $i => $base) {
						if(!isset($trf_srv_sel_prs[$i])) {$trf_srv_sel_prs[$i]=0;}
						if(!isset($cst_srv_sel_prs[$i])) {$cst_srv_sel_prs[$i]=0;}
						if(!isset($trf_srv_opt_prs[$i])) {$trf_srv_opt_prs[$i]=0;}
						if(!isset($cst_srv_opt_prs[$i])) {$cst_srv_opt_prs[$i]=0;}
            if($id_cat_prs>0) {
							if($trf_srv_opt_prs[$i] - $trf_srv_sel_prs[$i]!=0) {
								if(isset($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i])) {$opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i] += $trf_srv_opt_prs[$i] - $trf_srv_sel_prs[$i];}
								else {$opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i] = $trf_srv_opt_prs[$i] - $trf_srv_sel_prs[$i];}
							}
							if($cst_srv_opt_prs[$i] - $cst_srv_sel_prs[$i]!=0) {
								if(isset($opt_prs_cst_srv_cat[$id_trf][$id_cat_prs][$i])) {$opt_prs_cst_srv_cat[$id_trf][$id_cat_prs][$i] += $cst_srv_opt_prs[$i] - $cst_srv_sel_prs[$i];}
								else {$opt_prs_cst_srv_cat[$id_trf][$id_cat_prs][$i] = $cst_srv_opt_prs[$i] - $cst_srv_sel_prs[$i];}
							}
            }
            else{
							if($trf_srv_opt_prs[$i] - $trf_srv_sel_prs[$i]!=0) {$opt_prs_trf_srv[$id_dev_prs][$i] = $trf_srv_opt_prs[$i] - $trf_srv_sel_prs[$i];}
							if($cst_srv_opt_prs[$i] - $cst_srv_sel_prs[$i]!=0) {$opt_prs_cst_srv[$id_dev_prs][$i] = $cst_srv_opt_prs[$i] - $cst_srv_sel_prs[$i];}
						}
					}
				}
//CALCUL TARIFS HEBERGEMENTS PRESTATIONS EN OPTION
				$trf_db_sel_hbr_opt_prs = $cst_db_sel_hbr_opt_prs = $trf_sg_sel_hbr_opt_prs = $cst_sg_sel_hbr_opt_prs = $trf_tp_sel_hbr_opt_prs = $cst_tp_sel_hbr_opt_prs = $trf_qd_sel_hbr_opt_prs = $cst_qd_sel_hbr_opt_prs = 0;
				$rq_hbr = sel_quo("*","dev_hbr","id_prs",$id_dev_prs,"opt DESC, ctg");
				while($dt_hbr = ftc_ass($rq_hbr)) {
					$frs = $frs_crc + $dt_hbr['frs'];
					if(isset($dt_hbr['dt_min']) and $dt_hbr['dt_min']!="0000-00-00") {
						$dt_min_hbr = $dt_hbr['dt_min'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_min_hbr = date ('Y-m-d', strtotime ("-".$ord." days $dt_min_hbr"));}
						if($dt_min_crc < $dt_min_hbr) {$dt_min_crc = $dt_min_hbr;}
					}
					if(isset($dt_hbr['dt_max']) and $dt_hbr['dt_max']!="0000-00-00") {
						$dt_max_hbr = $dt_hbr['dt_max'];
						$ord = $dt_jrn['ord']-1;
						if($ord>0) {$dt_max_hbr = date ('Y-m-d', strtotime ("-".$ord." days $dt_max_hbr"));}
						if(!isset($dt_max_crc) or $dt_max_crc > $dt_max_hbr) {$dt_max_crc = $dt_max_hbr;}
					}
					if($dt_hbr['id_cat']==-1) {$err_hbr_def_opt_prs[$id_dev_prs][$dt_jrn['ord']] = 1;}
					if($dt_hbr['opt']) {
						$flg_tab_opt_prs = true;
						if(isset($hbr_id_opt_prs[$id_dev_prs])) {
							foreach($hbr_id_opt_prs[$id_dev_prs] as $i => $id_cat) {
								if($dt_hbr['id_cat']==$id_cat and $dt_hbr['id_cat_chm']==$chm_id_opt_prs[$id_dev_prs][$i]) {$flg_tab_opt_prs=false;}
							}
						}
						if($flg_tab_opt_prs==true) {
							$hbr_id_opt_prs[$id_dev_prs][$h]=$dt_hbr['id_cat'];
							$chm_id_opt_prs[$id_dev_prs][$h]=$dt_hbr['id_cat_chm'];
							$vll_hbr_opt_prs[$id_dev_prs][$h]=$dt_hbr['id_vll'];
						}
						$h++;

						if($dt_hbr['id_cat']>-2 and $dt_hbr['id_cat_chm']>-2) {

							$cur = $dt_hbr['crr_chm'];
							$taux = $dt_hbr['taux_chm'];
							$sup = $dt_hbr['sup_chm'];
							$tx_mrq = $mrq_hbr;
							$net = $dt_hbr['db_net_chm'];
							$rck = $dt_hbr['db_rck_chm'];
							include("clc_mrq.php");
							$cst_db_sel_hbr_opt_prs = $cst;
							$trf_db_sel_hbr_opt_prs = $trf;
							$err_hbr_db_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;


							$net = $dt_hbr['sg_net_chm'];
							$rck = $dt_hbr['sg_rck_chm'];
							include("clc_mrq.php");
							$cst_sg_sel_hbr_opt_prs = $cst;
							$trf_sg_sel_hbr_opt_prs = $trf;
							$err_hbr_sg_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;

							$net = $dt_hbr['tp_net_chm'];
							$rck = $dt_hbr['tp_rck_chm'];
							include("clc_mrq.php");
							$cst_tp_sel_hbr_opt_prs = $cst;
							$trf_tp_sel_hbr_opt_prs = $trf;
							$err_hbr_tp_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;

							$net = $dt_hbr['qd_net_chm'];
							$rck = $dt_hbr['qd_rck_chm'];
							include("clc_mrq.php");
							$cst_qd_sel_hbr_opt_prs = $cst;
							$trf_qd_sel_hbr_opt_prs = $trf;
							$err_hbr_qd_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;

							$cur = $dt_hbr['crr_rgm'];
							$taux = $dt_hbr['taux_rgm'];
							$sup = $dt_hbr['sup_rgm'];
							if($cur>0) {
								$net = $dt_hbr['db_net_rgm'];
								$rck = $dt_hbr['db_rck_rgm'];
								include("clc_mrq.php");
								$cst_db_sel_hbr_opt_prs += $cst;
								$trf_db_sel_hbr_opt_prs += $trf;
								if(!$err_hbr_db_opt_prs[$id_dev_prs][$dt_jrn['ord']]) {$err_hbr_db_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;}

								$net = $dt_hbr['sg_net_rgm'];
								$rck = $dt_hbr['sg_rck_rgm'];
								include("clc_mrq.php");
								$cst_sg_sel_hbr_opt_prs += $cst;
								$trf_sg_sel_hbr_opt_prs += $trf;
								if(!$err_hbr_sg_opt_prs[$id_dev_prs][$dt_jrn['ord']]) {$err_hbr_sg_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;}

								$net = $dt_hbr['tp_net_rgm'];
								$rck = $dt_hbr['tp_rck_rgm'];
								include("clc_mrq.php");
								$cst_tp_sel_hbr_opt_prs += $cst;
								$trf_tp_sel_hbr_opt_prs += $trf;
								if(!$err_hbr_tp_opt_prs[$id_dev_prs][$dt_jrn['ord']]) {$err_hbr_tp_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;}

								$net = $dt_hbr['qd_net_rgm'];
								$rck = $dt_hbr['qd_rck_rgm'];
								include("clc_mrq.php");
								$cst_qd_sel_hbr_opt_prs += $cst;
								$trf_qd_sel_hbr_opt_prs += $trf;
								if(!$err_hbr_qd_opt_prs[$id_dev_prs][$dt_jrn['ord']]) {$err_hbr_qd_opt_prs[$id_dev_prs][$dt_jrn['ord']] = $err;}
							}
						}
					}
					elseif($dt_hbr['res']!=-1) {
						$opt_hbr_id_opt_prs[$id_dev_prs][] = $dt_hbr['id_cat'];
						$opt_chm_id_opt_prs[$id_dev_prs][] = $dt_hbr['id_cat_chm'];
						$opt_hbr_vll_opt_prs[$id_dev_prs][] = $dt_hbr['id_vll'];

						$cur = $dt_hbr['crr_chm'];
						$taux = $dt_hbr['taux_chm'];
						$sup = $dt_hbr['sup_chm'];
						$tx_mrq = $mrq_hbr;
						$net = $dt_hbr['db_net_chm'];
						$rck = $dt_hbr['db_rck_chm'];
						include("clc_mrq.php");
						$cst_db_opt_hbr_opt_prs = $cst;
						$trf_db_opt_hbr_opt_prs = $trf;
						$flg_err_trf_db_opt_hbr_opt_prs = $err;

						$net = $dt_hbr['sg_net_chm'];
						$rck = $dt_hbr['sg_rck_chm'];
						include("clc_mrq.php");
						$cst_sg_opt_hbr_opt_prs = $cst;
						$trf_sg_opt_hbr_opt_prs = $trf;
						$flg_err_trf_sg_opt_hbr_opt_prs = $err;

						$net = $dt_hbr['tp_net_chm'];
						$rck = $dt_hbr['tp_rck_chm'];
						include("clc_mrq.php");
						$cst_tp_opt_hbr_opt_prs = $cst;
						$trf_tp_opt_hbr_opt_prs = $trf;
						$flg_err_trf_tp_opt_hbr_opt_prs = $err;

						$net = $dt_hbr['qd_net_chm'];
						$rck = $dt_hbr['qd_rck_chm'];
						include("clc_mrq.php");
						$cst_qd_opt_hbr_opt_prs = $cst;
						$trf_qd_opt_hbr_opt_prs = $trf;
						$flg_err_trf_qd_opt_hbr_opt_prs = $err;

						$cur = $dt_hbr['crr_rgm'];
						$taux = $dt_hbr['taux_rgm'];
						$sup = $dt_hbr['sup_rgm'];
						if($cur>0) {
							$net = $dt_hbr['db_net_rgm'];
							$rck = $dt_hbr['db_rck_rgm'];
							include("clc_mrq.php");
							$cst_db_opt_hbr_opt_prs += $cst;
							$trf_db_opt_hbr_opt_prs += $trf;
							if(!$flg_err_trf_db_opt_hbr_opt_prs) {$flg_err_trf_db_opt_hbr_opt_prs = $err;}

							$net = $dt_hbr['sg_net_rgm'];
							$rck = $dt_hbr['sg_rck_rgm'];
							include("clc_mrq.php");
							$cst_sg_opt_hbr_opt_prs += $cst;
							$trf_sg_opt_hbr_opt_prs += $trf;
							if(!$flg_err_trf_sg_opt_hbr_opt_prs) {$flg_err_trf_sg_opt_hbr_opt_prs = $err;}

							$net = $dt_hbr['tp_net_rgm'];
							$rck = $dt_hbr['tp_rck_rgm'];
							include("clc_mrq.php");
							$cst_tp_opt_hbr_opt_prs += $cst;
							$trf_tp_opt_hbr_opt_prs += $trf;
							if(!$flg_err_trf_tp_opt_hbr_opt_prs) {$flg_err_trf_tp_opt_hbr_opt_prs = $err;}

							$net = $dt_hbr['qd_net_rgm'];
							$rck = $dt_hbr['qd_rck_rgm'];
							include("clc_mrq.php");
							$cst_qd_opt_hbr_opt_prs += $cst;
							$trf_qd_opt_hbr_opt_prs += $trf;
							if(!$flg_err_trf_qd_opt_hbr_opt_prs) {$flg_err_trf_qd_opt_hbr_opt_prs = $err;}
						}
						if($id_cat_prs>0) { //REGROUPEMENT D'OPTION D'HEBERGEMENTS DANS DES PRESTATIONS EN OPTION !
							//RESULTAT MAUVAIS!!
							$err_trf_db_opt_hbr_opt_prs_cat[$id_cat_prs][] = 1;//$flg_err_trf_db_opt_hbr_opt_prs;
							$err_trf_sg_opt_hbr_opt_prs_cat[$id_cat_prs][] = 1;//$flg_err_trf_sg_opt_hbr_opt_prs;
							$err_trf_tp_opt_hbr_opt_prs_cat[$id_cat_prs][] = 1;//$flg_err_trf_tp_opt_hbr_opt_prs;
							$err_trf_qd_opt_hbr_opt_prs_cat[$id_cat_prs][] = 1;//$flg_err_trf_qd_opt_hbr_opt_prs;
							$trf_opt_hbr_db_opt_prs_cat[$id_cat_prs][] = $trf_db_opt_hbr_opt_prs - $trf_db_sel_hbr_opt_prs;
							$cst_opt_hbr_db_opt_prs_cat[$id_cat_prs][] = $cst_db_opt_hbr_opt_prs - $cst_db_sel_hbr_opt_prs;
							$trf_opt_hbr_sg_opt_prs_cat[$id_cat_prs][] = $trf_sg_opt_hbr_opt_prs - $trf_sg_sel_hbr_opt_prs;
							$cst_opt_hbr_sg_opt_prs_cat[$id_cat_prs][] = $cst_sg_opt_hbr_opt_prs - $cst_sg_sel_hbr_opt_prs;
							$trf_opt_hbr_tp_opt_prs_cat[$id_cat_prs][] = $trf_tp_opt_hbr_opt_prs - $trf_tp_sel_hbr_opt_prs;
							$cst_opt_hbr_tp_opt_prs_cat[$id_cat_prs][] = $cst_tp_opt_hbr_opt_prs - $cst_tp_sel_hbr_opt_prs;
							$trf_opt_hbr_qd_opt_prs_cat[$id_cat_prs][] = $trf_qd_opt_hbr_opt_prs - $trf_qd_sel_hbr_opt_prs;
							$cst_opt_hbr_qd_opt_prs_cat[$id_cat_prs][] = $cst_qd_opt_hbr_opt_prs - $cst_qd_sel_hbr_opt_prs;
						}
						else{
							$err_trf_db_opt_hbr_opt_prs[$id_dev_prs][] = $flg_err_trf_db_opt_hbr_opt_prs;
							$err_trf_sg_opt_hbr_opt_prs[$id_dev_prs][] = $flg_err_trf_sg_opt_hbr_opt_prs;
							$err_trf_tp_opt_hbr_opt_prs[$id_dev_prs][] = $flg_err_trf_tp_opt_hbr_opt_prs;
							$err_trf_qd_opt_hbr_opt_prs[$id_dev_prs][] = $flg_err_trf_qd_opt_hbr_opt_prs;
							$trf_opt_hbr_db_opt_prs[$id_dev_prs][] = $trf_db_opt_hbr_opt_prs - $trf_db_sel_hbr_opt_prs;
							$cst_opt_hbr_db_opt_prs[$id_dev_prs][] = $cst_db_opt_hbr_opt_prs - $cst_db_sel_hbr_opt_prs;
							$trf_opt_hbr_sg_opt_prs[$id_dev_prs][] = $trf_sg_opt_hbr_opt_prs - $trf_sg_sel_hbr_opt_prs;
							$cst_opt_hbr_sg_opt_prs[$id_dev_prs][] = $cst_sg_opt_hbr_opt_prs - $cst_sg_sel_hbr_opt_prs;
							$trf_opt_hbr_tp_opt_prs[$id_dev_prs][] = $trf_tp_opt_hbr_opt_prs - $trf_tp_sel_hbr_opt_prs;
							$cst_opt_hbr_tp_opt_prs[$id_dev_prs][] = $cst_tp_opt_hbr_opt_prs - $cst_tp_sel_hbr_opt_prs;
							$trf_opt_hbr_qd_opt_prs[$id_dev_prs][] = $trf_qd_opt_hbr_opt_prs - $trf_qd_sel_hbr_opt_prs;
							$cst_opt_hbr_qd_opt_prs[$id_dev_prs][] = $cst_qd_opt_hbr_opt_prs - $cst_qd_sel_hbr_opt_prs;
						}
					}
				}
				if($id_cat_prs>0) {
					if(isset($trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $trf_db_sel_hbr_opt_prs - $trf_db_sel_hbr;}
					else {$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $trf_db_sel_hbr_opt_prs - $trf_db_sel_hbr;}
					if(isset($cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $cst_db_sel_hbr_opt_prs - $cst_db_sel_hbr;}
					else {$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $cst_db_sel_hbr_opt_prs - $cst_db_sel_hbr;}
					if(isset($trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $trf_sg_sel_hbr_opt_prs - $trf_sg_sel_hbr;}
 					else {$trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $trf_sg_sel_hbr_opt_prs - $trf_sg_sel_hbr;}
					if(isset($cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $cst_sg_sel_hbr_opt_prs - $cst_sg_sel_hbr;}
					else {$cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $cst_sg_sel_hbr_opt_prs - $cst_sg_sel_hbr;}
					if(isset($trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $trf_tp_sel_hbr_opt_prs - $trf_tp_sel_hbr;}
					else {$trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $trf_tp_sel_hbr_opt_prs - $trf_tp_sel_hbr;}
					if(isset($cst_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$cst_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $cst_tp_sel_hbr_opt_prs - $cst_tp_sel_hbr;}
					else {$cst_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $cst_tp_sel_hbr_opt_prs - $cst_tp_sel_hbr;}
					if(isset($trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $trf_qd_sel_hbr_opt_prs - $trf_qd_sel_hbr;}
					else {$trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $trf_qd_sel_hbr_opt_prs - $trf_qd_sel_hbr;}
					if(isset($cst_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs])) {$cst_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs] += $cst_qd_sel_hbr_opt_prs - $cst_qd_sel_hbr;}
					else {$cst_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs] = $cst_qd_sel_hbr_opt_prs - $cst_qd_sel_hbr;}
				}
				else{
					$trf_db_hbr_opt_prs[$id_dev_prs] = $trf_db_sel_hbr_opt_prs - $trf_db_sel_hbr;
					$cst_db_hbr_opt_prs[$id_dev_prs] = $cst_db_sel_hbr_opt_prs - $cst_db_sel_hbr;
					$trf_sg_hbr_opt_prs[$id_dev_prs] = $trf_sg_sel_hbr_opt_prs - $trf_sg_sel_hbr;
					$cst_sg_hbr_opt_prs[$id_dev_prs] = $cst_sg_sel_hbr_opt_prs - $cst_sg_sel_hbr;
					$trf_tp_hbr_opt_prs[$id_dev_prs] = $trf_tp_sel_hbr_opt_prs - $trf_tp_sel_hbr;
					$cst_tp_hbr_opt_prs[$id_dev_prs] = $cst_tp_sel_hbr_opt_prs - $cst_tp_sel_hbr;
					$trf_qd_hbr_opt_prs[$id_dev_prs] = $trf_qd_sel_hbr_opt_prs - $trf_qd_sel_hbr;
					$cst_qd_hbr_opt_prs[$id_dev_prs] = $cst_qd_sel_hbr_opt_prs - $cst_qd_sel_hbr;
				}
			}
			if($cbl=='dev') {
				if(!isset($err_hbr_def_opt_prs[$id_dev_prs][$dt_jrn['ord']])) {$err_hbr_def_opt_prs[$id_dev_prs][$dt_jrn['ord']]=0;}
				if(!isset($err_hbr_db_opt_prs[$id_dev_prs][$dt_jrn['ord']])) {$err_hbr_db_opt_prs[$id_dev_prs][$dt_jrn['ord']]=0;}
				if(!isset($err_hbr_sg_opt_prs[$id_dev_prs][$dt_jrn['ord']])) {$err_hbr_sg_opt_prs[$id_dev_prs][$dt_jrn['ord']]=0;}
				if(!isset($err_hbr_tp_opt_prs[$id_dev_prs][$dt_jrn['ord']])) {$err_hbr_tp_opt_prs[$id_dev_prs][$dt_jrn['ord']]=0;}
				if(!isset($err_hbr_qd_opt_prs[$id_dev_prs][$dt_jrn['ord']])) {$err_hbr_qd_opt_prs[$id_dev_prs][$dt_jrn['ord']]=0;}
			}
		}
		if(isset($bss[$id_trf])) {
			foreach($bss[$id_trf] as $i => $base) {
				if($flg_err_trf_srv[$i]) {
					$err_trf_srv[$id_trf][$i] = 1;
					if(isset($err_srv_jrn[$id_trf][$i])) {$err_srv_jrn[$id_trf][$i] .= $dt_jrn['ord'].',';}
					else {$err_srv_jrn[$id_trf][$i] = $dt_jrn['ord'].',';}
				}
			}
		}
		if(!isset($flg_sel_hbr) or !$flg_sel_hbr) {$err_hbr_sel[$id_trf][$dt_jrn['ord']] = 1;}
		else{$err_hbr_sel[$id_trf][$dt_jrn['ord']] = 0;}
		if(isset($flg_dup_hbr) and $flg_dup_hbr) {$err_hbr_dup[$id_trf][$dt_jrn['ord']] = 1;}
		else{$err_hbr_dup[$id_trf][$dt_jrn['ord']] = 0;}
		if(!isset($err_hbr_def[$id_trf][$dt_jrn['ord']])) {$err_hbr_def[$id_trf][$dt_jrn['ord']]=0;}
		if(!isset($err_hbr_db[$id_trf][$dt_jrn['ord']])) {$err_hbr_db[$id_trf][$dt_jrn['ord']]=0;}
		if(!isset($err_hbr_sg[$id_trf][$dt_jrn['ord']])) {$err_hbr_sg[$id_trf][$dt_jrn['ord']]=0;}
		if(!isset($err_hbr_tp[$id_trf][$dt_jrn['ord']])) {$err_hbr_tp[$id_trf][$dt_jrn['ord']]=0;}
		if(!isset($err_hbr_qd[$id_trf][$dt_jrn['ord']])) {$err_hbr_qd[$id_trf][$dt_jrn['ord']]=0;}
	}
}
$color = array('yellow','blue','green','orange','purple','red');
$alphas = range('A', 'Z');
if(isset($map_jrn)) {
	//$lnk = "https://api.jawg.io/static/?zoom=12&center=48.856,2.351&size=640x640&layer=jawg-sunny&access-token=".$jawgkey;
	$lnk = "https://maps.googleapis.com/maps/api/staticmap?size=640x640&maptype=terrain";
	$pth = "&path=color:0x0000ff|weight:4";
	$lst = '';
	$lst_lat = 0;
	$lst_lon = 0;
	$last_vll = 0;
	$n = 0;
	$i = 0;
	$last_jrn = 0;
	foreach($map_jrn as $id_cat_jrn) {
		$rq_cat_vll_jrn = sel_quo("id_vll","cat_jrn_vll","id_jrn",$id_cat_jrn,"ord");
		while($dt_cat_vll_jrn = ftc_ass($rq_cat_vll_jrn)) {
			$id_cat_vll = $dt_cat_vll_jrn['id_vll'];
			$dt_cat_vll = ftc_ass(sel_quo("lat,lon","cat_vll","id",$id_cat_vll));
			if(($lst_lat != 0 or $lst_lon != 0) and $id_cat_jrn != $last_jrn and $id_cat_vll != $last_vll and $pth != "&path=color:0x0000ff|weight:4") {$pth .= "&path=color:0x0000ff|weight:4";}//NOUVEAU TRACÉ
			if($id_cat_vll != $last_vll) {
				$lat = $dt_cat_vll['lat'];
				$lon = $dt_cat_vll['lon'];
				if($n > 5) {$n = 0;}
				$flg_mrk = true;
				if(isset($mrk_vll) and in_array($id_cat_vll,$mrk_vll)) {$flg_mrk=false;}
				if($flg_mrk) {
					$mrk_vll[]=$id_cat_vll;
					$ia = $i;
					$ib = 0;
					while($ia>25) {
						$ia = $ia-26;
						$ib++;
					}
					$lnk .= '&markers=color:'.$color[$n].'|label:'.$alphas[$ia].'|';
					$lnk .= number_format($lat,3).','.number_format($lon,3);
					$lst .= $alphas[$ia];
					if($ib>0) {$lst .= $ib;}
					$lst .= ' : '.$vll[$id_cat_vll].'<br />';
					$i++;
				}
				$pth .= '|'.number_format($lat,3).','.number_format($lon,3);
				$last_vll = $id_cat_vll;
				$lst_lat = $lat;
				$lst_lon = $lon;
				$n++;
			}
			$last_jrn = $id_cat_jrn;
		}
	}
	if($i>3) {// nombre de points minimum sur la carte
		$lnk .= "&key=".$googleAPIKey;
		$map[] = $lnk.$pth."&sensor=false";
		$leg[] = $lst;
	}
	else{
		$map[] = '';
		$leg[] = '';
	}
	unset($mrk_vll);
}
else{
	$map[] = '';
	$leg[] = '';
}
if(isset($map_prs)) {
	//$lnk = "https://api.jawg.io/static/?zoom=12&center=48.856,2.351&size=640x640&layer=jawg-sunny&access-token=".$jawgkey;
	$lnk = "https://maps.googleapis.com/maps/api/staticmap?size=640x640&maptype=terrain";
	$pth = "&path=color:0x0000ff|weight:4";
	$id_prv_prs = 0;
	$lst = '';
	$lst_lat = 0;
	$lst_lon = 0;
	$last_lieu = 0;
	$last_prs = 0;
	$n = 0;
	$i = 0;
	$v1 = 0;
	foreach($map_prs as $j => $id_cat_prs) {
		$rq_cat_lieu_prs = sel_quo("id_lieu","cat_prs_lieu","id_prs",$id_cat_prs,"ord");
		while($dt_cat_lieu_prs = ftc_ass($rq_cat_lieu_prs)) {
			$id_cat_lieu = $dt_cat_lieu_prs['id_lieu'];
			$dt_cat_lieu = ftc_ass(sel_quo("lat,lon,rpr,hbr,apt,id_vll","cat_lieu","id",$id_cat_lieu));
			if($id_prv_prs != $id_cat_prs) {
				$dt_cat_prs = ftc_ass(sel_quo("is_out","cat_prs","id",$id_cat_prs));
				if($dt_cat_lieu['apt']) {
					$id_prv_prs = $id_cat_prs;
					if($dt_cat_prs['is_out']) {$v1 = $dt_cat_lieu['id_vll'];}
					elseif($dt_cat_lieu['id_vll']!=$v1 and $v1 != 0) {
						$vol_id[] = $v1.'_'.$dt_cat_lieu['id_vll'];
						$v1 = 0;
					}
				}
			}
			if($dt_cat_lieu['rpr'] and $vue_map) {
				if(($lst_lat != 0 or $lst_lon != 0) and $id_cat_prs != $last_prs and $id_cat_lieu != $last_lieu and !$dt_cat_lieu['hbr']) {$pth .= "&path=color:0x0000ff|weight:4";}//NOUVEAU TRACÉ
				if(($id_cat_lieu != $last_lieu and (!$dt_cat_lieu['hbr'] or $dt_cat_prs['is_out'])) or ($dt_cat_lieu['hbr'] and (isset($map_hbr[$j]) or (isset($last_id_cat_hbr) and $last_vll_hbr == $dt_cat_lieu['id_vll'])))) {
					if($dt_cat_lieu['hbr']) {
						if(isset($map_hbr[$j])) {
							if($last_lieu !=0){
								$dt_cat_hbr = ftc_ass(sel_quo("id,lon,lat,id_vll","cat_hbr","id",$map_hbr[$j]));
								$last_id_cat_hbr = $id_cat_hbr = $dt_cat_hbr['id'];
								$last_lat_hbr = $lat = $dt_cat_hbr['lat'];
								$last_lon_hbr = $lon = $dt_cat_hbr['lon'];
								$last_vll_hbr = $dt_cat_hbr['id_vll'];
							}
							else{ //if first place is an undefined accommodation place
								$id_cat_hbr = 0;
								$lat = $dt_cat_lieu['lat'];
								$lon = $dt_cat_lieu['lon'];
							}
						}
						elseif(isset($last_id_cat_hbr) and $last_vll_hbr == $dt_cat_lieu['id_vll']) {
							$id_cat_hbr = $last_id_cat_hbr;
							$lat = $last_lat_hbr;
							$lon = $last_lon_hbr;
						}
						elseif($dt_cat_prs['is_out']){
							$id_cat_hbr = 0;
							$lat = $dt_cat_lieu['lat'];
							$lon = $dt_cat_lieu['lon'];
						}
					}
					else{
						$id_cat_hbr = 0;
						$lat = $dt_cat_lieu['lat'];
						$lon = $dt_cat_lieu['lon'];
					}
					if(mb_strlen($lnk.$pth)>1980 or (($lst_lat != 0 or $lst_lon !=0) and sqrt(pow(($lat-$lst_lat),2)+pow(($lon-$lst_lon),2))>MIN_DISTANCE_FOR_NEW_MAP) or $flgOut) {
						$flgOut = false;
						if($i>=3) { // nombre de points minimum sur la carte
							$lnk .= "&key=".$googleAPIKey;
							$map[] = $lnk.$pth."&sensor=false";
							$leg[] = $lst;
						}

						$lnk = "https://maps.googleapis.com/maps/api/staticmap?size=640x640&maptype=terrain";
						$pth = "&path=color:0x0000ff|weight:4";
						$lst = '';
						$lst_lat = 0;
						$lst_lon = 0;
						$i = 0;
						unset($mrk_lieu,$mrk_hbr,$last_id_cat_hbr);
					}
					if($n > 5) {$n = 0;}
					if($dt_cat_lieu['rpr']) {
						$flg_mrk = true;
						if(isset($mrk_lieu) and !$dt_cat_lieu['hbr'] and in_array($id_cat_lieu,$mrk_lieu)) {$flg_mrk=false;}
						elseif(isset($mrk_hbr) and $dt_cat_lieu['hbr'] and in_array($id_cat_hbr,$mrk_hbr)) {$flg_mrk=false;}
					}
					else{$flg_mrk=false;}
					if($flg_mrk) {
						if($dt_cat_lieu['hbr']) {$mrk_hbr[]=$id_cat_hbr;}
						else{$mrk_lieu[]=$id_cat_lieu;}
						$ia = $i;
						$ib = 0;
						while($ia>25) {
							$ia = $ia-26;
							$ib++;
						}

						$lnk .= '&markers=color:'.$color[$n].'|label:'.$alphas[$ia].'|';
						$lnk .= $lat.','.$lon;
						$lst .= $alphas[$ia];
						if($ib>0) {$lst .= $ib;}

						if($dt_cat_lieu['hbr'] and isset($map_hbr[$j])) {
							if($id_cat_hbr != 0) {
								$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$map_hbr[$j]));
								if(empty($dt_hbr['titre'])) {$lst .= ' : '.$dt_hbr['nom'].'<br />';}
								else{$lst .= ' : '.$dt_hbr['titre'].' ('.$vll[$dt_hbr['id_vll']].')<br />';}
							}
							else{$lst .= ' : '.$lieu_vll[array_search($id_cat_lieu,$lieu_uid)].'<br />';} //if first place is an undefined accommodation place
						}
						elseif(!empty($ttr_lieu[$lgg_crc][$id_cat_lieu])) {$lst .= ' : '.$ttr_lieu[$lgg_crc][$id_cat_lieu].'<br />';}
						else{$lst .= ' : '.$lieu[$id_cat_lieu].'<br />';}
						$i++;
					}
					$pth .= '|'.$lat.','.$lon;
					$last_lieu = $id_cat_lieu;
					$lst_lat = $lat;
					$lst_lon = $lon;
					$n++;
				}
				$last_prs = $id_cat_prs;
			}
		}
		if($dt_cat_prs['is_out']) {$flgOut = true;}
		else {$flgOut = false;}
	}
	if($i>=3) {// nombre de points minimum sur la carte
		$lnk .= "&key=".$googleAPIKey;
		$map[] = $lnk.$pth."&sensor=false";
		$leg[] = $lst;
	}
	unset($mrk_lieu,$mrk_hbr);
}
?>
