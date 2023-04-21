<div id="wrapper">
	<input id="dat_min" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_min)){echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="vue('clc');" />
	<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_max)){echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('clc');" />
	<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('clc');" />
	<select style="width: 110px;" onchange="document.getElementById(this.value).scrollIntoView();this.value = 0">
		<option value="0">GROUPES</option>
		<optgroup label="EN COURS">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","cmp_itm INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON cmp_itm.id_grp = grp_dev.id","cnf","1","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
			<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
		</optgroup>
		<optgroup label="ARCHIVES">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","cmp_itm INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON cmp_itm.id_grp = grp_dev.id","cnf","2","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
			<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
		</optgroup>
	</select>
</div>
<br />
<br />
<?php
$rq_grp = sel_whe("grp_dev.id,nomgrp,dt_fac","cmp_fac LEFT JOIN (cmp_itm LEFT JOIN (
	grp_dev INNER JOIN (
		SELECT cmp_fac.id,MAX(date) AS dt_fac,id_grp FROM cmp_fac LEFT JOIN cmp_itm ON cmp_fac.id = cmp_itm.id_fac WHERE vnt=1 GROUP BY id_grp
	) fac ON grp_dev.id = fac.id_grp
) ON cmp_itm.id_grp = grp_dev.id) ON cmp_fac.id = cmp_itm.id_fac","grp_dev.id>0","dt_fac DESC,nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
	unset($tot_som_sld,$tot_som_iva,$tot_som_iibb,$tot_som_cpt,$fac_sld,$fac_cpt,$som_cst,$clc_som_prx,$clc_som_iva,$clc_som_cpt,$iva_mnt,$dvs,$sld,$id_crr,$mrq,$pre_cst,$pre_prx);
	$id_grp = $dt_grp['id'];
	$rq_fac = sel_whe("*","cmp_fac INNER JOIN cmp_itm ON cmp_itm.id_fac = cmp_fac.id","date >= '".$dat_min."' AND date <= '".$dat_max."' AND id_grp=".$id_grp,"date","DISTINCT");
	while($dt_fac = ftc_ass($rq_fac)){
		$id_itm = $dt_fac['id_itm'];
		$sld = $dt_fac['sld'];
		if($dt_fac['vnt']==1){
			$tot_som_sld += $sld;
			$fac_sld[$id_itm] += $sld;
			$tot_som_cpt += $cpt = $dt_fac['cpt'];
			$fac_cpt[$id_itm] += $cpt;
			$tot_som_iva += $iva = $sld*$iva_itm[$id_itm]/(100+$iva_itm[$id_itm]);
			$tot_som_iibb += $iibb = ($sld-$iva)*$iibb_itm[$id_itm]/100;
		}
		elseif(!$dt_fac['vnt']){if($dt_fac['vnt']==2){ECHO 'OK';}
			$som_cst[$id_itm] += $sld;
			if($vnt_itm[$id_itm]!=1){
				if($mnt_itm[$id_itm]){$iva_mnt += $sld*$iva_itm[$id_itm]/100;}
				if(!$aut_itm[$id_itm]){$pre_cst[0] += $sld;}
			}
			else{$pre_cst[1] += $sld;}
		}
		else{
			$som_cst[$id_itm] -= $sld;
			if($vnt_itm[$id_itm]!=1){
				if($mnt_itm[$id_itm]){$iva_mnt -= $sld*$iva_itm[$id_itm]/100;}
				if(!$aut_itm[$id_itm]){$pre_cst[0] -= $sld;}
			}
			else{$pre_cst[1] -= $sld;}
			$tot_som_cpt += $cpt = $dt_fac['cpt'];
			$fac_cpt[$id_itm] += $cpt;
			$iva = $sld*$iva_itm[$id_itm]/(100+$iva_itm[$id_itm]);
			$tot_som_iibb += $iibb = ($sld-$iva)*$iibb_itm[$id_itm]/100;
		}
	}
	if(isset($som_cst)){$som_cst['total'] = round(array_sum($som_cst),$prm_crr_dcm[$id_crr_cmp]);};
	unset($sld,$dcm);
	$rq_clc = sel_quo("id_itm,prx,dvs,sld,id_crr","cmp_clc","id_grp",$id_grp);
	while($dt_clc = ftc_ass($rq_clc)){
		if($dt_clc['id_itm']==0){
			$dvs = $dt_clc['dvs'];
			$sld = $dt_clc['sld'];
			$id_crr = $dt_clc['id_crr'];
		}
		else{$pre_prx += $dt_clc['prx'];}
	}
	if($id_crr>0){$dcm = $prm_crr_dcm[$id_crr];}
	else{$dcm = $prm_crr_dcm[1];}
	$mrq = 1-($som_cst['total']-$pre_cst[1]-$pre_cst[0]+$iva_mnt)/($sld-$pre_cst[1]-$pre_prx);
?>
<span id="<?php echo $id_grp; ?>"></span>
<br/>
<table>
	<tr style="font-weight: bold; text-align: center; vertical-align: bottom;">
		<td class="tb" style="width: 240px;"><h2><?php echo $dt_grp['nomgrp']; ?></h2></td>
		<td class="tb" style="width: 80px;">MONTANT</td>
		<td class="tb" style="width: 80px;">DEVISE</td>
		<td class="tb" style="width: 80px;">SOLDE</td>
		<td class="tb" style="width: 45px;">TAUX</td>
	</tr>
	<tr>
		<td class="td_fin" style="width: 240px;">VENTE TTC</td>
		<td class="td_fin"><input type="text" <?php if(!$aut['adm_fin']){echo ' disabled';} ?> id="clc_dvs0_<?php echo $id_grp; ?>" style="width: 70px;" value="<?php echo number_format($dvs,$dcm,',',''); ?>" onchange="maj('cmp_clc','dvs',this.value,'<?php echo '0_'.$id_grp ?>')" /></td>
		<td class="td_fin">
			<select <?php if(!$aut['adm_fin']){echo ' disabled';} ?> style="width: 50px;" onchange="maj('cmp_clc','id_crr',this.value,'<?php echo '0_'.$id_grp ?>')">
				<option value="0">NON DEFINI</option>
<?php
	foreach($cfg_crr_nom as $crr_id => $nom){
?>
					<option <?php if($crr_id==$id_crr){echo ' selected';} ?> value="<?php echo $crr_id ?>"><?php echo $nom ?></option>
<?php
	}
?>
			</select>
		</td>
		<td class="td_fin"><input type="text" <?php if(!$aut['adm_fin']){echo ' disabled';} ?> id="clc_sld0_<?php echo $id_grp; ?>" style="width: 70px;" value="<?php echo number_format($sld,$prm_crr_dcm[$id_crr_cmp],',',''); ?>" onchange="maj('cmp_clc','sld',this.value,'<?php echo '0_'.$id_grp ?>')" /></td>
		<td class="td_fin" id="clc_tx0_<?php echo $id_grp; ?>" style="width: 45px;"><?php include("vue_tx.php") ?></td>
	</tr>
	<tr>
		<td class="td_fin" colspan="3">IVA MONOTRIBUTISTAS</td>
		<td class="td_fin"><?php echo number_format($iva_mnt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
	</tr>
	<tr>
		<td class="td_fin" colspan="3">ITEMS ACHATS PREDIFINIS</td>
		<td class="td_fin"><?php echo number_format($pre_cst[0],$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
	</tr>
	<tr>
		<td class="td_fin" colspan="3">ITEMS VENTES PREDIFINIES</td>
		<td class="td_fin"><?php echo number_format($pre_prx,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
	</tr>
	<tr>
		<td class="td_fin" colspan="3">MARQUE AUTO</td>
		<td class="td_fin"<?php if($mrq<0){echo ' style="color: tomato"';} ?>><?php echo number_format($mrq*100,2,',',' ').'%'; ?></td>
	</tr>
</table>
<br/>
<strong>CALCULS</strong>
<table>
	<tr style="font-weight: bold; text-align:center;">
		<td class="tb" style="width: 240px;">ITEMS</td>
		<td class="tb" style="width: 80px;">COMPRAS</td>
		<td class="tb" style="width: 80px;">VENTAS T</td>
		<td class="tb" style="width: 80px;">VENTAS B</td>
		<td class="tb" style="width: 80px;">A FACTURAR</td>
		<td class="tb" style="width: 80px;">%IVA</td>
		<td class="tb" style="width: 80px;">IVA TOTAL</td>
		<td class="tb" style="width: 80px;">IVA NETO</td>
		<td class="tb" style="width: 80px;">COMPUTABLE</td>
		<td class="tb" style="width: 80px;">A DECLARAR</td>
	</tr>
<?php
	foreach($itm as $itm_id => $nom){
		if(!isset($fac_sld[$itm_id])){$fac_sld[$itm_id]=0;}
		if(!isset($fac_cpt[$itm_id])){$fac_cpt[$itm_id]=0;}
		if($aut_itm[$itm_id]){
			if($mnt_itm[$itm_id]){$clc_som_prx[0][$itm_id] = round($som_cst[$itm_id]/(1-$mrq)*(1+$iva_itm[$itm_id]/100),$prm_crr_dcm[$id_crr_cmp]);}
			else{$clc_som_prx[0][$itm_id] = round($som_cst[$itm_id]/(1-$mrq),$prm_crr_dcm[$id_crr_cmp]);}
		}
		else{
			$dt_clc = ftc_ass(sel_quo("prx","cmp_clc",array("id_itm","id_grp"),array($itm_id,$id_grp)));
			$clc_som_prx[0][$itm_id] = round($dt_clc['prx'],$prm_crr_dcm[$id_crr_cmp]);
		}
		if(isset($som_cst[$itm_id]) or ($clc_som_prx[0][$itm_id]!=0 and !is_nan($clc_som_prx[0][$itm_id])) or ($clc_som_prx[1][$itm_id]!=0 and !is_nan($clc_som_prx[1][$itm_id])) or number_format($fac_sld[$itm_id],$prm_crr_dcm[$id_crr_cmp])!=0 or $fac_cpt[$itm_id]!=0){
?>
	<tr>
		<td class="td_fin" <?php if($som_cst[$itm_id]==0 and $clc_som_prx[0][$itm_id]==0 and $clc_som_prx[1][$itm_id]==0){echo ' style="color:red;"';} ?>><?php echo $nom; ?></td>
		<td class="td_fin"><?php echo number_format($som_cst[$itm_id],$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>

		<td class="td_fin">
<?php
			if($vnt_itm[$itm_id]==1){
				$clc_som_prx[1][$itm_id] = $som_cst[$itm_id];
				echo number_format($clc_som_prx[1][$itm_id],$prm_crr_dcm[$id_crr_cmp],',',' ');
			}
?>
		</td>
		<td class="td_fin" style="width: 80px;<?php if(number_format($clc_som_prx[0][$itm_id] - $som_cst[$itm_id],$prm_crr_dcm[$id_crr_cmp])<0){echo 'color: tomato';} ?>	">
<?php
			if($vnt_itm[$itm_id]!=1){
				if(!$aut['adm_fin'] or $aut_itm[$itm_id]){echo number_format($clc_som_prx[0][$itm_id],$prm_crr_dcm[$id_crr_cmp],',','');}
				else{
?>
			<input type="text"  id="clc_prx<?php echo $itm_id.'_'.$id_grp; ?>" style="width: 70px;" value="<?php echo number_format($clc_som_prx[0][$itm_id],$prm_crr_dcm[$id_crr_cmp],',',''); ?>" onchange="maj('cmp_clc','prx',this.value,'<?php echo $itm_id.'_'.$id_grp ?>')" />
<?
				}
			}
			$dif = $clc_som_prx[0][$itm_id]+$clc_som_prx[1][$itm_id]-$fac_sld[$itm_id];
?>
		</td>
		<td class="td_fin" <?php if(number_format($dif,$prm_crr_dcm[$id_crr_cmp])!=0){echo ' style="color:red;"';}?>><?php if(number_format($dif,$prm_crr_dcm[$id_crr_cmp])!=0){if($dif>=0){echo '+';} echo number_format($dif,$prm_crr_dcm[$id_crr_cmp],',',' ');}else{echo 'OK';} ?></td>
		<td class="td_fin"><?php echo $iva_itm[$itm_id].'%'; ?></td>
		<td class="td_fin">
<?php
			if($vnt_itm[$itm_id]!=1){
				$clc_som_iva['tot'][$itm_id] = $clc_som_prx[0][$itm_id]*$iva_itm[$itm_id]/(100+$iva_itm[$itm_id]); //no round!!
				echo number_format($clc_som_iva['tot'][$itm_id],$prm_crr_dcm[$id_crr_cmp],',',' ');
			}
?>
		</td>
		<td class="td_fin">
<?php
			if($vnt_itm[$itm_id]!=1){
				if($mnt_itm[$itm_id]){$clc_som_iva['net'][$itm_id] = $clc_som_iva['tot'][$itm_id];}
				else{$clc_som_iva['net'][$itm_id] = round(($clc_som_prx[0][$itm_id]-$som_cst[$itm_id])*$iva_itm[$itm_id]/(100+$iva_itm[$itm_id]),$prm_crr_dcm[$id_crr_cmp]);}
				echo number_format($clc_som_iva['net'][$itm_id],$prm_crr_dcm[$id_crr_cmp],',',' ');
			}
?>
		</td>
		<td class="td_fin">
<?php
			if($vnt_itm[$itm_id]!=1){
				$clc_som_cpt[$itm_id] = round($clc_som_prx[0][$itm_id]-$som_cst[$itm_id]-$clc_som_iva['net'][$itm_id],$prm_crr_dcm[$id_crr_cmp]);
				echo number_format($clc_som_cpt[$itm_id],$prm_crr_dcm[$id_crr_cmp],',',' ');
			}
			$dif = $clc_som_cpt[$itm_id]-$fac_cpt[$itm_id];
?>
		</td>
		<td class="td_fin" <?php if(number_format($dif,$prm_crr_dcm[$id_crr_cmp])!=0){echo ' style="color:red;"';}?>><?php if(number_format($dif,$prm_crr_dcm[$id_crr_cmp])!=0){if($dif>=0){echo '+';}echo number_format($dif,$prm_crr_dcm[$id_crr_cmp],',',' ');}else{echo 'OK';} ?></td>
	</tr>
<?php
		}
	}
	if(isset($clc_som_prx[1])){$clc_som_prx[1]['total'] = round(array_sum($clc_som_prx[1]),$prm_crr_dcm[$id_crr_cmp]);}
	if(isset($clc_som_prx[0])){$clc_som_prx[0]['total'] = round(array_sum($clc_som_prx[0]),$prm_crr_dcm[$id_crr_cmp]);}
	if(isset($clc_som_iva['tot'])){$clc_som_iva['tot']['total'] = round(array_sum($clc_som_iva['tot']),$prm_crr_dcm[$id_crr_cmp]);}
	if(isset($clc_som_iva['net'])){$clc_som_iva['net']['total'] = round(array_sum($clc_som_iva['net']),$prm_crr_dcm[$id_crr_cmp]);}
	if(isset($clc_som_cpt)){$clc_som_cpt['total'] = round(array_sum($clc_som_cpt),$prm_crr_dcm[$id_crr_cmp]);}
?>
	<tr style="font-weight: bold; text-align:center;">
		<td class="tb"><em>sur la facture</em></td>
		<td class="tb"><?php if(!is_nan($som_cst['total'])){echo number_format($som_cst['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
		<td class="tb" style="<?php if(number_format($clc_som_prx[1]['total']+$clc_som_prx[0]['total']-$tot_som_sld,$prm_crr_dcm[$id_crr_cmp])!=0){echo 'color:red';}?>"><?php if(!is_nan($clc_som_prx[1]['total'])){echo number_format($clc_som_prx[1]['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
		<td class="tb" style="<?php if(number_format($clc_som_prx[1]['total']+$clc_som_prx[0]['total']-$tot_som_sld,$prm_crr_dcm[$id_crr_cmp])!=0){echo 'color:red';}?>"><?php if(!is_nan($clc_som_prx[0]['total'])){echo number_format($clc_som_prx[0]['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
		<td class="tb"></td>
		<td class="tb"></td>
		<td class="tb" style="<?php if(number_format($clc_som_iva['tot']['total']-$tot_som_iva,$prm_crr_dcm[$id_crr_cmp])!=0){echo 'color:red';}?>"><?php if(!is_nan($clc_som_iva['tot']['total'])){echo number_format($clc_som_iva['tot']['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
		<td class="tb"><?php if(!is_nan($clc_som_iva['net']['total'])){echo number_format($clc_som_iva['net']['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
		<td class="tb" style="<?php if(number_format($clc_som_cpt['total']-$tot_som_cpt,$prm_crr_dcm[$id_crr_cmp])!=0){echo 'color:red';}?>"><?php if(!is_nan($clc_som_cpt['total'])){echo number_format($clc_som_cpt['total'],$prm_crr_dcm[$id_crr_cmp],',',' ');} ?></td>
	</tr>
	<tr style="font-weight: bold; text-align:center;">
		<td colspan="6"></td>
		<td class="tb">IIBB</td>
		<td class="tb"><?php echo number_format($tot_som_iibb,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
		<td class="tb">&nbsp;&nbsp;&nbsp;&nbsp;&#8593;</td>
	</tr>
	<tr style="font-weight: bold; text-align:center;">
		<td colspan="6"></td>
		<td class="tb">COMPUTABLE</td>
		<td class="tb"<?php if($mrq<0){echo ' style="color: tomato"';} ?>><?php echo number_format($tot_som_cpt,$prm_crr_dcm[$id_crr_cmp],',',' '); ?></td>
		<td class="tb">&#8592;&nbsp;&nbsp;=</td>
	</tr>
</table>
<hr />
<br />
<?php
}
?>
