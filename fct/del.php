<?php
if(isset($_POST['id']) and $_POST['id'] >0) {
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/lng.php");
	$id = $_POST['id'];
	$txt = simplexml_load_file('txt.xml');
	switch($_POST['cbl']) {
		case 'grp':
			$num_crc = sel_quo("id","dev_crc","id_grp",$id);
			$num_fin = sel_quo("id","fin_bdg","id_grp",$id);
			if(num_rows($num_crc)==0 and num_rows($num_fin)==0) {
				delete("grp_res","id_grp",$id);
				delete("grp_pax","id_grp",$id);
				delete("grp_dev","id",$id);
			}
			else{echo $txt->del->grp->$id_lng;}
			break;
		case 'fin':
		case 'arc':
			$rq_crc = sel_quo("id_grp","dev_crc","id",$id);
			if(num_rows($rq_crc)) { //serveur bug erreur d'affichage (deja effacé)
				$rq_sel_mdl = sel_quo("id","dev_mdl","id_crc",$id);
				while($dt_sel_mdl = ftc_ass($rq_sel_mdl)) {
					$id_mdl = $dt_sel_mdl['id'];
					delete("dev_mdl_pax","id_mdl",$id_mdl);
					$rq_sel_rmn = sel_quo("id","dev_mdl_rmn","id_mdl",$id_mdl);
					while($dt_sel_rmn = ftc_ass($rq_sel_rmn)) {delete("dev_mdl_rmn_pax","id_rmn",$dt_sel_rmn['id']);}
					delete("dev_mdl_rmn","id_mdl",$id_mdl);
					delete("dev_mdl_bss","id_mdl",$id_mdl);
					$rq_sel_jrn = sel_quo("id","dev_jrn","id_mdl",$id_mdl);
					while($dt_sel_jrn = ftc_ass($rq_sel_jrn)) {
						$id_jrn = $dt_sel_jrn['id'];
						$rq_sel_prs = sel_quo("id","dev_prs","id_jrn",$id_jrn);
						while($dt_sel_prs = ftc_ass($rq_sel_prs)) {
							$id_prs = $dt_sel_prs['id'];
							$rq_sel_srv = sel_quo("id","dev_srv","id_prs",$id_prs);
							while($dt_sel_srv = ftc_ass($rq_sel_srv)) {
								$id_srv = $dt_sel_srv['id'];
								delete("dev_srv_pay","id_srv",$id_srv);
								delete("dev_srv_trf","id_srv",$id_srv);
							}
							delete("dev_srv","id_prs",$id_prs);
							$rq_sel_hbr = sel_quo("id","dev_hbr","id_prs",$dt_sel_prs['id']);
							while($dt_sel_hbr = ftc_ass($rq_sel_hbr)) {delete("dev_hbr_pay","id_hbr",$dt_sel_hbr['id']);}
							delete("dev_hbr","id_prs",$id_prs);
						}
						delete("dev_prs","id_jrn",$id_jrn);
					}
					delete("dev_jrn","id_mdl",$id_mdl);
					delete("dev_mdl_bss","id_mdl",$id_mdl);
					delete("dev_mdl_rgn","id_mdl",$id_mdl);
				}
				delete("dev_mdl","id_crc",$id);
				delete("dev_crc_pax","id_crc",$id);
				$rq_sel_rmn = sel_quo("id","dev_crc_rmn","id_crc",$id);
				while($dt_sel_rmn = ftc_ass($rq_sel_rmn)) {delete("dev_crc_rmn_pax","id_rmn",$dt_sel_rmn['id']);}
				delete("dev_crc_rmn","id_crc",$id);
				delete("dev_crc_bss","id_crc",$id);
				delete("dev_vol","id_crc",$id);
				$dt_crc = ftc_ass($rq_crc);
				$id_grp = $dt_crc['id_grp'];
				$rq_crc = sel_quo("id","dev_crc","id_grp",$id_grp);
				$rq_pax = sel_quo("id","grp_pax","id_grp",$id_grp);
				$rq_res = sel_quo("id","grp_res","id_grp",$id_grp);
				$rq_tsk = sel_quo("id","grp_tsk","id_grp",$id_grp);
				if(num_rows($rq_crc)==0 and num_rows($rq_pax)==0 and num_rows($rq_res)==0 and num_rows($rq_tsk)==0) {delete("grp_dev","id",$id_grp);}
				delete("dev_crc","id",$id);
			}
			break;
		case 'crc':
			delete("cat_crc","id",$id);
			delete("cat_crc_mdl","id_crc",$id);
			delete("cat_crc_txt","id_crc",$id);
			delete("cat_crc_clt","id_crc",$id);
			upd_cat("dev_crc",$id);
			break;
		case 'mdl':
			$rq_mdl_txt = sel_whe("id","cat_mdl_txt","id_mdl =".$id." AND web_uid!=''");
			if(num_rows($rq_mdl_txt) == 0) {
				$dt_crc_mdl = ftc_ass(sel_quo("id","cat_crc_mdl","id_mdl",$id));
				if(empty($dt_crc_mdl['id'])) {
					delete("cat_mdl","id",$id);
					delete("cat_mdl_jrn","id_mdl",$id);
					delete("cat_mdl_txt","id_mdl",$id);
					delete("cat_mdl_rgn","id_mdl",$id);
					upd_cat("dev_mdl",$id);
				}
				else{
					$rq_crc_mdl = sel_quo("nom","cat_crc_mdl INNER JOIN cat_crc ON cat_crc_mdl.id_crc = cat_crc.id","id_mdl",$id,"nom");
					while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {$err .= $dt_crc_mdl['nom']."\n";}
					echo $txt->del->mdl->$id_lng.$err;
				}
			}
			else{echo $txt->del->mdl2->$id_lng;}
			break;
		case 'jrn':
			$dt_mdl_jrn = ftc_ass(sel_quo("id","cat_mdl_jrn","id_jrn",$id));
			if(empty($dt_mdl_jrn['id'])) {
				delete("cat_jrn","id",$id);
				delete("cat_jrn_prs","id_jrn",$id);
				delete("cat_jrn_txt","id_jrn",$id);
				delete("cat_jrn_vll","id_jrn",$id);
				delete("cat_jrn_pic","id_jrn",$id);
				upd_cat("dev_jrn",$id);
			}
			else{
				$rq_mdl_jrn = sel_quo("nom","cat_mdl_jrn INNER JOIN cat_mdl ON cat_mdl_jrn.id_mdl = cat_mdl.id","id_jrn",$id,"nom");
				while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)) {$err .= $dt_mdl_jrn['nom']."\n";}
				echo $txt->del->jrn->$id_lng.$err;
			}
			break;
		case 'prs':
			$dt_jrn_prs = ftc_ass(sel_quo("id","cat_jrn_prs","id_prs",$id));
			if(empty($dt_jrn_prs['id'])) {
				delete("cat_prs","id",$id);
				delete("cat_prs_srv","id_prs",$id);
				delete("cat_prs_hbr","id_prs",$id);
				delete("cat_prs_txt","id_prs",$id);
				delete("cat_prs_lieu","id_prs",$id);
				upd_cat("dev_prs",$id);
			}
			else{
				$rq_jrn_prs = sel_quo("nom","cat_jrn_prs INNER JOIN cat_jrn ON cat_jrn_prs.id_jrn = cat_jrn.id","id_prs",$id,"nom");
				while($dt_jrn_prs = ftc_ass($rq_jrn_prs)) {$err .= $dt_jrn_prs['nom']."\n";}
				echo $txt->del->prs->$id_lng.$err;
			}
			break;
		case 'srv':
			$dt_prs_srv = ftc_ass(sel_quo("id","cat_prs_srv","id_srv",$id));
			if(empty($dt_prs_srv['id'])) {
				$rq_sel_srv_trf = sel_quo("id","cat_srv_trf","id_srv",$id);
				while($dt_sel_srv_trf = ftc_ass($rq_sel_srv_trf)) {
					delete("cat_srv_trf_bss","id_trf",$dt_sel_srv_trf['id']);
					delete("cat_srv_trf_ssn","id_trf",$dt_sel_srv_trf['id']);
				}
				delete("cat_srv","id",$id);
				delete("cat_srv_txt","id_srv",$id);
				delete("cat_srv_trf","id_srv",$id);
				upd_cat("dev_srv",$id);
			}
			else{
				$rq_prs_srv = sel_quo("nom","cat_prs_srv INNER JOIN cat_prs ON cat_prs_srv.id_prs = cat_prs.id","id_srv",$id,"nom");
				while($dt_prs_srv = ftc_ass($rq_prs_srv)) {$err .= $dt_prs_srv['nom']."\n";}
				echo $txt->del->srv->$id_lng.$err;
			}
			break;
		case 'hbr':
			$dt_vll_hbr = ftc_ass(sel_quo("id","cat_vll_hbr","id_hbr",$id));
			if(empty($dt_vll_hbr['id'])) {
				$dt_prs_hbr = ftc_ass(sel_quo("id","cat_prs_hbr","id_hbr",$id));
				if(empty($dt_prs_hbr['id'])) {
					$rq_sel_hbr_chm = sel_quo("id","cat_hbr_chm","id_hbr",$id);
					while($dt_sel_hbr_chm = ftc_ass($rq_sel_hbr_chm)) {
						$rq_sel_hbr_chm_trf = sel_quo("id","cat_hbr_chm_trf","id_chm",$dt_sel_hbr_chm['id']);
						while($dt_sel_hbr_chm_trf = ftc_ass($rq_sel_hbr_chm_trf)) {
							delete("cat_hbr_chm_trf_ssn","id_trf",$dt_sel_hbr_chm_trf['id']);
						}
						delete("cat_hbr_chm_trf","id_chm",$dt_sel_hbr_chm['id']);
						delete("cat_hbr_chm_txt","id_hbr_chm",$dt_sel_hbr_chm['id']);
					}
					delete("cat_hbr_chm","id_hbr",$id);
					$rq_sel_hbr_rgm = sel_quo("id","cat_hbr_rgm","id_hbr",$id);
					while($dt_sel_hbr_rgm = ftc_ass($rq_sel_hbr_rgm)) {
						$rq_sel_hbr_rgm_trf = sel_quo("id","cat_hbr_rgm_trf","id_rgm",$dt_sel_hbr_rgm['id']);
						while($dt_sel_hbr_rgm_trf = ftc_ass($rq_sel_hbr_rgm_trf)) {
							delete("cat_hbr_rgm_trf_ssn","id_trf",$dt_sel_hbr_rgm_trf['id']);
						}
						delete("cat_hbr_rgm_trf","id_rgm",$dt_sel_hbr_rgm['id']);
					}
					delete("cat_hbr_rgm","id_hbr",$id);
					delete("cat_hbr_pay","id_hbr",$id);
					delete("cat_hbr_txt","id_hbr",$id);
					delete("cat_hbr","id",$id);
					upd_cat("dev_hbr",$id);
				}
				else{
					$rq_prs_hbr = sel_quo("nom","cat_prs_hbr INNER JOIN cat_prs ON cat_prs_hbr.id_prs = cat_prs.id","id_hbr",$id,"nom");
					while($dt_prs_hbr = ftc_ass($rq_prs_hbr)) {$err .= $dt_prs_hbr['nom']."\n";}
					echo $txt->del->hbr->$id_lng.$err;
				}
			}
			else{
				$rq_vll_hbr = sel_quo("nom","cat_vll_hbr INNER JOIN cat_vll ON cat_vll_hbr.id_vll = cat_vll.id","id_hbr",$id);
				while($dt_vll_hbr = ftc_ass($rq_vll_hbr)) {$err = $dt_vll_hbr['nom']."\n";}
				echo $txt->del->hbr_def->$id_lng.$err;
			}
			break;
		case 'clt':
			$dt_dev_clt = ftc_ass(sel_quo("id","grp_dev","id_clt",$id));
			if(empty($dt_dev_clt['id'])) {
				$dt_cat_clt = ftc_ass(sel_quo("id","cat_crc_clt","id_clt",$id));
				if(empty($dt_cat_clt['id'])) {delete("cat_clt","id",$id);}
				else{
					$rq_cat_clt = sel_quo("nom","cat_crc INNER JOIN cat_crc_clt ON cat_crc.id = cat_crc_clt.id_crc","id_clt",$id,"nom");
					while($dt_dev_clt = ftc_ass($rq_dev_clt)) {$err .= $dt_dev_clt['groupe']."\n";}
					echo $txt->del->clt_crc->$id_lng.$err;
				}
			}
			else{
				$rq_dev_clt = sel_quo("nomgrp","grp_dev","id_clt",$id,"nomgrp");
				while($dt_dev_clt = ftc_ass($rq_dev_clt)) {$err .= $dt_dev_clt['nomgrp']."\n";}
				echo $txt->del->clt_dev->$id_lng.$err;
			}
			break;
		case 'frn':
			$dt_dev_srv = ftc_ass(sel_quo("id","dev_srv","id_frn",$id));
			if(empty($dt_dev_srv['id'])) {
				delete("cat_frn","id",$id);
				delete("cat_frn_ctg_srv","id_frn",$id);
				delete("cat_frn_pay","id_frn",$id);
				delete("cat_frn_vll","id_frn",$id);
			}
			else{
				$dt_dev_crc = ftc_ass(sel_quo("groupe,version","dev_crc INNER JOIN (dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_srv ON dev_prs.id=dev_srv.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl) ON dev_crc.id=dev_mdl.id_crc","dev_srv.id",$dt_dev_srv['id']));
				echo $txt->del->frn->$id_lng.' : '.$dt_dev_crc['groupe'].' V'.$dt_dev_crc['version'];
			}
			break;
		case 'pic':
			$dt_jrn_pic = ftc_ass(sel_quo("id","cat_jrn_pic","id_pic",$id));
			if(empty($dt_jrn_pic['id'])) {
				$dt_pic = ftc_ass(sel_quo("pic","cat_pic","id",$id));
				if(unlink('../pic/'.$dir.'/'.$dt_pic['pic'])) {delete("cat_pic","id",$id);}
			}
			else{echo $txt->del->pic->$id_lng;}
			break;
		case 'rgn':
			$dt_vll = ftc_ass(sel_quo("id","cat_vll","id_rgn",$id));
			if(empty($dt_vll['id'])) {delete("cat_rgn","id",$id);}
			else{echo $txt->del->rgn->$id_lng;}
			break;
		case 'vll':
			$dt_jrn_vll = ftc_ass(sel_quo("id","cat_jrn_vll","id_vll",$id));
			if(empty($dt_jrn_vll['id'])) {
				$dt_cat_srv = ftc_ass(sel_quo("id","cat_srv","id_vll",$id));
				if(empty($dt_cat_srv['id'])) {
					$dt_cat_hbr = ftc_ass(sel_quo("id","cat_hbr","id_vll",$id));
					if(empty($dt_cat_hbr['id'])) {
						$dt_cat_frn = ftc_ass(sel_quo("id","cat_frn_vll","id_vll",$id));
						if(empty($dt_cat_frn['id'])) {
							$dt_cat_lieu = ftc_ass(sel_quo("id","cat_lieu","id_vll",$id));
							if(empty($dt_cat_lieu['id'])) {
								delete("cat_vll","id",$id);
								delete("cat_vll_hbr","id_vll",$id);
							}
							else{echo $txt->del->vll_lieu->$id_lng;}
						}
						else{echo $txt->del->vll_frn->$id_lng;}
					}
					else{echo $txt->del->vll_hbr->$id_lng;}
				}
				else{echo $txt->del->vll_srv->$id_lng;}
			}
			else{echo $txt->del->vll_jrn->$id_lng;}
			break;
		case 'lieu':
			$dt_prs_lieu = ftc_ass(sel_quo("id","cat_prs_lieu","id_lieu",$id));
			if(empty($dt_prs_lieu['id'])) {
				delete("cat_lieu","id",$id);
				delete("cat_lieu_txt","id_lieu",$id);
			}
			else{echo $txt->del->lieu->$id_lng;}
			break;
		case 'bnq':
			$dt_frn = ftc_ass(sel_quo("id","cat_frn","id_bnq",$id));
			if(empty($dt_frn['id'])) {
				$dt_hbr = ftc_ass(sel_quo("id","cat_hbr","id_bnq",$id));
				if(empty($dt_hbr['id'])) {delete("cat_bnq","id",$id);}
				else{echo $txt->del->bnq_hbr->$id_lng;}
			}
			else{echo $txt->del->bnq_frn->$id_lng;}
			break;
	}
}
