<div class="dsg dib">
	<span class="vdfp"><?php echo $txt->rgmadditionnels->$id_lng.' :'; ?></span>
<?php
if($aut['cat'] and !$vrl) {
	$flg_add_rgm = true;
	if(isset($rgm_exist['chm'])) {
		$rgm_exist['chm'] = array_unique($rgm_exist['chm']);
		if(count($rgm_exist['chm'])>1) {$flg_add_rgm = false;}
	}
	if($flg_add_rgm) {
?>
	<span class="dib">
		<div class="sel" onclick="vue_cmd('sel_rgm_hbr')">
			<img src="../prm/img/sel.png" />
			<div><?php echo $txt->ajt->$id_lng; ?></div>
		</div>
		<div id="sel_rgm_hbr" class="cmd mw200">
			<div><input type="text" id="ipt_sel_rgm_hbr" onkeyup="auto_lst('hbr','rgm_hbr',this.value,event);" /></div>
			<div id="lst_rgm_hbr"><?php include("vue_lst_rgm.php") ?></div>
		</div>
	</span>
<?php
	}
}
?>
</div>
<hr/>
<div>
<?php
$rq_rgm = select("*","cat_hbr_rgm","id_hbr",$id);
while ($dt_rgm = ftc_ass($rq_rgm)) {
	$id_rgm = $dt_rgm['id'];
?>
	<div>
		<table class="dsg">
			<tr>
				<td class="w-100">
					<strong><?php echo upnoac($rgm[$id_lng][$dt_rgm['rgm']]); ?></strong>
				</td>
<?php
if($aut['cat'] and !$vrl) {
?>
				<td onclick="sup_hbr_rgm(<?php echo $id_rgm ?>);"><img src="../prm/img/sup.png" /></td>
<?php
}
?>
			</tr>
		</table>
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
<?php
	if($aut['cat'] and !$vrl) {
?>
				<td onclick="ajt_hbr_rgm_trf(<?php echo $id_rgm ?>)"><img src="../prm/img/ajt.png" /></td>
<?php
	}
?>
			</tr>
<?php
	$rq_trf = select("cat_hbr_rgm_trf.*","cat_hbr_rgm_trf LEFT JOIN (SELECT id_trf, min(dt_min) AS dt_min FROM cat_hbr_rgm_trf_ssn GROUP BY id_trf) ssn ON cat_hbr_rgm_trf.id = ssn.id_trf","id_rgm",$id_rgm,"dt_min");
	while($dt_trf = ftc_ass($rq_trf)) {
		$id_trf = $dt_trf['id'];
?>
			<tr>
				<td class="td"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_trf['def']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_hbr_rgm_trf','def','1',<?php echo $id_trf ?>,<?php echo $id ?>)}else{updateData('cat_hbr_rgm_trf','def','0',<?php echo $id_trf ?>,<?php echo $id ?>)};" /></td>
				<td>
					<table>
<?php
		$nb_ssn = ftc_ass(select("COUNT(*) as total","cat_hbr_rgm_trf_ssn","id_trf",$id_trf));
		$rq_ssn = select("*","cat_hbr_rgm_trf_ssn","id_trf",$id_trf,"dt_min");
		while($dt_ssn = ftc_ass($rq_ssn)) {
			$id_ssn = $dt_ssn['id'];
?>
						<tr>
							<td class="td" style="width: 76px;"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_ssn_dt_min<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn['dt_min']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn['dt_min']));} ?>" onchange="updateData('cat_hbr_rgm_trf_ssn','dt_min',this.value,<?php echo $id_ssn.','.$id ?>)" /></td>
							<td class="td" style="width: 76px;"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_ssn_dt_max<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn['dt_max']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn['dt_max']));} ?>" onchange="updateData('cat_hbr_rgm_trf_ssn','dt_max',this.value,<?php echo $id_ssn.','.$id ?>)" /></td>
<?php
			if($nb_ssn['total']>1 and $aut['cat']) {
?>
							<td onclick="sup_hbr_rgm_trf_ssn(<?php echo $id_ssn.','.$id_rgm ?>)"><img src="../prm/img/sup.png" /></td>
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
				<td onclick="ajt_hbr_rgm_trf_ssn(<?php echo $id_trf.','.$id_rgm ?>)"><img src="../prm/img/ajt.png" /></td>
<?php
		}
		else{echo '<td></td>';}
?>
				<td id="hbr_rgm_crr<?php echo $id_trf ?>" class="td"><?php include("vue_hbr_rgm_crr.php"); ?></td>
				<td class="td"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_est<?php echo $id_trf; ?>" type="checkbox" autocomplete="off" <?php if ($dt_trf['est']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_hbr_rgm_trf','est','1',<?php echo $id_trf ?>);document.getElementById('hbr_rgm_trf_sg_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_sg_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_db_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_db_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_tp_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_tp_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_qd_rck<?php echo $id_trf; ?>').style.backgroundColor ='gold';document.getElementById('hbr_rgm_trf_qd_net<?php echo $id_trf; ?>').style.backgroundColor ='gold';}else{updateData('cat_hbr_rgm_trf','est','0',<?php echo $id_trf ?>);document.getElementById('hbr_rgm_trf_sg_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_sg_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_db_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_db_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_tp_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_tp_net<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_qd_rck<?php echo $id_trf; ?>').style.backgroundColor ='white';document.getElementById('hbr_rgm_trf_qd_net<?php echo $id_trf; ?>').style.backgroundColor ='white';};" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_sg_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['sg_rck']!=0 and ($dt_trf['sg_net']==0 or $dt_trf['sg_net']>$dt_trf['sg_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['sg_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','sg_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_sg_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['sg_rck']!=0 and ($dt_trf['sg_net']==0 or $dt_trf['sg_net']>$dt_trf['sg_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['sg_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','sg_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_db_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['db_rck']!=0 and ($dt_trf['db_net']==0 or $dt_trf['db_net']>$dt_trf['db_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['db_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','db_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_db_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['db_rck']!=0 and ($dt_trf['db_net']==0 or $dt_trf['db_net']>$dt_trf['db_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['db_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','db_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_tp_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['tp_rck']!=0 and ($dt_trf['tp_net']==0 or $dt_trf['tp_net']>$dt_trf['tp_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['tp_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','tp_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_tp_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['tp_rck']!=0 and ($dt_trf['tp_net']==0 or $dt_trf['tp_net']>$dt_trf['tp_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['tp_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','tp_net',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_qd_rck<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['qd_rck']!=0 and ($dt_trf['qd_net']==0 or $dt_trf['qd_net']>$dt_trf['qd_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['qd_rck'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','qd_rck',this.value,<?php echo $id_trf ?>);" /></td>
				<td class="td"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="hbr_rgm_trf_qd_net<?php echo $id_trf; ?>" class="w52" style="<?php if($dt_trf['qd_rck']!=0 and ($dt_trf['qd_net']==0 or $dt_trf['qd_net']>$dt_trf['qd_rck'])) {echo 'background-color: tomato';} elseif($dt_trf['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($dt_trf['qd_net'],$prm_crr_dcm[$dt_trf['crr']],'.','') ?>" onChange="updateData('cat_hbr_rgm_trf','qd_net',this.value,<?php echo $id_trf ?>);" /></td>
<?php
		if($aut['cat'] and !$vrl) {
?>
				<td onclick="sup_hbr_rgm_trf(<?php echo $id_trf ?>)"><img src="../prm/img/sup.png"></td>
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
?>
</div>
