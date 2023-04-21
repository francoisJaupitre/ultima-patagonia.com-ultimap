<?php
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
include("../prm/rpl.php");
include("../cfg/ctg_hbr.php");
include("../prm/rgm.php");
include("../prm/room.php");
include("../prm/ncn.php");
include("../cfg/lng.php");
include("../cfg/vll.php");
$txt = simplexml_load_file('txt.xml');
$txt_res = simplexml_load_file('txt_res.xml');
if($id_dev_crc!=0) {$rq_dev = sel_quo("dev_crc.*,grp_dev.id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc);}
else{$rq_dev = sel_quo("dev_crc.*,grp_dev.id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.cnf","1");}
while($dt_dev = ftc_ass($rq_dev)) {
	$id_dev = $dt_dev['id'];
	$id_grp[$id_dev] = $dt_dev['id_grp'];
	$cnf[$id_dev] = $dt_dev['cnf'];
	$nom_gpe[$id_dev] = $dt_dev['groupe'];
	$id_clt[$id_dev] = $dt_dev['id_clt'];
	if($obj!='vch') {$lgg_crc[$id_dev] = $lgg_pys;}
	else{$lgg_crc[$id_dev] = $dt_dev['lgg'];}
	$id_lgg = $lgg[$lgg_crc[$id_dev]];
	$id_lgg_hbr = $lgg[$lgg_pys];
	$lgg_hbr = $lgg_pys;
	$lst_dev[] = $id_dev;
	$flg_send_crc = true;
	$k=0;
	$rq_pax = sel_quo("base","dev_crc_bss",array("vue","id_crc"),array("1",$id_dev),"base");
	while($dt_pax = ftc_ass($rq_pax)) {
		$nb_pax[0] = $dt_pax['base'];
		$k++;
	}
	if($dt_dev['ptl']) {$nb_pax[0] .= "+1";}
	if($k!=1) {$flg_err_crc = true;}
	$p[0]=0;
	$rq_rmn = sel_quo("id","dev_crc_rmn","id_crc",$id_dev);
	while($dt_rmn = ftc_ass($rq_rmn)) {
		$id_rmn = $dt_rmn['id'];
		$rq_pax = sel_grp("COUNT(nc) as nc,room,id_rmn","dev_crc_rmn_pax","id_rmn",$id_rmn,"room");
		while($dt_pax = ftc_ass($rq_pax)) {
			$nc = $dt_pax['nc'];
			$rm = $dt_pax['room'];
			if($rm>0) {
				if(isset($pax[0][$id_rmn])) {$pax[0][$id_rmn] .= $room[$id_lgg_hbr][$rm];}
				else{$pax[0][$id_rmn] = $room[$id_lgg_hbr][$rm];}
				if($cpc_room[$rm]>0) {$pax[0][$id_rmn] .= ': '.ceil($nc/$cpc_room[$rm]);}
				$pax[0][$id_rmn] .= " / ";
			}
		}
		$p[0]++;
		$pax[0][$id_rmn] = substr($pax[0][$id_rmn], 0, -3);
	}
	$rsp = '';
	$max_mdl = ftc_num(sel_quo("MAX(ord)","dev_mdl","id_crc",$id_dev));
	$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id_dev,"ord");
	while($dt_mdl = ftc_ass($rq_mdl)) {
		$id_dev_mdl = $dt_mdl['id'];
		$flg_send_mdl = true;
		if($dt_mdl['trf']) {
			$k=0;
			$rq_pax = sel_quo("base","dev_mdl_bss",array("vue","id_mdl"),array("1",$id_dev_mdl),"base");
			while($dt_pax = ftc_ass($rq_pax)) {
				$nb_pax[1] = $dt_pax['base'];
				$k++;
			}
			if($dt_mdl['ptl']) {$nb_pax[1] .= "+1";}
			if($k!=1) {
				$rsp_mdl[] = $txt->res_hbr->msg3->$id_lng.' '.$dt_mdl['ord'];
				$flg_send_mdl = false;
			}
			$p[$id_dev_mdl]=0;
			$rq_rmn = sel_quo("id","dev_mdl_rmn","id_mdl",$id_dev_mdl);
			while($dt_rmn = ftc_ass($rq_rmn)) {
				$id_rmn = $dt_rmn['id'];
				$rq_pax = sel_grp("COUNT(nc) as nc,room,id_rmn","dev_mdl_rmn_pax","id_rmn",$id_rmn,"room");
				while($dt_pax = ftc_ass($rq_pax)) {
					$nc = $dt_pax['nc'];
					$rm = $dt_pax['room'];
					if($rm>0) {
						$pax[1][$id_rmn] .= $room[$id_lgg_hbr][$rm];
						if($cpc_room[$rm]>0) {$pax[1][$id_rmn] .= ': '.ceil($nc/$cpc_room[$rm]);}
						$pax[1][$id_rmn] .= " / ";
					}
				}
				$p[$id_dev_mdl]++;
				if(isset($pax[1])) {$pax[1][$id_rmn] = substr($pax[1][$id_rmn], 0, -3);}
			}
			$rom = '';
			if($dt_mdl['sgl'] > 0) {$rom = $room[$id_lgg_hbr][1].': '.$dt_mdl['sgl']." / ";}
			if($dt_mdl['dbl_mat'] > 0) {$rom .= $room[$id_lgg_hbr][2].': '.$dt_mdl['dbl_mat']." / ";}
			if($dt_mdl['dbl_twn'] > 0) {$rom .= $room[$id_lgg_hbr][3].': '.$dt_mdl['dbl_twn']." / ";}
			if($dt_mdl['tpl_mat'] > 0) {$rom .= $room[$id_lgg_hbr][4].': '.$dt_mdl['tpl_mat']." / ";}
			if($dt_mdl['tpl_twn'] > 0) {$rom .= $room[$id_lgg_hbr][5].': '.$dt_mdl['tpl_twn']." / ";}
			if($dt_mdl['qdp'] > 0) {$rom .= $room[$id_lgg_hbr][6].': '.$dt_mdl['qdp']." / ";}
			//no existe if($dt_mdl['qtp'] > 0) {$rom .= $room[$id_lgg_hbr][7].': '.$dt_mdl['qtp']." / ";}
			if($dt_mdl['psg']) {$rom .= "+ SGL TL / ";}
			$nb_hbr[$id_dev_mdl] = num_rows(sel_quo("dev_hbr.id AS id_hbr","dev_hbr INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_jrn.id_mdl",$id_dev_mdl));
			if($rom == '' and $nb_hbr[$id_dev_mdl]>0 and !$p[$id_dev_mdl]) {
				$rsp_mdl[] = $txt->res_hbr->msg2->$id_lng.' '.$dt_mdl['ord'];
				$flg_send_mdl = false;
			}
			else{$rom = substr($rom, 0, -3);}
		}
		else{
			if(isset($flg_err_crc) and $flg_err_crc) {
				$rsp_crc[] = $txt->res_hbr->msg1->$id_lng;
				$flg_send_crc = false;
			}
			$rom = '';
			if($dt_dev['sgl'] > 0) {$rom = $room[$id_lgg_hbr][1].': '.$dt_dev['sgl']." / ";}
			if($dt_dev['dbl_mat'] > 0) {$rom .= $room[$id_lgg_hbr][2].': '.$dt_dev['dbl_mat']." / ";}
			if($dt_dev['dbl_twn'] > 0) {$rom .= $room[$id_lgg_hbr][3].': '.$dt_dev['dbl_twn']." / ";}
			if($dt_dev['tpl_mat'] > 0) {$rom .= $room[$id_lgg_hbr][4].': '.$dt_dev['tpl_mat']." / ";}
			if($dt_dev['tpl_twn'] > 0) {$rom .= $room[$id_lgg_hbr][5].': '.$dt_dev['tpl_twn']." / ";}
			if($dt_dev['qdp'] > 0) {$rom .= $room[$id_lgg_hbr][6].': '.$dt_dev['qdp']." / ";}
			//no existe	if($dt_dev['qtp'] > 0) {$rom .= $room[$id_lgg_hbr][7].': '.$dt_dev['qtp']." / ";}
			if($dt_dev['psg']) {$rom .= "+ SGL TL / ";}
			if($rom == '' and !$p[0]) {
				$rsp_crc[] = $txt->res_hbr->msg4->$id_lng;
				$flg_send_crc = false;
			}
			else{$rom = substr($rom, 0, -3);}
		}
		$max_jrn = ftc_num(sel_quo("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
		$rq_jrn = sel_quo("id,id_cat,date,ord","dev_jrn",array("opt","id_mdl"),array("1",$id_dev_mdl),"ord");
		while($dt_jrn = ftc_ass($rq_jrn)) {
			$id_dev_jrn = $dt_jrn['id'];
			$date_jrn = $dt_jrn['date'];
			$ord_jrn = $dt_jrn['ord'];
			if(empty($date_jrn) or $date_jrn=="0000-00-00") {
				$rsp_crc[] = $txt->res_hbr->msg5->$id_lng.' '.$ord_jrn;
				$flg_send_crc = $flg_send_mdl = false;
			}
			if(($dt_jrn['ord']==$max_jrn[0] and ($dt_mdl['fus']==1 or $dt_mdl['ord']==$max_mdl[0])) or $dt_jrn['id_cat']==-1) {$flg_sel_hbr = true;}
			else{$flg_sel_hbr = false;}

			$rq_prs = sel_quo("id,id_rmn,ctg,res,opt,heure","dev_prs","id_jrn",$id_dev_jrn,"opt DESC");
			while($dt_prs = ftc_ass($rq_prs)) {
				$id_dev_prs = $dt_prs['id'];
				$rq_hbr = sel_quo("*","dev_hbr","id_prs",$id_dev_prs);
				while($dt_hbr = ftc_ass($rq_hbr)) {
					$id_cat_hbr = $dt_hbr['id_cat'];
					$id_cat_chm = $dt_hbr['id_cat_chm'];
					if(
						(
							($cnf[$id_dev]>0 and $dt_prs['res']==1 and ($dt_hbr['sel']==1 or ($id_res_hbr!=0 and $obj!='vch')) and ($obj!='vch' xor ($obj=='vch' and ($dt_hbr['res']==2 or $id_cat_chm==-2))))
							or
							($cnf[$id_dev]<1 and $dt_prs['opt']==1 and ($dt_hbr['opt']==1 or ($id_res_hbr>0 and $id_res_chm>0)))
						)
						and (($id_res_hbr == $id_cat_hbr and ($id_res_chm == $id_cat_chm or $id_res_chm == 0 or $dt_prs['ctg']==11 or $dt_prs['ctg']==17)) or $id_res_hbr==0)
					 	and $id_cat_hbr > -2
					) { 	// preveer lista de fechas enviadas, confirmadas, anuladas etc.
						$flg_sel_hbr = true;
						if($id_cat_chm > -2) {
							$id_dev_hbr = $dt_hbr['id'];
							$id_rgm = $dt_hbr['rgm'];
							if($id_cat_hbr<=0 and $id_res_hbr==0) {
								$rsp_crc[] = $txt->res_hbr->msg6->$id_lng.' '.$ord_jrn;
								$flg_send_crc = $flg_send_mdl = false;
							}
							elseif($id_cat_chm<=0 and $id_res_hbr==$id_cat_hbr) {
								$rsp_crc[] = $txt->res_hbr->msg7->$id_lng.' '.$ord_jrn;
								$flg_send_crc = $flg_send_mdl = false;
							}
							else{
								if(!isset($hbr) or !in_array($id_cat_hbr,$hbr)) {$flg_new_hbr = true;}
								$hb = $id_cat_hbr;
								$rg = $id_rgm;
								if($flg_new_hbr) {
									$hbr[] = $hb;
									$ii[$hb][$rg]=0;
									$flg_new_hbr = false;
									$hbr_rgm[$hb][] = $id_rgm;
								}
								elseif(!isset($ii[$hb][$rg])) {
									$ii[$hb][$rg]=0;
									$flg_new_rgm = true;
									$hbr_rgm[$hb][] = $id_rgm;
								}
								else{$flg_new_rgm = false;}
								if(
									$flg_new_hbr
									or
									isset($flg_new_rgm) and $flg_new_rgm
									or
									isset($chm) and $chm[$hb][$rg][$ii[$hb][$rg]-1] != $id_cat_chm
								//	or $id_rgm != $hbr_rgm[$hb][$ii[$hb][$rg]-1]
									or !isset($rmn_pax[$hb][$rg][$ii[$hb][$rg]-1])
									or $dt_prs['id_rmn'] != $rmn_pax[$hb][$rg][$ii[$hb][$rg]-1]
									or ($rom != $rmn[$hb][$rg][$ii[$hb][$rg]-1] and !$pax[$dt_mdl['trf']][$dt_prs['id_rmn']])
									or (
										isset($pax[$dt_mdl['trf']][$dt_prs['id_rmn']])
										and $pax[$dt_mdl['trf']][$dt_prs['id_rmn']] != $rmn[$hb][$rg][$ii[$hb][$rg]-1]
										and (($dt_mdl['trf'] and $p[$id_dev_mdl]>1) or (!$dt_mdl['trf'] and $p[0]>1))
										and $pax[$dt_mdl['trf']][$dt_prs['id_rmn']]
									)
									or date ('Y-m-d', strtotime ("-".$j[$hb][$rg]." days $date_jrn")) != $hbr_in[$hb][$rg][$ii[$hb][$rg]-1]
									or (
										$dt_hbr['rva']!=''
										and $dt_hbr['rva']!=$rva[$hb][$rg][$ii[$hb][$rg]-1]
									)
								) {
									if($dt_prs['ctg']!=11 and $dt_prs['ctg']!=17) {
										$rva[$hb][$rg][$ii[$hb][$rg]] = $dt_hbr['rva'];
										$chm[$hb][$rg][$ii[$hb][$rg]] = $id_cat_chm;
										$nb_pax_hb[$hb][$rg][$ii[$hb][$rg]] = $nb_pax[$dt_mdl['trf']];
										if((($dt_mdl['trf'] and $p[$id_dev_mdl]>1) or (!$dt_mdl['trf'] and $p[0]>1)) and $pax[$dt_mdl['trf']][$dt_prs['id_rmn']]) {$rmn[$hb][$rg][$ii[$hb][$rg]] = $pax[$dt_mdl['trf']][$dt_prs['id_rmn']];}
										else{$rmn[$hb][$rg][$ii[$hb][$rg]] = $rom;}
										$rmn_pax[$hb][$rg][$ii[$hb][$rg]] = $dt_prs['id_rmn'];
										$hbr_in[$hb][$rg][$ii[$hb][$rg]] = $date_jrn;
										$mdl[$hb][$rg][$ii[$hb][$rg]] = $id_dev_mdl;
										$flg_out[$hb][$rg] = true;
										$old_dat[$hb][$rg][$ii[$hb][$rg]] = $date_jrn;
										$ii[$hb][$rg]++;
										$j[$hb][$rg]=1;
									}
									elseif($dt_prs['ctg']==11) {
										$hbr_early[$hb][] = $date_jrn;
										if(!is_null($dt_prs['heure'])) {$hre_early[$hb][] = $dt_prs['heure'];}
										if((($dt_mdl['trf'] and $p[$id_dev_mdl]>1) or (!$dt_mdl['trf'] and $p[0]>1)) and $pax[$dt_mdl['trf']][$dt_prs['id_rmn']]) {$rmn_early[$hb][$rg][$ii[$hb][$rg]] = $pax[$dt_mdl['trf']][$dt_prs['id_rmn']];}
										else{$rmn_early[$hb][$rg][$ii[$hb][$rg]] = $rom;}
									}
									elseif($dt_prs['ctg']==17) {
										$hbr_late[$hb][] = $date_jrn;
										if(!is_null($dt_prs['heure'])) {$hre_late[$hb][] = $dt_prs['heure'];}
										if((($dt_mdl['trf'] and $p[$id_dev_mdl]>1) or (!$dt_mdl['trf'] and $p[0]>1)) and $pax[$dt_mdl['trf']][$dt_prs['id_rmn']]) {$rmn_late[$hb][$rg][$ii[$hb][$rg]] = $pax[$dt_mdl['trf']][$dt_prs['id_rmn']];}
										else{$rmn_late[$hb][$rg][$ii[$hb][$rg]] = $rom;}
									}
									if($dt_mdl['trf']) {$flg_send[$id_dev][$hb]=$flg_send_mdl;}
									else{$flg_send[$id_dev][$hb]=$flg_send_crc;}
									$flg_send_crc=$flg_send_mdl=true;
								}
								else{
									$j[$hb][$rg]++;
									if(!empty($old_dat[$hb][$rg])) {
										foreach($old_dat[$hb][$rg] as $o => $old) {$old_dat[$hb][$rg][$o]=$date_jrn;}
									}
									else{								//AVOID BUG ON FUSIONED MODULE WITH 1 FREE NIGHT (= 2 HOTEL NIGHTS FOR 1 DAY!) // FJ 17-12-06
										$old_dat[$hb][$rg][0] = $date_jrn;
										$flg_out[$hb][$rg] = true;
									}
								}
							}
							$lst_srv[$id_dev][$id_cat_hbr][] = $id_dev_hbr;
						}
					}
				}
			}
			if(isset($flg_out)) {
				foreach($hbr_rgm as $hb => $flg_rgm) {
					foreach($flg_rgm as $rg) {
						$flg = $flg_out[$hb][$rg];
						if($flg) {
							$flg_hbr = false;
							for($k=0; $k<$ii[$hb][$rg];$k++) {//pour chaque sejour
								if(isset($old_dat[$hb][$rg][$k])) {
									if($old_dat[$hb][$rg][$k]!=$date_jrn) { //si la derniere nuit n'est pas cette journée
										$dat = $old_dat[$hb][$rg][$k];
										$hbr_out[$hb][$rg][$k] = date ('Y-m-d', strtotime ("+1 days $dat")); // le out sera cette journee en cours
										unset($old_dat[$hb][$rg][$k]);
									}
									else{$flg_hbr=true;}
								}
							}
							$flg_out[$hb][$rg] = $flg_hbr;
						}
					}
				}
			}
			if(!$flg_sel_hbr and ($id_res_hbr == 0 or $id_res_hbr == $id_cat_hbr)) {$rsp_crc[] = $txt->err->hbr_sel->$id_lng.' '.$ord_jrn;}
		}
		if($dt_mdl['trf'] and isset($rsp_mdl)) {$rsp .= implode(".\n",array_unique($rsp_mdl)).".\n";}
		unset($rsp_mdl);
	}
	if(isset($rsp_crc)) {$rsp .= implode(".\n",array_unique($rsp_crc)).".\n";}
	unset($rsp_crc);
	if(isset($flg_out)) {
		$date_jrn = date('Y-m-d', strtotime ("+1 days $date_jrn"));
		foreach($hbr_rgm as $hb => $flg_rgm) {
			foreach($flg_rgm as $rg) {
				$flg = $flg_out[$hb][$rg];
				if($flg) {
					for($k=0; $k<$ii[$hb][$rg];$k++) {
						if(isset($old_dat[$hb][$rg][$k]) and $old_dat[$hb][$rg][$k]!=$date_jrn) {
							$dat = $old_dat[$hb][$rg][$k];
							$hbr_out[$hb][$rg][$k] = date ('Y-m-d', strtotime ("+1 days $dat"));
						}
					}
				}
			}
		}
	}
	if(isset($hbr)) {
		$tab_hbr[$id_dev] = $hbr;
		$tab_rva[$id_dev] = $rva;
		$tab_chm[$id_dev] = $chm;
		$tab_rgm[$id_dev] = $hbr_rgm;
		$tab_rmn[$id_dev] = $rmn;
		if(isset($rmn_early)) {$tab_rmn_early[$id_dev] = $rmn_early;}
		if(isset($rmn_late)) {$tab_rmn_late[$id_dev] = $rmn_late;}
		$tab_rmn_pax[$id_dev] = $rmn_pax;
		$tab_in[$id_dev] = $hbr_in;
		$tab_out[$id_dev] = $hbr_out;
		$tab_mdl[$id_dev] = $mdl;
		if(isset($hbr_early)) {$tab_early[$id_dev] = $hbr_early;}
		if(isset($hre_early)) {$tab_hre_early[$id_dev] = $hre_early;}
		if(isset($hbr_late)) {$tab_late[$id_dev] = $hbr_late;}
		if(isset($hre_late)) {$tab_hre_late[$id_dev] = $hre_late;}
		$tab_nb_pax_hb[$id_dev] = $nb_pax_hb;
	}
	if($obj!='vch' and isset($tab_hbr[$id_dev])) {
		foreach($tab_hbr[$id_dev] as $i => $hb) {
			$dt_cat_hbr = ftc_ass(sel_quo("ctg","cat_hbr","id",$hb));
			foreach($tab_rgm[$id_dev][$hb] as $r => $rg) {
				$flg_rgm = true;
				foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch) {
					$dt_cat_chm = ftc_ass(sel_quo("nom","cat_hbr_chm","id",$ch));
					if(!isset($tab_chm[$id_dev][$hb][$rg][$j-1]) or $ch != $tab_chm[$id_dev][$hb][$rg][$j-1]) {
						if(isset($message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]])) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= '<br />Categoria: '.$dt_cat_chm['nom'].'<br />';}
						else {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] = '<br />Categoria: '.$dt_cat_chm['nom'].'<br />';}
					}
					if(($flg_rgm and (!isset($tab_rgm[$id_dev][$hb][$r-1]) or $rg != $tab_rgm[$id_dev][$hb][$r-1])) or !isset($tab_chm[$id_dev][$hb][$rg][$j-1]) or $ch != $tab_chm[$id_dev][$hb][$rg][$j-1]) {
						$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= '<br />Regimen: '.$rgm[$id_lgg_hbr][$rg].'<br /><br />';
						$flg_rgm = false;
					}
					if($rmg_hbr[$dt_cat_hbr['ctg']] and (
						!isset($tab_rmn[$id_dev][$hb][$rg][$j-1]) or $tab_rmn[$id_dev][$hb][$rg][$j] != $tab_rmn[$id_dev][$hb][$rg][$j-1]
						or !isset($tab_rgm[$id_dev][$hb][$j-1])
						or !isset($tab_rgm[$id_dev][$hb][$j])
						or $tab_rgm[$id_dev][$hb][$j] != $tab_rgm[$id_dev][$hb][$j-1]
						or !isset($tab_chm[$id_dev][$hb][$rg][$j-1]) or $ch != $tab_chm[$id_dev][$hb][$rg][$j-1]
					)) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= $tab_rmn[$id_dev][$hb][$rg][$j].'<br />';}
					elseif(empty($rmg_hbr[$dt_cat_hbr['ctg']])) {$rsp .= $txt->res_hbr->msg8->$id_lng.".\n";}
					$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= 'Check-in: '.date("d/m/Y", strtotime($tab_in[$id_dev][$hb][$rg][$j]));
					if(isset($tab_early[$id_dev][$hb])) {
						if(in_array($tab_in[$id_dev][$hb][$rg][$j],$tab_early[$id_dev][$hb])) {
							$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' con Early check-in';
							if(!is_null($tab_hre_early[$id_dev][$hb])) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' '.date("H:i", strtotime($tab_hre_early[$id_dev][$hb][$j])).$txt->res_frn->hs->$id_lgg;}
							if($tab_rmn[$id_dev][$hb][$rg][$j] != $tab_rmn_early[$id_dev][$hb][$rg][$j]) {
								if(empty($tab_rmn_early[$id_dev][$hb][$rg][$j])) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' ('.$txt_res->no_rmn->$id_lgg_hbr.')';}
								else{$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' ('.$tab_rmn_early[$id_dev][$hb][$rg][$j].')';}
							}
						}
					}
					$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= '<br />Check-out: '.date("d/m/Y", strtotime($tab_out[$id_dev][$hb][$rg][$j]));
					if(isset($tab_late[$id_dev][$hb])) {
						if(in_array($tab_out[$id_dev][$hb][$rg][$j],$tab_late[$id_dev][$hb])) {
							$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' con Late check-out';
							if(!is_null($tab_hre_late[$id_dev][$hb])) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' '.date("H:i", strtotime($tab_hre_late[$id_dev][$hb][$j])).$txt->res_frn->hs->$id_lgg;}
							if($tab_rmn[$id_dev][$hb][$rg][$j] != $tab_rmn_late[$id_dev][$hb][$rg][$j]) {
								if(empty($tab_rmn_late[$id_dev][$hb][$rg][$j])) {$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' ('.$txt_res->no_rmn->$id_lgg_hbr.')';}
								else{$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= ' ('.$tab_rmn_late[$id_dev][$hb][$rg][$j].')';}
							}
						}
					}
					$message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] .= '<br /><br />';
					if($rmg_hbr[$dt_cat_hbr['ctg']] and (
						!isset($tab_rmn[$id_dev][$hb][$rg][$j-1]) or $tab_rmn[$id_dev][$hb][$rg][$j] != $tab_rmn[$id_dev][$hb][$rg][$j-1]
						 or !isset($tab_rgm[$id_dev][$hb][$j])
						 or !isset($tab_rgm[$id_dev][$hb][$j-1])
						 or $tab_rgm[$id_dev][$hb][$j] != $tab_rgm[$id_dev][$hb][$j-1]
						 or !isset($tab_chm[$id_dev][$hb][$rg][$j-1]) or $ch != $tab_chm[$id_dev][$hb][$rg][$j-1]
					 )) {
						$dt_mdl = ftc_ass(sel_quo("trf","dev_mdl","id",$tab_mdl[$id_dev][$hb][$rg][$j]));
						if($tab_rmn_pax[$id_dev][$hb][$rg][$j]) {$id_rmn = $tab_rmn_pax[$id_dev][$hb][$rg][$j];}
						else{
							if($dt_mdl['trf']) {$dt_rmn = ftc_ass(sel_quo("id","dev_mdl_rmn",array("nr","id_mdl"),array("1",$tab_mdl[$id_dev][$hb][$rg][$j])));}
							else{$dt_rmn = ftc_ass(sel_quo("id","dev_crc_rmn",array("nr","id_crc"),array("1",$id_dev)));}
							$id_rmn = $dt_rmn['id'];
						}
						if($id_rmn>0) {
							$flg_pax = true;
							if($dt_mdl['trf']) {$rq_rmn_pax = sel_quo("*","dev_mdl_rmn_pax","id_rmn",$id_rmn,"nc,room");}
							else{$rq_rmn_pax = sel_quo("*","dev_crc_rmn_pax","id_rmn",$id_rmn,"nc,room");}
							while($dt_rmn_pax = ftc_ass($rq_rmn_pax)) {
								if($flg_pax) {
									$mesrmlst = '<table><tr><td>'.$txt_res->nom->$id_lgg_hbr.':</td><td>'.$txt_res->pre->$id_lgg_hbr.':</td><td>'.$txt_res->dob->$id_lgg_hbr.':</td><td>'.$txt_res->psp->$id_lgg_hbr.':</td><td>'.$txt_res->exp->$id_lgg_hbr.':</td><td>'.$txt_res->ncn->$id_lgg_hbr.':</td>';
									if($rmg_hbr[$dt_cat_hbr['ctg']]) {$mesrmlst .= '<td>'.$txt_res->rmn->$id_lgg_hbr.':</td>';}
									$mesrmlst .= '<td>'.$txt_res->info->$id_lgg_hbr.':</td>';
									$mesrmlst .= '</tr>';
									$flg_pax = false;
								}
								if($dt_rmn_pax['room']>0) {
									$dt_pax = ftc_ass(sel_quo("*","grp_pax","id",$dt_rmn_pax['id_pax']));
									$mesrmlst .= '<tr><td>'.stripslashes($dt_pax['nom']).'</td><td>'.stripslashes($dt_pax['pre']).'</td><td>';
									if($dt_pax['dob']!='0000-00-00') {$mesrmlst .= date("d/m/Y", strtotime($dt_pax['dob']));}
									$mesrmlst .= '</td><td>'.stripslashes($dt_pax['psp']).'</td><td>';
									if($dt_pax['exp']!='0000-00-00') {$mesrmlst .= date("d/m/Y", strtotime($dt_pax['exp']));}
									$mesrmlst .= '</td><td>'.$ncn[$id_lgg_hbr][$dt_pax['ncn']].'</td>';
									if($rmg_hbr[$dt_cat_hbr['ctg']]) {$mesrmlst .= '<td>'.$room[$id_lgg_hbr][$dt_rmn_pax['room']].': '.$dt_rmn_pax['nc']. '</td>';}
									$mesrmlst .= '<td>'.stripslashes($dt_pax['info']).'</td>';
									$mesrmlst .= '</tr>';
								}
							}
						$mesrmlst .= '</table><br/>';
						$mes_rmlst[$id_dev][$hb][$rg][$j] = $mesrmlst;
						$id_rmn=0;
						unset($mesrmlst);
						}
					}
				}
			}
		}
	}
}
?>
