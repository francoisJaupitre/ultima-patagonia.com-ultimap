<?php
if(isset($_POST['id_dev_jrn'])){
	$id_dev_jrn = $_POST['id_dev_jrn'];
	$vue_jrn = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../cfg/vll.php");
	include("../cfg/crr.php");
	$dt_jrn = ftc_ass(select("id_cat,id_mdl,date,ord","dev_jrn","id",$id_dev_jrn));
	$id_cat_jrn = $dt_jrn['id_cat'];
	$date_jrn = $dt_jrn['date'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$ord_jrn = $dt_jrn['ord'];
	$dt_mdl = ftc_ass(select("vue_sgl,vue_tpl,vue_qdp,trf,ptl,psg,com,mrq_hbr","dev_mdl","id",$id_dev_mdl));
	$trf_mdl = $dt_mdl['trf'];
	$dt_crc = ftc_ass(select("com,mrq_hbr,frs,ty_mrq,crr,vue_sgl,vue_tpl,vue_qdp,ptl,psg","dev_crc","id",$id_dev_crc));
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	if($trf_mdl){
		$vue_sgl_mdl = $dt_mdl['vue_sgl'];
		$vue_tpl_mdl = $dt_mdl['vue_tpl'];
		$vue_qdp_mdl = $dt_mdl['vue_qdp'];
		$com = $dt_mdl['com'];
		$mrq_hbr = $dt_mdl['mrq_hbr'];
		$ptl = $dt_mdl['ptl'];
		$psg = $dt_mdl['psg'];
		$bss_mdl = $vue_bss_mdl = $mrq_mdl = array();
		$rq_bss_mdl = select("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		if(num_rows($rq_bss_mdl)>0){
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)){
				$bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];
				$vue_bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['vue'];
				$mrq_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['mrq'];
			}
		}
		$nb_rmn_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl_rmn","id_mdl",$id_dev_mdl));
	}
	else{
		$vue_sgl_crc= $dt_crc['vue_sgl'];
		$vue_tpl_crc= $dt_crc['vue_tpl'];
		$vue_qdp_crc= $dt_crc['vue_qdp'];
		$com = $com_crc;
		$mrq_hbr = $mrq_hbr_crc;
		$ptl = $dt_crc['ptl'];
		$psg = $dt_crc['psg'];
		$bss_crc = $vue_bss_crc = array();
		$rq_bss_crc = select("*","dev_crc_bss","id_crc",$id_dev_crc,"base");
		if(num_rows($rq_bss_crc)>0){
			while($dt_bss_crc = ftc_ass($rq_bss_crc)){
				$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
				$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
				$mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
			}
		}
		$nb_rmn_crc = ftc_ass(select("COUNT(*) as total","dev_crc_rmn","id_crc",$id_dev_crc));
	}
	$rq_prs = select("id,nom,opt,ord,id_cat","dev_prs","id_jrn",$id_dev_jrn,"ord,opt DESC,nom,id");
	while($dt_prs = ftc_ass($rq_prs)){
		$prs_datas[$id_dev_jrn][$dt_prs['id']]['nom'] = $dt_prs['nom'];
		$prs_datas[$id_dev_jrn][$dt_prs['id']]['opt'] = $dt_prs['opt'];
		$prs_datas[$id_dev_jrn][$dt_prs['id']]['ord'] = $dt_prs['ord'];
		$prs_datas[$id_dev_jrn][$dt_prs['id']]['id_cat'] = $dt_prs['id_cat'];
	}
}
if($id_cat_jrn>-1){
	if($trf_mdl){
		$vue_sgl = $vue_sgl_mdl;
		$vue_tpl = $vue_tpl_mdl;
		$vue_qdp = $vue_qdp_mdl;
		$bss = $bss_mdl;
		$vue_bss = $vue_bss_mdl;
	}
	else{
		$vue_sgl = $vue_sgl_crc;
		$vue_tpl = $vue_tpl_crc;
		$vue_qdp = $vue_qdp_crc;
		$bss = $bss_crc;
		$vue_bss = $vue_bss_crc;
	}
	if($vue_jrn == 1){
		$nb_prs = ftc_ass(select("COUNT(*) as total","dev_prs","id_jrn",$id_dev_jrn));
		if($nb_prs['total'] > 0){
			$min_jrn = ftc_num(select("MIN(ord)","dev_jrn","id_mdl",$id_dev_mdl));
			$max_jrn = ftc_num(select("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
			$rq_prs = select("*","dev_prs","id_jrn",$id_dev_jrn,"ord,opt DESC");
			while($dt_prs = ftc_ass($rq_prs)){
				$id_dev_prs = $dt_prs['id'];
				$id_cat_prs = $dt_prs['id_cat'];
				$opt_prs = $dt_prs['opt'];
				$ord_prs = $dt_prs['ord'];
				$nom_prs = $dt_prs['nom'];
				$ttr_prs = $dt_prs['titre'];
				$dsc_prs = $dt_prs['dsc'];
				$not_prs = $dt_prs['notes'];
				$inf_prs = $dt_prs['info'];
				$id_ctg_prs = $dt_prs['ctg'];
				$hre_prs = $dt_prs['heure'];
				$id_res_prs = $dt_prs['res'];
				$dt_res_prs = $dt_prs['dt_res'];
				$tx_prs = $dt_prs['taux'];
				$nb_prs_opt = ftc_ass(select("COUNT(*) as total","dev_prs","ord=".$ord_prs." AND id_jrn",$id_dev_jrn));
				if($nb_prs_opt['total'] > 1){$flg_prs_opt = true;}
				else{$flg_prs_opt = false;}
				unset($trf_net,$trf_rck);
				if(!isset($prs_opt_id_cat)){
					$id_ant_prs = $id_dev_prs;
					echo  '<br />';
				}
				$prs_opt_id_cat[] = $id_cat_prs;
?>
<div id="div_prs<?php echo $id_dev_prs ?>" class="prs_prs<?php echo $id_dev_jrn.'_'.$ord_prs; if($opt_prs){echo ' sel_opt';} ?>">
	<table class="w-100">
		<tr	id="vue_ttr_prs_<?php echo $id_dev_prs ?>" <?php if($id_cat_prs>0){echo 'class="list_prs'.$id_cat_prs.'"';} ?>><?php include("vue_ttr_prs.php"); ?></tr>
		<tr id="vue_dsc_prs_<?php echo $id_dev_prs ?>"><?php include("vue_dsc_prs.php"); ?></tr>
	</table>
	<span id="vue_dt_prs_<?php echo $id_dev_prs ?>" class="up_srv up_hbr"><?php include("vue_dt_prs.php"); ?></span>
	<span id="vue_end_prs_<?php echo $id_dev_prs ?>"><?php include("vue_end_prs.php"); ?></span>
	<div id="vue_trf_hbr_<?php echo $id_dev_prs ?>"></div>
<?php
				$id_ant_prs = $id_dev_prs;
				if($nb_prs_opt['total'] == count($prs_opt_id_cat)){
?>
</div>
<?php
					if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){
?>
<span id="opt_prs_prs<?php echo $id_dev_jrn.'_'.$ord_prs ?>" class="ajt_prs_opt"><?php include("vue_opt_prs_prs.php"); ?></span>
<?php
					}
					unset($prs_opt_id_cat);
				}
				else{
?>
</div>
<?php
				}
			}
		}
	}
	else{
		$id_crr_trf = $id_crr_crc;
?>
<table class="dsg w-100">
	<tr>
		<td class="stl1"><?php echo $prm_crr_nom[$id_crr_trf]; ?></td>
		<td class="stl1"><?php echo $txt->prss->$id_lng.':'; ?></td>
<?php
		if(isset($prs_datas[$id_dev_jrn])) {
			$ord_prs_ant = 0;
			foreach($prs_datas[$id_dev_jrn] as $id_dev_prs => $dt_prs)	{
				if($ord_prs_ant != $dt_prs['ord']) {
					if($ord_prs_ant!=0){
?>
		</td>
<?php
					}
?>
		<td class="stl1">
<?php
				}
				else{echo '<br />';}
?>
			<span <?php if(!$dt_prs['opt']){echo 'style="font-weight: normal"';} ?>>
<?php
				if(!empty($dt_prs['nom'])){
					if($dt_prs['id_cat']>0){
?>
				<span class="lnk inf<?php echo $dt_prs['id_cat'] ?>prs" onmouseover="vue_elem('inf',<?php echo $dt_prs['id_cat'] ?>,'prs');" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs['id_cat'] ?>')">
<?php
					}
					echo stripslashes($dt_prs['nom']);
					if($dt_prs['id_cat']>0){echo '</span>';}
				}
				else{echo $txt->nonom->$id_lng;}
?>
			</span>
<?php
				$ord_prs_ant = $dt_prs['ord'];
			}
		}
?>
		</td>
	</tr>
</table>
<?php
		$flg_srv = false;
		$flg_hbr = false;
		unset($dt_min_srv,$dt_max_srv,$dt_min_hbr,$dt_max_hbr);
		if(isset($prs_datas[$id_dev_jrn])) {
			foreach($prs_datas[$id_dev_jrn] as $id_dev_prs => $dt_prs)	{
				if($dt_prs['opt']){
					include("trf_srv.php");
					include("trf_hbr.php");
				}
			}
		}
		/*$rq_prs = select("id,opt","dev_prs","id_jrn",$id_dev_jrn);
		while($dt_prs = ftc_ass($rq_prs)){
			$id_dev_prs = $dt_prs['id'];
			if($dt_prs['opt']==1){
				include("trf_srv.php");
				include("trf_hbr.php");
			}
		}*/
?>
<table class="dsg w-100">
	<tr>
<?php
		if($flg_srv){
?>
		<td class="stl2"><?php echo $txt->bss->$id_lng.':'; ?></td>
<?php
			foreach($bss as $id_bss => $base){
				if(($cnf>0 and $vue_bss[$id_bss]==1)or $cnf<1){
?>
		<td class="stl2"><?php echo $base; if($ptl){echo '+1';} echo '<br/>'.$txt->trf->$id_lng; ?></td>
		<td class="stl2"><?php echo $base; if($ptl){echo '+1';} echo '<br/>'.$txt->cst->$id_lng; ?></td>
<?php
				}
			}
?>
		<td class="stl2"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
		<td class="stl2"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
<?php
		}
		if($flg_hbr){
?>
		<td class="stl2"><?php echo $txt->room->$id_lng; ?></td>
<?php
			if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
		<td class="stl2"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->com->$id_lng.'<br/>'.$txt->dbl->$id_lng; ?></td>
<?php
			}
			if($vue_sgl==1){
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
				}
?>
		<td class="stl2"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->com->$id_lng.'<br/>'.$txt->sgl->$id_lng; ?></td>
<?php
				}
			}
			if($vue_tpl==1){
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
				}
?>
		<td class="stl2"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->com->$id_lng.'<br/>'.$txt->tpl->$id_lng; ?></td>
<?php
				}
			}
			if($vue_qdp==1){
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
				}
?>
		<td class="stl2"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
				if($cnf<1){
?>
		<td class="stl2"><?php echo $txt->com->$id_lng.'<br/>'.$txt->qdp->$id_lng; ?></td>
<?php
				}
			}
?>
		<td class="stl2"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
		<td class="stl2"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
<?php
		}
?>
	</tr>
	<tr>
<?php
		if($flg_srv){
?>
		<td class="stl2"><?php echo $txt->srvs->$id_lng.':'; ?></td>
<?php
			foreach($bss as $id_bss => $base){
				if(($cnf>0 and $vue_bss[$id_bss]==1)or $cnf<1){
?>
		<td class="stl2">
<?php
						if($est_trf[$id_bss]!=-1 and $trf_srv[$id_bss]>=$cst_srv[$id_bss]){
							echo number_format($trf_srv[$id_bss],$prm_crr_dcm[$id_crr_trf],'.','');
						}
?>
		</td>
		<td class="stl2" style="<?php if($est_trf[$id_bss]==1){echo 'background-color: gold;';} if($est_trf[$id_bss]==-1 or $cst_srv[$id_bss]==0){echo 'background-color: tomato;';} ?>">
<?php
				echo number_format($cst_srv[$id_bss],$prm_crr_dcm[$id_crr_trf],'.','');
?>
		</td>
<?php
				}
			}
?>
		<td class="stl2" style="<?php if($date_jrn=='0000-00-00'){echo 'background-color: gold';} elseif(strtotime($dt_min_srv)>strtotime($date_jrn) or $dt_min_srv=='0000-00-00'){echo 'background-color: tomato';}  ?>"><?php if($dt_min_srv!='0000-00-00'){echo date("d/m/Y", strtotime($dt_min_srv));} ?></td>
		<td class="stl2" style="<?php if(strtotime($dt_max_srv)<strtotime(date("Y-m-d"))){echo 'background-color: tomato';} elseif($date_jrn=='0000-00-00'){echo 'background-color: gold';} elseif(strtotime($dt_max_srv)<strtotime($date_jrn) or $dt_max_srv=='0000-00-00'){echo 'background-color: tomato';} ?>"><?php if($dt_max_srv!='0000-00-00'){echo date("d/m/Y", strtotime($dt_max_srv));} ?></td>
<?php
			unset($trf_srv,$cst_srv);
		}
		if($flg_hbr){
?>
		<td class="stl2"><?php echo $txt->hbrs->$id_lng.':'; ?></td>
<?php
			if($cnf<1){
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
				if($est_hbr!=-1 and $trf_db_sel_hbr>=$cst_db_sel_hbr){
					echo number_format($trf_db_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
				}
?>
		</td>
<?php
			}
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} if($est_hbr==-1 or $cst_db_sel_hbr==0){echo 'background-color: tomato;';} ?>">
<?php
				echo number_format($cst_db_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
?>
		</td>
<?php
			if($cnf<1){
?>
		<td class="stl3" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
				if($trf_db_sel_hbr!=0){echo((number_format(1-$cst_db_sel_hbr/$trf_db_sel_hbr,2,'.','')*100)."%");}
?>
		</td>
<?php
			}
			unset($trf_db_sel_hbr,$cst_db_sel_hbr);
			if($vue_sgl==1){
				if($cnf<1){
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($est_hbr!=-1 and $trf_sg_sel_hbr>=$cst_sg_sel_hbr){
						echo number_format($trf_sg_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
					}
?>
		</td>
<?php
				}
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} if($est_hbr==-1 or $cst_sg_sel_hbr==0){echo 'background-color: tomato;';} ?>">
<?php
					echo number_format($cst_sg_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
?>
		</td>
<?php
				if($cnf<1){
?>
		<td class="stl3" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($trf_sg_sel_hbr!=0){echo((number_format(1-$cst_sg_sel_hbr/$trf_sg_sel_hbr,2,'.','')*100)."%");}
?>
		</td>
<?php
				}
				unset($trf_sg_sel_hbr,$cst_sg_sel_hbr);
			}
			if($vue_tpl==1){
				if($cnf<1){
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($est_hbr!=-1 and $trf_tp_sel_hbr>=$cst_tp_sel_hbr){
						echo number_format($trf_tp_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
					}
?>

		</td>
<?php
				}
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} if($est_hbr==-1 or $cst_tp_sel_hbr==0){echo 'background-color: tomato;';} ?>">
<?php
					echo number_format($cst_tp_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
?>
		</td>
<?php
				if($cnf<1){
?>
		<td class="stl3" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($trf_tp_sel_hbr!=0){echo((number_format(1-$cst_tp_sel_hbr/$trf_tp_sel_hbr,2,'.','')*100)."%");}
?>
		</td>
<?php
				}
				unset($trf_tp_sel_hbr,$cst_tp_sel_hbr);
			}
			if($vue_qdp==1){
				if($cnf<1){
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($est_hbr!=-1 and $trf_qd_sel_hbr>=$cst_qd_sel_hbr){
						echo number_format($trf_qd_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
					}
?>
		</td>
<?php
				}
?>
		<td class="stl2" style="<?php if($est_hbr==1){echo 'background-color: gold;';} if($est_hbr==-1 or $cst_qd_sel_hbr==0){echo 'background-color: tomato;';} ?>">
<?php
					echo number_format($cst_qd_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.','');
?>
		</td>
<?php
				if($cnf<1){
?>
		<td class="stl3" style="<?php if($est_hbr==1){echo 'background-color: gold;';} ?>">
<?php
					if($trf_qd_sel_hbr!=0){echo((number_format(1-$cst_qd_sel_hbr/$trf_qd_sel_hbr,2,'.','')*100)."%");}
?>
		</td>
<?php
				}
				unset($trf_qd_sel_hbr,$cst_qd_sel_hbr);
			}
?>
		<td class="stl2" style="<?php if($date_jrn=='0000-00-00'){echo 'background-color: gold';} elseif(strtotime($dt_min_hbr)>strtotime($date_jrn) or $dt_min_hbr=='0000-00-00'){echo 'background-color: tomato';}  ?>"><?php if($dt_min_hbr!='0000-00-00'){echo date("d/m/Y", strtotime($dt_min_hbr));} ?></td>
		<td class="stl2" style="<?php if(strtotime($dt_max_hbr)<strtotime(date("Y-m-d"))){echo 'background-color: tomato';} elseif($date_jrn=='0000-00-00'){echo 'background-color: gold';} elseif(strtotime($dt_max_hbr)<strtotime($date_jrn) or $dt_max_hbr=='0000-00-00'){echo 'background-color: tomato';} ?>"><?php if($dt_max_hbr!='0000-00-00'){echo date("d/m/Y", strtotime($dt_max_hbr));} ?></td>
<?php
		}
?>
	</tr>
</table>
<?php
	}
}
?>
