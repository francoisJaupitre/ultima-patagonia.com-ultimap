<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$vue_res = $_POST['res_vue'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/res_srv.php");
	include("../cfg/crr.php");
	include("../cfg/frn.php");
	include("../cfg/vll.php");
	$dt_crc = ftc_ass(select("sgl, dbl_mat, dbl_twn, tpl_mat, tpl_twn, qdp, ptl, psg, crr", "dev_crc", "id", $id_dev_crc));
	$id_crr_crc = $dt_crc['crr'];
	if($vue_res)
	{
		$rq_bss_crc = sel_quo("*", "dev_crc_bss", "id_crc", $id_dev_crc, "base");
		if(num_rows($rq_bss_crc) > 0)
		{
			while($dt_bss_crc = ftc_ass($rq_bss_crc)){
				$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
				$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			}
		}
		$rq_mdl = select("*", "dev_mdl", "id_crc", $id_dev_crc, "ord");
		while($dt_mdl = ftc_ass($rq_mdl))
		{
			$mdl_datas[$dt_mdl['id']]['trf'] = $dt_mdl['trf'];
			$mdl_datas[$dt_mdl['id']]['ptl'] = $dt_mdl['ptl'];
			$mdl_datas[$dt_mdl['id']]['psg'] = $dt_mdl['psg'];
			$mdl_datas[$dt_mdl['id']]['sgl'] = $dt_mdl['sgl'];
			$mdl_datas[$dt_mdl['id']]['dbl_mat'] = $dt_mdl['dbl_mat'];
			$mdl_datas[$dt_mdl['id']]['dbl_twn'] = $dt_mdl['dbl_twn'];
			$mdl_datas[$dt_mdl['id']]['tpl_mat'] = $dt_mdl['tpl_mat'];
			$mdl_datas[$dt_mdl['id']]['tpl_twn'] = $dt_mdl['tpl_twn'];
			$mdl_datas[$dt_mdl['id']]['qdp'] = $dt_mdl['qdp'];
		}
	}
}
if($vue_res and isset($mdl_datas))
{
	foreach($mdl_datas as $id_dev_mdl => $dt_mdl)
	{
		if($dt_mdl['trf'])
		{
			$rq_bss_mdl = sel_quo("base", "dev_mdl_bss", array("vue", "id_mdl"), array(1, $id_dev_mdl), "base");
			if(num_rows($rq_bss_mdl) == 1)
			{
				$dt_bss_mdl = ftc_ass($rq_bss_mdl);
				$bss = $dt_bss_mdl['base'];
			}else{
				$bss = 0;
			}
			$sgl = $dt_mdl['sgl'];
			$dbl_mat = $dt_mdl['dbl_mat'];
			$dbl_twn = $dt_mdl['dbl_twn'];
			$tpl_mat = $dt_mdl['tpl_mat'];
			$tpl_twn = $dt_mdl['tpl_twn'];
			$qdp = $dt_mdl['qdp'];
			$ptl = $dt_mdl['ptl'];
			$psg = $dt_mdl['psg'];
		}
		else{
			if(array_count_values($vue_bss_crc)[1] == 1)
			{
				$key = array_search(1, $vue_bss_crc);
				$bss = $bss_crc[$key];
			}else{
				$bss = 0;
			}
			$sgl = $dt_crc['sgl'];
			$dbl_mat = $dt_crc['dbl_mat'];
			$dbl_twn = $dt_crc['dbl_twn'];
			$tpl_mat = $dt_crc['tpl_mat'];
			$tpl_twn = $dt_crc['tpl_twn'];
			$qdp = $dt_crc['qdp'];
			$ptl = $dt_crc['ptl'];
			$psg = $dt_crc['psg'];
		}
		$rq_jrn = sel_quo("id, ord", "dev_jrn", array("opt", "id_mdl"), array(1, $id_dev_mdl), "ord");
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			$rq_prs = sel_quo("id, id_cat, res, ctg, opt, sup, taux", "dev_prs", "id_jrn", $dt_jrn['id'], "ord, opt");
			while($dt_prs = ftc_ass($rq_prs))
			{
				if($cnf > 0)
				{
					$sup_dev = $dt_prs['sup'];
					$taux_dev= $dt_prs['taux'];
				}
				else{
					$sup_dev = $cfg_crr_sp[$id_crr_crc];
					$taux_dev = $cfg_crr_tx[$id_crr_crc];
				}
				if(($dt_prs['opt']==1 and $cnf<1) or ($dt_prs['res']==1 or $dt_prs['res']==-1 and $cnf>0)){$id_cat_prs = $dt_prs['id_cat'];}
				$rq_srv = select("*", "dev_srv", "opt=1 AND id_prs", $dt_prs['id']);
				while($dt_srv = ftc_ass($rq_srv)){
					$frs_srv = 1+$dt_srv['frs'];
					if($dt_prs['res']==1 or $dt_prs['opt']==1){//si payé puis annulé
						if($dt_prs['res']!=1 and $cnf>0 and $dt_prs['opt']==1){$id_frn=-1;}
						else{$id_frn = $dt_srv['id_frn'];}
						if(!isset($lst_frn) or !in_array($id_frn, $lst_frn)){
							$lst_frn[] = $id_frn;
							$cot_srv[$id_frn]=0;
							$liq_frn[$id_frn]=0;
							if($id_frn>0){
								$dt_frn = ftc_ass(select("frs", "cat_frn", "id", $id_frn));
								$frs_frn = 1+$dt_frn['frs'];
							}
							else{$frs_frn = $frs_srv;}
						}
						$jr_frn[$id_frn][] = $dt_jrn['ord'];
						$jr_frn_id[$id_frn][] = $dt_jrn['id'];
						$mdl_frn_id[$id_frn][] = $id_dev_mdl;
						if($id_frn>0 or $dt_srv['res']!=6){$res_frn[$id_frn][] = $dt_srv['res'];}
						$rq_srv_pay = select("*", "dev_srv_pay", "id_srv", $dt_srv['id']);
						while($dt_srv_pay = ftc_ass($rq_srv_pay)){
							if($dt_srv_pay['pay']==0){
								if($cfg_crr_sp[$dt_srv_pay['crr']]==1){$liq_frn[$id_frn] += $dt_srv_pay['liq'] * $cfg_crr_tx[$dt_srv_pay['crr']]*$frs_frn;}
								else{$liq_frn[$id_frn] += $dt_srv_pay['liq'] / $cfg_crr_tx[$dt_srv_pay['crr']]*$frs_frn;}
								if($dt_srv_pay['date']!='0000-00-00'){$dat_frn[$id_frn][] = $dt_srv_pay['date'];}
							}
							else{
								if($dt_srv_pay['sup']==1){$liq_frn[$id_frn] += $dt_srv_pay['liq'] * $dt_srv_pay['taux']*$frs_frn;}
								else{$liq_frn[$id_frn] += $dt_srv_pay['liq'] / $dt_srv_pay['taux']*$frs_frn;}
							}
						}
						if($dt_prs['opt']==1){
							$sup = $dt_srv['sup'];
							$taux = $dt_srv['taux'];
							$dt_srv_trf = ftc_ass(select("trf_net", "dev_srv_trf", "id_srv = ".$dt_srv['id']." AND base", $bss));
							$cot_sr = $dt_srv_trf['trf_net'] * $bss * $frs_srv;
							if(!$sup){
								if($sup_dev){$cot_srv[$id_frn] += $cot_sr * $taux * $taux_dev;}
								elseif($taux_dev!=0){$cot_srv[$id_frn] += $cot_sr * $taux / $taux_dev;}
							}
							elseif($taux!=0){
								if($sup_dev){$cot_srv[$id_frn] += $cot_sr / $taux * $taux_dev;}
								elseif($taux_dev!=0){$cot_srv[$id_frn] += $cot_sr / ($taux * $taux_dev);}
							}
						}
					}
				}
				if($cnf>0){$rq_hbr = select("*", "dev_hbr", "id_prs", $dt_prs['id'], "sel DESC");}
				else{$rq_hbr = select("*", "dev_hbr", "id_prs", $dt_prs['id'], "opt DESC");}
				while($dt_hbr = ftc_ass($rq_hbr)){
					$frs_hbr = 1+$dt_hbr['frs'];
					if(($cnf>0 or ($cnf<1 and $dt_prs['opt']==1)) and $dt_hbr['id_cat']>-2){
						if(($dt_prs['res']==1 and $dt_hbr['sel']==1 and $cnf>0) or ($dt_hbr['opt']==1 and $cnf<1)){
							if($dt_hbr['id_cat']>0){$id_hbr = $dt_hbr['id_cat'];}
							else{$id_hbr = -$dt_hbr['id'];}
							$id_chm = $dt_hbr['id_cat_chm'];
							if($id_hbr>0 and (!isset($hbr) or !in_array($id_hbr, $hbr))){$hbr[] = $id_hbr;}
							if(!isset($chm_hbr[$id_hbr]) or !in_array($id_chm, $chm_hbr[$id_hbr])){
								$chm_hbr[$id_hbr][] = $id_chm;
								$cot_hbr[$id_hbr][$id_chm] = $liq_hbr[$id_hbr][$id_chm] = 0;
							}
							$jr_hbr[$id_hbr][$id_chm][] = $dt_jrn['ord'];
							$jr_hbr_id[$id_hbr][$id_chm][] = $dt_jrn['id'];
							$mdl_hbr_id[$id_hbr][$id_chm][] = $id_dev_mdl;
							if($id_hbr<0 or $id_chm!=-2){$res_hbr[$id_hbr][$id_chm][] = $dt_hbr['res'];}
							if(($dt_prs['res']==1 and $cnf>0) or ($dt_prs['opt']==1 and $cnf<1)){
								$rq_hbr_pay = select("*", "dev_hbr_pay", "id_hbr", $dt_hbr['id']);
								while($dt_hbr_pay = ftc_ass($rq_hbr_pay)){
									if($dt_hbr_pay['pay']==0){
										if($cfg_crr_sp[$dt_hbr_pay['crr']]==1){$liq_hbr[$id_hbr][$id_chm] += $dt_hbr_pay['liq'] * $cfg_crr_tx[$dt_hbr_pay['crr']]*$frs_hbr;}
										else{$liq_hbr[$id_hbr][$id_chm] += $dt_hbr_pay['liq'] / $cfg_crr_tx[$dt_hbr_pay['crr']]*$frs_hbr;}
										if($dt_hbr_pay['date']!='0000-00-00'){$dat_hbr[$id_hbr][$id_chm][] = $dt_hbr_pay['date'];}
									}
									else{
										if($dt_hbr_pay['sup']==1){$liq_hbr[$id_hbr][$id_chm] += $dt_hbr_pay['liq'] * $dt_hbr_pay['taux']*$frs_hbr;}
										else{$liq_hbr[$id_hbr][$id_chm] += $dt_hbr_pay['liq'] / $dt_hbr_pay['taux']*$frs_hbr;}
									}
								}
							}
						}
						elseif(($dt_prs['res']==1 and $dt_hbr['sel']==0 and $cnf>0) or ($dt_hbr['opt']==0 and $cnf<1)){
							if($dt_hbr['id_cat']>0){$id_hbr_opt = $dt_hbr['id_cat'];}
							else{$id_hbr_opt = -$dt_hbr['id'];}
							if($dt_hbr['id_cat_chm']>0){$id_chm_opt = $dt_hbr['id_cat_chm'];}
							else{$id_chm_opt = -$dt_hbr['id'];}
							if(!isset($cot_hbr_opt[$id_hbr_opt][$id_chm_opt])){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] = 0;}
							$flg_hbr_opt = true;
							$flg_chm_opt = true;
							if(isset($hbr_opt)){
								foreach($hbr_opt as $hb_opt){
									if($hb_opt == $id_hbr_opt){
										$flg_hbr_opt = false;
										if(isset($chm_hbr_opt[$hb_opt])){
											foreach($chm_hbr_opt[$hb_opt] as $chm_opt){
												if($chm_opt == $id_chm_opt){$flg_chm_opt = false;}
											}
										}
									}
								}
							}
							if($flg_hbr_opt){$hbr_opt[] = $id_hbr_opt;}
							if($flg_chm_opt){$chm_hbr_opt[$id_hbr_opt][] = $id_chm_opt;}
							$jr_hbr_opt[$id_hbr_opt][$id_chm_opt][] = $dt_jrn['ord'];
							$jr_hbr_id_opt[$id_hbr_opt][$id_chm_opt][] = $dt_jrn['id'];
							$mdl_hbr_id_opt[$id_hbr_opt][$id_chm_opt][] = $id_dev_mdl;
							if($id_hbr_opt<0 or $id_chm_opt!=2){$res_hbr_opt[$id_hbr_opt][$id_chm_opt][] = $dt_hbr['res'];}
						}
					}
					if($dt_prs['opt']==1 and $dt_hbr['id_cat']>-2){
						if($dt_hbr['opt']==1){
							if($dt_prs['res']==1 or $cnf<1){
								$sup = $dt_hbr['sup_chm'];
								$taux = $dt_hbr['taux_chm'];
								$cot_hb = ($dt_hbr['db_net_chm']*($dbl_mat+$dbl_twn) + $dt_hbr['sg_net_chm']*($sgl+$psg) + $dt_hbr['tp_net_chm']*($tpl_mat+$tpl_twn) + $dt_hbr['qd_net_chm']*$qdp) * $frs_hbr;
								if(!$sup){
									if($sup_dev){$cot_hbr[$id_hbr][$id_chm] += $cot_hb * $taux * $taux_dev;}
									elseif($taux_dev!=0){$cot_hbr[$id_hbr][$id_chm] += $cot_hb * $taux / $taux_dev;}
								}
								elseif($taux!=0){
									if($sup_dev){$cot_hbr[$id_hbr][$id_chm] += $cot_hb / $taux * $taux_dev;}
									elseif($taux_dev!=0){$cot_hbr[$id_hbr][$id_chm] += $cot_hb / ($taux * $taux_dev);}
								}
								$sup = $dt_hbr['sup_rgm'];
								$taux = $dt_hbr['taux_rgm'];
								if($dt_hbr['crr_rgm']!=0){
									$cot_hb = ($dt_hbr['db_net_rgm']*($dbl_mat+$dbl_twn) + $dt_hbr['sg_net_rgm']*($sgl+$psg) + $dt_hbr['tp_net_rgm']*($tpl_mat+$tpl_twn) + $dt_hbr['qd_net_rgm']*$qdp) * $frs_hbr;
									if(!$sup){
										if($sup_dev){$cot_hbr[$id_hbr][$id_chm] += $cot_hb * $taux * $taux_dev;}
										elseif($taux_dev!=0){$cot_hbr[$id_hbr][$id_chm] += $cot_hb * $taux / $taux_dev;}
									}
									elseif($taux!=0){
										if($sup_dev){$cot_hbr[$id_hbr][$id_chm] += $cot_hb / $taux * $taux_dev;}
										elseif($taux_dev!=0){$cot_hbr[$id_hbr][$id_chm] += $cot_hb / ($taux * $taux_dev);}
									}
								}
							}
							if($dt_prs['id_cat']!=$id_cat_prs){
								$dif_hbr[$id_hbr]=2;
								$dif_chm[$id_chm]=1;
							}
							elseif($dt_hbr['id_cat']==$id_hbr){
								$dif_hbr[$id_hbr]=0;
								if($dt_hbr['id_cat_chm']==$id_chm){$dif_chm[$id_chm]=0;}
								else{$dif_chm[$id_chm]=1;}
							}
							else{
								$dif_hbr[$id_hbr]=1;
								$dif_chm[$id_chm]=1;
							}
						}
						elseif($cnf<1){
							$sup = $dt_hbr['sup_chm'];
							$taux = $dt_hbr['taux_chm'];
							$cot_hb = ($dt_hbr['db_net_chm']*($dbl_mat+$dbl_twn) + $dt_hbr['sg_net_chm']*($sgl+$psg) + $dt_hbr['tp_net_chm']*($tpl_mat+$tpl_twn) + $dt_hbr['qd_net_chm']*$qdp) * $frs_hbr;
							if(!$sup){
								if($sup_dev){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb * $taux * $taux_dev;}
								elseif($taux_dev!=0){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb * $taux / $taux_dev;}
							}
							elseif($taux!=0){
								if($sup_dev){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb / $taux * $taux_dev;}
								elseif($taux_dev!=0){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb / ($taux * $taux_dev);}
							}
							$sup = $dt_hbr['sup_rgm'];
							$taux = $dt_hbr['taux_rgm'];
							if($dt_hbr['crr_rgm']!=0){
								$cot_hb = ($dt_hbr['db_net_rgm']*($dbl_mat+$dbl_twn) + $dt_hbr['sg_net_rgm']*($sgl+$psg) + $dt_hbr['tp_net_rgm']*($tpl_mat+$tpl_twn) + $dt_hbr['qd_net_rgm']*$qdp) * $frs_hbr;
								if(!$sup){
									if($sup_dev){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb * $taux * $taux_dev;}
									elseif($taux_dev!=0){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb * $taux / $taux_dev;}
								}
								elseif($taux!=0){
									if($sup_dev){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb / $taux * $taux_dev;}
									elseif($taux_dev!=0){$cot_hbr_opt[$id_hbr_opt][$id_chm_opt] += $cot_hb / ($taux * $taux_dev);}
								}
							}
						}
					}
				}
				unset($id_hbr, $id_chm, $id_hbr_opt, $id_chm_opt, $cot_hb);
			}
		}
	}
	$cot = $liq = $dif = 0;
	if(isset($lst_frn)){
		$color = '';
		if($cnf>0){
			foreach($lst_frn as $fr){
				foreach($res_frn[$fr] as $id_res_frn) {$color_frn[]=$id_res_frn;}
			}
			if(isset($color_frn)){
				foreach(array_unique($color_frn) as $id_res_frn){
					if($id_res_frn<6){$color .= $col_res_srv[$id_res_frn].', ';}
				}
			}
			unset($color_frn);
			if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
			else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
		}
?>
			<table class="dsg w-100">
<?php
		if($cnf<1){
?>
				<tr style="font-style: italic;" colspan="5">
					<td><?php echo $txt->srv_sel->$id_lng; ?></td>
				</tr>
<?php
		}
?>
				<tr style="<?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->jours->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->frns->$id_lng; ?></td>
<?php
		$flg_res = false;
		foreach($lst_frn as $fr){
			foreach(array_unique($res_frn[$fr]) as $id_res_frn) {
				if($id_res_frn>0) {$flg_res = true;}
			}
		}
		if($cnf>0 or $flg_res){
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->ress->$id_lng; ?></td>
<?php
		}
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->dev->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->pay->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->dif->$id_lng; ?></td>
<?php
		if(isset($dat_frn)){
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->delai->$id_lng; ?></td>
<?php
		}
?>
				<tr/>
<?php
		foreach($lst_frn as $fr){
			$jr_frn[$fr] = array_unique($jr_frn[$fr]);
			$jr_frn_id[$fr] = array_unique($jr_frn_id[$fr]);
			$cot += $cot_srv[$fr];
			$color = '';
			foreach(array_unique($res_frn[$fr]) as $id_res_frn) {
				if(($cnf>0 or ($flg_res and $id_res_frn>0)) and $id_res_frn<6){$color .= $col_res_srv[$id_res_frn].', ';}
			}
			if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
			else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
?>
				<tr style="font-weight: normal; <?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px;"><?php foreach($jr_frn[$fr] as $i => $jr){ ?><span class="lnk" onclick="scroll2(<?php echo $jr_frn_id[$fr][$i].', '.$mdl_frn_id[$fr][$i]; ?>)"><?php echo $jr;?></span> - <?php } ?></td>
					<td class="stl1" style="padding: 0px 5px; position: relative;">
<!--COMMANDES-->
						<span <?php if($fr>0){ ?> class="lnk inf<?php echo $fr ?>frn" onmouseover="vue_elem('inf', <?php echo $fr ?>, 'frn')" onclick="vue_cmd('vue_cmd_frn<?php echo $fr; ?>')" <?php } ?>><?php if($fr>0){echo stripslashes($frn[$fr]);} elseif($fr==0){echo $txt->nodef->$id_lng;} else{echo $txt->cotnocnf->$id_lng;}?></span>
						<div id="vue_cmd_frn<?php echo $fr; ?>" class="cmd mw200 wsn" style="text-align:left;left:50%;transform:translate(-50%);">
							<strong><?php echo $txt->cmd->$id_lng; ?></strong>
							<ul>
								<li onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $fr;?>');document.getElementById('vue_cmd_frn<?php echo $fr; ?>').style.display='none';"><?php echo $txt->cat->$id_lng; ?></li>
								<li onclick="window.open('../resources/php/docxFrn.php?id=<?php echo $id_dev_crc;?>&frn=<?php echo $fr;?>');"><?php echo $txt->lst_res->$id_lng; ?></li>
								<li onclick="window.open('../resources/php/vchFrn.php?id=<?php echo $id_dev_crc;?>&frn=<?php echo $fr;?>');"><?php echo $txt->vch->$id_lng; ?></li>
								<li onclick="mailFrn(<?php echo $fr; ?>, 0);"><?php echo $txt->maildevis->$id_lng; ?></li>
<?php
			if($aut['res']){
?>
								<li onclick="mailFrn(<?php echo $fr; ?>, 1);"><?php echo $txt->mailres->$id_lng; ?></li>
<?php
			}
			if($aut['dev']){
?>
								<li onclick="searchFrn(0, <?php echo $fr ?>, 0);"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
			}
?>

							</ul>
						</div>
					</td>
<?php
			if($cnf>0){
				$statut = '';
				foreach(array_unique($res_frn[$fr]) as $id_res_frn) {
					if($id_res_frn<6){$statut .= $res_srv[$id_lng][$id_res_frn].' - ';}
				}
				$statut = substr_replace($statut, "", -3);
?>
					<td class="stl1" style="padding: 0px 5px;"><?php echo $statut; ?></td>
<?php
			}
?>
					<td class="stl1" style="padding: 0px 5px;"><?php echo number_format($cot_srv[$fr], $prm_crr_dcm[1], '.', ''); ?></td>
					<td class="stl1" style="<?php if($cnf>0 and $liq_frn[$fr]<=0 and $fr>=0){echo 'background-color: tomato;';} ?> padding: 0px 5px;"><?php echo number_format($liq_frn[$fr], $prm_crr_dcm[1], '.', ''); ?></td>
<?php
			if($fr!=0){
				if($liq_frn[$fr]>0 or $fr<0){
?>
					<td class="stl1" style="<?php if($cot_srv[$fr]-$liq_frn[$fr]<0){echo 'background-color: tomato;';} if($cot_srv[$fr]-$liq_frn[$fr]>0 and $liq_frn[$fr]!=0){echo 'background-color: skyblue;';} ?>padding: 0px 5px;">
<?php
					$liq += $liq_frn[$fr];
					$dif += $cot_srv[$fr]-$liq_frn[$fr];
					echo number_format($cot_srv[$fr]-$liq_frn[$fr], $prm_crr_dcm[1], '.', '');
?>
					</td>
<?php
				}
				elseif($cnf>0){echo '<td class="stl1" style="background-color: tomato;"></td>';}
				else{echo '<td class="stl1"></td>';}
			}
			else{echo '<td class="stl1"></td>';}
			if(isset($dat_frn)>0){
				$dat = min($dat_frn[$fr]);
?>
					<td class="stl1" style="padding: 0px 5px;<?php if($dat < date('Y-m-d')){echo 'color: red';} elseif($dat == date('Y-m-d')){echo 'background-color: red';} ?>"><?php if(is_array($dat_frn[$fr])){echo date("d/m/Y", strtotime($dat));} ?></td>
<?php
			}
?>
				</tr>
<?php
		}
?>
				<tr>
					<td></td>
					<td></td>
<?php
		if($cnf>0){
?>
					<td></td>
<?php
		}
?>
					<td class="stl1 usa" style="font-weight: normal; <?php if($dif<0 and $cnf>0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($cot, $prm_crr_dcm[1], '.', '') ?></td>
<?php
		if($cnf>0){
?>
					<td class="stl1" style="font-weight: normal; <?php if($dif<0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($liq, $prm_crr_dcm[1], '.', '') ?></td>
					<td class="stl1" style="font-weight: normal; <?php if($dif<0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($dif, $prm_crr_dcm[1], '.', '') ?></td>
					<td></td>
<?php
		}
?>
				</tr>
			</table>
<?php
	}
	$cot = $liq = $dif = 0;
	if(isset($hbr)){
		$color = '';
		if($cnf>0){
			foreach($hbr as $hb){
				foreach($chm_hbr[$hb] as $chm){
					foreach($res_hbr[$hb][$chm] as $id_res_chm) {$color_chm[] = $id_res_chm;}
				}
				if(isset($color_chm)){
					foreach(array_unique($color_chm) as $id_res_chm){
						if($id_res_chm<6){$color .= $col_res_srv[$id_res_chm].', ';}
					}
				}
				unset($color_chm);
				if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
				else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
			}
		}
?>
			<table class="dsg w-100">
<?php
		if($cnf<1){
?>
				<tr style="font-style: italic;" colspan="7">
					<td><?php echo $txt->hbr_sel->$id_lng; ?></td>
				</tr>
<?php
		}
?>
				<tr style="<?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->jours->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->vlls->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->hbrs->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->ctgs->$id_lng; ?></td>
<?php
		$flg_res = false;
		foreach($hbr as $hb){
			foreach($chm_hbr[$hb] as $chm){
				foreach(array_unique($res_hbr[$hb][$chm]) as $id_res_chm) {
					if($id_res_chm>0) {$flg_res = true;}
				}
			}
		}
		if($cnf>0 or $flg_res){
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->ress->$id_lng; ?></td>
<?php
		}
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->dev->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->pay->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->dif->$id_lng; ?></td>
<?php
		if(isset($dat_hbr)){
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->delai->$id_lng; ?></td>
<?php
		}
?>
				<tr/>
<?php
		foreach($hbr as $hb){
			if($hb>0){
				$dt_hbr = ftc_ass(select("nom, id_vll", "cat_hbr", "id", $hb));
				$id_vll = $dt_hbr['id_vll'];
				$hbr_nom = $dt_hbr['nom'];
			}
			elseif($hb<0){
				$h = -$hb;
				$dt_hbr = ftc_ass(select("nom, id_vll, nom_chm", "dev_hbr", "id", $h));
				$id_vll = $dt_hbr['id_vll'];
				$hbr_nom = $dt_hbr['nom'];
			}
			else{
				$id_vll = '';
				$hbr_nom = '';
			}
			foreach($chm_hbr[$hb] as $chm){
				if($hb>=0){
					if($chm>0){
						$dt_chm = ftc_ass(select("nom", "cat_hbr_chm", "id", $chm));
						$chm_nom = $dt_chm['nom'];
					}
					elseif($chm==-1){$chm_nom = $txt->nodef->$id_lng;}
					elseif($chm==-2){$chm_nom = $txt->libre->$id_lng;}
					else{$chm_nom = '';}
				}
				else{$chm_nom = $dt_hbr['nom_chm'];}
				$jr_hbr[$hb][$chm] = array_unique($jr_hbr[$hb][$chm]);
				$color = '';
				foreach(array_unique($res_hbr[$hb][$chm]) as $id_res_chm) {
					if(($cnf>0 or ($flg_res and $id_res_chm>0)) and $id_res_chm<6){$color .= $col_res_srv[$id_res_chm].', ';}
				}
				if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
				else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
?>
				<tr style="font-weight: normal; <?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px;"><?php foreach($jr_hbr[$hb][$chm] as $i => $jr){ ?><span class="lnk" onclick="scroll2(<?php echo $jr_hbr_id[$hb][$chm][$i].', '.$mdl_hbr_id[$hb][$chm][$i]; ?>)"><?php echo $jr;?></span> - <?php } ?></td>
					<td class="stl1" style="padding: 0px 5px; <?php if($dif_hbr[$hb] == 2){echo "background-color: mediumorchid;";} ?>"><?php if($id_vll>0){echo stripslashes($vll[$id_vll]);} else{echo '-';} ?></td>
					<td class="stl1" style="padding: 0px 5px; position: relative; <?php if($dif_hbr[$hb] > 0){echo "background-color: mediumorchid;";} ?>">
<?php
				if($hb>0){
?>
<!--COMMANDES-->
						<span class="lnk inf<?php echo $hb ?>hbr" onmouseover="vue_elem('inf', <?php echo $hb ?>, 'hbr')" onclick="<?php if($chm >0){echo "vue_cmd('vue_cmd_hbr".$hb."_".$chm."')";} else{echo "window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=".$hb."')";} ?>"><?php echo stripslashes($hbr_nom) ?></span>
<?php
					if($chm>0){
?>
						<div id="vue_cmd_hbr<?php echo $hb.'_'.$chm; ?>" class="cmd mw200 wsn" style="text-align:left;left:50%;transform:translate(-50%);">
							<strong><?php echo $txt->cmd->$id_lng; ?></strong>
							<ul>
								<li onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $hb;?>');document.getElementById('vue_cmd_hbr<?php echo $hb.'_'.$chm; ?>').style.display='none';"><?php echo $txt->cat->$id_lng; ?></li>
								<li onclick="window.open('../resources/php/docxHbr.php?id=<?php echo $id_dev_crc;?>&hbr=<?php echo $hb;?>&chm=<?php echo $chm;?>');"><?php echo $txt->lst_res->$id_lng; ?></li>
								<li onclick="window.open('../resources/php/vchHbr.php?id=<?php echo $id_dev_crc;?>&hbr=<?php echo $hb;?>');"><?php echo $txt->vch->$id_lng; ?></li>
								<li onclick="mailHbr(<?php echo $hb.', '.$chm.', 0'; ?>);"><?php echo $txt->maildevis->$id_lng; ?></li>
<?php
						if($aut['res']){
?>
								<li onclick="mailHbr(<?php echo $hb.', '.$chm.', 1'; ?>);"><?php echo $txt->mailres->$id_lng; ?></li>
<?php
						}
						if($aut['dev']){
?>
								<li onclick="searchHbr(<?php echo $hb.', '.$chm ?>, 0, 0, 0, 0, 'updateRates');"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
						}
?>
							</ul>
						</div>
<?php
					}
				}
				elseif($hb<0){echo stripslashes($hbr_nom);}
				else{echo '-';}
?>
					</td>
					<td class="stl1" style="padding: 0px 5px; <?php if($dif_chm[$chm] == 1){echo "background-color: mediumorchid;";} ?>"><?php echo stripslashes($chm_nom); ?></td>
<?php
				if($cnf>0 or $flg_res){
					$statut = '';
					foreach(array_unique($res_hbr[$hb][$chm]) as $id_res_chm) {
						if($id_res_chm<6){$statut .= $res_srv[$id_lng][$id_res_chm].' - ';}
					}
					$statut = substr_replace($statut, "", -3);
?>
					<td class="stl1" style="padding: 0px 5px;"><?php echo $statut; ?></td>
<?php
				}
?>
					<td class="stl1" style="padding: 0px 5px;"><?php if($chm > -2){echo number_format($cot_hbr[$hb][$chm], $prm_crr_dcm[1], '.', '');} ?></td>
					<td class="stl1" style="<?php if($chm > -2 and $cnf > 0 and $liq_hbr[$hb][$chm] <= 0){echo 'background-color: tomato;';} ?>padding: 0px 5px;"><?php if($chm > -2 or $liq_hbr[$hb][$chm]!=0){echo number_format($liq_hbr[$hb][$chm], $prm_crr_dcm[1], '.', '');} ?></td>

<?php
				if($chm > -2){
					$cot += $cot_hbr[$hb][$chm];
					if($liq_hbr[$hb][$chm]>0){
						$liq += $liq_hbr[$hb][$chm];
						$dif += $cot_hbr[$hb][$chm]-$liq_hbr[$hb][$chm];
?>
					<td class="stl1" style="<?php if($chm > -2 and number_format($cot_hbr[$hb][$chm]-$liq_hbr[$hb][$chm], $prm_crr_dcm[1], '.', '')<0){echo 'background-color: tomato;';} if($chm > -2 and number_format($cot_hbr[$hb][$chm]-$liq_hbr[$hb][$chm], $prm_crr_dcm[1], '.', '')>0 and $liq_hbr[$hb][$chm]!=0){echo 'background-color: skyblue;';} ?>padding: 0px 5px;">
<?php
						echo number_format($cot_hbr[$hb][$chm]-$liq_hbr[$hb][$chm], $prm_crr_dcm[1], '.', '');
					}
					elseif($cnf>0){echo '<td style="background-color: tomato;">';}
					else{echo '<td class="stl1"></td>';}
				}
				else{echo '<td class="stl1">-</td>';}
?>
					</td>
<?php
				if(isset($dat_hbr)){
					$dat = min($dat_hbr[$hb][$chm]);
?>
					<td class="stl1" style="padding: 0px 5px; <?php if($dat < date('Y-m-d')){echo 'color: red';} elseif($dat == date('Y-m-d')){echo 'background-color: red';} ?>"><?php if($chm > -2 and is_array($dat_hbr[$hb][$chm])){echo date("d/m/Y", strtotime($dat));} ?></td>
<?php
				}
?>
				</tr>
<?php
			}
		}
?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
<?php
		if($cnf>0){
?>
					<td></td>
<?php
		}
?>
					<td class="stl1 usa" style="font-weight: normal; <?php if($dif<0 and $cnf>0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($cot, $prm_crr_dcm[1], '.', '') ?></td>
<?php
		if($cnf>0){
?>
					<td class="stl1" style="font-weight: normal; <?php if($dif<0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($liq, $prm_crr_dcm[1], '.', '') ?></td>
					<td class="stl1" style="font-weight: normal; <?php if($dif<0){echo 'background-color: tomato;';} else {echo 'background-color: skyblue;';}?>"><?php echo number_format($dif, $prm_crr_dcm[1], '.', '') ?></td>
					<td></td>
<?php
		}
?>
				</tr>
			</table>
<?php
	}
	$cot = $liq = $dif = 0;
	if(isset($hbr_opt)){
		$color = '';
		if($cnf>0){
			foreach($hbr_opt as $hb_opt){
				foreach($chm_hbr_opt[$hb_opt] as $chm_opt){
					foreach($res_hbr_opt[$hb_opt][$chm_opt] as $id_res_chm) {$color_chm[] = $id_res_chm;}
				}
				if(isset($color_chm)){
					foreach(array_unique($color_chm) as $id_res_chm){
						if($id_res_chm<6){$color .= $col_res_srv[$id_res_chm].', ';}
					}
				}
				unset($color_chm);
				if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
				else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
			}
		}

?>
			<table class="dsg w-100">
<?php
		if($cnf<1){
?>
				<tr style="font-style: italic;" colspan="5">
					<td><?php echo $txt->hbr_opt->$id_lng; ?></td>
				</tr>
<?php
		}
?>
				<tr style="<?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->jours->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->vlls->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->hbrs->$id_lng; ?></td>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->ctgs->$id_lng; ?></td>
<?php
		if($cnf<1){
?>
					<td class="stl1" style="padding: 0px 5px; font-weight: bold;"><?php echo $txt->dev->$id_lng; ?></td>
<?php
		}
?>
				<tr/>
<?php
		foreach($hbr_opt as $hb_opt){
			if($hb_opt!=0){
				$dt_hbr = ftc_ass(select("nom, id_vll", "cat_hbr", "id", $hb_opt));
				$id_vll = $dt_hbr['id_vll'];
				$hbr_nom = $dt_hbr['nom'];
			}
			else{
				$id_vll = '';
				$hbr_nom = '';
			}
			foreach($chm_hbr_opt[$hb_opt] as $chm_opt){
				if($chm_opt>0){
					$dt_chm = ftc_ass(select("nom", "cat_hbr_chm", "id", $chm_opt));
					$chm_nom = $dt_chm['nom'];
				}
				elseif($chm_opt==-1){$chm_nom = $txt->nodef->$id_lng;}
				elseif($chm_opt==-2){$chm_nom = $txt->libre->$id_lng;}
				else{$chm_nom = '';}
				$jr_hbr_opt[$hb_opt][$chm_opt] = array_unique($jr_hbr_opt[$hb_opt][$chm_opt]);
				$color = '';
				foreach(array_unique($res_hbr_opt[$hb_opt][$chm_opt]) as $id_res_chm) {
					if($cnf>0 and $id_res_chm<6){$color .= $col_res_srv[$id_res_chm].', ';}
				}
				if(substr_count($color, ', ')==1){$color = "background:".substr_replace($color, "", -1);}
				else{$color = "background: linear-gradient(".substr_replace($color, "", -1).")";}
?>
				<tr style="font-weight: normal; <?php echo $color; ?>">
					<td class="stl1" style="padding: 0px 5px;"><?php foreach($jr_hbr_opt[$hb_opt][$chm_opt] as $i => $jr){ ?><span class="lnk" onclick="scroll2(<?php echo $jr_hbr_id_opt[$hb_opt][$chm_opt][$i].', '.$mdl_hbr_id_opt[$hb_opt][$chm_opt][$i]; ?>)"><?php echo $jr;?></span> - <?php } ?></td>
					<td class="stl1" style="padding: 0px 5px;"><?php echo stripslashes($vll[$id_vll]) ?></td>
					<td class="stl1" style="padding: 0px 5px; position: relative;">
<!--COMMANDES-->
						<span class="lnk inf<?php echo $hb_opt ?>hbr" onmouseover="vue_elem('inf', <?php echo $hb_opt ?>, 'hbr')" onclick="vue_cmd('vue_cmd_hbr_opt<?php echo $hb_opt.'_'.$chm_opt; ?>')"><?php echo stripslashes($hbr_nom) ?></span>
						<div id="vue_cmd_hbr_opt<?php echo $hb_opt.'_'.$chm_opt; ?>" class="cmd mw200 wsn" style="text-align:left; left:50%; transform:translate(-50%);">
							<strong><?php echo $txt->cmd->$id_lng; ?></strong>
							<ul>
								<li onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $hb_opt;?>');document.getElementById('vue_cmd_hbr_opt<?php echo $hb_opt.'_'.$chm_opt; ?>').style.display='none';"><?php echo $txt->cat->$id_lng; ?></li>
								<li onclick="window.open('../resources/php/docxHbr.php?id=<?php echo $id_dev_crc;?>&hbr=<?php echo $hb_opt;?>&chm=<?php echo $chm_opt;?>');"><?php echo $txt->lst_res->$id_lng; ?></li>
								<li onclick="mailHbr(<?php echo $hb_opt.', '.$chm_opt.', 0'; ?>);"><?php echo $txt->maildevis->$id_lng; ?></li>
<?php
				if($aut['res']){
?>
								<li onclick="mailHbr(<?php echo $hb_opt.', '.$chm_opt.', 1'; ?>);"><?php echo $txt->mailres->$id_lng; ?></li>
<?php
				}
				if($aut['dev']){
?>
								<li onclick="searchHbr(<?php echo $hb_opt.', '.$chm_opt ?>, 0, 0, 0, 0, 'updateRates');"><?php echo $txt->acttrf->$id_lng; ?></li>
								<li onclick="searchHbr(<?php echo $hb_opt.', '.$chm_opt ?>, 0, 0, 0, 0, 'sup');"><?php echo $txt->sup->$id_lng; ?></li>
<?php
				}
?>
							</ul>
						</div>
					</td>
					<td class="stl1" style="padding: 0px 5px;"><?php echo stripslashes($chm_nom) ?></td>
<?php
				if($cnf<1){
?>
					<td class="stl1" style="padding: 0px 5px;"><?php if($chm_opt > -2){echo number_format($cot_hbr_opt[$hb_opt][$chm_opt], $prm_crr_dcm[1], '.', '');} ?></td>
<?php
				}
?>
				</tr>
<?php
			}
		}
?>
			</table>
<?php
	}
}
?>
