<?php
$tot_inv[$nzero] = $inv_zero;
$tot_pst = $tot_crn = $tot_dtt = array();
foreach($pst as $id_pst => $nom) {
	if(isset($tot_pst[$nzero])) {$tot_pst[$nzero] += $prd_pst[$id_pst] - $chg_pst[$id_pst];}
	else{$tot_pst[$nzero] = $prd_pst[$id_pst] - $chg_pst[$id_pst];}
	if(isset($tot_crn[$nzero])) {$tot_crn[$nzero] += $crn_pst[$id_pst];}
	else{$tot_crn[$nzero] = $crn_pst[$id_pst];}
	if(isset($tot_dtt[$nzero])) {$tot_dtt[$nzero] += $dtt_pst[$id_pst];}
	else{$tot_dtt[$nzero] = $dtt_pst[$id_pst];}
}
$n_min = intval(((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) / 12) + $nzero +1;
$rq_trs = sel_whe("*","fin_trs INNER JOIN fin_ecr ON fin_trs.id_ecr = fin_ecr.id","date <= '".$dat_max."'");
while($dt_trs = ftc_ass($rq_trs)) {
	$n = intval(((date("Y",strtotime($dt_trs['date'])) * 12 + date("m",strtotime($dt_trs['date']))) - $min_m) / 12) + $nzero +1;
	if(isset($flux_css[$dt_trs['id_css']]['sld'][$n])) {$flux_css[$dt_trs['id_css']]['sld'][$n] += $dt_trs['sld'];}
	else{$flux_css[$dt_trs['id_css']]['sld'][$n] = $dt_trs['sld'];}
	if(isset($flux_css[$dt_trs['id_css']]['dvs'][$n])) {$flux_css[$dt_trs['id_css']]['dvs'][$n] += $dt_trs['dvs'];}
	else{$flux_css[$dt_trs['id_css']]['dvs'][$n] = $dt_trs['dvs'];}
}
foreach ($sld_inv as $dat => $sld) {
	if($css_inv[$dat] > 0 and $dat!='0000-00-00' and strtotime($dat) <= strtotime($dat_max)){
		$n = intval(((date("Y",strtotime($dat)) * 12 + date("m",strtotime($dat))) - $min_m) / 12) + $nzero + 1;
		if(isset($flux_css[$css_inv[$dat]]['sld'][$n])) {$flux_css[$css_inv[$dat]]['sld'][$n] += $sld;}
		else{$flux_css[$css_inv[$dat]]['sld'][$n] = $sld;}
		if(isset($flux_css[$css_inv[$dat]]['dvs'][$n])) {$flux_css[$css_inv[$dat]]['dvs'][$n] += $dvs_inv[$dat];}
		else{$flux_css[$css_inv[$dat]]['dvs'][$n] = $dvs_inv[$dat];}
	}
}
$rq_bdg = sel_whe("*","fin_bdg INNER JOIN fin_ecr ON fin_bdg.id_ecr = fin_ecr.id","date <= '".$dat_max."'");
while($dt_bdg = ftc_ass($rq_bdg)) {
	$n = intval(((date("Y",strtotime($dt_bdg['date'])) * 12 + date("m",strtotime($dt_bdg['date']))) - $min_m) / 12) + $nzero + 1;
	if(isset($tot_pst[$n])) {$tot_pst[$n] += $dt_bdg['prd'] - $dt_bdg['chg'];}
	else{$tot_pst[$n] = $dt_bdg['prd'] - $dt_bdg['chg'];}
	if(isset($som_dtt[$dt_bdg['id_pst']][$n])) {$som_dtt[$dt_bdg['id_pst']][$n] += $dt_bdg['dtt'];}
	else{$som_dtt[$dt_bdg['id_pst']][$n] = $dt_bdg['dtt'];}
	if(isset($som_crn[$dt_bdg['id_pst']][$n])) {$som_crn[$dt_bdg['id_pst']][$n] += $dt_bdg['crn'];}
	else{$som_crn[$dt_bdg['id_pst']][$n] = $dt_bdg['crn'];}
}
?>
<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_max)) {echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('bln');" />
<input type="button" value="-1M" onclick="document.getElementById('dat_max').value='<?php echo date("t/m/Y",strtotime(date("Y-m",strtotime($dat_max)). ' -1 month')) ?>';vue('bln');" />
<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('bln');" />
<input type="button" value="+1M" onclick="document.getElementById('dat_max').value='<?php echo date("t/m/Y",strtotime(date("Y-m",strtotime($dat_max)). ' +1 month')); ?>';vue('bln');" />
<table>
	<tr>
		<td class="vat">
			<table>
<?php
for($b = $nzero; $b <= $exc; $b++) {
?>
				<tr style="font-weight: bold;<?php if($chkver[$b] or ($b < $n_min and ($b != $nzero or $n_min > $nzero +1))) {echo 'display: none;';} ?>" class="inv_td<?php echo $b ?>">
					<td class="btn">
						<div id="str<?php echo $b ?>" onclick="show('td<?php echo $b ?>');" >
<?php
	if($b==$nzero) {echo 'BILAN INTIAL';}
	else{echo 'BILAN '.$b;}
?>
							<input type="hidden" id="htd<?php echo $b ?>" class="chkver" value="<?php if(isset($chkver[$b])) {echo $chkver[$b];} else{echo '0';} ?>">
						</div>
					</td>
				</tr>
<?php
}
?>
			</table>
		</td>
<?php
if($n_min <= $nzero +1){
?>
		<td style="vertical-align: top; text-align: center; <?php if(!isset($chkver[$nzero]) or !$chkver[$nzero]) {echo 'display: none;';} ?>" class="td<?php echo $nzero; ?>">
			<div class="tbl_trf">
				<span onclick="hide('td<?php echo $nzero; ?>');"><img style="vertical-align: middle;" src="../prm/img/cls.png" /></span>
				<strong>BILAN INITIAL</strong>
				<hr/>
				<table>
					<tr>
						<td style="text-align: center; vertical-align: top;">
							<strong>ACTIF</strong>
							<hr/>
							TRESORERIE
							<table>
								<tr style="font-weight: bold">
									<td class="td_fin">CAISSES</td>
									<td class="td_fin">MONTANT</td>
									<td class="td_fin">SOLDE</td>
									<td class="td_fin">TAUX</td>
								</tr>
<?php
}
foreach($css as $id_css => $nom) {
	if($id_css>0) {
		if(isset($tot_css[$nzero])) {$tot_css[$nzero] += $sld_css[$id_css];}
		else{$tot_css[$nzero] = $sld_css[$id_css];}
		if($n_min <= $nzero +1){
?>
								<tr>
									<td class="td_fin wsn"><?php echo $nom ?></td>
									<td class="td_fin wsn" style="width: 110px;"><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dvs_css[$id_css],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','') ?>" onchange="maj('fin_css','dvs',this.value,<?php echo $id_css ?>)" /><?php echo $prm_crr_nom[$cfg_crr_css[$id_css]] ?></td>
									<td class="td_fin"><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($sld_css[$id_css],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_css','sld',this.value,<?php echo $id_css ?>)" /></td>
									<td class="td_fin">
<?php
		if(!isset($cfg_crr_dcm[$cfg_crr_css[$id_css]]) or number_format($sld_css[$id_css],$prm_crr_dcm[1])==0 or number_format($dvs_css[$id_css],$cfg_crr_dcm[$cfg_crr_css[$id_css]])==0) {echo '-';}
		elseif($cfg_crr_sp[$cfg_crr_css[$id_css]]==1) {echo number_format($sld_css[$id_css]/$dvs_css[$id_css],$cfg_crr_dcm[$cfg_crr_css[$id_css]],',','.');}
		else{echo number_format($dvs_css[$id_css]/$sld_css[$id_css],$cfg_crr_dcm[$cfg_crr_css[$id_css]],',','.');}
?>
									</td>
								</tr>
<?php
		}
	}
	else{$tot_dvd[$nzero]=$sld_css[$id_css];}
}
if(isset($tot_css) and isset($tot_crn)) {$tot_act[$nzero] = $tot_css[$nzero] + $tot_crn[$nzero];}
if(isset($tot_inv) and isset($tot_pst) and isset($tot_dvd)) {$tot_cpt[$nzero] = $tot_inv[$nzero] + $tot_pst[$nzero]- $tot_dvd[$nzero];}
if(isset($tot_cpt) and isset($tot_dtt)) {$tot_psf[$nzero] = $tot_cpt[$nzero] + $tot_dtt[$nzero];}
if($n_min <= $nzero +1){
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td></td>
									<td class="td_fin"><?php if(isset($tot_css)) {echo number_format($tot_css[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
									<td></td>
								</tr>
							</table>
							<hr/>
							CREANCES
							<table>
<?php
	foreach($pst as $id_pst => $nom) {
?>
								<tr>
									<td class="td_fin" style="width: 125px;"><?php echo $nom ?></td>
									<td class="td_fin" style="width: 80px;"><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($crn_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_crn',this.value,<?php echo $id_pst ?>)" /></td>
								</tr>
<?php
	}
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td class="td_fin"><?php if(isset($tot_crn)) {echo number_format($tot_crn[$nzero],$prm_crr_dcm[1],',','');} ?></td>
								<tr>
							</table>
							<hr/>
						</td>
						<td style="text-align: center; vertical-align: top;">
							<strong>PASSIF</strong>
							<hr/>
							CAPITAUX
							<table>
								<tr style="font-weight: bold">
									<td class="td_fin">INVESTISSEMENTS</td>
									<td class="td_fin"><?php if(isset($tot_inv)) {echo number_format($tot_inv[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
								</tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">DIVIDENDES</td>
									<td class="td_fin"><?php if(isset($tot_dvd)) {echo number_format($tot_dvd[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
								</tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">RESULTATS</td>
									<td class="td_fin"><?php if(isset($tot_pst)) {echo number_format($tot_pst[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
								</tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL FONDS PROPRES</td>
									<td class="td_fin" style="<?php if($tot_cpt[$nzero]<0) {echo 'color:red';} ?>"><?php if(isset($tot_cpt)) {echo number_format($tot_cpt[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
								</tr>
							</table>
							<hr/>
							DETTES
							<table>
<?php
	foreach($pst as $id_pst => $nom) {
?>
								<tr>
									<td class="td_fin" style="width: 125px;"><?php echo $nom ?></td>
									<td class="td_fin" style="width: 80px;"><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dtt_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_dtt',this.value,<?php echo $id_pst ?>)" /></td>
								</tr>
<?php
	}
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td class="td_fin"><?php if(isset($tot_dtt)) {echo number_format($tot_dtt[$nzero],$prm_crr_dcm[1],',','.');} ?></td>
								<tr>
							</table>
							<hr/>
						</td>
					</tr>
					<tr>
						<td>
							<strong>TOTAL: <?php if(isset($tot_act)) {echo number_format($tot_act[$nzero],$prm_crr_dcm[1],',','.');} ?><strong>
						</td>
						<td>
							<strong>TOTAL: <?php if(isset($tot_psf)) {echo number_format($tot_psf[$nzero],$prm_crr_dcm[1],',','.');} ?><strong>
						</td>
					</tr>
				</table>
			</div>
		</td>
<?php
}
for($b = $nzero+1; $b <= $exc; $b++) {
	if($b >= $n_min){
?>
		<td style="vertical-align: top; text-align: center;<?php if(!isset($chkver[$b]) or !$chkver[$b]) {echo 'display: none;';} ?>" class="td<?php echo $b ?>">
			<div class="tbl_trf">
				<span onclick="hide('td<?php echo $b ?>');"><img style="vertical-align: middle;" src="../prm/img/cls.png" /></span>
				<strong>BILAN N<?php echo $b ?></strong>
				<hr/>
				<table>
					<tr>
						<td style="text-align: center; vertical-align: top;">
							<strong>ACTIF</strong>
							<hr/>
							TRESORERIE
							<table>
								<tr style="font-weight: bold">
									<td class="td_fin">CAISSES</td>
									<td class="td_fin">MONTANT</td>
									<td class="td_fin">SOLDE</td>
									<td class="td_fin">TAUX</td>
								</tr>
<?php
	}
	foreach($css as $id_css => $nom) {
		if($id_css>0) {
			$tot_css_dvs[$id_css][$b] = $dvs_css[$id_css];
			$tot_css_sld[$id_css][$b] = $sld_css[$id_css];
			for($n=$nzero+1;$n<=$b;$n++) {
				if(isset($flux_css[$id_css]['dvs'][$n])) {$tot_css_dvs[$id_css][$b] += $flux_css[$id_css]['dvs'][$n];}
				if(isset($flux_css[$id_css]['sld'][$n])) {$tot_css_sld[$id_css][$b] += $flux_css[$id_css]['sld'][$n];}


			}
			if(isset($tot_css[$b])) {$tot_css[$b] += $tot_css_sld[$id_css][$b];}
			else{$tot_css[$b] = $tot_css_sld[$id_css][$b];}

			if($b >= $n_min and (number_format($tot_css_dvs[$id_css][$b],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.')!=0 or number_format($tot_css_sld[$id_css][$b],$prm_crr_dcm[1],',','.')!=0)) {
?>
								<tr>
									<td class="td_fin wsn"><?php echo $nom ?></td>
									<td class="td_fin wsn"><?php echo number_format($tot_css_dvs[$id_css][$b],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').' '.$prm_crr_nom[$cfg_crr_css[$id_css]] ?></td>
									<td class="td_fin"><?php echo number_format($tot_css_sld[$id_css][$b],$prm_crr_dcm[1],',','.') ?></td>
									<td class="td_fin">
<?php
				if(!isset($cfg_crr_dcm[$cfg_crr_css[$id_css]]) or number_format($tot_css_dvs[$id_css][$b],$prm_crr_dcm[$cfg_crr_css[$id_css]])==0 or number_format($tot_css_sld[$id_css][$b],$prm_crr_dcm[1])==0) {echo '-';}
				elseif($cfg_crr_sp[$cfg_crr_css[$id_css]]==1) {echo number_format($tot_css_sld[$id_css][$b]/$tot_css_dvs[$id_css][$b],$cfg_crr_dcm[$cfg_crr_css[$id_css]],',','.');}
				else{echo number_format($tot_css_dvs[$id_css][$b]/$tot_css_sld[$id_css][$b],$cfg_crr_dcm[$cfg_crr_css[$id_css]],',','.');}
?>
									</td>
								<tr>
<?php
			}
		}
		else{
			$tot_dvd[$b] = $sld_css[$id_css];
			for($n=$nzero+1;$n<=$b;$n++) {
				if(isset($flux_css[$id_css]['sld'][$n])) {$tot_dvd[$b] += $flux_css[$id_css]['sld'][$n];}
			}
		}
	}
	for($c=$b;$c>=$nzero;$c--) {
		if(isset($tot_dvd[$c-1])) {$tot_dvd[$b] -= $tot_dvd[$c-1];}
	}
	for($c=$nzero;$c<=$exc;$c++) {
		if(isset($tot_pst[$c])) {$tot_rep[$c] = $tot_pst[$c];}
		else{$tot_rep[$c] = 0;}
		if(isset($tot_dvd[$c])) {$tot_rep[$c] -= $tot_dvd[$c];}
		if($c > $nzero) {
			$tot_inv[$c] = $tot_inv[$c-1];
			$tot_rep[$c] += $tot_rep[$c-1];
		}
	}
	foreach ($sld_inv as $dat => $sld) {
		if($css_inv[$dat] > 0 and $dat!='0000-00-00' and strtotime($dat) <= strtotime($dat_max)) {
			$ninv = intval(((date("Y",strtotime($dat)) * 12 + date("m",strtotime($dat))) - $min_m) / 12) + $nzero + 1;
			for($c=$ninv;$c<=$exc;$c++) { //remplacer $nzero par execices <=> $dat
				$tot_inv[$c] += $sld; //BOUCLE FOREACH AVEC TOUS LES EXERCICES DEPUIS $DAT
			}
		}
	}
	if($b >= $n_min){
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td></td>
									<td class="td_fin"><?php echo number_format($tot_css[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
							</table>
							<hr/>
							CREANCES
							<table>
<?php
	}
	$tot_cpt[$b] = $tot_inv[$b]+$tot_rep[$b];
	foreach($pst as $id_pst => $nom) {
		$tot_bdg_dtt[$id_pst][$b] = $dtt_pst[$id_pst];
		$tot_bdg_crn[$id_pst][$b] = $crn_pst[$id_pst];
		for($n=$nzero+1;$n<=$b;$n++) {
			if(isset($som_dtt[$id_pst][$n])) {$tot_bdg_dtt[$id_pst][$b] += $som_dtt[$id_pst][$n];}
			if(isset($som_crn[$id_pst][$n])) {$tot_bdg_crn[$id_pst][$b] += $som_crn[$id_pst][$n];}
		}
		if(isset($tot_dtt[$b])) {$tot_dtt[$b] += $tot_bdg_dtt[$id_pst][$b];}
		else{$tot_dtt[$b] = $tot_bdg_dtt[$id_pst][$b];}
		if(isset($tot_crn[$b])) {$tot_crn[$b] += $tot_bdg_crn[$id_pst][$b];}
		else{$tot_crn[$b] = $tot_bdg_crn[$id_pst][$b];}
		if($b >= $n_min and number_format($tot_bdg_crn[$id_pst][$b],$prm_crr_dcm[1])!=0) {
?>
								<tr>
									<td class="td_fin"><?php echo $nom ?></td>
									<td class="td_fin"><?php echo number_format($tot_bdg_crn[$id_pst][$b],$prm_crr_dcm[1],',','.') ?></td>
								<tr>
<?php
		}
	}
	$tot_act[$b] = $tot_css[$b] + $tot_crn[$b];
	$tot_psf[$b] = $tot_cpt[$b] + $tot_dtt[$b];
	if($b >= $n_min){
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td class="td_fin"><?php echo number_format($tot_crn[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
							</table>
							<hr/>
						</td>
						<td style="text-align: center; vertical-align: top;">
							<strong>PASSIF</strong>
							<hr/>
							CAPITAUX
							<table>
								<tr style="font-weight: bold">
									<td class="td_fin">CAPITAL</td>
									<td class="td_fin"><?php echo number_format($tot_inv[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">REPORT A NOUVEAU ANTERIEURS</td>
									<td class="td_fin">
<?php
	echo number_format($tot_rep[$b-1],$prm_crr_dcm[1],',','.');//}
?>
									</td>
								</tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">RESULTAT</td>
									<td class="td_fin"><?php if(isset($tot_pst[$b])) {echo number_format($tot_pst[$b],$prm_crr_dcm[1],',','.');} else{echo '-';} ?></td>
								</tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">DIVIDENDES</td>
									<td class="td_fin"><?php echo number_format($tot_dvd[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">REPORT A NOUVEAU</td>
									<td class="td_fin"><?php echo number_format($tot_rep[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
								<tr><td></td></tr>
								<tr><td></td></tr>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL FONDS PROPRES</td>
									<td class="td_fin" style="<?php if($tot_cpt[$b]<0) {echo 'color:red';} ?>"><?php echo number_format($tot_cpt[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
							</table>
							<hr/>
							DETTES
							<table>
<?php
		foreach($pst as $id_pst => $nom) {
			if(number_format($tot_bdg_dtt[$id_pst][$b],$prm_crr_dcm[1])!=0) {
?>
								<tr>
									<td class="td_fin"><?php echo $nom ?></td>
									<td class="td_fin"><?php echo number_format($tot_bdg_dtt[$id_pst][$b],$prm_crr_dcm[1],',','.') ?></td>
								<tr>
<?php
			}
		}
?>
								<tr style="font-weight: bold">
									<td class="td_fin">TOTAL</td>
									<td class="td_fin"><?php echo number_format($tot_dtt[$b],$prm_crr_dcm[1],',','.') ?></td>
								</tr>
							</table>
							<hr/>
						</td>
					</tr>
					<tr>
						<td>
							<strong>TOTAL: <?php echo number_format($tot_act[$b],$prm_crr_dcm[1],',','.')?><strong>
						</td>
						<td>
							<strong>TOTAL: <?php echo number_format($tot_psf[$b],$prm_crr_dcm[1],',','.')?><strong>
						</td>
					</tr>
				</table>
			</div>
		</td>
<?php
	}
}
?>
	</tr>
</table>
