<?php
$rq_trs = sel_whe("fin_trs.*,fin_ecr.date","fin_trs INNER JOIN fin_ecr ON fin_trs.id_ecr = fin_ecr.id","date <= '".$dat_max."' AND date >= '".$dat_min."'","date");
while($dt_trs = ftc_ass($rq_trs)) {
	$dat = $dt_trs['date'];
	$n = intval(((date("Y",strtotime($dat)) * 12 + date("m",strtotime($dat))) - $min_m) / 12) + $nzero + 1;
	if(strtotime($dat)>=strtotime($dat_min) and strtotime($dat)<=strtotime(date('Y-m-d'))) {
		if($dt_trs['dvs']>0) {
			if(isset($arr_trs['enc_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))])) {$arr_trs['enc_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] += $dt_trs['dvs'];}
			else{$arr_trs['enc_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] = $dt_trs['dvs'];}
			if(isset($arr_trs['enc_dvs'][$dt_trs['id_css']]['total'][$n])) {$arr_trs['enc_dvs'][$dt_trs['id_css']]['total'][$n] += $dt_trs['dvs'];}
			else{$arr_trs['enc_dvs'][$dt_trs['id_css']]['total'][$n] = $dt_trs['dvs'];}
		}
		else{
			if(isset($arr_trs['dec_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))])) {$arr_trs['dec_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] -= $dt_trs['dvs'];}
			else{$arr_trs['dec_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] = -$dt_trs['dvs'];}
			if(isset($arr_trs['dec_dvs'][$dt_trs['id_css']]['total'][$n])) {$arr_trs['dec_dvs'][$dt_trs['id_css']]['total'][$n] -= $dt_trs['dvs'];}
			else{$arr_trs['dec_dvs'][$dt_trs['id_css']]['total'][$n] = -$dt_trs['dvs'];}
		}
		if(isset($arr_trs['flx_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))])) {$arr_trs['flx_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] += $dt_trs['dvs'];}
		else{$arr_trs['flx_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] = $dt_trs['dvs'];}
		if(isset($arr_trs['flx_dvs'][$dt_trs['id_css']]['total'][$n])) {$arr_trs['flx_dvs'][$dt_trs['id_css']]['total'][$n] += $dt_trs['dvs'];}
		else{$arr_trs['flx_dvs'][$dt_trs['id_css']]['total'][$n] = $dt_trs['dvs'];}
	}
	elseif(strtotime($dat)>strtotime(date('Y-m-d'))) {
		if($dt_trs['dvs']>0) {
			$arr_trs['fut_enc_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] += $dt_trs['dvs'];
			$arr_trs['fut_enc_dvs'][$dt_trs['id_css']]['total'][$n] += $dt_trs['dvs'];
		}
		else{
			$arr_trs['fut_dec_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] -= $dt_trs['dvs'];
			$arr_trs['fut_dec_dvs'][$dt_trs['id_css']]['total'][$n] -= $dt_trs['dvs'];
		}
		$arr_trs['fut_flx_dvs'][$dt_trs['id_css']][date("m/Y", strtotime($dat))] += $dt_trs['dvs'];
		$arr_trs['fut_flx_dvs'][$dt_trs['id_css']]['total'][$n] += $dt_trs['dvs'];
	}
}

foreach ($dvs_inv as $dat => $dvs) {
	if($css_inv[$dat] > 0 and $dat!='0000-00-00'){
		$n = intval(((date("Y",strtotime($dat)) * 12 + date("m",strtotime($dat))) - $min_m) / 12) + $nzero + 1;
		if(strtotime($dat)>=strtotime($dat_min) and strtotime($dat)<=strtotime(date('Y-m-d'))) {
			if($dvs>0) {
				if(isset($arr_trs['enc_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))])) {$arr_trs['enc_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] += $dvs;}
				else{$arr_trs['enc_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] = $dvs;}
				if(isset($arr_trs['enc_dvs'][$css_inv[$dat]]['total'][$n])) {$arr_trs['enc_dvs'][$css_inv[$dat]]['total'][$n] += $dvs;}
				else{$arr_trs['enc_dvs'][$css_inv[$dat]]['total'][$n] = $dvs;}
			}
			else{
				if(isset($arr_trs['dec_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))])) {$arr_trs['dec_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] -= $dvs;}
				else{$arr_trs['dec_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] = -$dvs;}
				if(isset($arr_trs['dec_dvs'][$css_inv[$dat]]['total'][$n])) {$arr_trs['dec_dvs'][$css_inv[$dat]]['total'][$n] -= $dvs;}
				else{$arr_trs['dec_dvs'][$css_inv[$dat]]['total'][$n] = -$dvs;}
			}
			if(isset($arr_trs['flx_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))])) {$arr_trs['flx_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] += $dvs;}
			else{$arr_trs['flx_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] = $dvs;}
			if(isset($arr_trs['flx_dvs'][$css_inv[$dat]]['total'][$n])) {$arr_trs['flx_dvs'][$css_inv[$dat]]['total'][$n] += $dvs;}
			else{$arr_trs['flx_dvs'][$css_inv[$dat]]['total'][$n] = $dvs;}
		}
		elseif(strtotime($dat)>strtotime(date('Y-m-d'))) {
			if($dvs>0) {
				$arr_trs['fut_enc_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] += $dvs;
				$arr_trs['fut_enc_dvs'][$css_inv[$dat]]['total'][$n] += $dvs;
			}
			else{
				$arr_trs['fut_dec_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] -= $dvs;
				$arr_trs['fut_dec_dvs'][$css_inv[$dat]]['total'][$n] -= $dvs;
			}
			$arr_trs['fut_flx_dvs'][$css_inv[$dat]][date("m/Y", strtotime($dat))] += $dvs;
			$arr_trs['fut_flx_dvs'][$css_inv[$dat]]['total'][$n] += $dvs;
		}
	}
}

foreach($css as $id_css => $nom) {
	$arr_trs['sld_dvs'][$id_css]['initial'] = $dvs_css[$id_css];
	$dat = $dat_min;
	$sld = $dvs_css[$id_css];
	if(isset($arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$sld += $arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))];}
	if(isset($arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$sld += $arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))];}
	$arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))] = $sld;
	$dat = date('Y-m', strtotime ("+1 months $dat"));
	while($dat <= $dat_max) {
		$arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))] = $sld;
		if(isset($arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))] += $arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))];}
		if(isset($arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))] += $arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))];}
		$sld = $arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))];
		$dat = date('Y-m', strtotime ("+1 months $dat"));
	}
}
?>
<div id="wrapper">
	<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_max)) {echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('trs');" />
	<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('trs');" />
</div>
<br />
<br />
<table>
	<tr>
		<td></td>
		<td>
			<table>
				<tr>
<?php
if(isset($dat_max)) {
	$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;// $nzero*12;
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(is_int($n/12) and $n != $n_min) {
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
<?php
$j=0;
foreach($css as $id_css => $nom) {
	if($id_css>0) {
?>
				<tr style="font-weight: bold;<?php if($chkhor[$j]) {echo 'display: none;';} ?>" class="inv_tr<?php echo $id_css ?>">
					<td class="btn">
						<div id="str<?php echo $id_css ?>" onclick="show('tr<?php echo $id_css ?>');" ><?php echo $nom ?></div>
						<input type="hidden" id="htr<?php echo $id_css ?>" class="chkhor" value="<?php if(isset($chkhor[$j])) {echo $chkhor[$j];} else{echo '0';} ?>">
					</td>
				</tr>
<?php
		$j++;
	}
}
?>
			</table>
		</td>
		<td class="vat">
			<table>
				<tr id="chkver" <?php if(!isset($chkver)) {echo 'style="display: none;"';} ?>>
					<td><input type="hidden" class="chkver" value="0"></td>
<?php
if(isset($dat_max)) {
	$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;// $nzero*12;
	$dat = $dat_min;
	$j = count($chkver)*12;
	for($i=1; $i < $j; $i++) {
		if(is_int($n/12) and $n != $n_min) {
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
<?php
$j = 0;
foreach($css as $id_css => $nom) {
	if($id_css>0) {
?>
				<tr style="font-weight: bold;<?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'display: none;';} ?>" class="tr<?php echo $id_css ?>" >
					<td class="btn">
						<div class="htr<?php echo $id_css ?>" onclick="hide('tr<?php echo $id_css ?>');" ><?php echo $nom ?></div>
					</td>
<?php
		if(isset($dat_max)) {
			$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
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
<?php
		}
?>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin">SOLDE INITIAL</td>
<?php
		$n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;
		if($nzero == $n_min){
			$n = $nzero*12+1;
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_trs['sld_dvs'][$id_css]['initial'],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.'); ?></td>
<?php
		}
		else{
			$n = $n_min + 1;
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat_min))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.'); ?></td>
<?php
		}
		if(isset($dat_max)) {
			$dat = $dat_min;
			while(date('Y-m', strtotime ("+1 months $dat")) <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.'); ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin">
						ENCAISSEMENTS
						<br />
						<span style="font-style: italic;">PREVISIONS</span>
					</td>
<?php
			$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
					if(isset($arr_trs['enc_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['enc_dvs'][$id_css]['total'][$n/12];}
					else{$dvs = 0;}
					echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
				if(isset($arr_trs['enc_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$dvs = $arr_trs['enc_dvs'][$id_css][date("m/Y", strtotime($dat))];}
				else{$dvs = 0;}
				echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_enc_dvs'][$id_css][date("m/Y", strtotime($dat))]) and $arr_trs['fut_enc_dvs'][$id_css][date("m/Y", strtotime($dat))]!=0) {echo number_format($arr_trs['fut_enc_dvs'][$id_css][date("m/Y", strtotime($dat))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
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
				if(isset($arr_trs['enc_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['enc_dvs'][$id_css]['total'][$n/12];}
				else{$dvs = 0;}
				echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_enc_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
<?php
		}
?>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin">
						DECAISSEMENTS
						<br />
						<span style="font-style: italic;">PREVISIONS</span>
					</td>
<?php
		if(isset($dat_max)) {
			$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
					if(isset($arr_trs['dec_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['dec_dvs'][$id_css]['total'][$n/12];}
					else{$dvs = 0;}
					echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
				if(isset($arr_trs['dec_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$dvs = $arr_trs['dec_dvs'][$id_css][date("m/Y", strtotime($dat))];}
				else{$dvs = 0;}
				echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_dec_dvs'][$id_css][date("m/Y", strtotime($dat))]) and $arr_trs['fut_dec_dvs'][$id_css][date("m/Y", strtotime($dat))]!=0) {echo number_format($arr_trs['fut_dec_dvs'][$id_css][date("m/Y", strtotime($dat))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
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
				if(isset($arr_trs['dec_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['dec_dvs'][$id_css]['total'][$n/12];}
				else{$dvs = 0;}
				echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_dec_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
<?php
		}
?>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?> style="font-weight: bold">
					<td class="td_fin">
						FLUX
						<br />
						<span style="font-style: italic;">PREVISIONS</span>
					</td>
<?php
		if(isset($dat_max)) {
			$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>>
<?php
					if(isset($arr_trs['flx_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['flx_dvs'][$id_css]['total'][$n/12];}
					else{$dvs = 0;}
					echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>>
<?php
				if(isset($arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))])) {$dvs = $arr_trs['flx_dvs'][$id_css][date("m/Y", strtotime($dat))];}
				else{$dvs = 0;}
				if($dvs>0) {echo'+';}echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))]) and $arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))]!=0) {if(($arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))])>0) {echo'+';}echo number_format($arr_trs['fut_flx_dvs'][$id_css][date("m/Y", strtotime($dat))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
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
			if(isset($arr_trs['flx_dvs'][$id_css]['total'][$n/12])) {$dvs = $arr_trs['flx_dvs'][$id_css]['total'][$n/12];}
			else{$dvs = 0;}
			echo number_format($dvs,$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.').'<br />';
?>
						<span style="font-style: italic;"><?php if(isset($arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12]) and $arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12]!=0) {echo number_format($arr_trs['fut_flx_dvs'][$id_css]['total'][$n/12],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.');} ?></span>
					</td>
<?php
		}
?>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>>
					<td class="td_fin">SOLDE FINAL</td>
<?php
		if(isset($dat_max)) {
			$n = $n_min = intval((date("Y",strtotime($dat_min)) * 12 + date("m",strtotime($dat_min))) - $min_m) + $nzero*12;
			$dat = $dat_min;
			while($dat <= $dat_max) {
				if(is_int($n/12) and $n != $n_min) {
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
				}
?>
					<td class="td_fin td<?php echo intval($n/12)+1; ?>" <?php if(!isset($chkver[intval($n/12)+1]) or !$chkver[intval($n/12)+1]) {echo 'style="display: none;"';} ?>><?php echo number_format($arr_trs['sld_dvs'][$id_css][date("m/Y", strtotime($dat))],$prm_crr_dcm[$cfg_crr_css[$id_css]],',','.'); ?></td>
<?php
				$dat = date('Y-m', strtotime ("+1 months $dat"));
				$n++;
			}
			while(!is_int($n/12)) {$n++;}
?>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
					<td class="td_fin2 td<?php echo $n/12 ?>" <?php if(!isset($chkver[$n/12]) or !$chkver[$n/12]) {echo 'style="display: none;"';} ?>></td>
<?php
		}
?>
				</tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
				<tr class="tr<?php echo $id_css ?>" <?php if(!isset($chkhor[$j]) or !$chkhor[$j]) {echo 'style="display: none;"';} ?>><td></td></tr>
<?php
		$j++;
	}
}
?>
			</table>
		</td>
	</tr>
</table>
