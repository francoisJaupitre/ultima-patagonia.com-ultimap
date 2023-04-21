<div id="wrapper">
	<input id="dat_min" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_min)){echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="vue('rsm');" />
	<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_max)){echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('rsm');" />
	<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('rsm');" />
</div>
<br />
<br />
<?php
$rq_fac = sel_whe("cmp_fac.*","cmp_fac","date >= '".$dat_min."' AND date <= '".$dat_max."' AND vnt=1","date DESC,fac DESC","DISTINCT");
if(num_rows($rq_fac)>0){
?>
<table>
	<tr style="font-weight: bold; text-align: center; vertical-align: bottom;">
		<td class="tb">DATE</td>
		<td class="tb">RAISON SOCIALE</td>
		<td class="tb">CUIT/RUT</td>
		<td class="tb">NUMERO</td>
		<td>
			<table>
				<tr>
					<td class="tb" style="width: 360px;">ITEM</td>
					<td class="tb" style="width: 80px;">SOLDE</td>
					<td class="tb" style="width: 80px;">IVA</td>
					<td class="tb" style="width: 80px;">IIBB</td>
					<td class="tb" style="width: 80px;">COMPUTABLE</td>
					<td class="tb" style="width: 130px;">GROUPE</td>
				</tr>
			</table>
		</td>
	</tr>
<?php
	while($dt_fac = ftc_ass($rq_fac)){
		unset($fac_som_sld,$fac_som_iva,$fac_som_iibb,$fac_som_cpt);
		$dt = explode('-',$dt_fac['date']);
		$ms1 = $dt[0].'-'.$dt[1];
		if(isset($ms2) and $ms1 != $ms2){
?>
	<tr>
		<td colspan="4"></td>
		<td class="td_fin">
			<table>
<?php
			foreach($lst_itm as $id_itm){
?>
				<tr>
					<td style="width: 360px;"><?php echo $itm[$id_itm]; ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($itm_som_sld[$id_itm],$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($itm_som_iva[$id_itm] >0){echo '-';}else{echo '+';} echo number_format(abs($itm_som_iva[$id_itm]),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($itm_som_iibb[$id_itm] >0){echo '-';}else{echo '+';} echo number_format(abs($itm_som_iibb[$id_itm]),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($itm_som_cpt[$id_itm] ,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="width: 130px;"></td>
				</tr>
<?php
			}
?>
				<tr>
					<td style="font-weight: bold;"><?php echo date("m/Y",strtotime($ms2)); ?></td>
					<td style="font-weight: bold;"><?php echo number_format($tot_som_sld,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($tot_som_iva>0){echo '-';}else{echo '+';} echo number_format(abs($tot_som_iva),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($tot_som_iibb>0){echo '-';}else{echo '+';} echo number_format(abs($tot_som_iibb),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php echo number_format($tot_som_cpt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="5"><hr /></td>
	</tr>
<?php
			unset($lst_itm,$itm_som_sld,$itm_som_iva,$itm_som_iibb,$itm_som_cpt);
			unset($tot_som_sld,$tot_som_iva,$tot_som_iibb,$tot_som_cpt);
		}
		$ms2 = $ms1;
?>
	<tr>
		<td class="td_fin"><?php if($dt_fac['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_fac['date']));} ?></td>
		<td class="td_fin"><?php echo stripslashes($dt_fac['nom']) ?></td>
		<td class="td_fin"><?php echo stripslashes($dt_fac['imp']) ?></td>
		<td class="td_fin"><?php echo stripslashes($dt_fac['fac']) ?></td>
		<td class="td_fin">
			<table>
<?
		$rq_itm = sel_quo("cmp_itm.*,grp_dev.nomgrp","cmp_itm LEFT JOIN grp_dev ON cmp_itm.id_grp = grp_dev.id","id_fac",$dt_fac['id']);
		while($dt_itm = ftc_ass($rq_itm)){
			$id_itm = $dt_itm['id_itm'];
			if(!isset($fac_som_sld)){$fac_som_sld = $fac_som_iva = $fac_som_iibb = $fac_som_cpt = 0;}
			$fac_som_sld += $sld = $dt_itm['sld'];
			$fac_som_iva += $iva = $sld*$iva_itm[$dt_itm['id_itm']]/(100+$iva_itm[$dt_itm['id_itm']]);
			$fac_som_iibb += $iibb = ($sld-$iva)*$iibb_itm[$dt_itm['id_itm']]/100;
			$fac_som_cpt += $cpt = $dt_itm['cpt'];
?>
				<tr>
					<td class="tb" style="width: 360px;"><?php echo $itm[$id_itm]; ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($sld,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($iva>0){echo '-';}else{echo '+';} echo number_format(abs($iva),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($iibb>0){echo '-';}else{echo '+';} echo number_format(abs($iibb),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($cpt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb wsn" style="width: 130px;"><?php echo $dt_itm['nomgrp']; ?></td>
				</tr>
<?php
			if(!isset($lst_itm)){$lst_itm[] = $id_itm;}
			elseif(!in_array($id_itm,$lst_itm)){$lst_itm[] = $id_itm;}
			if(!isset($itm_som_sld[$id_itm])){$itm_som_sld[$id_itm] = $itm_som_iva[$id_itm] = $itm_som_iibb[$id_itm] = $itm_som_cpt[$id_itm] = 0;}
			$itm_som_sld[$id_itm] += round($sld,$prm_crr_dcm[$id_crr_cmp]);
			$itm_som_iva[$id_itm] += round($iva,$prm_crr_dcm[$id_crr_cmp]);
			$itm_som_iibb[$id_itm] += round($iibb,$prm_crr_dcm[$id_crr_cmp]);
			$itm_som_cpt[$id_itm] += round($cpt,$prm_crr_dcm[$id_crr_cmp]);
		}
?>
				<tr>
					<td></td>
					<td style="font-weight: bold;"><?php echo number_format($fac_som_sld,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($fac_som_iva>0){echo '-';}else{echo '+';} echo number_format(abs($fac_som_iva),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($fac_som_iibb>0){echo '-';}else{echo '+';} echo number_format(abs($fac_som_iibb),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php echo number_format($fac_som_cpt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
				</tr>
			</table>
		</td>
	</tr>
<?php
		if(!isset($tot_som_sld)){$tot_som_sld = $tot_som_iva = $tot_som_iibb = $tot_som_cpt = 0;}
		$tot_som_sld += round($fac_som_sld,$prm_crr_dcm[$id_crr_cmp]);
		$tot_som_iva += round($fac_som_iva,$prm_crr_dcm[$id_crr_cmp]);
		$tot_som_iibb += round($fac_som_iibb,$prm_crr_dcm[$id_crr_cmp]);
		$tot_som_cpt += round($fac_som_cpt,$prm_crr_dcm[$id_crr_cmp]);
	}
?>
	<tr>
		<td colspan="4"></td>
		<td class="td_fin">
			<table>
<?php
	foreach($lst_itm as $id_itm){
?>
				<tr>
					<td style="width: 360px;"><?php echo $itm[$id_itm]; ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($itm_som_sld[$id_itm],$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($itm_som_iva[$id_itm] >0){echo '-';}else{echo '+';} echo number_format(abs($itm_som_iva[$id_itm]),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php if($itm_som_iibb[$id_itm] >0){echo '-';}else{echo '+';} echo number_format(abs($itm_som_iibb[$id_itm]),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td class="tb" style="width: 80px;"><?php echo number_format($itm_som_cpt[$id_itm] ,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="width: 130px;"></td>
				</tr>
<?php
	}
?>
				<tr>
					<td style="font-weight: bold;"><?php echo date("m/Y",strtotime($ms2)); ?></td>
					<td style="font-weight: bold;"><?php echo number_format($tot_som_sld,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($tot_som_iva>0){echo '-';}else{echo '+';} echo number_format(abs($tot_som_iva),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php if($tot_som_iibb>0){echo '-';}else{echo '+';} echo number_format(abs($tot_som_iibb),$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td style="font-weight: bold;"><?php echo number_format($tot_som_cpt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
					<td></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
}
?>
