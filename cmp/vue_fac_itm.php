<?php
if($dt_fac['date']<date("Y-m-d")){$flg_old=true;}
else{$flg_old=false;}
?>
<td class="td_fin" style="<?php if($flg_old){echo 'background: lightgrey';} ?>">
	<table>
		<tr>
			<td><input <?php if(!$aut['cmp']){echo ' disabled';} ?> type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if($dt_fac['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_fac['date']));} ?>" onchange="maj('cmp_fac','date',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
			<td><input type="text" <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 180px;" value="<?php echo stripslashes($dt_fac['nom']) ?>" onchange="maj('cmp_fac','nom',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
			<td><input type="text" <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 100px;" value="<?php echo stripslashes($dt_fac['imp']) ?>" onchange="maj('cmp_fac','imp',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
			<td><input type="text" <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 130px;" value="<?php echo stripslashes($dt_fac['fac']) ?>" onchange="maj('cmp_fac','fac',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
			<td id="fac_vnt<?php echo $dt_fac['id'] ?>"><?php include("vue_fac_vnt.php"); ?></td>
			<td>
				<select style="width: 70px;" onchange="maj('cmp_fac','ctr',this.value,<?php echo $dt_fac['id'] ?>)">
					<option value="0">ESPERA</option>
					<option <?php if(!$aut['cmp']){echo ' disabled';} ?> <?php if($dt_fac['ctr']==1){echo ' selected';} ?> value="1">AUDITORIA</option>
					<option <?php if(!$aut['adm_fin']){echo ' disabled';} ?> <?php if($dt_fac['ctr']==2){echo ' selected';} ?> value="2">OK</option>
				</select>
			</td>
		</tr>
	</table>
</td>
<td class="td_fin" style="<?php if($flg_old){echo 'background: lightgrey';} ?>">
	<table>
<?php
unset($flg_err);
$rq_itm = sel_quo("*","cmp_itm","id_fac",$dt_fac['id'],"id_itm,id_grp");
$nb_itm = num_rows($rq_itm);
$sum_sld = 0;
while($dt_itm = ftc_ass($rq_itm)){
	$dvs = $dt_itm['dvs'];
	$sld = $dt_itm['sld'];
	$id_crr = $dt_itm['id_crr'];
	if($id_crr>0){$dcm = $prm_crr_dcm[$id_crr];}
	else{$dcm = $prm_crr_dcm[1];}
	$sum_sld += $sld;
	if((($dvs!=0 or $sld!=0) and $dt_itm['id_itm']==0) or ($dt_itm['id_crr']==0 and $dvs!=0) or ($dvs!=0 and $sld==0) or $dt_itm['id_grp']==0){$flg_err = true;}
?>
		<tr>
			<td class="tb" style="width: 80px;"><input type="text" id="itm_dvs<?php echo $dt_itm['id']; ?>" <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 70px;" value="<?php echo number_format($dvs,$dcm,',','') ?>" onchange="maj('cmp_itm','dvs',this.value,<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>)" /></td>
			<td class="tb" style="width: 80px;">
				<select <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 50px;" onchange="maj('cmp_itm','id_crr',this.value,<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>)">
					<option value="0">NON DEFINI</option>
<?php
	foreach($cfg_crr_nom as $crr_id => $nom){
		if($crr_id!=$id_crr_cmp){
?>
					<option <?php if($crr_id==$dt_itm['id_crr']){echo ' selected';} ?> value="<?php echo $crr_id ?>"><?php echo $nom ?></option>
<?php
		}
	}
?>
				</select>
			</td>
			<td class="tb" style="width: 80px;"><input type="text" id="itm_sld<?php echo $dt_itm['id']; ?>" <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 70px;" value="<?php echo number_format($sld,$prm_crr_dcm[$id_crr_cmp],',','') ?>" onchange="maj('cmp_itm','sld',this.value,<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>)" /></td>
			<td id="itm_tx<?php echo $dt_itm['id']; ?>" style="width: 45px;"><?php include("vue_tx.php") ?></td>
			<td class="tb" style="width: 300px;">
				<select <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 290px;" onchange="maj('cmp_itm','id_itm',this.value,<?php echo $dt_itm['id'] ?>)">
					<option value="0">NON DEFINI</option>
<?php
	foreach($itm as $itm_id => $nom){
?>
					<option <?php if($itm_id==$dt_itm['id_itm']){echo ' selected';} ?> value="<?php echo $itm_id ?>"><?php echo $nom ?></option>
<?php
	}
?>
				</select>
			</td>
			<td class="tb" style="width: 80px;"><input type="text" id="itm_cpt<?php echo $dt_itm['id']; ?>" class="fac_cpt<?php echo $dt_fac['id']; ?>"<?php if(!$aut['cmp'] or !$dt_fac['vnt']){echo ' disabled';} ?> style="width: 70px;" value="<?php echo number_format($dt_itm['cpt'],$prm_crr_dcm[$id_crr_cmp],',','') ?>" onchange="maj('cmp_itm','cpt',this.value,<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>)" /></td>
			<td class="tb" style="width: 120px;">
<?php
	$flg_sel = false;
?>
				<select <?php if(!$aut['cmp']){echo ' disabled';} ?> style="width: 110px;" onchange="maj('cmp_itm','id_grp',this.value,<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>)">
					<option <?php if($dt_itm['id_grp']=='0'){echo ' selected';$flg_sel = true;} ?> value="0">NON DEFINI</option>
					<option <?php if($dt_itm['id_grp']=='-1'){echo ' selected';$flg_sel = true;} ?> value="-1">Autre</option>
					<optgroup label="EN COURS">
<?php
	$rq_grp = sel_quo("grp_dev.id,nomgrp","grp_dev INNER JOIN dev_crc ON grp_dev.id=dev_crc.id_grp","cnf","1","nomgrp","DISTINCT");
	while($dt_grp = ftc_ass($rq_grp)){
?>
						<option <?php if($dt_grp['id']==$dt_itm['id_grp']){echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
	}
?>
					</optgroup>
					<optgroup label="ARCHIVES">
<?php
	$rq_grp = sel_quo("grp_dev.id,nomgrp","grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp","cnf","2","nomgrp","DISTINCT");
	while($dt_grp = ftc_ass($rq_grp)){
?>
						<option <?php if($dt_grp['id']==$dt_itm['id_grp']){echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
	}
?>
					</optgroup>
					<optgroup label="SANS DEVIS">
<?php
		$rq_grp = sel_whe("grp_dev.id,nomgrp","grp_dev LEFT JOIN dev_crc ON grp_dev.id = dev_crc.id_grp","dev_crc.id IS NULL","nomgrp","DISTINCT");
		while($dt_grp = ftc_ass($rq_grp)){
?>
						<option <?php if($dt_grp['id']==$dt_bdg['id_grp']){echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
		}
?>
					</optgroup>
<?php
		if(!$flg_sel){
?>
					<option selected value="<?php echo $dt_bdg['id_grp'] ?>">ANNULATION</option>
<?php
		}
?>
				</select>
			</td>
<?php
	if($aut['cmp']){
?>
			<td onclick="sup('itm',<?php echo $dt_itm['id'].','.$dt_fac['id'] ?>);">
				<img src="../prm/img/sup.png">
			</td>
<?php
	}
?>
		</tr>
<?php
}
if($nb_itm>1){
?>
		<tr>
			<td></td>
			<td></td>
			<td id="fac_sum<?php echo $dt_fac['id'] ?>"><?php include("vue_fac_sum.php"); ?></td>
		</tr>
<?php
}
?>
	</table>
</td>
<td class="td_fin" style="width: 140px;<?php if($flg_old){echo 'background: lightgrey';} ?>"><input type="text" <?php if(!$aut['cmp']){echo ' disabled';} ?> value="<?php echo stripslashes($dt_fac['dsc']) ?>" onchange="maj('cmp_fac','dsc',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
<td id="fac_err<?php echo $dt_fac['id'] ?>"><?php include("vue_fac_err.php"); ?></td>
<td>
	<div class="div_cmd" onclick="vue_cmd('vue_cmd<?php echo $dt_fac['id'] ?>');">
<!--COMMANDES-->
		<img src="../prm/img/cmd.gif" />
		<div id="vue_cmd<?php echo $dt_fac['id'] ?>" class="cmd wsn">
			<strong><?php echo $txt->cmd->$id_lng; ?></strong>
			<ul>
<?php
if($aut['cmp']){
?>
				<li onclick="ajt('itm',<?php echo $dt_fac['id'] ?>);document.getElementById('vue_cmd<?php echo $dt_fac['id'] ?>').style.display='none';">AJOUTER ITEM</li>
				<li onclick="sup('fac',<?php echo $dt_fac['id'] ?>);document.getElementById('vue_cmd<?php echo $dt_fac['id'] ?>').style.display='none';">SUPPRIMER FACTURE</li>
<?php
}
?>
			</ul>
		</div>
	</div>
</td>
