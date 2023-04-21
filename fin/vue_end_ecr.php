<?php
if(isset($_POST['id_grp'])) {
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/css.php");
	include("../cfg/fin.php");
	include("../cfg/pst.php");
	$nom_nat = $_POST['nom_nat'];
	$id_pst = $_POST['id_pst'];
	$id_grp = $_POST['id_grp'];
	$dt_mx = $_POST['dat_max'];
	$dt_mn = $_POST['dat_min'];
	$dt = explode('/',$dt_mx);
	if(isset($dt[2])) {$dat_max = $dt[2].'-'.$dt[1].'-'.$dt[0];}
	$dt = explode('/',$dt_mn);
	$dat_min = $dt[2].'-'.$dt[1].'-'.$dt[0];
}
if($nom_nat!='*') {
	$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_trs ON fin_ecr.id = fin_trs.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND nature ='".addslashes($nom_nat)."'","date","DISTINCT");
	while($dt_ecr = ftc_ass($rq_ecr)) {
		if(isset($som_nat_trs[date("m/Y", strtotime($dt_ecr['date']))])) {$som_nat_trs[date("m/Y", strtotime($dt_ecr['date']))] += $dt_ecr['sld'];}
		else{$som_nat_trs[date("m/Y", strtotime($dt_ecr['date']))] = $dt_ecr['sld'];}
	}
	$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_bdg ON fin_ecr.id = fin_bdg.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND nature ='".addslashes($nom_nat)."'","date","DISTINCT");
	while($dt_ecr = ftc_ass($rq_ecr)) {
		if(isset($som_nat_prd[date("m/Y", strtotime($dt_ecr['date']))])) {$som_nat_prd[date("m/Y", strtotime($dt_ecr['date']))] += $dt_ecr['prd'];}
		else{$som_nat_prd[date("m/Y", strtotime($dt_ecr['date']))] = $dt_ecr['prd'];}
		if(isset($som_nat_chg[date("m/Y", strtotime($dt_ecr['date']))])) {$som_nat_chg[date("m/Y", strtotime($dt_ecr['date']))] += $dt_ecr['chg'];}
		else{$som_nat_chg[date("m/Y", strtotime($dt_ecr['date']))] = $dt_ecr['chg'];}
		if(isset($som_nat_dtt[date("m/Y", strtotime($dt_ecr['date']))])) {$som_nat_dtt[date("m/Y", strtotime($dt_ecr['date']))] += $dt_ecr['dtt'];}
		else{$som_nat_dtt[date("m/Y", strtotime($dt_ecr['date']))] = $dt_ecr['dtt'];}
		if(isset($som_nat_crn[date("m/Y", strtotime($dt_ecr['date']))])) {$som_nat_crn[date("m/Y", strtotime($dt_ecr['date']))] += $dt_ecr['crn'];}
		else{$som_nat_crn[date("m/Y", strtotime($dt_ecr['date']))] = $dt_ecr['crn'];}
	}
}
if($id_grp!=0 and $id_grp>-3) {
	if($id_pst!=0) {
		if($id_grp!=-2) {$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_bdg ON fin_ecr.id = fin_bdg.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=".$id_grp." AND id_pst=".$id_pst,"date","DISTINCT");}
		else{$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_bdg ON fin_ecr.id = fin_bdg.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=0 AND id_pst=".$id_pst,"date","DISTINCT");}
		while($dt_ecr = ftc_ass($rq_ecr)) {
			$m = $dt_ecr['mois'];
			if(!in_array($m,$mois)) {$mois[] = $m;}
			$som_pst_prd[$m] += $dt_ecr['prd'];
			$som_pst_chg[$m] += $dt_ecr['chg'];
			$som_pst_dtt[$m] += $dt_ecr['dtt'];
			$som_pst_crn[$m] += $dt_ecr['crn'];
		}
		asort($mois);
		if($id_grp!=-2) {
			$dt_grp = ftc_ass(sel_quo("nomgrp","grp_dev","id",$id_grp));
			$nomgrp = $dt_grp['nomgrp'];
		}
		else{$nomgrp = 'NON DEFINI';}
?>
<hr />
<table>
	<tr style="font-weight: bold;">
		<td class="tb" style="width: 120px;"><?php echo $pst[$id_pst].' - '.$nomgrp; ?></td>
		<td class="tb" style="width: 80px;">PRODUITS</td>
		<td class="tb" style="width: 80px;">CHARGES</td>
		<td class="tb" style="width: 80px;">DETTES</td>
		<td class="tb" style="width: 80px;">CREANCES</td>
	</tr>
<?php
		foreach($mois as $m) {
			if($som_pst_prd[$m] or $som_pst_chg[$m] or $som_pst_dtt[$m] or $som_pst_crn[$m]) {
?>
	<tr>
		<td class="td_fin"><?php echo date("m/Y", strtotime($m)); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_prd[$m],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_chg[$m],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_dtt[$m],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_crn[$m],$prm_crr_dcm[1],',',''); ?></td>
	</tr>
<?php
			}
		}
		if(isset($som_pst_prd)) {$som_pst_prd['total'] = array_sum($som_pst_prd);}
		if(isset($som_pst_chg)) {$som_pst_chg['total'] = array_sum($som_pst_chg);}
		if(isset($som_pst_dtt)) {$som_pst_dtt['total'] = array_sum($som_pst_dtt);}
		if(isset($som_pst_crn)) {$som_pst_crn['total'] = array_sum($som_pst_crn);}
?>
	<tr style="font-weight: bold;">
		<td class="td_fin">TOTAL</td>
		<td class="td_fin"><?php echo number_format($som_pst_prd['total'],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_chg['total'],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_dtt['total'],$prm_crr_dcm[1],',',''); ?></td>
		<td class="td_fin"><?php echo number_format($som_pst_crn['total'],$prm_crr_dcm[1],',',''); ?></td>
	</tr>
</table>
<?php
	}	
	if($id_grp!=-2) {$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_bdg ON fin_ecr.id = fin_bdg.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=".$id_grp,"date","DISTINCT");}
	else{$rq_ecr = sel_whe("*","fin_ecr INNER JOIN fin_bdg ON fin_ecr.id = fin_bdg.id_ecr","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=0","date","DISTINCT");}
	while($dt_ecr = ftc_ass($rq_ecr)) {
		if(isset($som_cnf_prd[$dt_ecr['id_pst']])) {$som_cnf_prd[$dt_ecr['id_pst']] += $dt_ecr['prd'];}
		else{$som_cnf_prd[$dt_ecr['id_pst']] = $dt_ecr['prd'];}
		if(isset($som_cnf_chg[$dt_ecr['id_pst']])) {$som_cnf_chg[$dt_ecr['id_pst']] += $dt_ecr['chg'];}
		else{$som_cnf_chg[$dt_ecr['id_pst']] = $dt_ecr['chg'];}
		if(isset($som_cnf_dtt[$dt_ecr['id_pst']])) {$som_cnf_dtt[$dt_ecr['id_pst']] += $dt_ecr['dtt'];}
		else{$som_cnf_dtt[$dt_ecr['id_pst']] = $dt_ecr['dtt'];}
		if(isset($som_cnf_crn[$dt_ecr['id_pst']])) {$som_cnf_crn[$dt_ecr['id_pst']] += $dt_ecr['crn'];}
		else{$som_cnf_crn[$dt_ecr['id_pst']] = $dt_ecr['crn'];}
	}
	if($id_grp!=-2) {
		$dt_grp = ftc_ass(sel_quo("nomgrp","grp_dev","id",$id_grp));
		$nomgrp = $dt_grp['nomgrp'];
	}
	else{$nomgrp = 'NON DEFINI';}
?>
<hr />
<table>
	<tr style="font-weight: bold;">
	<td class="tb" style="width: 120px;"><?php echo $nomgrp; ?></td>
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
	<td class="td_fin"><?php if(isset($som_cnf_prd[$pst_id])) {echo number_format($som_cnf_prd[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
	<td class="td_fin"><?php if(isset($som_cnf_chg[$pst_id])) {echo number_format($som_cnf_chg[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
	<td class="td_fin"><?php if(isset($som_cnf_dtt[$pst_id])) {echo number_format($som_cnf_dtt[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
	<td class="td_fin"><?php if(isset($som_cnf_crn[$pst_id])) {echo number_format($som_cnf_crn[$pst_id],$prm_crr_dcm[1],',','');} ?></td>
</tr>
<?php
		}
	}
	if(isset($som_cnf_prd)) {$som_cnf_prd['total'] = array_sum($som_cnf_prd);}
	if(isset($som_cnf_chg)) {$som_cnf_chg['total'] = array_sum($som_cnf_chg);}
	if(isset($som_cnf_dtt)) {$som_cnf_dtt['total'] = array_sum($som_cnf_dtt);}
	if(isset($som_cnf_crn)) {$som_cnf_crn['total'] = array_sum($som_cnf_crn);}
?>
<tr style="font-weight: bold;">
	<td class="td_fin">TOTAL</td>
	<td class="td_fin"><?php echo number_format($som_cnf_prd['total'],$prm_crr_dcm[1],',',''); ?></td>
	<td class="td_fin"><?php echo number_format($som_cnf_chg['total'],$prm_crr_dcm[1],',',''); ?></td>
	<td class="td_fin"><?php echo number_format($som_cnf_dtt['total'],$prm_crr_dcm[1],',',''); ?></td>
	<td class="td_fin"><?php echo number_format($som_cnf_crn['total'],$prm_crr_dcm[1],',',''); ?></td>
</tr>
</table>
<?php
}
if($nom_nat!='*') {
?>
<hr />
<table>
	<tr style="font-weight: bold; text-align: center;">
		<td class="tb" style="width: 120px;"><?php echo $nom_nat ?></td>
		<td class="tb" style="width: 80px;">TRESORERIE</td>
		<td class="tb" style="width: 80px;">PRODUITS</td>
		<td class="tb" style="width: 80px;">CHARGES</td>
		<td class="tb" style="width: 80px;">DETTES</td>
		<td class="tb" style="width: 80px;">CREANCES</td>
	</tr>
<?php
	$dat = $dat_min;
	while($dat <= $dat_max) {
		if(isset($som_nat_trs[date("m/Y", strtotime($dat))]) or isset($som_nat_prd[date("m/Y", strtotime($dat))]) or isset($som_nat_chg[date("m/Y", strtotime($dat))]) or isset($som_nat_dtt[date("m/Y", strtotime($dat))]) or isset($som_nat_crn[date("m/Y", strtotime($dat))])) {
?>
	<tr>
		<td class="td_fin"><?php echo date("m/Y", strtotime($dat)); ?></td>
		<td class="td_fin"><?php echo $som_nat_trs[date("m/Y", strtotime($dat))]; ?></td>
		<td class="td_fin"><?php if(isset($som_nat_prd[date("m/Y", strtotime($dat))])) {echo $som_nat_prd[date("m/Y", strtotime($dat))];} ?></td>
		<td class="td_fin"><?php if(isset($som_nat_chg[date("m/Y", strtotime($dat))])) {echo $som_nat_chg[date("m/Y", strtotime($dat))];} ?></td>
		<td class="td_fin"><?php if(isset($som_nat_dtt[date("m/Y", strtotime($dat))])) {echo $som_nat_dtt[date("m/Y", strtotime($dat))];} ?></td>
		<td class="td_fin"><?php if(isset($som_nat_crn[date("m/Y", strtotime($dat))])) {echo $som_nat_crn[date("m/Y", strtotime($dat))];} ?></td>
	</tr>
<?php

		}
		$dat = date('Y-m', strtotime ("+1 months $dat"));
	}
	if($som_nat_trs) {$som_nat_trs['total'] = array_sum($som_nat_trs);}
	if($som_nat_prd) {$som_nat_prd['total'] = array_sum($som_nat_prd);}
	if($som_nat_chg) {$som_nat_chg['total'] = array_sum($som_nat_chg);}
	if($som_nat_dtt) {$som_nat_dtt['total'] = array_sum($som_nat_dtt);}
	if($som_nat_crn) {$som_nat_crn['total'] = array_sum($som_nat_crn);}

?>
	<tr style="font-weight: bold;">
		<td class="td_fin">TOTAL</td>
		<td class="td_fin"><?php echo $som_nat_trs['total']; ?></td>
		<td class="td_fin"><?php echo $som_nat_prd['total']; ?></td>
		<td class="td_fin"><?php echo $som_nat_chg['total']; ?></td>
		<td class="td_fin"><?php echo $som_nat_dtt['total']; ?></td>
		<td class="td_fin"><?php echo $som_nat_crn['total']; ?></td>
	</tr>
</table>
<?php
}
?>
