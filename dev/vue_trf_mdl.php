<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/rgn.php");
	$dt_mdl = ftc_ass(select("trf,vue_sgl,vue_dbl,vue_tpl,vue_qdp,com,mrq_hbr,ptl,psg,sgl,dbl_mat,dbl_twn,tpl_mat,tpl_twn,qdp","dev_mdl","id",$id_dev_mdl));
	$trf_mdl = $dt_mdl['trf'];
	if($trf_mdl){
		$vue_sgl_mdl = $dt_mdl['vue_sgl'];
		$vue_dbl_mdl = $dt_mdl['vue_dbl'];
		$vue_tpl_mdl = $dt_mdl['vue_tpl'];
		$vue_qdp_mdl = $dt_mdl['vue_qdp'];
		$com_mdl = $dt_mdl['com'];
		$mrq_hbr_mdl = $dt_mdl['mrq_hbr'];
		$ptl = $dt_mdl['ptl'];
		$psg = $dt_mdl['psg'];
		$sgl_mdl = $dt_mdl['sgl'];
		$dbl_mat_mdl = $dt_mdl['dbl_mat'];
		$dbl_twn_mdl = $dt_mdl['dbl_twn'];
		$tpl_mat_mdl = $dt_mdl['tpl_mat'];
		$tpl_twn_mdl = $dt_mdl['tpl_twn'];
		$qdp_mdl = $dt_mdl['qdp'];
		$rq_bss_mdl = select("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"vue DESC,base");
		if(num_rows($rq_bss_mdl)>0){
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)){
				$bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];
				$vue_bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['vue'];
				$mrq_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['mrq'];
			}
		}
	}
	$dt_crc = ftc_ass(select("ty_mrq","dev_crc","id",$id_dev_crc));
	$ty_mrq = $dt_crc['ty_mrq'];
}
?>
<td class="<?php if(!$trf_mdl){echo 'lslm';}else{echo'tht';} ?>" colspan="2">
<?php
	echo $txt->trfmdl->$id_lng;
?>
	<input <?php if(!$aut['dev'] or $cnf>0){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($trf_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','trf','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','trf','0',<?php echo $id_dev_mdl ?>)};" />
<?php
if($trf_mdl){
?>
	<span class="wsn">
		<strong><?php echo $txt->sgl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev'] or $psg){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_sgl_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','vue_sgl','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','vue_sgl','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->dbl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_dbl_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','vue_dbl','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','vue_dbl','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->tpl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_tpl_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','vue_tpl','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','vue_tpl','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->qdp->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_qdp_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','vue_qdp','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','vue_qdp','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->ptl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($ptl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','ptl','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','ptl','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
<?php
	if($ptl){
?>
	<span class="wsn">
		<strong><?php echo $txt->psg->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($psg){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl','psg','1',<?php echo $id_dev_mdl ?>)}else{maj('dev_mdl','psg','0',<?php echo $id_dev_mdl ?>)};" />
	</span>
<?php
	}
?>
	||
	<span class="wsn fwb">
<?php
	$bss_cnf = 0;
	echo $txt->bss->$id_lng.': ';
	if(isset($bss_mdl)){
		foreach($bss_mdl as $id_bss => $base){
			echo $base;
			if($ptl){echo '+1';}
			if(($cnf > 0 and $vue_bss_mdl[$id_bss] == 0) or $cnf < 1){
?>
		<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if($vue_bss_mdl[$id_bss]){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_mdl_bss','vue','1',<?php echo $id_bss.','.$id_dev_mdl ?>)}else{maj('dev_mdl_bss','vue','0',<?php echo $id_bss.','.$id_dev_mdl ?>)};" />
<?php
			}
			elseif($cnf > 0){
				$bss_cnf = $base;
				echo ' '.$txt->confi->$id_lng.' - ';
			}
		}
	}
	else{
?>
		<input type="button" <?php if(!$aut['dev']){echo ' disabled';} ?> value="<?php echo $txt->ajt->$id_lng; ?>" onclick="addBss('mdl',<?php echo $id_dev_mdl ?>);">
<?php
	}
?>
	</span>
<?php
}
?>
</td>
<td class="dsg">
<?php
if($trf_mdl){
?>
	<strong><?php echo $txt->comm->$id_lng.':'; ?></strong>
	<input <?php if(!$aut['dev']){echo ' disabled';} ?> <?php if($ty_mrq==1){echo 'disabled';} ?> id="mdl_com<?php echo $id_dev_mdl ?>" type="text" style="width: 35px;" value="<?php echo $com_mdl*100 ?>" onChange="maj('dev_mdl','com',this.value.replace(',','.')/100,<?php echo $id_dev_mdl ?>)"/>
	<strong>%</strong>
	<strong><?php echo '  |  '.$txt->mrq_hbr->$id_lng.':'; ?></strong>
	<input <?php if(!$aut['dev']){echo ' disabled';} ?> <?php if($ty_mrq==2){echo 'disabled';} ?> id="mdl_mrq_hbr<?php echo $id_dev_mdl ?>" type="text" style="width: 35px;" value="<?php echo $mrq_hbr_mdl*100 ?>" onChange="maj('dev_mdl','mrq_hbr',this.value.replace(',','.')/100,<?php echo $id_dev_mdl ?>)"/>
	<strong>% | </strong>
<?php
	if($vue_sgl_mdl == 1){
?>
	<strong><?php echo $txt->sgl->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_sgl<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $sgl_mdl; ?>" onchange="maj('dev_mdl','sgl',this.value,<?php echo $id_dev_mdl ?>);" />
<?php
	}
	if($vue_dbl_mdl == 1){
?>
	<strong><?php echo $txt->dbl->$id_lng.' '.$txt->mat->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_dbl_mat<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $dbl_mat_mdl; ?>" onchange="maj('dev_mdl','dbl_mat',this.value,<?php echo $id_dev_mdl ?>);" />
	<strong><?php echo $txt->dbl->$id_lng.' '.$txt->twin->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_dbl_twn<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $dbl_twn_mdl; ?>" onchange="maj('dev_mdl','dbl_twn',this.value,<?php echo $id_dev_mdl ?>);" />
<?php
	}
	if($vue_tpl_mdl == 1){
?>
	<strong><?php echo $txt->tpl->$id_lng.' '.$txt->mat->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_tpl_mat<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $tpl_mat_mdl; ?>" onchange="maj('dev_mdl','tpl_mat',this.value,<?php echo $id_dev_mdl ?>);" />
	<strong><?php echo $txt->tpl->$id_lng.' '.$txt->twin->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_tpl_twn<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $tpl_twn_mdl; ?>" onchange="maj('dev_mdl','tpl_twn',this.value,<?php echo $id_dev_mdl ?>);" />
<?php
	}
	if($vue_qdp_mdl == 1){
?>
	<strong><?php echo $txt->qdp->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="mdl_qdp<?php echo $id_dev_mdl ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $qdp_mdl; ?>" onchange="maj('dev_mdl','qdp',this.value,<?php echo $id_dev_mdl ?>);" />
<?php
	}
	if($psg){
?>
	<strong>+ SGL TL</strong>
<?php
	}
?>
	<span id="mdl_err_rmn<?php echo $id_dev_mdl ?>" class="fwb red"><?php if($bss_cnf > 0 and $sgl_mdl + ($dbl_mat_mdl + $dbl_twn_mdl) * 2 + ($tpl_mat_mdl + $tpl_twn_mdl) * 3 + $qdp_mdl * 4 != $bss_cnf + $ptl - $psg) {echo $txt->err_rmn->$id_lng;} ?></span>
	<span class="wsn fwb">
<?php
	if(isset($bss_mdl)){
		echo $txt->bss->$id_lng.'/'.$txt->mrq->$id_lng.': ';
		foreach($bss_mdl as $id_bss => $base){
			echo $base;
			if($ptl){echo '+1';}
?>
			<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="mdl_bss_mrq<?php echo $id_bss ?>" type="text" style="width: 35px;" value="<?php echo $mrq_mdl[$id_bss]*100 ?>" onChange="maj('dev_mdl_bss','mrq',this.value.replace(',','.')/100,<?php echo $id_bss ?>)"/>
			<strong>% | </strong>
<?php
		}
	}
?>
	</span>
<?php
}
?>
</td>
