<div>
<?php
$rq_rgm = select("rgm","cat_hbr_rgm","id_hbr",$id,"","DISTINCT");
while($dt_rgm = ftc_ass($rq_rgm)) {$rgm_exist['hbr'][] = $dt_rgm['rgm'];}
$rq_chm = select("*","cat_hbr_chm","id_hbr",$id,"nom");
while($dt_chm = ftc_ass($rq_chm)) {
	$id_chm = $dt_chm['id'];
	$rgm_exist['chm'][] = $dt_chm['rgm'];
?>
	<div>
		<table class="dsg">
			<tr>
				<td class="w-100">
					<div style="float:right; padding-left: 5px;">
						<span id="hbr_chm_rgm<?php echo $id_chm ?>"><?php include("vue_hbr_chm_rgm.php"); ?></span>
						<span class="vatdib">
							<strong><?php echo $txt->nbr->$id_lng.' :'; ?></strong>
							<input type="number" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 40px;" value="<?php echo stripslashes($dt_chm['nbr']) ?>" onChange="maj('cat_hbr_chm','nbr',this.value,<?php echo $id_chm ?>)" />
							<strong><?php echo $txt->cpc->$id_lng.' :'; ?></strong>
							<input type="number" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 40px;" value="<?php echo stripslashes($dt_chm['cpc']) ?>" onChange="maj('cat_hbr_chm','cpc',this.value,<?php echo $id_chm ?>)" />
						</span>
					</div>
					<div class="div_cat">
						<div style="float:left; padding-right: 5px;">
							<strong><?php echo $txt->chm->$id_lng.' :'; ?></strong>
							<input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_chm['nom']) ?>" onChange="maj('cat_hbr_chm','nom',this.value,<?php echo $id_chm.','.$id ?>)" />
							<strong><?php echo $txt->infos->$id_lng.' :'; ?></strong>
						</div>
						<div class="div_cat"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_chm['info']) ?>" onChange="maj('cat_hbr_chm','info',this.value,<?php echo $id_chm ?>)" /></div>
					</div>
				</td>
				<td>
<!--COMMANDES-->
					<div class="div_cmd2" onclick="vue_cmd('vue_cmd_chm<?php echo $id_chm ?>');">
						<img src="../prm/img/cmd.gif" />
						<div id="vue_cmd_chm<?php echo $id_chm ?>" class="cmd wsn">
							<strong><?php echo $txt->cmd->$id_lng; ?></strong>
							<ul>
<?php
	if($aut['cat'] and !$vrl) {
?>
								<li onclick="dup('chm',<?php echo $id_chm ?>);"><?php echo $txt->cop->$id_lng; ?></li>
<?php
	}
	if($aut['cat'] and !$vrl) {
?>
								<li onclick="sup_hbr_chm(<?php echo $id_chm ?>);"><?php echo $txt->del->$id_lng; ?></li>
<?php
	}
?>
							</ul>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<div id="hbr_chm_txt<?php echo $id_chm ?>" class="dsg"><?php include("vue_hbr_chm_txt.php");?></div>
		<table class="dsg w-100">
			<tr>
				<td></td>
				<td>
					<table>
						<tr>
							<td class="td" style="width: 76px;"><?php echo $txt->dtmin->$id_lng; ?></td>
							<td class="td" style="width: 76px;"><?php echo $txt->dtmax->$id_lng; ?></td>
						</tr>
					</table>
				</td>
				<td></td>
				<td class="td"><?php echo $txt->crr->$id_lng; ?></td>
				<td class="td"><?php echo $txt->est->$id_lng; ?></td>
				<td class="td"><?php echo $txt->sgl->$id_lng; ?><br/><?php echo $txt->rack->$id_lng; ?></td>
				<td class="td"><?php echo $txt->sgl->$id_lng; ?><br/><?php echo $txt->net->$id_lng; ?></td>
				<td class="td"><?php echo $txt->dbl->$id_lng; ?><br/><?php echo $txt->rack->$id_lng; ?></td>
				<td class="td"><?php echo $txt->dbl->$id_lng; ?><br/><?php echo $txt->net->$id_lng; ?></td>
				<td class="td"><?php echo $txt->tpl->$id_lng; ?><br/><?php echo $txt->rack->$id_lng; ?></td>
				<td class="td"><?php echo $txt->tpl->$id_lng; ?><br/><?php echo $txt->net->$id_lng; ?></td>
				<td class="td"><?php echo $txt->qdp->$id_lng; ?><br/><?php echo $txt->rack->$id_lng; ?></td>
				<td class="td"><?php echo $txt->qdp->$id_lng; ?><br/><?php echo $txt->net->$id_lng; ?></td>
				<td onclick="ajt_hbr_chm_trf(<?php echo $id_chm ?>)"><img src="../prm/img/ajt.png" /></td>
			</tr>
<?php
	$rq_trf = select("cat_hbr_chm_trf.*","cat_hbr_chm_trf INNER JOIN (SELECT id_trf, min(dt_min) AS dt_min FROM cat_hbr_chm_trf_ssn GROUP BY id_trf) ssn ON cat_hbr_chm_trf.id = ssn.id_trf","id_chm",$id_chm,"dt_min");
	while($dt_trf = ftc_ass($rq_trf)) {
		$id_trf = $id_cat = $dt_trf['id'];
		$cbl_cat = 'hbr_chm_trf';
		include("../prm/aut.php");
?>
			<tr>
				<td class="td"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_trf['def']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_hbr_chm_trf','def','1',<?php echo $id_trf ?>,<?php echo $id ?>)}else{maj('cat_hbr_chm_trf','def','0',<?php echo $id_trf ?>,<?php echo $id ?>)};" /></td>
				<td>
					<table>
<?php
		$nb_ssn = ftc_ass(select("COUNT(*) as total","cat_hbr_chm_trf_ssn","id_trf",$id_trf));
		$rq_ssn = select("*","cat_hbr_chm_trf_ssn","id_trf",$id_trf,"dt_min");
		while($dt_ssn = ftc_ass($rq_ssn)) {
			$id_ssn = $dt_ssn['id'];
?>
						<tr>
							<td class="td" style="width: 76px;"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_ssn_dt_min<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn['dt_min']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn['dt_min']));} ?>" onchange="maj('cat_hbr_chm_trf_ssn','dt_min',this.value,<?php echo $id_ssn.','.$id ?>);" /></td>
							<td class="td" style="width: 76px;"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_ssn_dt_max<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn['dt_max']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn['dt_max']));} ?>" onchange="maj('cat_hbr_chm_trf_ssn','dt_max',this.value,<?php echo $id_ssn.','.$id ?>);" /></td>
<?php
			if($nb_ssn['total']>1 and $aut['cat']) {
?>
							<td onclick="sup_hbr_chm_trf_ssn(<?php echo $id_ssn ?>)"><img src="../prm/img/sup.png" /></td>
<?php
			}
?>
						</tr>
<?php
		}
?>
					</table>
				</td>
<?php
			if($aut['cat'] and !$vrl) {
?>
				<td onclick="ajt_hbr_chm_trf_ssn(<?php echo $id_trf.','.$id_chm ?>)"><img src="../prm/img/ajt.png" /></td>
<?php
			}
			else{echo '<td></td>';}
?>

				<td id="hbr_chm_crr<?php echo $id_trf ?>" class="td"><?php include("vue_hbr_chm_crr.php"); ?></td>
				<td class="td"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_est<?php echo $id_trf; ?>" type="checkbox" autocomplete="off" <?php if ($dt_trf['est']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_hbr_chm_trf','est','1',<?php echo $id_trf ?>);document.getElementById('hbr_chm_trf_sg_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_sg_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_db_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_db_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_tp_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_tp_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_qd_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_chm_trf_qd_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';}else{maj('cat_hbr_chm_trf','est','0',<?php echo $id_trf ?>);document.getElementById('hbr_chm_trf_sg_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_sg_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_db_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_db_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_tp_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_tp_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_qd_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_chm_trf_qd_net<?php echo $id_trf; ?>').style.backgroundColor ='white';};" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_sg_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['sg_rck']!=0 and ($dt_trf['sg_net']==0 or $dt_trf['sg_net']>$dt_trf['sg_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['sg_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','sg_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_sg_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['sg_rck']!=0 and ($dt_trf['sg_net']==0 or $dt_trf['sg_net']>$dt_trf['sg_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['sg_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','sg_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_db_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['db_rck']!=0 and ($dt_trf['db_net']==0 or $dt_trf['db_net']>$dt_trf['db_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['db_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','db_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_db_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['db_rck']!=0 and ($dt_trf['db_net']==0 or $dt_trf['db_net']>$dt_trf['db_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['db_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','db_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_tp_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['tp_rck']!=0 and ($dt_trf['tp_net']==0 or $dt_trf['tp_net']>$dt_trf['tp_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['tp_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','tp_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_tp_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['tp_rck']!=0 and ($dt_trf['tp_net']==0 or $dt_trf['tp_net']>$dt_trf['tp_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['tp_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','tp_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_qd_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['qd_rck']!=0 and ($dt_trf['qd_net']==0 or $dt_trf['qd_net']>$dt_trf['qd_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['qd_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','qd_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_chm_trf_qd_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['qd_rck']!=0 and ($dt_trf['qd_net']==0 or $dt_trf['qd_net']>$dt_trf['qd_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['qd_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="maj('cat_hbr_chm_trf','qd_net',this.value,<?php echo $id_trf ?>);" /></td>
<?php
		if($aut['cat'] and !$vrl) {
?>
				<td onclick="sup_hbr_chm_trf(<?php echo $id_trf ?>)"><img src="../prm/img/sup.png" /></td>
<?php
		}
?>
			</tr>
<?php
	}
?>
		</table>
	</div>
	<hr/>
<?php
}
$id_chm = 0;
$id_cat = $id;
$cbl_cat = 'hbr';
?>
</div>
<div class="dsg dib">
	<span class="vdfp2"><?php echo $txt->chms->$id_lng.' :'; ?></span>
<?php
if($aut['cat'] and !$vrl) {
?>
	<span class="dib" onClick="ajt_hbr_chm()"><img src="../prm/img/ajt.png" /></span>
<?php
}
?>
</div>
