<tr id="vue_srv_<?php echo $id_cat_srv ?>" style="height: 25px;">
<?php
if(!$aut['dev'] or $id_cat_srv != 0) {
?>
	<td class="stl5"><?php echo stripslashes($vll[$id_vll]) ?></td>
	<td class="stl5">
<?php
	echo $ctg_srv[$id_lng][$id_ctg_srv];
	if($dt_srv['lgg']>0) {echo ' ('.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].')';}
?>
	</td>
	<td class="stl5">
		<span class="lnk inf<?php echo $id_cat_srv ?>srv" onmouseover="vue_elem('inf',<?php echo $id_cat_srv ?>,'srv')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $id_cat_srv ?>');"><?php echo stripslashes($nom_srv) ?></span>
	</td>
<?php
}
else{
?>
	<td class="stl4" id="srv_vll<?php echo $id_dev_srv ?>"><?php include("vue_srv_vll.php"); ?></td>
	<td class="stl4" id="srv_ctg<?php echo $id_dev_srv ?>"><?php include("vue_srv_ctg_srv.php"); ?></td>
	<td class="stl4">
		<input type="text" id="nom_srv<?php echo $id_dev_srv ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?> style="background-color: tomato; width: 100%;" value="<?php echo stripslashes($nom_srv) ?>" onChange="maj('dev_srv','nom',this.value,<?php echo $id_dev_srv ?>)" />
	</td>
<?php
}
?>
	<td class="stl3">
		<input <?php if(!$aut['dev'] or $id_cat_prs>0) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($opt_srv) {echo('checked="checked"');} ?>
			onclick="if(this.checked) {maj('dev_srv','opt','1',<?php echo $dt_srv['id'] ?>)}else{maj('dev_srv','opt','0',<?php echo $dt_srv['id'] ?>)};"
		/>
	</td>
<?php
if($dt_prs['res']==1 or $dt_prs['res']==-1 or $nb_frn_srv['total']>0 or $cnf<1) {
?>
	<td class="stl2">
<?php
	if($opt_srv==1 and ($dt_prs['res']!=0 or $dt_srv['id_frn']!=0 or $cnf<1)) {
?>
		<div id="srv_frn<?php echo $id_dev_srv; ?>" style="text-align: center;" class="frn frn_dev_frn<?php echo $dt_srv['id_frn'] ?> srv_dev_frn<?php echo $id_dev_srv ?> dsp_frn"><?php include("vue_srv_frn.php"); ?></div>
<?php
	}
?>
	</td>
<?php
}
?>
	<td class="stl3">
<?php
if($opt_srv==1) {
?>
		<span id="srv_res<?php echo $id_dev_srv ?>" class="crc_dev_srv<?php echo $id_dev_crc ?> mdl_dev_srv<?php echo $id_dev_mdl ?> jrn_dev_srv<?php echo $id_dev_jrn ?> prs_dev_srv<?php echo $id_dev_prs ?> srv_dev_srv<?php echo $id_dev_srv ?> frn_dev_srv<?php echo $dt_srv['id_frn'] ?>">
<?php
	include("vue_srv_res.php"); ?>
		</span>
<?php
}
?>
	</td>
<?php
//PAIEMENTS
if($dt_prs['res']==1 or $nb_pay_srv['total']>0) {
?>
	<td id="srv_pay_pay<?php echo $id_dev_srv ?>" class="stl3 srv_pay_pay"><?php include("vue_srv_pay.php"); ?></td>
<?php
}
?>
	<td>
		<div style="float: right; height: 22px;" onclick="vue_cmd('vue_cmd_srv<?php echo $id_dev_srv; ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_srv<?php echo $id_dev_srv; ?>" class="cmd wsn">
				<strong><?php echo $txt->srv->$id_lng; ?></strong>
				<ul>
<?php
if($aut['res'] and $opt_srv==1 and $id_ctg_prs != 19 and $id_ctg_prs != 20) {
?>
					<li onclick="ajt_pay('srv',<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->ajtpay->$id_lng; ?></li>
<?php
}
if($aut['dev']) {
	if(!$est_srv) {
?>
					<li onclick="est('srv',1,<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->est1->$id_lng; ?></li>
<?php
	}
	else{
?>
					<li onclick="est('srv',0,<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->est0->$id_lng; ?></li>
<?php
	}
}
if($aut['cat'] and $id_cat_srv == 0) {
?>
					<li onclick="grd('srv',<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->grd->$id_lng; ?></li>
<?php
}
if($aut['dev'] and $id_cat_prs == 0) {
?>
					<li onclick="sup('srv',<?php echo $id_dev_srv.','.$id_dev_prs.',0,'.$id_cat_srv ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->sup->$id_lng; ?></li>
<?php
}
?>
				</ul>
<?php
if($id_cat_srv > 0 and $aut['dev']) {
?>
				<br/>
				<strong><?php echo $txt->cat->$id_lng; ?></strong>
				<ul>
					<li onclick="act_txt('srv',<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
					<li onclick="act_trf('srv',<?php echo $id_dev_srv.','.$id_dev_prs ?>);document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->acttrf->$id_lng; ?></li>
					<li onclick="sup_cat('srv',<?php echo $id_dev_srv.','.$id_dev_prs.','.$id_dev_jrn.','.$id_dev_mdl ?> );document.getElementById('vue_cmd_srv<?php echo $id_dev_srv; ?>').style.display='none';"><?php echo $txt->supcat->$id_lng; ?></li>
				</ul>
<?php
}
?>
			</div>
		</div>
	</td>
<?php
if($cnf<1) {
?>
	<td class="stl3">
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if($date_jrn=='0000-00-00' or strtotime($dt_srv['dt_min'])>strtotime($date_jrn)) {echo 'background-color: gold';} elseif($dt_srv['dt_min']=='0000-00-00') {echo 'background-color: tomato';} ?>"
			value="<?php if($dt_srv['dt_min']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_srv['dt_min']));} ?>" onchange="maj('dev_srv','dt_min',this.value,<?php echo ($id_dev_srv.','.$id_dev_prs); ?>)"
		/>
	</td>
	<td class="stl3">
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if(strtotime($dt_srv['dt_max'])<strtotime(date("Y-m-d")) or $dt_srv['dt_max']=='0000-00-00') {echo 'background-color: tomato';} elseif($date_jrn=='0000-00-00' or strtotime($dt_srv['dt_max'])<strtotime($date_jrn)) {echo 'background-color: gold';} ?>"
			value="<?php if($dt_srv['dt_max']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_srv['dt_max']));} ?>" onchange="maj('dev_srv','dt_max',this.value,<?php echo ($id_dev_srv.','.$id_dev_prs); ?>)"
		/>
	</td>
<?php
}
?>
<td class="stl3">
	<input type="text" id="srv_frs<?php echo $id_dev_srv ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?> style="width: 35px;" value="<?php echo number_format($dt_srv['frs']*100,2); ?>" onChange="maj('dev_srv','frs',this.value/100,<?php echo $id_dev_srv ?>)" />
		%
</td>
<td id="srv_crr<?php echo $id_dev_srv ?>" class="stl5" style="text-align: center;"><?php include("vue_srv_crr.php"); ?></td>
<?php
if(isset($bss)) {
	foreach($bss as $id_bss => $base) {
		if(($cnf>0 and $vue_bss[$id_bss]==1) or $cnf<1) {
			$dt_trf = ftc_ass(select("id,trf_net,trf_rck,est","dev_srv_trf","id_srv =".$id_dev_srv." AND base",$base));
			$id_trf = $dt_trf['id'];
			$trf_rck = $dt_trf['trf_rck'];
			$trf_net = $dt_trf['trf_net'];
			$est_srv = $dt_trf['est'];
			unset($dt_trf);
			if($ty_mrq==2) {
?>
	<td class="stl3">
		<input type="text" id="srv_trf_trf_rck<?php echo $id_trf ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_srv==1) {echo 'background-color: gold;';} if($est_srv==-1 or $trf_rck<$trf_net and $trf_rck!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($trf_rck,$prm_crr_dcm[$dt_srv['crr']],'.',''); ?>"
			onChange="maj('dev_srv_trf','trf_rck',this.value,<?php echo $id_trf ?>);"
		/>
	</td>
<?php
			}
?>
	<td class="stl3">
		<input type="text" id="srv_trf_trf_net<?php echo $id_trf ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_srv==1) {echo 'background-color: gold;';} if($trf_net==0 or $est_srv==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($trf_net,$prm_crr_dcm[$dt_srv['crr']],'.',''); ?>"
			onChange="maj('dev_srv_trf','trf_net',this.value,<?php echo $id_trf ?>);"
		/>
	</td>
<?php
			if($ty_mrq==2) {
?>
	<td class="stl3" id="com_srv_trf<?php echo $id_trf ?>"><?php include("vue_trf_com.php") ?></td>
<?php
			}
		}
	}
}
?>
</tr>
<?php
unset($dt_srv);
?>
