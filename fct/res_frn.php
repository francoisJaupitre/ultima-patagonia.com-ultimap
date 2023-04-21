<?php
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
include("../prm/rpl.php");
include("../prm/ctg_prs.php");
include("../prm/ctg_srv.php");
include("../prm/res_srv.php");
include("../prm/ncn.php");
include("../cfg/lng.php");
include("../cfg/vll.php");
$txt = simplexml_load_file('txt.xml');
$txt_res = simplexml_load_file('txt_res.xml');
if($id_dev_crc!=0){$rq_dev = sel_quo("dev_crc.*,grp_dev.id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc);}
else{$rq_dev = sel_quo("dev_crc.*,grp_dev.id_clt","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.cnf","1");}
while($dt_dev = ftc_ass($rq_dev)){
	$id_dev = $dt_dev['id'];
	$id_grp[$id_dev] = $dt_dev['id_grp'];
	$cnf[$id_dev] = $dt_dev['cnf'];
	$nom_gpe[$id_dev] = $dt_dev['groupe'];
	$id_clt[$id_dev] = $dt_dev['id_clt'];
	if($obj!='vch'){$lgg_crc[$id_dev] = $lgg_pys;}
	else{$lgg_crc[$id_dev] = $dt_dev['lgg'];}
	$id_lgg = $lgg[$lgg_crc[$id_dev]];
	$id_lgg_frn = $lgg[$lgg_pys];
	$lgg_frn = $lgg_pys;
	$lst_dev[] = $id_dev;
	$flg_send_crc = $flg_crc = true;
	$n_pax = '';
	$rq_pax = sel_quo("base","dev_crc_bss",array("vue","id_crc"),array("1",$id_dev),"base");
	if(num_rows($rq_pax)!=1){$flg_err_crc = true;}
	while($dt_pax = ftc_ass($rq_pax)){$n_pax .= $dt_pax['base'].'/';}
	$nb_pax[0] = substr($n_pax, 0, -1);
	if($dt_dev['ptl']){$nb_pax[0] .= "+1";}
	$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id_dev,"ord");
	while($dt_mdl = ftc_ass($rq_mdl)){
		$id_dev_mdl = $dt_mdl['id'];
		$flg_send_mdl = true;
		if($dt_mdl['trf']==1){
			$n_pax = '';
			$rq_pax = sel_quo("base","dev_mdl_bss",array("vue","id_mdl"),array("1",$id_dev_mdl),"base");
			if(num_rows($rq_pax)!=1){
				$rsp_mdl[] = $txt->res_frn->msg2->$id_lng.' '.$dt_mdl['ord'].".\n";
				$flg_send_mdl = false;
			}
			while($dt_pax = ftc_ass($rq_pax)){$n_pax = $dt_pax['base'].'/';}
			$nb_pax[1] = substr($n_pax, 0, -1);
			if($dt_mdl['ptl']){$nb_pax[1] .= "+1";}
			$dt_rmn = ftc_ass(sel_quo("MIN(id) AS id","dev_mdl_rmn","id_mdl",$id_dev_mdl));
			$id_rmn = $dt_rmn['id'];
		}
		elseif($flg_crc){
			if($flg_err_crc){
				$rsp_crc[] = $txt->res_frn->msg1->$id_lng.".\n";
				$flg_send_crc = false;
			}
			$dt_rmn = ftc_ass(sel_quo("MIN(id) AS id","dev_crc_rmn","id_crc",$id_dev_crc));
			$id_rmn = $dt_rmn['id'];
			$flg_crc = false;
		}
		$rq_jrn = sel_quo("id,date,ord","dev_jrn",array("opt","id_mdl"),array("1",$id_dev_mdl),"ord");
		while($dt_jrn = ftc_ass($rq_jrn)){
			$id_dev_jrn = $dt_jrn['id'];
			$date_jrn = $dt_jrn['date'];
			if(empty($date_jrn) or $date_jrn=="0000-00-00"){
				$rsp_crc[] = $txt->res_frn->msg3->$id_lng.' '.$dt_jrn['ord'].".\n";
				$rsp_mdl[] = $txt->res_frn->msg3->$id_lng.' '.$dt_jrn['ord'].".\n";
				$flg_send_crc = false;
				$flg_send_mdl = false;
			}
			$rq_prs = sel_quo("id,id_cat,ctg,res,opt,heure,info","dev_prs","id_jrn",$id_dev_jrn,"ord");
			while($dt_prs = ftc_ass($rq_prs)){
				$id_dev_prs = $dt_prs['id'];
				$id_cat_prs = $dt_prs['id_cat'];
				$rq_srv = sel_whe("dev_srv.id,opt,res,id_frn,rva,vch,ctg","dev_srv INNER JOIN cat_frn ON dev_srv.id_frn = cat_frn.id","res<6 AND id_prs=".$id_dev_prs);
				while($dt_srv = ftc_ass($rq_srv)){
					if($guia_ctg_srv[$dt_srv['ctg']]){$prs_guia[$id_dev_prs] = 1;}
					if(
						(
							($cnf[$id_dev]>0 and $dt_prs['res']==1 and ($obj!='vch' or ($dt_srv['res']==2 and $dt_srv['vch']>0)))
						 	or
							($cnf[$id_dev]<1 and $dt_prs['opt']==1)
						)
						and (($id_res_frn == $dt_srv['id_frn'] or $id_res_frn == 0) and $dt_srv['opt']==1)
					){
						$id_dev_srv = $dt_srv['id'];
						$id_frn = $dt_srv['id_frn'];
						if($id_frn==0 and $id_res_frn==0){
							$rsp_crc[] = $txt->res_frn->msg4->$id_lng.' '.$dt_jrn['ord'].".\n";
							$rsp_mdl[] = $txt->res_frn->msg4->$id_lng.' '.$dt_jrn['ord'].".\n";
							$flg_send_crc = false;
							$flg_send_mdl = false;
						}
					elseif($id_cat_prs<=0 and $id_res_frn==$id_frn){
							$rsp_crc[] = $txt->res_frn->msg5->$id_lng.' '.$dt_jrn['ord'].".\n";
							$rsp_mdl[] = $txt->res_frn->msg5->$id_lng.' '.$dt_jrn['ord'].".\n";
							$flg_send_crc = false;
							$flg_send_mdl = false;
						}
						else{
							$flg_new_frn = true;
							if(isset($frn)){
								foreach($frn as $fr){
									if($fr == $id_frn){$flg_new_frn = false;}
								}
							}
							$fr = $id_frn;
							if($flg_new_frn){
								$frn[] = $fr;
								$ii[$fr]=0;
							}
							if(
								$flg_new_frn
								or $prs[$fr][$ii[$fr]-1] != $id_cat_prs
								or $rmn[$fr][$ii[$fr]-1] != $id_rmn
								or (
									!is_null($dt_prs['heure'])
									and $dt_prs['heure'] != $hre[$fr][$ii[$fr]-1]
								)
								or (
									$dt_prs['info']!=''
									and $dt_prs['info']!=$info[$fr][$ii[$fr]-1]
								)
								or date('Y-m-d', strtotime ("-".$j[$fr]." days $date_jrn")) != $frn_in[$fr][$ii[$fr]-1]
								or (
									$dt_srv['rva']!=''
									and $dt_srv['rva']!=$rva[$fr][$ii[$fr]-1]
								)
							){
								$rva[$fr][$ii[$fr]] = $dt_srv['rva'];
								$prs[$fr][$ii[$fr]] = $id_cat_prs;
								$rmn[$fr][$ii[$fr]] = $id_rmn;
								$nb_pax_fr[$fr][$ii[$fr]] = $nb_pax[$dt_mdl['trf']];
								$frn_in[$fr][$ii[$fr]] = $date_jrn;
								$hre[$fr][$ii[$fr]] = $dt_prs['heure'];
								$info[$fr][$ii[$fr]]=$dt_prs['info'];
								$prs_ctg[$fr][$ii[$fr]]=$dt_prs['ctg'];
								$prs_id[$fr][$ii[$fr]]=$id_dev_prs;
								$mdl[$fr][$ii[$fr]] = $id_dev_mdl;
								$flg_out[$fr] = true;
								$old_dat[$fr][$ii[$fr]] = $date_jrn;
								$ii[$fr]++;
								$j[$fr]=1;
							}
							else{
								$j[$fr]++;
								if(!empty($old_dat[$fr])){
									foreach($old_dat[$fr] as $o => $old){$old_dat[$fr][$o]=$date_jrn;}
								}
								else{								// idem correction bug res_hbr
									$old_dat[$fr][0] = $date_jrn;
									$flg_out[$fr] = true;
								}
							}
						}
						$lst_srv[$id_dev][$id_frn][] = $id_dev_srv;
						if($dt_mdl['trf']){$flg_send[$id_dev][$fr]=$flg_send_mdl;}
						else{$flg_send[$id_dev][$fr]=$flg_send_crc;}
						$flg_send_crc=$flg_send_mdl=true;
					}
				}
			}
			if(isset($flg_out)){
				foreach($flg_out as $fr => $flg){
					if($flg){
						$flg_frn = false;
						for($k=0; $k<$ii[$fr];$k++){
							if(isset($old_dat[$fr][$k])){
								if($old_dat[$fr][$k]!=$date_jrn){
									$frn_out[$fr][$k] = $old_dat[$fr][$k];
									unset($old_dat[$fr][$k]);
								}
								else{$flg_frn=true;}
							}
						}
						$flg_out[$fr] = $flg_frn;
					}
				}
			}
		}
		if($dt_mdl['trf'] and isset($rsp_mdl)){$rsp .= implode(".\n",array_unique($rsp_mdl)).".\n";}
		unset($rsp_mdl);
	}
	if(isset($rsp_crc)){$rsp .= implode(".\n",array_unique($rsp_crc)).".\n";}
	unset($rsp_crc);
	if(isset($flg_out)){
		$date_jrn = date('Y-m-d', strtotime ("+1 days $date_jrn"));
		foreach($flg_out as $fr => $flg){
			if($flg){
				for($k=0; $k<$ii[$fr];$k++){;
					if(isset($old_dat[$fr][$k]) and $old_dat[$fr][$k]!=$date_jrn){
						$dat = $old_dat[$fr][$k];
						$frn_out[$fr][$k] = $dat;
					}
				}
			}
		}
	}
	if(isset($frn)){
		$tab_frn[$id_dev] = $frn;
		$tab_rva[$id_dev] = $rva;
		$tab_prs[$id_dev] = $prs;
		$tab_rmn[$id_dev] = $rmn;
		$tab_nb_pax_fr[$id_dev] = $nb_pax_fr;
		$tab_in[$id_dev] = $frn_in;
		$tab_out[$id_dev] = $frn_out;
		$tab_hre[$id_dev] = $hre;
		$tab_info[$id_dev] = $info;
		$tab_ctg_prs[$id_dev] = $prs_ctg;
		$tab_prs_id[$id_dev] = $prs_id;
		$tab_mdl[$id_dev] = $mdl;
	}
	if($obj!='vch' and isset($tab_frn[$id_dev])){
		foreach($tab_frn[$id_dev] as $i => $fr){
			unset($old_dat,$nbpx);
			if(count(array_unique($tab_nb_pax_fr[$id_dev][$fr])) > 1){
				foreach(array_unique($tab_nb_pax_fr[$id_dev][$fr]) as $pax){$nbpx .= $pax.' / ';}
				$nbpax[$id_dev][$fr] = substr($nbpx, 0, -3);
				$flg_mlt_pax = true;
			}
			else{
				$nbpax[$id_dev][$fr] = $tab_nb_pax_fr[$id_dev][$fr][0];
				$flg_mlt_pax = false;
			}
			foreach($tab_prs[$id_dev][$fr] as $j => $pr){
				if($tab_ctg_prs[$id_dev][$fr][$j] != 10){
					$dat = date("d/m/Y", strtotime($tab_in[$id_dev][$fr][$j]));
					if($tab_out[$id_dev][$fr][$j]!=$tab_in[$id_dev][$fr][$j] and !empty($tab_out[$id_dev][$fr][$j]) and $tab_ctg_prs[$id_dev][$fr][$j] != 19 and $tab_ctg_prs[$id_dev][$fr][$j] != 20){$dat .= ' - '.date("d/m/Y", strtotime($tab_out[$id_dev][$fr][$j]));}
					if($dat!=$old_dat or $pr!=$old_prs){$message[$id_dev][$fr] .= '<br />';}
					if($dat!=$old_dat){
						$message[$id_dev][$fr] .= '<br />'.$dat.':<br />';
						$old_dat = $dat;
					}
				}
				if($tab_prs_id[$id_dev][$fr][$j]!=$old_prs_id[$fr]){
					$dt_cat_prs = ftc_ass(sel_quo("nom,duree,is_out,titre,ref","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_frn,"cat_prs.id",$pr));
//					if(!empty($dt_cat_prs['ref'])){$message[$id_dev][$fr] .= ' ['.$dt_cat_prs['ref'].']<br />';}
					if($flg_mlt_pax){$message[$id_dev][$fr] .= ' x'.$tab_nb_pax_fr[$id_dev][$fr][$j].'<br />';}
					$old_prs = $pr;
					$old_prs_id[$fr] = $tab_prs_id[$id_dev][$fr][$j];
					if(!isset($lieu_prs[$id_dev][$pr])){
						$rq_prs_lieu = sel_quo("id_lieu","cat_prs_lieu",array("shw","id_prs"),array("1",$pr),"ord");
						while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){$lieu_prs[$id_dev][$pr][] = $dt_prs_lieu['id_lieu'];}
					}
					$flg_rtc = true;
					if($tab_ctg_prs[$id_dev][$fr][$j] == 10){
						for($k = $j;$k < count($tab_in[$id_dev][$fr]); $k++){
							$earlier = new DateTime($tab_in[$id_dev][$fr][$k]);
							$later = new DateTime($tab_out[$id_dev][$fr][$j]);
							$diff = $later->diff($earlier)->format("%a");
							if($diff==1 and $tab_ctg_prs[$id_dev][$fr][$j] == $tab_ctg_prs[$id_dev][$fr][$k] and $tab_prs[$id_dev][$fr][$j] == $tab_prs[$id_dev][$fr][$k]){
								$tab_in[$id_dev][$fr][$k] = $tab_in[$id_dev][$fr][$j];
								$flg_rtc = false;
							}
						}
						if($flg_rtc){
							$earlier = new DateTime($tab_in[$id_dev][$fr][$j]);
							$later = new DateTime($tab_out[$id_dev][$fr][$j]);
							$diff = $later->diff($earlier)->format("%a");
							$message[$id_dev][$fr] .=  '<br />'.$ctg_prs[$id_lgg_frn][$tab_ctg_prs[$id_dev][$fr][$j]].' '.($diff+1).' '.$txt->res_frn->jours->$id_lgg_frn.' ';
						}
					}
					if($flg_rtc){
						if($tab_ctg_prs[$id_dev][$fr][$j]!=10){
							if(!is_null($tab_hre[$id_dev][$fr][$j])){$message[$id_dev][$fr] .= date("H:i", strtotime($tab_hre[$id_dev][$fr][$j])).$txt->res_frn->hs->$id_lgg.": ";}
							if(isset($lieu_prs[$id_dev][$pr])){$message[$id_dev][$fr] .= $ctg_prs[$id_lgg_frn][$tab_ctg_prs[$id_dev][$fr][$j]]." ";}
							if(!$dt_cat_prs['is_out']){$message[$id_dev][$fr] .= $tab_info[$id_dev][$fr][$j]." ";}
						}
						if(!empty($dt_cat_prs['ref'])){$message[$id_dev][$fr] .= '['.$dt_cat_prs['ref'].'] ';}
						$dt_prs = ftc_ass(sel_quo("id_jrn,id_mdl,dev_jrn.ord AS ord_jrn,dev_mdl.ord AS ord_mdl,fus","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn= dev_jrn.id","dev_prs.id",$tab_prs_id[$id_dev][$fr][$j]));
						$id_jrn = $dt_prs['id_jrn'];
						if(!isset($ord[$fr][$id_jrn])){$ord[$fr][$id_jrn]=1;}
						if($id_jrn!=$new_jrn[$fr]){
							$new_jrn[$fr] = $id_jrn;
							$flg_new = $flg_old = true;
							$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$id_jrn);
							while($dt_dev_prs = ftc_ass($rq_dev_prs)){
								$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
								while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
									if(
										(
											($cnf[$id_dev]>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)))
											or
											($cnf[$id_dev]<1 and $dt_dev_hbr['opt']==1)
										)
										and $dt_dev_hbr['id_cat']!=0
									){
										$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_frn,"cat_hbr.id",$dt_dev_hbr['id_cat']));
										if($dt_cat_hbr['titre']==''){$new_hbr_nom[$fr] = $dt_cat_hbr['nom'];}
										else{$new_hbr_nom[$fr] = $dt_cat_hbr['titre'];}
										$new_vll[$fr] = $dt_cat_hbr['id_vll'];
									}
									$flg_new = false;
								}
							}
							if($flg_new and !$dt_cat_prs['is_out']){
								if(!$dt_prs['fus']){
									if(isset($old_hbr_nom[$fr])){$new_hbr_nom[$fr]=$old_hbr_nom[$fr];}
									else{$new_hbr_nom[$fr]='NO HOTEL!';}
								}
								else{
									$dt_dev_mdl = ftc_ass(sel_quo("id","dev_mdl",array("ord","id_crc"),array($dt_prs['ord_mdl']+1,$id_dev)));
									$dt_dev_jrn = ftc_ass(sel_quo("id","dev_jrn",array("ord","id_mdl"),array($dt_prs['ord_jrn'],$dt_dev_mdl['id'])));
									$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$dt_dev_jrn['id']);
									while($dt_dev_prs = ftc_ass($rq_dev_prs)){
										$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
										while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
											if(
												(
													($cnf[$id_dev]>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)))
													or
													($cnf[$id_dev]<1 and $dt_dev_hbr['opt']==1)
												)
												and $dt_dev_hbr['id_cat']!=0
											){
												$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_frn,"cat_hbr.id",$dt_dev_hbr['id_cat']));
												if($dt_cat_hbr['titre']==''){$new_hbr_nom[$fr] = $dt_cat_hbr['nom'];}
												else{$new_hbr_nom[$fr] = $dt_cat_hbr['titre'];}
												$new_vll[$fr] = $dt_cat_hbr['id_vll'];
											}
										}
									}
								}
							}
						}

						if($flg_old or !isset($old_hbr_nom[$fr])){
							$flg_old = false;
							$dt_jrn = ftc_ass(sel_quo("date","dev_jrn","id",$id_jrn));
							$dat = $dt_jrn['date'];
							$dat = date("Y-m-d",strtotime("-1 days $dat"));
							$dt_mdl = ftc_ass(sel_quo("dev_mdl.id,dev_mdl.ord","dev_jrn LEFT JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_jrn));
							$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("opt","date","id_mdl"),array("1",$dat,$dt_mdl['id'])));
							if($dt_jrn['id']==''){
								$ord_mdl = $dt_mdl['ord']-1;
								if($ord_mdl>0){
									$dt_mdl = ftc_ass(sel_quo("id","dev_mdl",array("id_crc","ord"),array($id_dev,$ord_mdl)));
									$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("opt","date","id_mdl"),array("1",$dat,$dt_mdl['id'])));
								}
							}
							if($dt_jrn['id']!=$old_jrn[$pr]){
								$old_jrn[$pr] = $dt_jrn['id_jrn'];
								$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$dt_jrn['id']);
								while($dt_dev_prs = ftc_ass($rq_dev_prs)){
									$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
									while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
										if($cnf[$id_dev]==1 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)) and $dt_dev_hbr['id_cat']!=0){
											$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_frn,"cat_hbr.id",$dt_dev_hbr['id_cat']));
											if($dt_cat_hbr['titre']==''){$old_hbr_nom[$fr] = $dt_cat_hbr['nom'];}
											else{$old_hbr_nom[$fr] = $dt_cat_hbr['titre'];}
											$old_vll[$fr] = $dt_cat_hbr['id_vll'];
										}
									}
								}
							}
						}
						$flg_un = false;
						if(isset($lieu_prs[$id_dev][$pr])){
							foreach($lieu_prs[$id_dev][$pr] as $id_lieu){
								if($flg_un){$message[$id_dev][$fr] .= " - ";}
								else{$flg_un = true;}
								$flg_hbr = true;
								$dt_lieu = ftc_ass(sel_quo("nom,hbr,titre,id_vll","cat_lieu LEFT JOIN cat_lieu_txt ON cat_lieu.id = cat_lieu_txt.id_lieu AND lgg=".$lgg_frn,"cat_lieu.id",$id_lieu));
								if($dt_lieu['hbr']){
									if($ord[$fr][$id_jrn]==1 and $old_hbr_nom[$fr]!='' and $old_vll[$fr]==$dt_lieu['id_vll']){$message[$id_dev][$fr] .= $old_hbr_nom[$fr].' ('.$vll[$old_vll[$fr]].')';}
									elseif($new_hbr_nom[$fr]!='' and $new_vll[$fr]==$dt_lieu['id_vll']){$message[$id_dev][$fr] .= $new_hbr_nom[$fr].' ('.$vll[$new_vll[$fr]].')';}
									elseif($old_hbr_nom[$fr]!='' and $old_vll[$fr]==$dt_lieu['id_vll']){$message[$id_dev][$fr] .= $old_hbr_nom[$fr].' ('.$vll[$old_vll[$fr]].')';}
									else{$flg_hbr = false;}
								}
								else{$flg_hbr = false;}
								if(!$flg_hbr){
									if($dt_lieu['titre']==''){$message[$id_dev][$fr] .= $dt_lieu['nom'];}
									else{$message[$id_dev][$fr] .= $dt_lieu['titre'];}
								}
								$ord[$fr][$id_jrn]++;
							}
						}
						elseif($dt_cat_prs['titre']==''){$message[$id_dev][$fr] .= $dt_cat_prs['nom'];}
						else{$message[$id_dev][$fr] .= $dt_cat_prs['titre'];}
						if($dt_cat_prs['is_out']){$message[$id_dev][$fr] .= " OUT: ".$tab_info[$id_dev][$fr][$j];}
						if(!is_null($dt_cat_prs['duree'])){
							$message[$id_dev][$fr] .= '<br />-> '.$txt->res_frn->duree->$id_lgg_frn.': ';
							if(date("i", strtotime($dt_cat_prs['duree']))=='00'){$message[$id_dev][$fr] .= date("H", strtotime($dt_cat_prs['duree'])).$txt->res_frn->hs->$id_lgg." ";}
							else{$message[$id_dev][$fr] .= date("H:i", strtotime($dt_cat_prs['duree'])).$txt->res_frn->hs->$id_lgg." ";}
						}

						unset($old_frn,$old_ctg,$old_nom);
						$rq_srv = sel_whe("id_cat,id_frn,ctg,dev_srv.lgg,nom,titre,res","dev_srv LEFT JOIN cat_srv_txt ON dev_srv.id_cat = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_frn,"res<6 AND opt=1 AND id_prs=".$tab_prs_id[$id_dev][$fr][$j],"id_frn,ctg,nom");
						while($dt_srv = ftc_ass($rq_srv)){
							if($dt_srv['id_frn']!=$old_frn or $dt_srv['ctg']!=$old_ctg or ($dt_srv['nom']!=$old_nom and ($mrk_nom_ctg_srv[$dt_srv['ctg']] or $mrk_ctg_ctg_srv[$dt_srv['ctg']]))) {
								$old_frn = $dt_srv['id_frn'];
								$old_ctg = $dt_srv['ctg'];
								$old_nom = $dt_srv['nom'];
								if($dt_srv['id_frn']!=$fr){
									if($mrk_ctg_ctg_srv[$dt_srv['ctg']] or $mrk_nom_ctg_srv[$dt_srv['ctg']]){
										$message[$id_dev][$fr] .= '<br />->';


										/*idem*/
										if($mrk_ctg_ctg_srv[$dt_srv['ctg']]){
											$message[$id_dev][$fr] .= ' '.$ctg_srv[$id_lgg_frn][$dt_srv['ctg']].' ';
											if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$message[$id_dev][$fr] .= '('.$nom_lgg_lgg[$id_lgg_frn][$dt_srv['lgg']].') ';}
										}
										if($mrk_nom_ctg_srv[$dt_srv['ctg']]){
											if($dt_srv['titre']==''){
												$message[$id_dev][$fr] .= ' '.$dt_srv['nom'];
												if(!$mrk_ctg_ctg_srv[$dt_srv['ctg']] and $lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$message[$id_dev][$fr] .= '('.$nom_lgg_lgg[$id_lgg_frn][$dt_srv['lgg']].') ';}
											}
											else{$message[$id_dev][$fr] .= ' '.$dt_srv['titre'];}
										}


										if($dt_srv['id_frn']>0){
											$dt_cat_frn = ftc_ass(sel_quo("nom","cat_frn","id",$dt_srv['id_frn']));
											$message[$id_dev][$fr] .= ": ".$dt_cat_frn['nom'];
										}
										else{$message[$id_dev][$fr] .= ": SIN DEFINIR";}
									}
								}
								elseif($mrk_srv_ctg_prs[$tab_ctg_prs[$id_dev][$fr][$j]]){
									$message[$id_dev][$fr] .= '<br />->';
									if($srv_ctg_srv[$dt_srv['ctg']]){$message[$id_dev][$fr] .= ' '.$txt->res_frn->msg6->$id_lgg_frn;}

									/*idem*/
									if($mrk_ctg_ctg_srv[$dt_srv['ctg']]){
										$message[$id_dev][$fr] .= ' '.$ctg_srv[$id_lgg_frn][$dt_srv['ctg']].' ';
										if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$message[$id_dev][$fr] .= '('.$nom_lgg_lgg[$id_lgg_frn][$dt_srv['lgg']].') ';}
									}
									if($mrk_nom_ctg_srv[$dt_srv['ctg']]){
										if($dt_srv['titre']==''){
											$message[$id_dev][$fr] .= ' '.$dt_srv['nom'];
											if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$message[$id_dev][$fr] .= '('.$nom_lgg_lgg[$id_lgg_frn][$dt_srv['lgg']].') ';}
										}
										else{$message[$id_dev][$fr] .= ' '.$dt_srv['titre'];}
									}


									if($dt_srv['res']>1){$message[$id_dev][$fr] .= ": ".$res_srv[$id_lgg_frn][$dt_srv['res']];}
									else{$message[$id_dev][$fr] .= ": ".$txt->res_frn->compris->$id_lgg.' ';}
								}
							}
						}
						$message[$id_dev][$fr] .= '<br />';
					}

					$dt_mdl = ftc_ass(sel_quo("trf","dev_mdl","id",$tab_mdl[$id_dev][$fr][$j]));
					$flg_pax = true;
					if($dt_mdl['trf']){$rq_rmn_pax = sel_quo("*","dev_mdl_pax INNER JOIN grp_pax ON dev_mdl_pax.id_pax = grp_pax.id","id_mdl",$tab_mdl[$id_dev][$fr][$j],"ord");}
					else{$rq_rmn_pax = sel_quo("*","dev_crc_pax INNER JOIN grp_pax ON dev_crc_pax.id_pax = grp_pax.id","id_crc",$id_dev,"ord");}
					while($dt_rmn_pax = ftc_ass($rq_rmn_pax)){
						if($flg_pax){
							$mespxlst = '<table><tr><td>'.$txt_res->nom->$id_lgg_frn.':</td><td>'.$txt_res->pre->$id_lgg_frn.':</td><td>'.$txt_res->dob->$id_lgg_frn.':</td><td>'.$txt_res->psp->$id_lgg_frn.':</td><td>'.$txt_res->exp->$id_lgg_frn.':</td><td>'.$txt_res->ncn->$id_lgg_frn.':</td><td>'.$txt_res->info->$id_lgg_frn.':</td></tr>';
							$flg_pax = false;
						}
						$mespxlst .= '<tr><td>'.stripslashes($dt_rmn_pax['nom']).'</td><td>'.stripslashes($dt_rmn_pax['pre']).'</td><td>';
						if($dt_rmn_pax['dob']!='0000-00-00'){$mespxlst .= date("d/m/Y", strtotime($dt_rmn_pax['dob']));}
						$mespxlst .= '</td><td>'.stripslashes($dt_rmn_pax['psp']).'</td><td>';
						if($dt_rmn_pax['exp']!='0000-00-00'){$mespxlst .= date("d/m/Y", strtotime($dt_rmn_pax['exp']));}
						$mespxlst .= '</td><td>'.$ncn[$id_lgg_frn][$dt_rmn_pax['ncn']].'</td><td>'.stripslashes($dt_rmn_pax['info']).'</td></tr>';
					}
					$mespxlst .= '</table><br/><br/>';
					$mes_pxlst[$id_dev][$fr][] = $mespxlst;


				}
			}
			$message[$id_dev][$fr] .= '<br />';
		}
		$message[$id_dev][$fr] .= '<br />';
	}
}
?>
