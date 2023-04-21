<?php
$arr_bdg['chg_ope']['initial'] = $arr_bdg['chg_ope_tot_cumul'] = $arr_bdg['chg_ope']['initial'] = $arr_bdg['chg_fix_tot_cumul'] = $arr_bdg['chg_com']['initial'] = $arr_bdg['chg_com_tot_cumul'] = $arr_bdg['chg_fix']['initial'] = $arr_bdg['chg_fix_tot_cumul'] = 0;
$arr_bdg['prd_ope']['initial'] = $arr_bdg['prd_ope_tot_cumul'] = $arr_bdg['prd_ope']['initial'] = $arr_bdg['prd_fix_tot_cumul'] = $arr_bdg['prd_com']['initial'] = $arr_bdg['prd_com_tot_cumul'] = $arr_bdg['prd_fix']['initial'] = $arr_bdg['prd_fix_tot_cumul'] = 0;
foreach($pst as $id_pst => $nom) {
	if($prd_pst[$id_pst]!=0) {
		if($rsl_pst[$id_pst]==1) {
			$arr_bdg['prd_ope']['initial'] += $prd_pst[$id_pst];
			$arr_bdg['prd_ope_cumul'][$id_pst] = $prd_pst[$id_pst];
			$arr_bdg['prd_ope_tot_cumul'] += $prd_pst[$id_pst];
		}
		elseif($rsl_pst[$id_pst]==2) {
			$arr_bdg['prd_com']['initial'] += $prd_pst[$id_pst];
			$arr_bdg['prd_com_cumul'][$id_pst] = $prd_pst[$id_pst];
			$arr_bdg['prd_com_tot_cumul'] += $prd_pst[$id_pst];
		}
		else{
			$arr_bdg['prd_fix']['initial'] += $prd_pst[$id_pst];
			$arr_bdg['prd_fix_cumul'][$id_pst] = $prd_pst[$id_pst];
			$arr_bdg['prd_fix_tot_cumul'] += $prd_pst[$id_pst];
		}
	}
	if($chg_pst[$id_pst]!=0) {
		if($rsl_pst[$id_pst]==1) {
			if(isset($chg_pst[$id_pst])) {$arr_bdg['chg_ope']['initial'] += $chg_pst[$id_pst];}
			$arr_bdg['chg_ope_cumul'][$id_pst] = $chg_pst[$id_pst];
			$arr_bdg['chg_ope_tot_cumul'] += $chg_pst[$id_pst];
		}
		elseif($rsl_pst[$id_pst]==2) {
			$arr_bdg['chg_com']['initial'] += $chg_pst[$id_pst];
			$arr_bdg['chg_com_cumul'][$id_pst] = $chg_pst[$id_pst];
			$arr_bdg['chg_com_tot_cumul'] += $chg_pst[$id_pst];
		}
		else{
			$arr_bdg['chg_fix']['initial'] += $chg_pst[$id_pst];
			$arr_bdg['chg_fix_cumul'][$id_pst] = $chg_pst[$id_pst];
			$arr_bdg['chg_fix_tot_cumul'] += $chg_pst[$id_pst];
		}
	}
}
$rq_bdg = sel_whe("fin_bdg.*,grp_dev.id_clt","fin_bdg INNER JOIN fin_ecr ON fin_bdg.id_ecr = fin_ecr.id LEFT JOIN grp_dev ON fin_bdg.id_grp = grp_dev.id","date <= '".$dat_max."' AND mois >= '".$dat_min."'","mois");
while($dt_bdg = ftc_ass($rq_bdg)) {
	$dat = $dt_bdg['mois'];
	$n = intval(((date("Y",strtotime($dat)) * 12 + date("m",strtotime($dat))) - $min_m) / 12) + $nzero + 1;
	if($dt_bdg['prd']!=0) {
		if($rsl_pst[$dt_bdg['id_pst']]==1) {
			if(isset($arr_bdg['prd_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_ope_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['prd_ope_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_ope']['total'][$n])) {$arr_bdg['prd_ope']['total'][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope']['total'][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_ope_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['prd_ope_cumul'][$dt_bdg['id_pst']] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope_cumul'][$dt_bdg['id_pst']] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_ope_tot_cumul'])) {$arr_bdg['prd_ope_tot_cumul'] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope_tot_cumul'] = $dt_bdg['prd'];}
			$arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_ope']['total'][$n];
			if(isset($arr_bdg['prd_ope']['clt'][$n][$dt_bdg['id_clt']])) {$arr_bdg['prd_ope']['clt'][$n][$dt_bdg['id_clt']] += $dt_bdg['prd'];} else{$arr_bdg['prd_ope']['clt'][$n][$dt_bdg['id_clt']] = $dt_bdg['prd'];}
		}
		elseif($rsl_pst[$dt_bdg['id_pst']]==2) {
			if(isset($arr_bdg['prd_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_com'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_com'][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_com'][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_com_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['prd_com_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_com_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_com']['total'][$n])) {$arr_bdg['prd_com']['total'][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_com']['total'][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_com_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['prd_com_cumul'][$dt_bdg['id_pst']] += $dt_bdg['prd'];} else{$arr_bdg['prd_com_cumul'][$dt_bdg['id_pst']] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_com_tot_cumul'])) {$arr_bdg['prd_com_tot_cumul'] += $dt_bdg['prd'];} else{$arr_bdg['prd_com_tot_cumul'] = $dt_bdg['prd'];}
			$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_com']['total'][$n];
		}
		else{
			if(isset($arr_bdg['prd_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_fix'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_fix'][date("m/Y", strtotime($dat))] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix'][date("m/Y", strtotime($dat))] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_fix_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['prd_fix_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_fix']['total'][$n])) {$arr_bdg['prd_fix']['total'][$n] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix']['total'][$n] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_fix_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['prd_fix_cumul'][$dt_bdg['id_pst']] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix_cumul'][$dt_bdg['id_pst']] = $dt_bdg['prd'];}
			if(isset($arr_bdg['prd_fix_tot_cumul'])) {$arr_bdg['prd_fix_tot_cumul'] += $dt_bdg['prd'];} else{$arr_bdg['prd_fix_tot_cumul'] = $dt_bdg['prd'];}
			$arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_fix']['total'][$n];
		}
	}
	if($dt_bdg['chg']!=0 or ($dt_bdg['id_pst']>0 and $prd_pst[$dt_bdg['id_pst']]==0)) {
		if($rsl_pst[$dt_bdg['id_pst']]==1) {
			if(isset($arr_bdg['chg_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_ope'][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope'][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_ope_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['chg_ope_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_ope']['total'][$n])) {$arr_bdg['chg_ope']['total'][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope']['total'][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_ope_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['chg_ope_cumul'][$dt_bdg['id_pst']] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope_cumul'][$dt_bdg['id_pst']] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_ope_tot_cumul'])) {$arr_bdg['chg_ope_tot_cumul'] += $dt_bdg['chg'];} else{$arr_bdg['chg_ope_tot_cumul'] = $dt_bdg['chg'];}
			$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_ope']['total'][$n];
		}
		elseif($rsl_pst[$dt_bdg['id_pst']]==2) {
			if(isset($arr_bdg['chg_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_com'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_com'][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_com'][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_com'][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_com_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['chg_com_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_com_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_com']['total'][$n])) {$arr_bdg['chg_com']['total'][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_com']['total'][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_com_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['chg_com_cumul'][$dt_bdg['id_pst']] += $dt_bdg['chg'];} else{$arr_bdg['chg_com_cumul'][$dt_bdg['id_pst']] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_com_tot_cumul'])) {$arr_bdg['chg_com_tot_cumul'] += $dt_bdg['chg'];} else{$arr_bdg['chg_com_tot_cumul'] = $dt_bdg['chg'];}
			$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_com']['total'][$n];
		}
		else{
			if(isset($arr_bdg['chg_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix'][$dt_bdg['id_pst']][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_fix'][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_fix'][date("m/Y", strtotime($dat))] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix'][date("m/Y", strtotime($dat))] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_fix_tot'][$dt_bdg['id_pst']][$n])) {$arr_bdg['chg_fix_tot'][$dt_bdg['id_pst']][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix_tot'][$dt_bdg['id_pst']][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_fix']['total'][$n])) {$arr_bdg['chg_fix']['total'][$n] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix']['total'][$n] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_fix_cumul'][$dt_bdg['id_pst']])) {$arr_bdg['chg_fix_cumul'][$dt_bdg['id_pst']] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix_cumul'][$dt_bdg['id_pst']] = $dt_bdg['chg'];}
			if(isset($arr_bdg['chg_fix_tot_cumul'])) {$arr_bdg['chg_fix_tot_cumul'] += $dt_bdg['chg'];} else{$arr_bdg['chg_fix_tot_cumul'] = $dt_bdg['chg'];}
			$arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_fix']['total'][$n];
		}
	}
}
if(isset($arr_bdg['prd_ope_cumul'])) {arsort($arr_bdg['prd_ope_cumul']);}
if(isset($arr_bdg['chg_ope_cumul'])) {arsort($arr_bdg['chg_ope_cumul']);}
if(isset($arr_bdg['prd_com_cumul'])) {arsort($arr_bdg['prd_com_cumul']);}
if(isset($arr_bdg['chg_com_cumul'])) {arsort($arr_bdg['chg_com_cumul']);}
if(isset($arr_bdg['prd_fix_cumul'])) {arsort($arr_bdg['prd_fix_cumul']);}
if(isset($arr_bdg['chg_fix_cumul'])) {arsort($arr_bdg['chg_fix_cumul']);}
$n = $nzero*12;
$dat = $dat_min;
while($dat <= $dat_max) {
	if((!isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	if((!isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	if((!isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	if((!isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	if((!isset($arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	if((!isset($arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))]) or $arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))]==0) and !is_int($n/12) and $n != $nzero*12) {
		if(isset($arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))]) or $arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))] = 0) {$arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))] = $arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime("-1 months $dat"))];}
	}
	$dat = date('Y-m', strtotime ("+1 months $dat"));
	$n++;

}
?>
<div id="wrapper">
	<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_max)) {echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('rsl');" />
	<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('rsl');" />
</div>
<br />
<br />
<table>
	<tr>
		<td>
			<table>
				<tr>
					<td class="btn inv_td<?php echo $nzero; ?>" style="font-weight: bold;<?php if($chkver[$nzero]) {echo 'display: none;';} ?>">
						<div id="std<?php echo $nzero; ?>" onclick="show('td<?php echo $nzero; ?>');" >INITIAL</div>
					</td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="btn inv_td<?php echo $n/12 ?>" style="font-weight: bold;<?php if($chkver[$n/12]) {echo 'display: none;';} ?>">
						<div id="std<?php echo $n/12 ?>" onclick="show('td<?php echo $n/12 ?>');" >N<?php echo $n/12; ?></div>
					</td>
<?php
		}
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="btn inv_td<?php echo $n/12 ?>" style="font-weight: bold;<?php if($chkver[$n/12]) {echo 'display: none;';} ?>">
						<div id="std<?php echo $n/12 ?>" onclick="show('td<?php echo $n/12 ?>');" >N<?php echo $n/12; ?></div>
					</td>
<?php
}
?>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="vat">
			<table>
				<tr>
					<td></td>
					<td colspan="2" class="td<?php echo $nzero; ?> text-center" style="font-weight: bold;<?php if(!$chkver[$nzero]) {echo 'display: none;';} ?>">
						<div class="btn" id="std<?php echo $nzero; ?>" onclick="hide('td<?php echo $nzero; ?>');" >
							<img style="vertical-align: middle;" src="../prm/img/cls.png" />
							INITIAL
							<input type="hidden" id="htd<?php echo $nzero; ?>" class="chkver" value="<?php echo $chkver[$nzero] ?>">
						</div>
					</td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	$j = (count($chkver)-1)*12;
	for($i=1; $i < $j; $i++) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td colspan="16" class="td<?php echo $n/12 ?> text-center" style="font-weight: bold;<?php if(!isset($chkver[$n/12]) or !$chkver[$n/12] or date('Y-m', strtotime ("-1 years $dat")) > $dat_max) {echo 'display: none;';} ?>">
						<span class="btn" id="std<?php echo $n/12 ?>" onclick="hide('td<?php echo $n/12 ?>');" >
							<img style="vertical-align: middle;" src="../prm/img/cls.png" />
<?php
			echo 'N'.$n/12;
?>
							<input type="hidden" id="htd<?php echo $n/12 ?>" class="chkver" value="<?php if(isset($chkver[$n/12])) {echo $chkver[$n/12];} else{echo '0';} ?>">
						</span>
					</td>
<?php
		}
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
	if(!isset($chkhor[0])) {$chkhor[0]=0;}
?>
					<td colspan="16" class="td<?php echo $n/12 ?> text-center" style="font-weight: bold;<?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'display: none;';} ?>">
						<span class="btn" id="std<?php echo $n/12 ?>" onclick="hide('td<?php echo $n/12 ?>');" >
							<img style="vertical-align: middle;" src="../prm/img/cls.png" />
<?php
	echo 'N'.$n/12;
?>
							<input type="hidden" id="htd<?php echo $n/12 ?>" class="chkver" value="<?php if(isset($chkver[$n/12])) {echo $chkver[$n/12];} else{echo '0';} ?>">
						</div>
					</td>
<?php
}
?>
				</tr>
				<tr style="font-weight: bold;">
					<td class="btn">
						<div class="tr_ope text-center" onclick="hide('tr_ope');" style="padding-top: 20px; height: 35px;<?php if(!$chkhor[0]) {echo ' display: none';} ?>" >OPERATIONS</div>
						<div id="str_ope" onclick="show('tr_ope');" style="padding-top: 20px; height: 35px;<?php if($chkhor[0]) {echo ' display: none';} ?>" class="inv_tr_ope text-center">OPERATIONS</div>
						<input type="hidden" id="htr_ope" class="chkhor" value="<?php echo $chkhor[0] ?>">
					</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>INITIAL</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo date("m/Y", strtotime($dat)); ?></td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin">TOTAL<br/>CUMULE</td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
<?php
if(isset($arr_bdg) and count($arr_bdg['prd_ope_cumul'])>0) {
	foreach($arr_bdg['prd_ope_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_ope" <?php if(!$chkhor[0]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($prd_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_prd',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_ope_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['prd_ope_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_ope'][$id_pst][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['prd_ope'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',','');} else{echo '-';} ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_ope_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['prd_ope_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['prd_ope_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_ope" <?php if(!$chkhor[0]) {echo 'style="display: none;"';} ?>>
					<td></td>
				</tr>
				<tr style="font-weight: bold">
					<td class="td_fin">
						TOTAL PRODUIT<br />
						<em>variation interannuelle</em>
					</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_ope']['initial']); ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['prd_ope']['total'][$n/12])) {$arr_bdg['prd_ope']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['prd_ope']['total'][$n/12]);
				if(isset($arr_bdg['prd_ope']['total'][$n/12-1])) {
					echo '<br/>';
					$vr = (($arr_bdg['prd_ope']['total'][$n/12]-$arr_bdg['prd_ope']['total'][$n/12-1])/abs($arr_bdg['prd_ope']['total'][$n/12-1]))*100;
					if($vr>0) {echo '+';}
					echo number_format($vr).'%';
				}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?> wsn" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				arsort($arr_bdg['prd_ope']['clt'][$n/12]);
				foreach($arr_bdg['prd_ope']['clt'][$n/12] as $id_clt => $k) {
					if($arr_bdg['prd_ope']['clt'][$n/12][$id_clt]!=0) {
						if($id_clt>0) {
							$dt_clt = ftc_ass(sel_quo("nom","cat_clt","id",$id_clt));
							echo $dt_clt['nom'];
						}
						elseif($id_clt==0) {echo 'Autre';}
						echo ' : '.number_format($arr_bdg['prd_ope']['clt'][$n/12][$id_clt]).'<br/>';
					}
				}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
			if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]);}
			else{echo '-';}
			if(!isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))] = 0;}
			if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {
				echo '<br/>';
				$vr = (($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]-$arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])/abs($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]))*100;
				if($vr>0) {echo '+';}
				echo number_format($vr).'%';
			}
?>
					</td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
					</td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
		if(!isset($arr_bdg['prd_ope']['total'][$n/12])) {$arr_bdg['prd_ope']['total'][$n/12] = 0;}
		echo number_format($arr_bdg['prd_ope']['total'][$n/12]);
		if($arr_bdg['prd_ope']['total'][$n/12-1]!=0) {
			echo '<br/>';
			$vr = (($arr_bdg['prd_ope']['total'][$n/12]-$arr_bdg['prd_ope']['total'][$n/12-1])/abs($arr_bdg['prd_ope']['total'][$n/12-1]))*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?> wsn" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
		if(array_key_exists($n/12,$arr_bdg['prd_ope']['clt'])) {
			arsort($arr_bdg['prd_ope']['clt'][$n/12]);
			foreach($arr_bdg['prd_ope']['clt'][$n/12] as $id_clt => $k) {
				if($arr_bdg['prd_ope']['clt'][$n/12][$id_clt]!=0) {
					if($id_clt>0) {
						$dt_clt = ftc_ass(sel_quo("nom","cat_clt","id",$id_clt));
						echo $dt_clt['nom'];
					}
					elseif($id_clt==0) {echo 'Autre';}
					echo ' : '.number_format($arr_bdg['prd_ope']['clt'][$n/12][$id_clt]).'<br/>';
				}
			}
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin"><?php echo number_format($arr_bdg['prd_ope_tot_cumul']); ?></td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
if(isset($arr_bdg) and count($arr_bdg['chg_ope_cumul'])>0) {
	foreach($arr_bdg['chg_ope_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_ope" <?php if(!$chkhor[0]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($chg_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_chg',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_ope_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['chg_ope_tot'][$id_pst][$n/12]);} else{echo '-';}	 ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_ope'][$id_pst][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_ope'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',','');} else{echo '-';} ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_ope_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['chg_ope_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['chg_ope_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_ope" <?php if(!$chkhor[0]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">TOTAL CHARGE</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_ope']['initial'])) {echo number_format($arr_bdg['chg_ope']['initial']);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['chg_ope']['total'][$n/12])) {$arr_bdg['chg_ope']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['chg_ope']['total'][$n/12]);
?>
</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))]);} else{echo '-';} ?></td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" style="font-weight: bold; <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'display: none;';} ?>">
<?php
			if(!isset($arr_bdg['chg_ope']['total'][$n/12])) {$arr_bdg['chg_ope']['total'][$n/12] = 0;}
			echo number_format($arr_bdg['chg_ope']['total'][$n/12]);
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php if(isset($arr_bdg['chg_ope_tot_cumul'])) {echo number_format($arr_bdg['chg_ope_tot_cumul']);} else{echo '-';} ?></td>
<?php
	}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
?>
				<tr style="font-weight: bold">
					<td class="td_fin">MARGE OPERATIONNELLE<br/><em>[% produit opérationnel]</em><br /><em>variation interannuelle</em></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>
<?php
if(isset($arr_bdg)) {
	$mr = 0;
	if(isset($arr_bdg['prd_ope']['initial'])) {$mr += $arr_bdg['prd_ope']['initial'];}
	if(isset($arr_bdg['chg_ope']['initial'])) {$mr -= $arr_bdg['chg_ope']['initial'];}
	echo number_format($mr).'<br/>[';
	if($arr_bdg['prd_ope']['initial']!=0) {echo number_format($mr/$arr_bdg['prd_ope']['initial']*100).'%';}
	echo ']';
}
?>
					</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
			$mr = 0;
			if(isset($arr_bdg['prd_ope']['total'][$n/12])) {$mr += $arr_bdg['prd_ope']['total'][$n/12];}
			if(isset($arr_bdg['chg_ope']['total'][$n/12])) {$mr -= $arr_bdg['chg_ope']['total'][$n/12];}
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
			echo ']';
			if(isset($arr_bdg['prd_ope']['total'][$n/12-1]) and isset($arr_bdg['chg_ope']['total'][$n/12-1])) {
				$mr2 = $arr_bdg['prd_ope']['total'][$n/12-1] - $arr_bdg['chg_ope']['total'][$n/12-1];
				if($mr2!=0) {
					echo '<br/>';
					$vr = ($mr-$mr2)/abs($mr2)*100;
					if($vr>0) {echo '+';}
					echo number_format($vr).'%';
				}
			}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
		if(!isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))] = 0;}
		if(!isset($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_ope'][date("m/Y", strtotime($dat))] = 0;}
		$mr = $arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]-$arr_bdg['chg_ope'][date("m/Y", strtotime($dat))];
		echo number_format($mr).'<br/>[';
		if($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]!=0) {echo number_format($mr/$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]*100).'%';}
		echo ']';
		if(!isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))])) {$arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))] = 0;}
		if(!isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))])) {$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))] = 0;}
		if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]!=$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) {
			echo '<br/>';
			$vr = ((($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))])-($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]))/abs($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]))*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" style="font-weight: bold; <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'display: none;';} ?>">
<?php
		if(isset($arr_bdg)) {
			if(!isset($arr_bdg['chg_ope']['total'][$n/12])) {$arr_bdg['chg_ope']['total'][$n/12] = 0;}
			$mr = $arr_bdg['prd_ope']['total'][$n/12]-$arr_bdg['chg_ope']['total'][$n/12];
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
			echo ']';
			$mr2 = $arr_bdg['prd_ope']['total'][$n/12-1]-$arr_bdg['chg_ope']['total'][$n/12-1];
			if($mr2!=0) {
				echo '<br/>';
				$vr = ($mr-$mr2)/abs($mr2)*100;
				if($vr>0) {echo '+';}
				echo number_format($vr).'%';
			}
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold">
<?php
		if(isset($arr_bdg)) {
			$mr = $arr_bdg['prd_ope_tot_cumul']-$arr_bdg['chg_ope_tot_cumul'];
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope_tot_cumul']!=0) {echo number_format($mr/$arr_bdg['prd_ope_tot_cumul']*100).'%';}
			echo ']';
		}
?>
					</td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr style="font-weight: bold">
					<td class="btn">
						<div class="tr_com text-center" onclick="hide('tr_com');" style="padding-top: 20px; height: 35px;<?php if(!$chkhor[1]) {echo ' display: none';} ?>" >COMMERCIAL</div>
						<div id="str_com" onclick="show('tr_com');" style="padding-top: 20px; height: 35px;<?php if($chkhor[1]) {echo ' display: none';} ?>" class="inv_tr_com text-center">COMMERCIAL</div>
						<input type="hidden" id="htr_com" class="chkhor" value="<?php echo $chkhor[1] ?>">
					</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>INITIAL</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo date("m/Y", strtotime($dat)); ?></td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin">TOTAL<br/>CUMULE</td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
<?php
if(isset($arr_bdg) and count($arr_bdg['prd_com_cumul'])>0) {
	foreach($arr_bdg['prd_com_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_com" <?php if(!$chkhor[1]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($prd_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_prd',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_com_tot'][$id_pst][$n/12]); ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_com'][$id_pst][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['prd_com'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',','');} else{echo '-';} ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_com_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['prd_com_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['prd_com_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_com" <?php if(!$chkhor[1]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">TOTAL PRODUIT</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_com']['initial']); ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['prd_com']['total'][$n/12])) {$arr_bdg['prd_com']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['prd_com']['total'][$n/12]);
				if(isset($arr_bdg['prd_com']['total'][$n/12-1]) and $arr_bdg['prd_com']['total'][$n/12-1]!=0) {
					echo '<br/>';
					$vr = (($arr_bdg['prd_com']['total'][$n/12]-$arr_bdg['prd_com']['total'][$n/12-1])/abs($arr_bdg['prd_com']['total'][$n/12-1]))*100;
					if($vr>0) {echo '+';}
					echo number_format($vr).'%';
				}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['prd_com'][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['prd_com'][date("m/Y", strtotime($dat))]);} else{echo '-';}?></td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
		if(!isset($arr_bdg['prd_com']['total'][$n/12])) {$arr_bdg['prd_com']['total'][$n/12] = 0;}
		echo number_format($arr_bdg['prd_com']['total'][$n/12]);
		if($arr_bdg['prd_com']['total'][$n/12-1]!=0) {
			echo '<br/>';
			$vr = (($arr_bdg['prd_com']['total'][$n/12]-$arr_bdg['prd_com']['total'][$n/12-1])/abs($arr_bdg['prd_com']['total'][$n/12-1]))*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin"><?php echo number_format($arr_bdg['prd_com_tot_cumul']); ?></td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
if(isset($arr_bdg) and count($arr_bdg['chg_com_cumul'])>0) {
	foreach($arr_bdg['chg_com_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_com" <?php if(!$chkhor[1]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($chg_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_chg',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['chg_com_tot'][$id_pst][$n/12]); ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_com'][$id_pst][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_com'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',','');} else{echo '-';} ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_com_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['chg_com_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['chg_com_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_com" <?php if(!$chkhor[1]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">TOTAL CHARGE</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['chg_com']['initial']); ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['chg_com']['total'][$n/12])) {$arr_bdg['chg_com']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['chg_com']['total'][$n/12]);
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_com'][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_com'][date("m/Y", strtotime($dat))]);} else{echo '-';} ?></td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" style="font-weight: bold; <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'display: none;';} ?>">
<?php
				if(!isset($arr_bdg['chg_com']['total'][$n/12])) {$arr_bdg['chg_com']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['chg_com']['total'][$n/12]);
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['chg_com_tot_cumul']); ?></td>
<?php
	}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
?>
				<tr style="font-weight: bold">
					<td class="td_fin">MARGE COMMERCIALE<br/><em>[% produit opérationnel]</em><br /><em>variation interannuelle</em></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>
<?php
if(isset($arr_bdg)) {
	$mr = $arr_bdg['prd_ope']['initial']-$arr_bdg['chg_ope']['initial']+$arr_bdg['prd_com']['initial']-$arr_bdg['chg_com']['initial'];
	echo number_format($mr).'<br/>[';
	if($arr_bdg['prd_ope']['initial']!=0) {echo number_format($mr/$arr_bdg['prd_ope']['initial']*100).'%';}
	echo ']';
}
?>
					</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
			$mr = $arr_bdg['prd_ope']['total'][$n/12]-$arr_bdg['chg_ope']['total'][$n/12]+$arr_bdg['prd_com']['total'][$n/12]-$arr_bdg['chg_com']['total'][$n/12];
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
			echo ']';
			if(isset($arr_bdg['prd_ope']['total'][$n/12-1]) and isset($arr_bdg['chg_ope']['total'][$n/12-1]) and isset($arr_bdg['prd_com']['total'][$n/12-1]) and isset($arr_bdg['chg_com']['total'][$n/12-1])) {
				$mr2 = $arr_bdg['prd_ope']['total'][$n/12-1]-$arr_bdg['chg_ope']['total'][$n/12-1]+$arr_bdg['prd_com']['total'][$n/12-1]-$arr_bdg['chg_com']['total'][$n/12-1];
				if($mr2!=0) {
					echo '<br/>';
					$vr = ($mr-$mr2)/abs($mr2)*100;
					if($vr>0) {echo '+';}
					echo number_format($vr).'%';
				}
			}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
		$mr = 0;
		if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))])) {$mr += $arr_bdg['prd_ope'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))])) {$mr -= $arr_bdg['chg_ope'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['prd_com'][date("m/Y", strtotime($dat))])) {$mr += $arr_bdg['prd_com'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_com'][date("m/Y", strtotime($dat))])) {$mr -= $arr_bdg['chg_com'][date("m/Y", strtotime($dat))];}
		echo number_format($mr).'<br/>[';
		if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]) and $arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]!=0) {echo number_format($mr/$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]*100).'%';}
		echo ']';
		if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]) and isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))]) and isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))]) and isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))]) and isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]) and $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]+$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]!=0) {
			echo '<br/>';
			$vr = ((($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))]+$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))]-$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))])-($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]+$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]))/abs($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]+$arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]-$arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))]))*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
	if(isset($arr_bdg)) {
		$mr = $arr_bdg['prd_ope']['total'][$n/12]-$arr_bdg['chg_ope']['total'][$n/12]+$arr_bdg['prd_com']['total'][$n/12]-$arr_bdg['chg_com']['total'][$n/12];
		echo number_format($mr).'<br/>[';
		if($arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
		echo ']';
		$mr2 = $arr_bdg['prd_ope']['total'][$n/12-1]-$arr_bdg['chg_ope']['total'][$n/12-1]+$arr_bdg['prd_com']['total'][$n/12-1]-$arr_bdg['chg_com']['total'][$n/12-1];
		if($mr2!=0) {
			echo '<br/>';
			$vr = ($mr-$mr2)/abs($mr2)*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
			}
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin">
<?php
		if(isset($arr_bdg)) {
			$mr = $arr_bdg['prd_ope_tot_cumul']-$arr_bdg['chg_ope_tot_cumul']+$arr_bdg['prd_com_tot_cumul']-$arr_bdg['chg_com_tot_cumul'];
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope_tot_cumul']!=0) {echo number_format($mr/$arr_bdg['prd_ope_tot_cumul']*100).'%';}
			echo ']';
		}
?>
					</td>
<?php
	}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr style="font-weight: bold">
					<td class="btn">
						<div class="tr_fix text-center" onclick="hide('tr_fix');" style="padding-top: 20px; height: 35px;<?php if(!$chkhor[2]) {echo ' display: none';} ?>" >FIXES</div>
						<div id="str_fix" onclick="show('tr_fix');" style="padding-top: 20px; height: 35px;<?php if($chkhor[2]) {echo ' display: none';} ?>" class="inv_tr_fix text-center">FIXES</div>
						<input type="hidden" id="htr_fix" class="chkhor" value="<?php echo $chkhor[2] ?>">
					</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>INITIAL</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo date("m/Y", strtotime($dat)); ?></td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>TOTAL N<?php echo $n/12; ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin">TOTAL<br/>CUMULE</td>
<?php
}
?>
				</tr>
				<tr><td></td></tr>
<?php
if(isset($arr_bdg) and isset($arr_bdg['prd_fix_cumul']) and count($arr_bdg['prd_fix_cumul'])>0) {
	foreach($arr_bdg['prd_fix_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_fix" <?php if(!$chkhor[2]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($prd_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_prd',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_fix_tot'][$id_pst][$n/12]); ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_fix'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',',''); ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_fix'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['prd_fix_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_fix" <?php if(!$chkhor[2]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">TOTAL PRODUIT</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['prd_fix']['initial']); ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['prd_fix']['total'][$n/12])) {$arr_bdg['prd_fix']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['prd_fix']['total'][$n/12]);
				if($arr_bdg['prd_fix']['total'][$n/12-1]!=0) {
					echo '<br/>';
					$vr = (($arr_bdg['prd_fix']['total'][$n/12]-$arr_bdg['prd_fix']['total'][$n/12-1])/abs($arr_bdg['prd_fix']['total'][$n/12-1]))*100;
					if($vr>0) {echo '+';}
					echo number_format($vr).'%';
				}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
			echo number_format($arr_bdg['prd_fix'][date("m/Y", strtotime($dat))]);
			if($n>=12 and $arr_bdg['prd_fix'][date("m/Y", strtotime("-1 year $dat"))]!=0) {
				echo '<br/>';
				$vr = (($arr_bdg['prd_fix'][date("m/Y", strtotime($dat))]-$arr_bdg['prd_fix'][date("m/Y", strtotime("-1 year $dat"))])/abs($arr_bdg['prd_fix'][date("m/Y", strtotime("-1 year $dat"))]))*100;
				if($vr>0) {echo '+';}
				echo number_format($vr).'%';
			}
?>
					</td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
		if(!isset($arr_bdg['prd_fix']['total'][$n/12])) {$arr_bdg['prd_fix']['total'][$n/12] = 0;}
		echo number_format($arr_bdg['prd_fix']['total'][$n/12]);
		if($arr_bdg['prd_fix']['total'][$n/12-1]!=0) {
			echo '<br/>';
			$vr = (($arr_bdg['prd_fix']['total'][$n/12]-$arr_bdg['prd_fix']['total'][$n/12-1])/abs($arr_bdg['prd_fix']['total'][$n/12-1]))*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin"><?php echo number_format($arr_bdg['prd_fix_tot_cumul']); ?></td>
<?php
	}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
if(isset($arr_bdg) and count($arr_bdg['chg_fix_cumul'])) {
	foreach($arr_bdg['chg_fix_cumul'] as $id_pst => $z) {
?>
				<tr class="tr_fix" <?php if(!$chkhor[2]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin"><?php echo $pst[$id_pst] ?></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><input type="text" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($chg_pst[$id_pst],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_pst','sld_chg',this.value,<?php echo $id_pst ?>)" /></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
		if(isset($dat_max)) {
			$n = $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_fix_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['chg_fix_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_fix'][$id_pst][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_fix'][$id_pst][date("m/Y", strtotime($dat))],$prm_crr_dcm[1],',','');} else{echo '-';} ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" style="<?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'display: none;';} ?>font-weight: bold"><?php if(isset($arr_bdg['chg_fix_tot'][$id_pst][$n/12])) {echo number_format($arr_bdg['chg_fix_tot'][$id_pst][$n/12]);} else{echo '-';} ?></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin" style="font-weight: bold"><?php echo number_format($arr_bdg['chg_fix_cumul'][$id_pst]); ?></td>
<?php
		}
?>
				</tr>
<?php
	}
?>
				<tr class="tr_fix" <?php if(!$chkhor[2]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">TOTAL CHARGE</td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_bdg['chg_fix']['initial']); ?></td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
	if(isset($dat_max)) {
		$n = $nzero*12;
		$dat = $dat_min;
		while($dat <= $dat_max) {
			if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
				if(!isset($arr_bdg['chg_fix']['total'][$n/12])) {$arr_bdg['chg_fix']['total'][$n/12] = 0;}
				echo number_format($arr_bdg['chg_fix']['total'][$n/12]);
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
			}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php if(isset($arr_bdg['chg_fix'][date("m/Y", strtotime($dat))])) {echo number_format($arr_bdg['chg_fix'][date("m/Y", strtotime($dat))]);} else{echo '-';} ?></td>
<?php
			$dat = date('Y-m', strtotime ("+1 months $dat"));
			$n++;
		}
		while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
			if(!isset($arr_bdg['chg_fix']['total'][$n/12])) {$arr_bdg['chg_fix']['total'][$n/12] = 0;}
			echo number_format($arr_bdg['chg_fix']['total'][$n/12]);
?>
</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin"><?php echo number_format($arr_bdg['chg_fix_tot_cumul']); ?></td>
<?php
	}
?>
				</tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
<?php
}
?>
				<tr><td></td></tr>
				<tr style="font-weight: bold">
					<td class="td_fin">RESULTAT<br/><em>[% produit opérationnel]</em><br /><em>variation interannuelle</em></td>
					<td class="td_fin td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>>
<?php
$mr = 0;
if(isset($arr_bdg['prd_ope']['initial'])) {$mr += $arr_bdg['prd_ope']['initial'];}
if(isset($arr_bdg['chg_ope']['initial'])) {$mr -= $arr_bdg['chg_ope']['initial'];}
if(isset($arr_bdg['prd_com']['initial'])) {$mr += $arr_bdg['prd_com']['initial'];}
if(isset($arr_bdg['chg_com']['initial'])) {$mr -= $arr_bdg['chg_com']['initial'];}
if(isset($arr_bdg['prd_fix']['initial'])) {$mr += $arr_bdg['prd_fix']['initial'];}
if(isset($arr_bdg['chg_fix']['initial'])) {$mr -= $arr_bdg['chg_fix']['initial'];}
echo number_format($mr).'<br/>[';
if(isset($arr_bdg['prd_ope']['initial']) and $arr_bdg['prd_ope']['initial']!=0) {echo number_format($mr/$arr_bdg['prd_ope']['initial']*100).'%';}
echo ']';
?>
					</td>
					<td class="td_fin2 td<?php echo $nzero; ?>" <?php if(!$chkver[$nzero]) {echo 'style="display: none;"';} ?>></td>
<?php
if(isset($dat_max)) {
	$n = $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $nzero*12) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
			$mr = 0;
			if(isset($arr_bdg['prd_ope']['total'][$n/12])) {$mr += $arr_bdg['prd_ope']['total'][$n/12];}
			if(isset($arr_bdg['chg_ope']['total'][$n/12])) {$mr -= $arr_bdg['chg_ope']['total'][$n/12];}
			if(isset($arr_bdg['prd_com']['total'][$n/12])) {$mr += $arr_bdg['prd_com']['total'][$n/12];}
			if(isset($arr_bdg['chg_com']['total'][$n/12])) {$mr -= $arr_bdg['chg_com']['total'][$n/12];}
			if(isset($arr_bdg['prd_fix']['total'][$n/12])) {$mr += $arr_bdg['prd_fix']['total'][$n/12];}
			if(isset($arr_bdg['chg_fix']['total'][$n/12])) {$mr -= $arr_bdg['chg_fix']['total'][$n/12];}
			echo number_format($mr).'<br/>[';
			if($arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
			echo ']';
			$mr2 = 0;
			if(isset($arr_bdg['prd_ope']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_ope']['total'][$n/12-1];}
			if(isset($arr_bdg['chg_ope']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_ope']['total'][$n/12-1];}
			if(isset($arr_bdg['prd_com']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_com']['total'][$n/12-1];}
			if(isset($arr_bdg['chg_com']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_com']['total'][$n/12-1];}
			if(isset($arr_bdg['prd_fix']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_fix']['total'][$n/12-1];}
			if(isset($arr_bdg['chg_fix']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_fix']['total'][$n/12-1];}
			if($mr2!=0) {
				echo '<br/>';
				$vr = ($mr-$mr2)/abs($mr2)*100;
				if($vr>0) {echo '+';}
				echo number_format($vr).'%';
			}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
		$mr = 0;
		if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))])) {$mr += $arr_bdg['prd_ope'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_ope'][date("m/Y", strtotime($dat))])) {$mr -= $arr_bdg['chg_ope'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['prd_com'][date("m/Y", strtotime($dat))])) {$mr += $arr_bdg['prd_com'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_com'][date("m/Y", strtotime($dat))])) {$mr -= $arr_bdg['chg_com'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['prd_fix'][date("m/Y", strtotime($dat))])) {$mr += $arr_bdg['prd_fix'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_fix'][date("m/Y", strtotime($dat))])) {$mr -= $arr_bdg['chg_fix'][date("m/Y", strtotime($dat))];}
		echo number_format($mr).'<br/>[';
		if(isset($arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]) and $arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]!=0) {echo number_format($mr/$arr_bdg['prd_ope'][date("m/Y", strtotime($dat))]*100).'%';}
		echo ']';
		$vr1 = 0;
		if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 += $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 -= $arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 += $arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 -= $arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 += $arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime($dat))];}
		if(isset($arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))])) {$vr1 -= $arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime($dat))];}
		$vr2 = 0;
		if(isset($arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 += $arr_bdg['prd_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if(isset($arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 -= $arr_bdg['chg_ope_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if(isset($arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 += $arr_bdg['prd_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if(isset($arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 -= $arr_bdg['chg_com_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if(isset($arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 += $arr_bdg['prd_fix_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if(isset($arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))])) {$vr2 -= $arr_bdg['chg_fix_mois_cumul'][date("m/Y", strtotime("-1 year $dat"))];}
		if($vr2 !=0) {
 			echo '<br/>';
			$vr = ($vr1-$vr2)/abs($vr2)*100;
			if($vr>0) {echo '+';}
			echo number_format($vr).'%';
		}
?>
					</td>
<?php
		$dat = date('Y-m', strtotime ("+1 months $dat"));
		$n++;
	}
	while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
	$mr = 0;
	if(isset($arr_bdg['prd_ope']['total'][$n/12])) {$mr += $arr_bdg['prd_ope']['total'][$n/12];}
	if(isset($arr_bdg['chg_ope']['total'][$n/12])) {$mr -= $arr_bdg['chg_ope']['total'][$n/12];}
	if(isset($arr_bdg['prd_com']['total'][$n/12])) {$mr += $arr_bdg['prd_com']['total'][$n/12];}
	if(isset($arr_bdg['chg_com']['total'][$n/12])) {$mr -= $arr_bdg['chg_com']['total'][$n/12];}
	if(isset($arr_bdg['prd_fix']['total'][$n/12])) {$mr += $arr_bdg['prd_fix']['total'][$n/12];}
	if(isset($arr_bdg['chg_fix']['total'][$n/12])) {$mr -= $arr_bdg['chg_fix']['total'][$n/12];}
	echo number_format($mr).'<br/>[';
	if(isset($arr_bdg['prd_ope']['total'][$n/12]) and $arr_bdg['prd_ope']['total'][$n/12]!=0) {echo number_format($mr/$arr_bdg['prd_ope']['total'][$n/12]*100).'%';}
	echo ']';
	$mr2 = 0;
	if(isset($arr_bdg['prd_ope']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_ope']['total'][$n/12-1];}
	if(isset($arr_bdg['chg_ope']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_ope']['total'][$n/12-1];}
	if(isset($arr_bdg['prd_com']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_com']['total'][$n/12-1];}
	if(isset($arr_bdg['chg_com']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_com']['total'][$n/12-1];}
	if(isset($arr_bdg['prd_fix']['total'][$n/12-1])) {$mr2 += $arr_bdg['prd_fix']['total'][$n/12-1];}
	if(isset($arr_bdg['chg_fix']['total'][$n/12-1])) {$mr2 -= $arr_bdg['chg_fix']['total'][$n/12-1];}
	if($mr2!=0) {
		echo '<br/>';
		$vr = ($mr-$mr2)/abs($mr2)*100;
		if($vr>0) {echo '+';}
		echo number_format($vr).'%';
	}
?>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin">
<?php
	$mr = 0;
	if(isset($arr_bdg['prd_ope_tot_cumul'])) {$mr += $arr_bdg['prd_ope_tot_cumul'];}
	if(isset($arr_bdg['chg_ope_tot_cumul'])) {$mr -= $arr_bdg['chg_ope_tot_cumul'];}
	if(isset($arr_bdg['prd_com_tot_cumul'])) {$mr += $arr_bdg['prd_com_tot_cumul'];}
	if(isset($arr_bdg['chg_com_tot_cumul'])) {$mr -= $arr_bdg['chg_com_tot_cumul'];}
	if(isset($arr_bdg['prd_fix_tot_cumul'])) {$mr += $arr_bdg['prd_fix_tot_cumul'];}
	if(isset($arr_bdg['chg_fix_tot_cumul'])) {$mr -= $arr_bdg['chg_fix_tot_cumul'];}
	echo number_format($mr).'<br/>[';
	if(isset($arr_bdg['prd_ope_tot_cumul']) and $arr_bdg['prd_ope_tot_cumul']!=0) {echo number_format($mr/$arr_bdg['prd_ope_tot_cumul']*100).'%';}
	echo ']';
?>
					</td>
<?php
}
?>
				</tr>
			</table>
		</td>
	</tr>
</table>
