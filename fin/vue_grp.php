<div id="wrapper">
	<input id="dat_min" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_min)) {echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="vue('grp');" />
	<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_max)) {echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('grp');" />
	<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('grp');" />
	<select style="width: 110px;" onchange="document.getElementById(this.value).scrollIntoView();this.value = 0">
	<option value="0">GROUPES</option>
	<option <?php if($id_grp=='-1') {echo ' selected';} ?> value="-1">Autre</option>
	<optgroup label="EN COURS">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","fin_bdg INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","cnf","1","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
?>
		<option <?php if($dt_grp['id']==$id_grp) {echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
	<optgroup label="ARCHIVES">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","fin_bdg INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","cnf","2","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
?>
		<option <?php if($dt_grp['id']==$id_grp) {echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
</select>
</div>
<br />
<br />
<table>
	<tr>
		<td>
<?php
$rq_bdg = sel_whe("*","fin_bdg INNER JOIN fin_ecr ON fin_bdg.id_ecr = fin_ecr.id","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=-1");
while($dt_bdg = ftc_ass($rq_bdg)) {
	if(isset($som_cnf_prd[$dt_bdg['id_pst']])) {$som_cnf_prd[$dt_bdg['id_pst']] += $dt_bdg['prd'];}
	else{$som_cnf_prd[$dt_bdg['id_pst']] = $dt_bdg['prd'];}
	if(isset($som_cnf_chg[$dt_bdg['id_pst']])) {$som_cnf_chg[$dt_bdg['id_pst']] += $dt_bdg['chg'];}
	else{$som_cnf_chg[$dt_bdg['id_pst']] = $dt_bdg['chg'];}
	if(isset($som_cnf_dtt[$dt_bdg['id_pst']])) {$som_cnf_dtt[$dt_bdg['id_pst']] += $dt_bdg['dtt'];}
	else{$som_cnf_dtt[$dt_bdg['id_pst']] = $dt_bdg['dtt'];}
	if(isset($som_cnf_crn[$dt_bdg['id_pst']])) {$som_cnf_crn[$dt_bdg['id_pst']] += $dt_bdg['crn'];}
	else{$som_cnf_crn[$dt_bdg['id_pst']] = $dt_bdg['crn'];}
	if(isset($som_cnf_prd_tot[$dt_bdg['id_pst']])) {$som_cnf_prd_tot[$dt_bdg['id_pst']] += $dt_bdg['prd'];}
	else{$som_cnf_prd_tot[$dt_bdg['id_pst']] = $dt_bdg['prd'];}
	if(isset($som_cnf_chg_tot[$dt_bdg['id_pst']])) {$som_cnf_chg_tot[$dt_bdg['id_pst']] += $dt_bdg['chg'];}
	else{$som_cnf_chg_tot[$dt_bdg['id_pst']] = $dt_bdg['chg'];}
	if(isset($som_cnf_dtt_tot[$dt_bdg['id_pst']])) {$som_cnf_dtt_tot[$dt_bdg['id_pst']] += $dt_bdg['dtt'];}
	else{$som_cnf_dtt_tot[$dt_bdg['id_pst']] = $dt_bdg['dtt'];}
	if(isset($som_cnf_crn_tot[$dt_bdg['id_pst']])) {$som_cnf_crn_tot[$dt_bdg['id_pst']] += $dt_bdg['crn'];}
	else{$som_cnf_crn_tot[$dt_bdg['id_pst']] = $dt_bdg['crn'];}
}
?>
			<span id="<?php echo $id_grp; ?>"></span>
			<br/>
			<table>
				<tr style="font-weight: bold;">
					<td class="tb" style="width: 120px;">AUTRES</td>
					<td class="tb" style="width: 80px;">PRODUITS</td>
					<td class="tb" style="width: 80px;">CHARGES</td>
					<td class="tb" style="width: 80px;">DETTES</td>
					<td class="tb" style="width: 80px;">CREANCES</td>
				</tr>
<?php
	foreach($pst as $pst_id => $nom) {
		if(!isset($som_cnf_prd[$pst_id])) {$som_cnf_prd[$pst_id]=0;}
		if(!isset($som_cnf_chg[$pst_id])) {$som_cnf_chg[$pst_id]=0;}
		if(!isset($som_cnf_dtt[$pst_id])) {$som_cnf_dtt[$pst_id]=0;}
		if(!isset($som_cnf_crn[$pst_id])) {$som_cnf_crn[$pst_id]=0;}
		if($som_cnf_prd[$pst_id] or $som_cnf_chg[$pst_id] or $som_cnf_dtt[$pst_id] or $som_cnf_crn[$pst_id]) {
?>
				<tr>
					<td class="td_fin"><?php echo $nom; ?></td>
					<td class="td_fin"><?php if($som_cnf_prd[$pst_id]!=0) {echo number_format($som_cnf_prd[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_chg[$pst_id]!=0) {echo number_format($som_cnf_chg[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_dtt[$pst_id]!=0) {echo number_format($som_cnf_dtt[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_crn[$pst_id]!=0) {echo number_format($som_cnf_crn[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
				</tr>
<?php

		}
	}
	if(isset($som_cnf_prd)) {$som_cnf_prd['total'] = round(array_sum($som_cnf_prd),$prm_crr_dcm[1]);}
	if(isset($som_cnf_chg)) {$som_cnf_chg['total'] = round(array_sum($som_cnf_chg),$prm_crr_dcm[1]);}
	if(isset($som_cnf_dtt)) {$som_cnf_dtt['total'] = round(array_sum($som_cnf_dtt),$prm_crr_dcm[1]);}
	if(isset($som_cnf_crn)) {$som_cnf_crn['total'] = round(array_sum($som_cnf_crn),$prm_crr_dcm[1]);}
?>
				<tr style="font-weight: bold;">
					<td class="td_fin">TOTAL</td>
					<td class="td_fin"><?php if(isset($som_cnf_prd) and $som_cnf_prd['total']!=0) {echo number_format($som_cnf_prd['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if(isset($som_cnf_chg) and $som_cnf_chg['total']!=0) {echo number_format($som_cnf_chg['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td style="color:red" class="td_fin"><?php if(isset($som_cnf_dtt) and $som_cnf_dtt['total']!=0) {echo number_format($som_cnf_dtt['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td style="color:red" class="td_fin"><?php if(isset($som_cnf_crn) and $som_cnf_crn['total']!=0) {echo number_format($som_cnf_crn['total'],$prm_crr_dcm[1],',','');} ?></td>
				</tr>
				<tr style="font-weight: bold;">
					<td class="td_fin">RESULTAT</td>
					<td class="td_fin"><?php if(isset($som_cnf_prd) and isset($som_cnf_chg)) {echo number_format($som_cnf_prd['total']-$som_cnf_chg['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if(isset($som_cnf_prd) and $som_cnf_prd['total']!=0) {echo number_format((1-($som_cnf_chg['total']/$som_cnf_prd['total']))*100,$prm_crr_dcm[1],',','');}else{echo '-';} ?>%</td>
					<td class="td_fin">FDR</td>
					<td style="<?php if(isset($som_cnf_dtt) and isset($som_cnf_crn) and $som_cnf_dtt['total']<$som_cnf_crn['total']) {echo 'color:red';} ?>" class="td_fin"><?php  if(isset($som_cnf_dtt) and isset($som_cnf_crn)) {echo number_format($som_cnf_crn['total']-$som_cnf_dtt['total'],$prm_crr_dcm[1],',','');} ?></td>
				</tr>
			</table>
<?php
$rq_grp = sel_whe("grp_dev.id,nomgrp,id_clt","fin_bdg INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","cnf=1 OR cnf=2","dt_cnf DESC","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
	unset($som_cnf_prd,$som_cnf_chg,$som_cnf_dtt,$som_cnf_crn);
	$id_grp = $dt_grp['id'];
	$id_clt = $dt_grp['id_clt'];
	$lst_clt[] = $id_clt;
	$rq_bdg = sel_whe("*","fin_bdg INNER JOIN fin_ecr ON fin_bdg.id_ecr = fin_ecr.id","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=".$id_grp);
	while($dt_bdg = ftc_ass($rq_bdg)) {
		if(isset($som_cnf_prd[$dt_bdg['id_pst']])) {$som_cnf_prd[$dt_bdg['id_pst']] += $dt_bdg['prd'];}
		else{$som_cnf_prd[$dt_bdg['id_pst']] = $dt_bdg['prd'];}
		if(isset($som_cnf_chg[$dt_bdg['id_pst']])) {$som_cnf_chg[$dt_bdg['id_pst']] += $dt_bdg['chg'];}
		else{$som_cnf_chg[$dt_bdg['id_pst']] = $dt_bdg['chg'];}
		if(isset($som_cnf_dtt[$dt_bdg['id_pst']])) {$som_cnf_dtt[$dt_bdg['id_pst']] += $dt_bdg['dtt'];}
		else{$som_cnf_dtt[$dt_bdg['id_pst']] = $dt_bdg['dtt'];}
		if(isset($som_cnf_crn[$dt_bdg['id_pst']])) {$som_cnf_crn[$dt_bdg['id_pst']] += $dt_bdg['crn'];}
		else{$som_cnf_crn[$dt_bdg['id_pst']] = $dt_bdg['crn'];}

		if(isset($som_clt_prd[$id_clt][$dt_bdg['id_pst']])) {$som_clt_prd[$id_clt][$dt_bdg['id_pst']] += $dt_bdg['prd'];}
		else{$som_clt_prd[$id_clt][$dt_bdg['id_pst']] = $dt_bdg['prd'];}
		if(isset($som_clt_chg[$id_clt][$dt_bdg['id_pst']])) {$som_clt_chg[$id_clt][$dt_bdg['id_pst']] += $dt_bdg['chg'];}
		else{$som_clt_chg[$id_clt][$dt_bdg['id_pst']] = $dt_bdg['chg'];}
		if(isset($som_clt_dtt[$id_clt][$dt_bdg['id_pst']])) {$som_clt_dtt[$id_clt][$dt_bdg['id_pst']] += $dt_bdg['dtt'];}
		else{$som_clt_dtt[$id_clt][$dt_bdg['id_pst']] = $dt_bdg['dtt'];}
		if(isset($som_clt_crn[$id_clt][$dt_bdg['id_pst']])) {$som_clt_crn[$id_clt][$dt_bdg['id_pst']] += $dt_bdg['crn'];}
		else{$som_clt_crn[$id_clt][$dt_bdg['id_pst']] = $dt_bdg['crn'];}

		if(isset($som_cnf_prd_tot[$dt_bdg['id_pst']])) {$som_cnf_prd_tot[$dt_bdg['id_pst']] += $dt_bdg['prd'];}
		else{$som_cnf_prd_tot[$dt_bdg['id_pst']] = $dt_bdg['prd'];}
		if(isset($som_cnf_chg_tot[$dt_bdg['id_pst']])) {$som_cnf_chg_tot[$dt_bdg['id_pst']] += $dt_bdg['chg'];}
		else{$som_cnf_chg_tot[$dt_bdg['id_pst']] = $dt_bdg['chg'];}
		if(isset($som_cnf_dtt_tot[$dt_bdg['id_pst']])) {$som_cnf_dtt_tot[$dt_bdg['id_pst']] += $dt_bdg['dtt'];}
		else{$som_cnf_dtt_tot[$dt_bdg['id_pst']] = $dt_bdg['dtt'];}
		if(isset($som_cnf_crn_tot[$dt_bdg['id_pst']])) {$som_cnf_crn_tot[$dt_bdg['id_pst']] += $dt_bdg['crn'];}
		else{$som_cnf_crn_tot[$dt_bdg['id_pst']] = $dt_bdg['crn'];}
	}
?>
			<hr/>
			<span id="<?php echo $id_grp; ?>"></span>
			<br/>
			<table>
				<tr style="font-weight: bold; vertical-align: bottom">
					<td class="tb" style="width: 120px;"><h2><?php echo $dt_grp['nomgrp']; ?></h2></td>
					<td class="tb" style="width: 80px;">PRODUITS</td>
					<td class="tb" style="width: 80px;">CHARGES</td>
					<td class="tb" style="width: 80px;">DETTES</td>
					<td class="tb" style="width: 80px;">CREANCES</td>
				</tr>
<?php
	foreach($pst as $pst_id => $nom) {
		if(isset($som_cnf_prd[$pst_id]) or isset($som_cnf_chg[$pst_id]) or isset($som_cnf_dtt[$pst_id]) or isset($som_cnf_crn[$pst_id])) {
?>
				<tr>
					<td class="td_fin"><?php echo $nom; ?></td>
					<td class="td_fin"><?php if($som_cnf_prd[$pst_id]!=0) {echo number_format($som_cnf_prd[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_chg[$pst_id]!=0) {echo number_format($som_cnf_chg[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_dtt[$pst_id]!=0) {echo number_format($som_cnf_dtt[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_crn[$pst_id]!=0) {echo number_format($som_cnf_crn[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
				</tr>
<?php
		}
	}
	if(isset($som_cnf_prd)) {$som_cnf_prd['total'] = round(array_sum($som_cnf_prd),$prm_crr_dcm[1]);}
	if(isset($som_cnf_chg)) {$som_cnf_chg['total'] = round(array_sum($som_cnf_chg),$prm_crr_dcm[1]);}
	if(isset($som_cnf_dtt)) {$som_cnf_dtt['total'] = round(array_sum($som_cnf_dtt),$prm_crr_dcm[1]);}
	if(isset($som_cnf_crn)) {$som_cnf_crn['total'] = round(array_sum($som_cnf_crn),$prm_crr_dcm[1]);}

?>
				<tr style="font-weight: bold;">
					<td class="td_fin">TOTAL</td>
					<td class="td_fin"><?php if($som_cnf_prd['total']!=0) {echo number_format($som_cnf_prd['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td class="td_fin"><?php if($som_cnf_chg['total']!=0) {echo number_format($som_cnf_chg['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td style="color:red" class="td_fin"><?php if($som_cnf_dtt['total']!=0) {echo number_format($som_cnf_dtt['total'],$prm_crr_dcm[1],',','');} ?></td>
					<td style="color:red" class="td_fin"><?php if($som_cnf_crn['total']!=0) {echo number_format($som_cnf_crn['total'],$prm_crr_dcm[1],',','');} ?></td>
				</tr>
				<tr style="font-weight: bold;">
					<td class="td_fin">RESULTAT</td>
					<td class="td_fin"><?php echo number_format($som_cnf_prd['total']-$som_cnf_chg['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php if($som_cnf_prd['total']!=0) {echo number_format((1-($som_cnf_chg['total']/$som_cnf_prd['total']))*100,$prm_crr_dcm[1],',','');}else{echo '-';} ?>%</td>
					<td class="td_fin">FDR</td>
					<td style="<?php if($som_cnf_dtt['total']<$som_cnf_crn['total']) {echo 'color:red';} ?>" class="td_fin"><?php echo number_format($som_cnf_crn['total']-$som_cnf_dtt['total'],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
			</table>
<?php
}
?>
		</td>
		<td class="vat">

<?php
if(isset($lst_clt)) {
	$lst_clt = array_unique($lst_clt);
	foreach($lst_clt as $id_clt) {
		$dt_clt = ftc_ass(sel_quo("nom","cat_clt","id",$id_clt));
?>
			<table>
				<tr style="font-weight: bold;">
					<td class="tb" style="width: 120px;"><?php echo $dt_clt['nom']; ?></td>
					<td class="tb" style="width: 80px;">PRODUITS</td>
					<td class="tb" style="width: 80px;">CHARGES</td>
					<td class="tb" style="width: 80px;">DETTES</td>
					<td class="tb" style="width: 80px;">CREANCES</td>
				</tr>
<?php
		foreach($pst as $pst_id => $nom) {
			if(isset($som_clt_prd[$id_clt][$pst_id]) or isset($som_clt_chg[$id_clt][$pst_id]) or isset($som_clt_dtt[$id_clt][$pst_id]) or isset($som_clt_crn[$id_clt][$pst_id])) {
?>
				<tr>
					<td class="td_fin"><?php echo $nom; ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_prd[$id_clt][$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_chg[$id_clt][$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_dtt[$id_clt][$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_crn[$id_clt][$pst_id],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
<?php
			}
		}
		if(isset($som_clt_prd[$id_clt])) {$som_clt_prd[$id_clt]['total'] = round(array_sum($som_clt_prd[$id_clt]),$prm_crr_dcm[1]);}
		if(isset($som_clt_chg[$id_clt])) {$som_clt_chg[$id_clt]['total'] = round(array_sum($som_clt_chg[$id_clt]),$prm_crr_dcm[1]);}
		if(isset($som_clt_dtt[$id_clt])) {$som_clt_dtt[$id_clt]['total'] = round(array_sum($som_clt_dtt[$id_clt]),$prm_crr_dcm[1]);}
		if(isset($som_clt_crn[$id_clt])) {$som_clt_crn[$id_clt]['total'] = round(array_sum($som_clt_crn[$id_clt]),$prm_crr_dcm[1]);}

?>
				<tr style="font-weight: bold;">
					<td class="td_fin">TOTAL</td>
					<td class="td_fin"><?php echo number_format($som_clt_prd[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_chg[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_dtt[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_clt_crn[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
				<tr style="font-weight: bold;">
					<td class="td_fin">RESULTAT</td>
					<td class="td_fin"><?php echo number_format($som_clt_prd[$id_clt]['total']-$som_clt_chg[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php if($som_clt_prd[$id_clt]['total']!=0) {echo number_format((1-($som_clt_chg[$id_clt]['total']/$som_clt_prd[$id_clt]['total']))*100,$prm_crr_dcm[1],',','');}else{echo '-';} ?>%</td>
					<td class="td_fin">FDR</td>
					<td style="<?php if($som_clt_dtt[$id_clt]['total']<$som_clt_crn[$id_clt]['total']) {echo 'color:red';} ?>" class="td_fin"><?php echo number_format($som_clt_crn[$id_clt]['total']-$som_clt_dtt[$id_clt]['total'],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
			</table>
<?php
	}
?>
		</td>
		<td class="vat">
			<table>
				<tr style="font-weight: bold;">
					<td class="tb" style="width: 120px;">TOTAL</td>
					<td class="tb" style="width: 80px;">PRODUITS</td>
					<td class="tb" style="width: 80px;">CHARGES</td>
					<td class="tb" style="width: 80px;">DETTES</td>
					<td class="tb" style="width: 80px;">CREANCES</td>
				</tr>
<?php
	foreach($pst as $pst_id => $nom) {
		if(isset($som_cnf_prd_tot[$pst_id]) or isset($som_cnf_chg_tot[$pst_id]) or isset($som_cnf_dtt_tot[$pst_id]) or isset($som_cnf_crn_tot[$pst_id])) {
?>
				<tr>
					<td class="td_fin"><?php echo $nom; ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_prd_tot[$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_chg_tot[$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_dtt_tot[$pst_id],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_crn_tot[$pst_id],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
<?php
		}
	}
	if(isset($som_cnf_prd_tot)) {$som_cnf_prd_tot['total'] = round(array_sum($som_cnf_prd_tot),$prm_crr_dcm[1]);}
	if(isset($som_cnf_chg_tot)) {$som_cnf_chg_tot['total'] = round(array_sum($som_cnf_chg_tot),$prm_crr_dcm[1]);}
	if(isset($som_cnf_dtt_tot)) {$som_cnf_dtt_tot['total'] = round(array_sum($som_cnf_dtt_tot),$prm_crr_dcm[1]);}
	if(isset($som_cnf_crn_tot)) {$som_cnf_crn_tot['total'] = round(array_sum($som_cnf_crn_tot),$prm_crr_dcm[1]);}
?>
				<tr style="font-weight: bold;">
					<td class="td_fin">TOTAL</td>
					<td class="td_fin"><?php echo number_format($som_cnf_prd_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_chg_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_dtt_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php echo number_format($som_cnf_crn_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
				<tr style="font-weight: bold;">
					<td class="td_fin">RESULTAT</td>
					<td class="td_fin"><?php echo number_format($som_cnf_prd_tot['total']-$som_cnf_chg_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
					<td class="td_fin"><?php if($som_cnf_prd_tot['total']!=0) {echo number_format((1-($som_cnf_chg_tot['total']/$som_cnf_prd_tot['total']))*100,$prm_crr_dcm[1],',','');}else{echo '-';} ?>%</td>
					<td class="td_fin">FDR</td>
					<td style="<?php if($som_cnf_dtt_tot['total']<$som_cnf_crn_tot['total']) {echo 'color:red';} ?>" class="td_fin"><?php echo number_format($som_cnf_crn_tot['total']-$som_cnf_dtt_tot['total'],$prm_crr_dcm[1],',',''); ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
}
?>
