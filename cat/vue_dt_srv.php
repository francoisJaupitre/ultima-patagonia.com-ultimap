<div class="dsg">
	<table>
		<tr>
<?php
if($aut['cat'] and !$vrl) {
?>
			<td onclick="ajt_srv_trf();"><img src="../prm/img/ajt.png" /></td>
<?php
}
else{echo '<td></td>';}
?>
			<td class="td"><?php echo $txt->crr->$id_lng; ?></td>
			<td></td>
			<td class="td"><?php echo $txt->dtmin->$id_lng; ?></td>
			<td class="td"><?php echo $txt->dtmax->$id_lng; ?></td>
			<td></td>
			<td></td>
			<td class="td"><?php echo $txt->bsmin->$id_lng; ?></td>
			<td class="td"><?php echo $txt->bsmax->$id_lng; ?></td>
			<td class="td"><?php echo $txt->trfcoll->$id_lng; ?></td>
			<td class="td"><?php echo $txt->trfrack->$id_lng; ?></td>
			<td class="td"><?php echo $txt->trfnet->$id_lng; ?></td>
			<td class="td"><?php echo $txt->com->$id_lng; ?></td>
			<td class="td"><?php echo $txt->est->$id_lng; ?></td>
			<td class="td"><?php echo $txt->frn2->$id_lng; ?></td>
			<td></td>
			<td style="width: 23px;"></td>
		</tr>
<?php
$rq_trf = select("cat_srv_trf.*","cat_srv_trf INNER JOIN (SELECT id_trf, min(dt_min) AS dt_min FROM cat_srv_trf_ssn GROUP BY id_trf) ssn ON cat_srv_trf.id = ssn.id_trf","id_srv",$id,"dt_min");
while($dt_trf = ftc_ass($rq_trf)) {
	$id_trf = $dt_trf['id'];
	$nb_ssn = ftc_ass(select("COUNT(*) as total","cat_srv_trf_ssn","id_trf",$id_trf));
	$nb_bss = ftc_ass(select("COUNT(*) as total","cat_srv_trf_bss","id_trf",$id_trf));
	if($nb_ssn['total']>$nb_bss['total']) {$rowmax = $nb_ssn['total'];}
	else{$rowmax = $nb_bss['total'];}
	$rq_ssn = select("*","cat_srv_trf_ssn","id_trf",$id_trf,"dt_min");
	$dt_ssn = ftc_all($rq_ssn);
	$rq_bss = select("*","cat_srv_trf_bss","id_trf",$id_trf,"bs_min");
	$dt_bss = ftc_all($rq_bss);
	for($n=0; $n<$rowmax; $n++) {
		if(isset($dt_ssn[$n])) {$id_ssn = $dt_ssn[$n]['id'];}
		if(isset($dt_bss[$n])) {
			$id_bss = $dt_bss[$n]['id'];
			$id_frn = $dt_bss[$n]['id_frn'];
			$trf_rck = $dt_bss[$n]['trf_rck'];
			$trf_net = $dt_bss[$n]['trf_net'];
		}
?>
		<tr>
<?php
		if($n==0) {
?>
			<td class="vat" rowspan="<?php echo $rowmax ?>"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_trf['def']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_srv_trf','def','1',<?php echo $id_trf ?>,<?php echo $id ?>)}else{updateData('cat_srv_trf','def','0',<?php echo $id_trf ?>,<?php echo $id ?>)};" /></td>
			<td id="dt_srv_crr<?php echo $id_trf ?>" class="vam td" rowspan="<?php echo $rowmax ?>"><?php include("vue_dt_srv_crr.php"); ?></td>
			<td class="vat" rowspan="<?php echo $rowmax ?>">
			<!--COMMANDES-->
				<div class="div_cmd2" onclick="vue_cmd('vue_cmd_trf<?php echo $id_trf ?>');">
					<img src="../prm/img/cmd.gif" />
					<div id="vue_cmd_trf<?php echo $id_trf ?>" class="cmd wsn">
						<strong><?php echo $txt->cmd->$id_lng; ?></strong>
						<ul>
<?php
		if($aut['cat'] and !$vrl) {
?>
							<li onclick="duplicate('trf',<?php echo $id_trf ?>);"><?php echo $txt->cop->$id_lng; ?></li>
<?php
		}
		if($aut['cat'] and !$vrl) {
?>
							<li onclick="sup_srv_trf(<?php echo $id_trf ?>);"><?php echo $txt->del->$id_lng; ?></li>
<?php
		}
?>
						</ul>
					</div>
				</div>
			</td>
<?php
		}
		if(isset($id_ssn) and isset($dt_ssn[$n]) and $id_ssn>0) {
?>
			<td class="td td_ssn<?php echo $id_ssn; ?>"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> id="srv_trf_ssn_dt_min<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn[$n]['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn[$n]['dt_min']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn[$n]['dt_min']));} ?>" onchange="updateData('cat_srv_trf_ssn','dt_min',this.value,<?php echo $id_ssn.','.$id ?>);" /></td>
			<td class="td td_ssn<?php echo $id_ssn; ?>"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> id="srv_trf_ssn_dt_max<?php echo $id_ssn; ?>" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" style="<?php if(strtotime($dt_ssn[$n]['dt_max'])<strtotime(date('Y-m-d'))) {echo 'background-color: tomato';} ?>" value="<?php if($dt_ssn[$n]['dt_max']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_ssn[$n]['dt_max']));} ?>" onchange="updateData('cat_srv_trf_ssn','dt_max',this.value,<?php echo $id_ssn.','.$id ?>);" /></td>
<?php
			if($nb_ssn['total']>1 and $aut['cat']) {
?>
			<td class="td_ssn<?php echo $id_ssn; ?>" onclick="sup_srv_trf_ssn(<?php echo $id_ssn.','.$id_trf ?>)"><img src="../prm/img/sup.png" /></td>
<?php
			}
			else{echo '<td class="td_ssn'.$id_ssn.'"></td>';}
?>
<?php
		}
		else{
?>
			<td colspan="3"></td>
<?php
		}
		if($n==0) {
			if($aut['cat'] and !$vrl) {
?>
			<td rowspan="<?php echo $rowmax ?>" class="vat" onclick="ajt_srv_trf_ssn(<?php echo $id_trf ?>)"><img src="../prm/img/ajt.png"/></td>
<?php
			}
			else{echo '<td class="vat" rowspan="'.$rowmax.'" ></td>';}
		}
		if(isset($id_bss) and isset($dt_bss[$n]) and $id_bss>0) {
?>
			<td class="td td_bss<?php echo $id_bss; ?>"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="srv_trf_bss_bs_min<?php echo $id_bss; ?>" class="w25" value="<?php echo $dt_bss[$n]['bs_min'] ?>" <?php if($dt_bss[$n]['bs_min']==0){echo 'style="background-color: tomato"';} ?> onChange="updateData('cat_srv_trf_bss','bs_min',this.value,<?php echo $id_bss ?>,<?php echo $id_trf ?>);" /></td>
			<td class="td td_bss<?php echo $id_bss; ?>"><input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="srv_trf_bss_bs_max<?php echo $id_bss; ?>" class="w25" value="<?php echo $dt_bss[$n]['bs_max'] ?>" <?php if($dt_bss[$n]['bs_max']==0){echo 'style="background-color: tomato"';} ?> onChange="updateData('cat_srv_trf_bss','bs_max',this.value,<?php echo $id_bss ?>,<?php echo $id_trf ?>);" /></td>
			<td class="td td_bss<?php echo $id_bss; ?>"><input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($dt_bss[$n]['clc']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_srv_trf_bss','clc','1',<?php echo $id_bss ?>);}else{updateData('cat_srv_trf_bss','clc','0',<?php echo $id_bss ?>)};" /></td>
			<td class="td td_bss<?php echo $id_bss; ?>">
				<input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="srv_trf_bss_trf_rck<?php echo $id_bss; ?>" class="w52" style="<?php if($trf_rck!=0 and ($trf_net==0 or $trf_net>$trf_rck)) {echo 'background-color: tomato';} elseif($dt_bss[$n]['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($trf_rck,$prm_crr_dcm[$dt_trf['crr']],'.','') ?>"
				onChange="updateData('cat_srv_trf_bss','trf_rck',this.value,<?php echo $id_bss ?>); if(this.value!=0 && (document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').value==0 || document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').value-this.value>0)) {this.style.backgroundColor ='red';document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').style.backgroundColor ='red';}
				else if(document.getElementById('est<?php echo $id_bss; ?>').checked) {this.style.backgroundColor ='gold';document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').style.backgroundColor ='gold';}
				else{this.style.backgroundColor ='white';document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').style.backgroundColor ='white';}" />
			</td>
			<td class="td td_bss<?php echo $id_bss; ?>">
				<input type="text" <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="srv_trf_bss_trf_net<?php echo $id_bss; ?>" class="w52" style="<?php if($trf_rck!=0 and ($trf_net==0 or $trf_net>$trf_rck)) {echo 'background-color: tomato';} elseif($dt_bss[$n]['est']) {echo'background-color: gold';} ?>" value="<?php echo number_format($trf_net,$prm_crr_dcm[$dt_trf['crr']],'.','') ?>"
				onChange="updateData('cat_srv_trf_bss','trf_net',this.value,<?php echo $id_bss ?>); if(document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').value!=0 && (this.value==0 || this.value-document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').value>0)) {this.style.backgroundColor ='red';document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').style.backgroundColor ='red';}
				else if(document.getElementById('est<?php echo $id_bss; ?>').checked) {this.style.backgroundColor ='gold';document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').style.backgroundColor ='gold';}
				else{this.style.backgroundColor ='white';document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').style.backgroundColor ='white';}" />
			</td>
			<td id="dt_srv_com<?php echo $id_bss; ?>" class="td td_bss<?php echo $id_bss; ?>"><?php include("vue_dt_srv_com.php"); ?></td>
			<td class="td td_bss<?php echo $id_bss; ?>">
				<input <?php if(!$aut['cat'] or $vrl) {echo ' disabled';} ?> id="est<?php echo $id_bss; ?>" type="checkbox" autocomplete="off" <?php if($dt_bss[$n]['est']) {echo('checked="checked"');} ?>
				onclick="if(this.checked) {updateData('cat_srv_trf_bss','est','1',<?php echo $id_bss ?>);document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').style.backgroundColor ='gold';document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').style.backgroundColor ='gold';}
				else{updateData('cat_srv_trf_bss','est','0',<?php echo $id_bss ?>);document.getElementById('srv_trf_bss_trf_rck<?php echo $id_bss; ?>').style.backgroundColor ='white';document.getElementById('srv_trf_bss_trf_net<?php echo $id_bss; ?>').style.backgroundColor ='white';};" />
			</td>
			<td id="dt_srv_frn<?php echo $id_bss; ?>" class="td frn td_bss<?php echo $id_bss; ?>" style="width: 100px; overflow: hidden"><?php if($id_ctg and $id_vll) {include("vue_dt_srv_frn.php");} ?></td>
<?php
			if($nb_bss['total']>1 and $aut['cat'] and !$vrl) {
?>
			<td class="td_bss<?php echo $id_bss; ?>" onclick="sup_srv_trf_bss(<?php echo $id_bss ?>)"><img src="../prm/img/sup.png" /></td>
<?php
			}
			else{echo '<td class="td_bss'.$id_bss.'"></td>';}
		}
		else{
?>
			<td colspan="9"></td>
<?php
		}
		if($n==0) {
			if($aut['cat'] and !$vrl) {
?>
			<td rowspan="<?php echo $rowmax ?>" class="vat">
				<span class="dib" onclick="ajt_srv_trf_bss(<?php echo $id_trf ?>)"><img src="../prm/img/ajt.png" /></span>
			</td>
<?php
			}
			else{echo '<td class="vat"></td>';}
		}
?>
		</tr>
<?php
	}
?>
		<tr><td colspan="18"><hr /></td></tr>
<?php
}
?>
	</table>
<?php
if($aut['cat'] and !$vrl) {
?>
	<div class="div_cat">
		<div style="float: left; width: 500px; margin-right : 20px">
			<textarea onchange="generateTable(this.value)"></textarea>
			<table>
				<tr>
					<td rowspan="2"><button onclick="rotateTable()">🔄</button></td>
					<td rowspan="2"><button onclick="saveTable()">💾</button></td>
					<td class="td"><?php echo $txt->bsmin->$id_lng; ?></td>
					<td class="td"><?php echo $txt->bsmax->$id_lng; ?></td>
					<td class="td"><?php echo $txt->trfcoll->$id_lng; ?></td>
					<td class="td"><?php echo $txt->trfrack->$id_lng; ?></td>
					<td class="td"><?php echo $txt->trfnet->$id_lng; ?></td>
					<td class="td"><?php echo $txt->est->$id_lng; ?></td>
				</tr>
				<tr>
					<td class="td"><input class="generatedCol" id="bs_min" type="checkbox" autocomplete="off"></td>
					<td class="td"><input class="generatedCol" id="bs_max" type="checkbox" autocomplete="off"></td>
					<td class="td"><input class="generatedCol" id="clc" type="checkbox" autocomplete="off"></td>
					<td class="td"><input class="generatedCol" id="trf_rck" type="checkbox" autocomplete="off"></td>
					<td class="td"><input class="generatedCol" id="trf_net" type="checkbox" autocomplete="off"></td>
					<td class="td"><input class="generatedCol" id="est" type="checkbox" autocomplete="off"></td>
				</tr>
			</table>
		</div>
		<div class="div_cat">
			<table id="generatedTable"></table>
		</div>
	</div>
<?php
}
?>
</div>
