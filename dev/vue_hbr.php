<?php
$id_hbr = $dt_hbr['id_cat'];
$id_chm = $dt_hbr['id_cat_chm'];
$nom_hbr = $dt_hbr['nom'];
$nom_chm = $dt_hbr['nom_chm'];
?>
<tr style="height: 25px;">
<?php
if(!$aut['dev'] or $id_hbr != 0) {
?>
	<td class="stl5"><?php if($id_vll > 0) {echo stripslashes($vll[$id_vll]);} else{echo $txt->vll->$id_lng;} ?></td>
	<td class="stl5"><?php if($id_rgm > 0) {echo $rgm[$id_lng][$id_rgm];} else{echo $txt->rgm->$id_lng;} ?></td>
<?php
}
else{
?>
	<td id="hbr_vll<?php echo $id_dev_hbr ?>" class="stl4 vll"><?php include("vue_hbr_vll.php"); ?></td>
	<td id="hbr_rgm<?php echo $id_dev_hbr ?>" class="stl4"><?php include("vue_hbr_rgm.php"); ?></td>
<?php
}
?>
	<td id="hbr_hbr<?php echo $id_dev_hbr ?>" class="stl5 wsn"><?php include("vue_hbr_hbr.php"); ?></td>
	<td id="hbr_chm<?php echo $id_dev_hbr ?>" class="stl5 wsn"><?php include("vue_hbr_chm.php"); ?></td>
	<td class="stl3">
		<input type="text" id="hbr_frs<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?> style="width: 35px;" value="<?php echo number_format($dt_hbr['frs']*100,2); ?>" onChange="maj('dev_hbr','frs',this.value/100,<?php echo $id_dev_hbr ?>)" />
			%
	</td>
	<td class="stl5" style="text-align: center;">
<?php
if($id_hbr>-2 and $id_chm>-2) {
?>
		<span id="chm_crr<?php echo $id_dev_hbr ?>"><?php include("vue_hbr_chm_crr.php"); ?></span>
<?php
	if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<span id="rgm_crr<?php echo $id_dev_hbr ?>"><?php include("vue_hbr_rgm_crr.php"); ?></span>
<?php
	}
}
?>
	</td>
<?php
if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_db_rck_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($est_chm==-1 or $dt_hbr['db_rck_chm']<$dt_hbr['db_net_chm'] and $dt_hbr['db_rck_chm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['db_rck_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','db_rck_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_db_rck_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($est_rgm==-1 or $dt_hbr['db_rck_rgm']<$dt_hbr['db_net_rgm'] and $dt_hbr['db_rck_chm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['db_rck_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','db_rck_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		}
	}
?>
	</td>
<?php
}
?>
	<td class="stl3">
<?php
if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_db_net_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($dt_hbr['db_net_chm']==0 or $est_chm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['db_net_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','db_net_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
	if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_db_net_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($dt_hbr['db_net_rgm']==0 or $est_rgm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['db_net_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','db_net_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
	}
}
?>
	</td>
<?php
if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
		$trf_rck = $dt_hbr['db_rck_chm'];
		$trf_net = $dt_hbr['db_net_chm'];
?>
		<span id="com_db_chm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
		if($dt_hbr['crr_rgm']!=0) {
			$trf_rck = $dt_hbr['db_rck_rgm'];
			$trf_net = $dt_hbr['db_net_rgm'];
?>
		<br />
		<span id="com_db_rgm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
		}
	}
?>
	</td>
<?php
}
if($vue_sgl) {
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_sg_rck_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($est_chm==-1 or $dt_hbr['sg_rck_chm']<$dt_hbr['sg_net_chm'] and $dt_hbr['sg_net_chm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['sg_rck_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','sg_rck_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_sg_rck_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($est_rgm==-1 or $dt_hbr['sg_rck_rgm']<$dt_hbr['sg_net_rgm'] and $dt_hbr['sg_net_rgm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['sg_rck_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','sg_rck_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			}
		}
?>
	</td>
<?php
	}
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_sg_net_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($dt_hbr['sg_net_chm']==0 or $est_chm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['sg_net_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','sg_net_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_sg_net_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($dt_hbr['sg_net_rgm']==0 or $est_rgm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['sg_net_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','sg_net_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		}
	}
?>
	</td>
<?php
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
			$trf_rck = $dt_hbr['sg_rck_chm'];
			$trf_net = $dt_hbr['sg_net_chm'];
?>
		<span id="com_sg_chm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			if($dt_hbr['crr_rgm']!=0) {
				$trf_rck = $dt_hbr['sg_rck_rgm'];
				$trf_net = $dt_hbr['sg_net_rgm'];
?>
		<br />
		<span id="com_sg_rgm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			}
		}
?>
	</td>
<?php
	}
}
if($vue_tpl) {
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_tp_rck_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($est_chm==-1 or $dt_hbr['tp_rck_chm']<$dt_hbr['tp_net_chm'] and $dt_hbr['tp_net_chm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['tp_rck_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','tp_rck_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_tp_rck_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($est_rgm==-1 or $dt_hbr['tp_rck_rgm']<$dt_hbr['tp_net_rgm'] and $dt_hbr['tp_net_rgm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['tp_rck_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','tp_rck_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			}
		}
?>
	</td>
<?php
	}
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_tp_net_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($dt_hbr['tp_net_chm']==0 or $est_chm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['tp_net_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','tp_net_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_tp_net_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($dt_hbr['tp_net_rgm']==0 or $est_rgm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['tp_net_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','tp_net_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		}
	}
?>
	</td>
<?php
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
			$trf_rck = $dt_hbr['tp_rck_chm'];
			$trf_net = $dt_hbr['tp_net_chm'];
?>
			<span id="com_tp_chm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			if($dt_hbr['crr_rgm']!=0) {
				$trf_rck = $dt_hbr['tp_rck_rgm'];
				$trf_net = $dt_hbr['tp_net_rgm'];
?>
			<br />
			<span id="com_tp_rgm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			}
		}
?>
	</td>
<?php
	}
}
if($vue_qdp) {
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_qd_rck_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($est_chm==-1 or $dt_hbr['qd_rck_chm']<$dt_hbr['qd_net_chm'] and $dt_hbr['qd_rck_chm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['qd_rck_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','qd_rck_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_qd_rck_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($est_rgm==-1 or $dt_hbr['qd_rck_rgm']<$dt_hbr['qd_net_rgm'] and $dt_hbr['qd_rck_rgm']!=0) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['qd_rck_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','qd_rck_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
			}
		}
?>
	</td>
<?php
	}
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input type="text" id="hbr_qd_net_chm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_chm==1) {echo 'background-color: gold;';} if($dt_hbr['qd_net_chm']==0 or $est_chm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['qd_net_chm'],$prm_crr_dcm[$dt_hbr['crr_chm']],'.','') ?>"
			onChange="maj('dev_hbr','qd_net_chm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input type="text" id="hbr_qd_net_rgm<?php echo $id_dev_hbr ?>" <?php if(!$aut['dev']) {echo ' disabled';} ?>
			class="w52" style="<?php if($est_rgm==1) {echo 'background-color: gold;';} if($dt_hbr['qd_net_rgm']==0 or $est_rgm==-1) {echo 'background-color: tomato;';} ?>"
			value="<?php echo number_format($dt_hbr['qd_net_rgm'],$prm_crr_dcm[$dt_hbr['crr_rgm']],'.','') ?>"
			onChange="maj('dev_hbr','qd_net_rgm',this.value,<?php echo $id_dev_hbr ?>)"
		/>
<?php
		}
	}
?>
	</td>
<?php
	if($ty_mrq==2) {
?>
	<td class="stl3">
<?php
		if($id_hbr>-2 and $id_chm>-2) {
			$trf_rck = $dt_hbr['qd_rck_chm'];
			$trf_net = $dt_hbr['qd_net_chm'];
?>
		<span id="com_qd_chm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			if($dt_hbr['crr_rgm']!=0) {
				$trf_rck = $dt_hbr['tp_rck_rgm'];
				$trf_net = $dt_hbr['tp_net_rgm'];
?>
		<br />
		<span id="com_tp_rgm<?php echo $id_dev_hbr ?>"><?php include("vue_trf_com.php") ?></span>
<?php
			}
		}
?>
</td>
<?php
	}
}
if($cnf<1) {
?>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if($date_jrn=='0000-00-00' or strtotime($dt_hbr['dt_min_chm'])>strtotime($date_jrn)) {echo 'background-color: gold';} elseif($dt_hbr['dt_min_chm']=='0000-00-00') {echo 'background-color: tomato';} ?>"
			value="<?php if($dt_hbr['dt_min_chm']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_hbr['dt_min_chm']));} ?>"
			onchange="maj('dev_hbr','dt_min_chm',this.value,<?php echo ($id_dev_hbr.','.$id_dev_prs); ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if($date_jrn=='0000-00-00' or strtotime($dt_hbr['dt_min_rgm'])>strtotime($date_jrn)) {echo 'background-color: gold';} elseif($dt_hbr['dt_min_rgm']=='0000-00-00') {echo 'background-color: tomato';} ?>"
			value="<?php if($dt_hbr['dt_min_rgm']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_hbr['dt_min_rgm']));} ?>"
			onchange="maj('dev_hbr','dt_min_rgm',this.value,<?php echo ($id_dev_hbr.','.$id_dev_prs); ?>)"
		/>
<?php
		}
	}
?>
	</td>
	<td class="stl3">
<?php
	if($id_hbr>-2 and $id_chm>-2) {
?>
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if(strtotime($dt_hbr['dt_max_chm'])<strtotime(date("Y-m-d")) or $dt_hbr['dt_max_chm']=='0000-00-00') {echo 'background-color: tomato';} elseif($date_jrn=='0000-00-00' or strtotime($dt_hbr['dt_max_chm'])<strtotime($date_jrn)) {echo 'background-color: gold';} ?>"
		 	value="<?php if($dt_hbr['dt_max_chm']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_hbr['dt_max_chm']));} ?>"
			onchange="maj('dev_hbr','dt_max_chm',this.value,<?php echo ($id_dev_hbr.','.$id_dev_prs); ?>)"
		/>
<?php
		if($dt_hbr['crr_rgm']!=0) {
?>
		<br />
		<input <?php if(!$aut['dev']) {echo ' disabled';} ?> type="text" class="w74"
			style="<?php if(strtotime($dt_hbr['dt_max_rgm'])<strtotime(date("Y-m-d")) or $dt_hbr['dt_max_rgm']=='0000-00-00') {echo 'background-color: tomato';} elseif($date_jrn=='0000-00-00' or strtotime($dt_hbr['dt_max_rgm'])<strtotime($date_jrn)) {echo 'background-color: gold';} ?>"
			value="<?php if($dt_hbr['dt_max_rgm']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_hbr['dt_max_rgm']));} ?>"
			onchange="maj('dev_hbr','dt_max_rgm',this.value,<?php echo ($id_dev_hbr.','.$id_dev_prs); ?>)"
		/>
<?php
		}
	}
?>
	</td>
<?php
}
?>
	<td class="stl3">
		<input <?php if(!$aut['dev'] or $opt_hbr) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($opt_hbr) {echo('checked="checked"');} ?>
			onclick="maj('dev_hbr','opt','1',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);searchHbr(<?php echo $id_cat_hbr.','.$id_cat_chm.',0,'.$id_rgm.','.$id_dev_hbr.','.$id_dev_prs ?>,'opt');"
		/>
	</td>
<?php
if($cnf>0) {
?>
	<td class="stl3">
		<input <?php if(!$aut['res'] or $sel_hbr) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($sel_hbr) {echo('checked="checked"');} ?>
			onclick="maj('dev_hbr','sel','1',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);searchHbr(<?php echo $id_cat_hbr.','.$id_cat_chm.',0,'.$id_rgm.','.$id_dev_hbr.','.$id_dev_prs ?>,'sel');"
		/>
	</td>
<?php
}
?>
	<td class="stl3">
<?php
if(($sel_hbr==1 or $dt_hbr['res']!=0 or $cnf<1) and $id_hbr > -1 and $id_chm > -2) {
?>
		<span id="hbr_res<?php echo $id_dev_hbr ?>" class="crc_dev_hbr<?php echo $id_dev_crc ?> mdl_dev_hbr<?php echo $id_dev_mdl ?> jrn_dev_hbr<?php echo $id_dev_jrn ?> prs_dev_hbr<?php echo $id_dev_prs ?> hbr_dev_hbr<?php echo $id_dev_hbr ?> cat_dev_hbr<?php echo $id_cat_hbr ?>"><?php include("vue_hbr_res.php"); ?></span>
<?php
}
?>
	</td>
<?php
//PAIEMENTS
if($cnf >0 or $nb_pay_hbr['total']>0) {
?>
	<td id="hbr_pay_pay<?php echo $id_dev_hbr ?>" class="stl3 hbr_pay_pay"><?php include("vue_hbr_pay.php"); ?></td>
<?php
}
?>
	<td>
		<div style="float: right; height: 22px;" onclick="vue_cmd('vue_cmd_hbr<?php echo $id_dev_hbr; ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_hbr<?php echo $id_dev_hbr; ?>" class="cmd wsn">
				<div>
					<strong><?php echo $txt->hbr->$id_lng; ?></strong>
					<ul>
<?php
if($id_cat_hbr >-1 and $aut['res']) {
?>
						<li onclick="ajt_pay('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->ajtpay->$id_lng; ?></li>
<?php
}
if($aut['dev'] and ($dt_hbr['res'] == 0 or $cnf<1) and $id_cat_hbr != -1) {
?>
						<li onclick="maj('dev_hbr','id_cat','-1',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);maj('dev_hbr','id_cat_chm','0',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);"><?php echo $txt->majhbr->$id_lng; ?></li>
<?php
	if($id_cat_hbr > 0 and $id_cat_chm != -1) {
?>
						<li onclick="maj('dev_hbr','id_cat_chm','-1',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);"><?php echo $txt->majchm->$id_lng; ?></li>
<?php
	}
}
if($aut['dev']) {
	if(!$est_chm or !$est_rgm) {
?>
						<li onclick="est('hbr',1,<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->est1->$id_lng; ?></li>
<?php
	}
	if($est_chm or $est_rgm) {
?>
						<li onclick="est('hbr',0,<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->est0->$id_lng; ?></li>
<?php
	}
}
if($aut['cat']) {
	if($id_cat_hbr == 0) {
?>
						<li onclick="saveToCat('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->grdhbr->$id_lng; ?></li>
<?php
	}
	elseif($id_cat_hbr > 0 and $id_cat_chm == 0) {
?>
						<li onclick="saveToCat('chm',<?php echo $id_dev_hbr.','.$id_dev_prs.','.$id_cat_hbr ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->grdchm->$id_lng; ?></li>
<?php
	}
}
if($opt_hbr == 0 and ((($aut['dev'] || $aut['res']) and $cnf<1) or ($aut['res'] and $cnf>0 and $sel_hbr==0))) {
?>
						<li onclick="sup('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs.',0,'.$id_cat_hbr.',0,'.$id_cat_chm ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->sup->$id_lng; ?></li>
<?php
}
?>
					</ul>
<?php
if($id_cat_hbr > 0 and $aut['dev']) {
?>
					<br/>
					<strong><?php echo $txt->cat->$id_lng; ?></strong>
					<ul>
						<li onclick="prevUpdateText('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
						<li onclick="prevUpdateRates('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs ?>);document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
	if($opt_hbr == 0) {
?>
						<li onclick="sup_cat('hbr',<?php echo $id_dev_hbr.','.$id_dev_prs.','.$id_dev_jrn.','.$id_dev_mdl ?> );document.getElementById('vue_cmd_hbr<?php echo $id_dev_hbr; ?>').style.display='none';"><?php echo $txt->supcat->$id_lng; ?></li>
<?php
	}
?>
					</ul>
<?php
}
?>
				</div>
			</div>
		</div>
	</td>
</tr>
