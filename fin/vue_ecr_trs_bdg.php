<?php
$flg_err = $flg_old = $flg_old2 = false;
if($dt_ecr['date'] < date("Y-m-d")) {$flg_old = true;}
if($dt_ecr['date'] < date("Y-m-d",strtotime(date("Y-m-d") . ' -1 year'))){$flg_old2 = true;}
$flux_trs = 0;
?>
<td class="td_fin" style="<?php if($flg_old) {echo 'background: lightgrey';} ?>"><input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if($dt_ecr['date']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ecr['date']));} ?>" onchange="maj('fin_ecr','date',this.value,<?php echo $dt_ecr['id'] ?>)" /></td>
<td class="td_fin" style="<?php if($flg_old) {echo 'background: lightgrey';} ?>"><input type="text" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> style="width: 140px;" value="<?php echo stripslashes($dt_ecr['nature']) ?>" onchange="maj('fin_ecr','nature',this.value,<?php echo $dt_ecr['id'] ?>)" /></td>
<td class="td_fin" style="<?php if($flg_old) {echo 'background: lightgrey';} ?>">
	<table>
<?php
$rq_trs = sel_quo("*","fin_trs","id_ecr",$dt_ecr['id'],"FIELD(id_css,".implode(",",array_keys($css)).")");
while($dt_trs = ftc_ass($rq_trs)) {
	$flux_trs += $dt_trs['sld'];
	if($dt_trs['sld']!=0 and $dt_trs['id_css']==0) {$flg_err = true;}
?>
		<tr>
			<td class="tb" style="width: 100px;">
				<select <?php if(!$aut['adm_fin'] or $flg_old2 or ($dt_trs['id_css']>0 and !$actf_css[$dt_trs['id_css']])) {echo ' disabled';} ?> style="width: 90px;" onchange="maj('fin_trs','id_css',this.value,<?php echo $dt_trs['id'].','.$dt_ecr['id'] ?>)">
					<option value="0">NON DEFINI</option>
<?php
	foreach($css as $css_id => $nom) {
		if($actf_css[$css_id] or $css_id==$dt_trs['id_css']){
?>
					<option <?php if($css_id==$dt_trs['id_css']) {echo ' selected';} ?> value="<?php echo $css_id ?>"><?php echo $nom ?></option>
<?php
		}
	}
?>
				</select>
			</td>
			<td class="tb" style="width: 85px;"><input type="text" id="trs_dvs<?php echo $dt_trs['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2 or ($dt_trs['id_css']>0 and !$actf_css[$dt_trs['id_css']])) {echo ' disabled';} ?> class="w74" value="<?php if($dt_trs['dvs']>0) {echo '+';} if($dt_trs['id_css']>0) {echo number_format($dt_trs['dvs'],$prm_crr_dcm[$cfg_crr_css[$dt_trs['id_css']]],',','');} else{echo number_format($dt_trs['dvs'],2,',','');} ?>" onchange="maj('fin_trs','dvs',this.value,<?php echo $dt_trs['id'] ?>)" /></td>
			<td style="width: 35px;"><?php if($dt_trs['id_css']>0) {echo ' '.$prm_crr_nom[$cfg_crr_css[$dt_trs['id_css']]];} ?></td>
			<td class="tb" style="width: 85px;"><input type="text" id="trs_sld<?php echo $dt_trs['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2 or ($dt_trs['id_css']>0 and !$actf_css[$dt_trs['id_css']])) {echo ' disabled';} ?> class="w74" value="<?php if($dt_trs['sld']>0) {echo '+';} echo number_format($dt_trs['sld'],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_trs','sld',this.value,<?php echo $dt_trs['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td id="trs_tx<?php echo $dt_trs['id']; ?>" style="width: 45px;"><?php include("vue_ecr_trs_tx.php") ?></td>
			<td>
				<select <?php if(!$aut['adm_fin'] or $flg_old2 or ($dt_trs['id_css']>0 and !$actf_css[$dt_trs['id_css']])) {echo ' disabled';} ?> class="w74" onchange="maj('fin_trs','att',this.value,<?php echo $dt_trs['id'] ?>)">
					<option value="0">EN ATTENTE</option>
					<option <?php if($dt_trs['att']==1) {echo ' selected';} ?> value="1">OK</option>
					<option <?php if($dt_trs['att']==2) {echo ' selected';} ?> value="2">NON</option>
				</select>
			<td>
<?php
	if($aut['adm_fin'] and !$flg_old2 and ($dt_trs['id_css']==0 or $actf_css[$dt_trs['id_css']])) {
?>
			<td onclick="sup('trs',<?php echo $dt_trs['id'].','.$dt_ecr['id'] ?>);">
				<img src="../prm/img/sup.png">
			</td>
<?php
	}
?>
		</tr>
<?php
}
?>
	</table>
</td>
<td class="td_fin" style="<?php if($flg_old) {echo 'background: lightgrey';} ?>">
	<table>
<?php
$som_bdg = 0;
$rq_bdg = sel_quo("*","fin_bdg","id_ecr",$dt_ecr['id'],"id_pst,mois,id_grp");
while($dt_bdg = ftc_ass($rq_bdg)) {
	$som_bdg += $dt_bdg['prd'] - $dt_bdg['chg'] + $dt_bdg['dtt'] - $dt_bdg['crn'];
	if(($dt_bdg['prd']!=0 or $dt_bdg['chg'] or $dt_bdg['dtt'] or $dt_bdg['crn']) and ($dt_bdg['id_pst']==0 or $dt_bdg['mois']=="0000-00-00")) {$flg_err = true;}
?>
		<tr>
			<td class="tb" style="width: 120px;">
				<select <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> style="width: 110px;" onchange="maj('fin_bdg','id_pst',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)">
					<option value="0">NON DEFINI</option>
<?php
	foreach($pst as $pst_id => $nom) {
?>
					<option <?php if($pst_id==$dt_bdg['id_pst']) {echo ' selected';} ?> value="<?php echo $pst_id ?>"><?php echo $nom ?></option>
<?php
	}
?>
				</select>
			</td>
			<td class="tb" style="width: 80px;"><input type="text" id="bdg_prd<?php echo $dt_bdg['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dt_bdg['prd'],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_bdg','prd',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td class="tb" style="width: 80px;"><input type="text" id="bdg_chg<?php echo $dt_bdg['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dt_bdg['chg'],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_bdg','chg',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td class="tb" style="width: 80px;"><input type="text" id="bdg_dtt<?php echo $dt_bdg['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dt_bdg['dtt'],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_bdg','dtt',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td class="tb" style="width: 80px;"><input type="text" id="bdg_crn<?php echo $dt_bdg['id']; ?>" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> class="w74" value="<?php echo number_format($dt_bdg['crn'],$prm_crr_dcm[1],',','') ?>" onchange="maj('fin_bdg','crn',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td class="tb" style="width: 120px;">
<?php
	if($dt_bdg['id_pst']>0 and $rsl_pst[$dt_bdg['id_pst']]>0) {
			$flg_sel = false;
?>
				<select <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> style="width: 110px;" onchange="maj('fin_bdg','id_grp',this.value,<?php echo $dt_bdg['id'] ?>)">
					<option <?php if($dt_bdg['id_grp']=='0') {echo ' selected';$flg_sel = true;} ?> value="0">NON DEFINI</option>
					<option <?php if($dt_bdg['id_grp']=='-1') {echo ' selected';$flg_sel = true;} ?> value="-1">Autre</option>
					<optgroup label="EN COURS">
<?php
		$rq_grp = sel_quo("grp_dev.id,nomgrp,cnf","grp_dev INNER JOIN dev_crc ON grp_dev.id=dev_crc.id_grp","cnf","1","nomgrp","DISTINCT");
		while($dt_grp = ftc_ass($rq_grp)) {
?>
						<option <?php if($dt_grp['id']==$dt_bdg['id_grp']) {echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
		}
?>
					</optgroup>
					<optgroup label="ARCHIVES">
<?php
		$rq_grp = sel_quo("grp_dev.id,nomgrp,cnf","grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp","cnf","2","nomgrp","DISTINCT");
		while($dt_grp = ftc_ass($rq_grp)) {
?>
						<option <?php if($dt_grp['id']==$dt_bdg['id_grp']) {echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
		}
?>
					</optgroup>
					<optgroup label="AUTRES">
<?php
		$rq_grp = sel_whe("grp_dev.id,nomgrp","grp_dev LEFT JOIN dev_crc ON grp_dev.id = dev_crc.id_grp","dev_crc.id IS NULL","nomgrp","DISTINCT");
		while($dt_grp = ftc_ass($rq_grp)) {
?>
						<option <?php if($dt_grp['id']==$dt_bdg['id_grp']) {echo ' selected';$flg_sel = true;} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
		}
		if(!$flg_sel) {
			$dt_grp = ftc_ass(sel_quo("nomgrp","grp_dev","id",$dt_bdg['id_grp']));
?>
					<option selected value="<?php echo $dt_bdg['id_grp'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
		}
?>
					</optgroup>
				</select>
<?php
	}
?>
			</td>
			<td class="tb" style="width: 60px;"><input <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> style="width: 50px;" type="text" autocomplete="off" placeholder="mm/aaaa" value="<?php if($dt_bdg['mois']!='0000-00-00') {echo date("m/Y", strtotime($dt_bdg['mois']));} ?>" onchange="maj('fin_bdg','mois',this.value,<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>)" /></td>
			<td class="tb" style="width: 140px;"><input type="text" <?php if(!$aut['adm_fin'] or $flg_old2) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_bdg['dsc']) ?>" onchange="maj('fin_bdg','dsc',this.value,<?php echo $dt_bdg['id'] ?>)" /></td>
<?php
	if($aut['adm_fin'] and !$flg_old2) {
?>
			<td onclick="sup('bdg',<?php echo $dt_bdg['id'].','.$dt_ecr['id'] ?>);">
				<img src="../prm/img/sup.png">
			</td>
<?php
	}
?>
		</tr>
<?php
}
?>
	</table>
</td>
<td id="ecr_err<?php echo $dt_ecr['id'] ?>"><?php include("vue_ecr_err.php"); ?></td>
<?php
if($aut['adm_fin'] and !$flg_old2){
?>
<td>
	<div class="div_cmd" onclick="vue_cmd('vue_cmd<?php echo $dt_ecr['id'] ?>');">
<!--COMMANDES-->
		<img src="../prm/img/cmd.gif" />
		<div id="vue_cmd<?php echo $dt_ecr['id'] ?>" class="cmd wsn">
			<strong><?php echo $txt->cmd->$id_lng; ?></strong>
			<ul>
				<li onclick="ajt('trs',<?php echo $dt_ecr['id'] ?>);document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">AJOUTER FLUX DE TRESORERIE</li>
				<li onclick="ajt('bdg',<?php echo $dt_ecr['id'] ?>);document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">AJOUTER BUDGET</li>
				<li onclick="dup(<?php echo $dt_ecr['id'] ?>,'d');document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">COPIER A 1 JOUR</li>
				<li onclick="dup(<?php echo $dt_ecr['id'] ?>,'m');document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">COPIER A 1 MOIS</li>
				<li onclick="dup(<?php echo $dt_ecr['id'] ?>,'Y');document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">COPIER A 1 AN</li>
				<li onclick="sup('ecr',<?php echo $dt_ecr['id'] ?>);document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">SUPPRIMER ECRITURE</li>
<?php
	if(!empty($dt_ecr['nature'])) {
?>
			<li onclick="fus('<?php echo $dt_ecr['id'] ?>');document.getElementById('vue_cmd<?php echo $dt_ecr['id'] ?>').style.display='none';">FUSIONNER ECRITURE</li>
<?php
	}
?>
			</ul>
		</div>
	</div>
</td>
<?php
}
?>
