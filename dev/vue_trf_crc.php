<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$dt_crc = ftc_ass(select("vue_sgl,vue_dbl,vue_tpl,vue_qdp,sgl,dbl_mat,dbl_twn,tpl_mat,tpl_twn,qdp,ptl,psg","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$vue_sgl_crc = $dt_crc['vue_sgl'];
	$vue_dbl_crc = $dt_crc['vue_dbl'];
	$vue_tpl_crc = $dt_crc['vue_tpl'];
	$vue_qdp_crc = $dt_crc['vue_qdp'];
	$sgl_crc = $dt_crc['sgl'];
	$dbl_mat_crc = $dt_crc['dbl_mat'];
	$dbl_twn_crc = $dt_crc['dbl_twn'];
	$tpl_mat_crc = $dt_crc['tpl_mat'];
	$tpl_twn_crc = $dt_crc['tpl_twn'];
	$qdp_crc = $dt_crc['qdp'];
	$ptl = $dt_crc['ptl'];
	$psg = $dt_crc['psg'];
	$rq_bss_crc = select("*","dev_crc_bss","id_crc",$id_dev_crc,"vue DESC,base");
	if(num_rows($rq_bss_crc)>0){
		while($dt_bss_crc = ftc_ass($rq_bss_crc)){
			$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
			$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			$mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
		}
	}
}
?>
<td class="lsb">
	<span class="wsn">
		<strong><?php echo $txt->sgl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev'] or $psg){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_sgl_crc){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_sgl','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','vue_sgl','0',<?php echo $id_dev_crc ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->dbl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_dbl_crc){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_dbl','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','vue_dbl','0',<?php echo $id_dev_crc ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->tpl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_tpl_crc){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_tpl','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','vue_tpl','0',<?php echo $id_dev_crc ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->qdp->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($vue_qdp_crc){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','vue_qdp','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','vue_qdp','0',<?php echo $id_dev_crc ?>)};" />
	</span>
	<span class="wsn">
		<strong><?php echo $txt->ptl->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($ptl){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','ptl','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','ptl','0',<?php echo $id_dev_crc ?>)};" />
	</span>
<?php
if($ptl){
?>
	<span class="wsn">
		<strong><?php echo $txt->psg->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if ($psg){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc','psg','1',<?php echo $id_dev_crc ?>)}else{maj('dev_crc','psg','0',<?php echo $id_dev_crc ?>)};" />
	</span>
<?php
}
?>
	||
	<span class="wsn fwb">
<?php
$bss_cnf = 0;
echo $txt->bss->$id_lng.': ';
if(isset($bss_crc)){
	foreach($bss_crc as $id_bss => $base){
		echo $base;
		if($ptl){echo '+1';}
		if(($cnf > 0 and $vue_bss_crc[$id_bss] == 0) or $cnf < 1){
?>
		<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> type="checkbox" style="margin-right: 10px;" autocomplete="off" <?php if($vue_bss_crc[$id_bss]){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_crc_bss','vue','1',<?php echo $id_bss ?>)}else{maj('dev_crc_bss','vue','0',<?php echo $id_bss ?>)};" />
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
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="button" value="<?php echo $txt->ajt->$id_lng; ?>" onclick="ajt_bss('crc',<?php echo $id_dev_crc ?>);">
<?php
}
?>
	</span>
</td>
<td class="dsg">
<?php
if($vue_sgl_crc==1){
?>
	<strong><?php echo $txt->sgl->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="crc_sgl<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $sgl_crc; ?>" onchange="maj('dev_crc','sgl',this.value,<?php echo $id_dev_crc ?>);" />
<?php
}
if($vue_dbl_crc==1){
?>
	<strong><?php echo $txt->dbl->$id_lng.' '.$txt->mat->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo' disabled';} ?> id="crc_dbl_mat<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $dbl_mat_crc; ?>" onchange="maj('dev_crc','dbl_mat',this.value,<?php echo $id_dev_crc ?>);" />
	<strong><?php echo $txt->dbl->$id_lng.' '.$txt->twin->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="crc_dbl_twn<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $dbl_twn_crc; ?>" onchange="maj('dev_crc','dbl_twn',this.value,<?php echo $id_dev_crc ?>);" />
<?php
}
if($vue_tpl_crc==1){
?>
	<strong><?php echo $txt->tpl->$id_lng.' '.$txt->mat->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="crc_tpl_mat<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $tpl_mat_crc; ?>" onchange="maj('dev_crc','tpl_mat',this.value,<?php echo $id_dev_crc ?>);" />
	<strong><?php echo $txt->tpl->$id_lng.' '.$txt->twin->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="crc_tpl_twn<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $tpl_twn_crc; ?>" onchange="maj('dev_crc','tpl_twn',this.value,<?php echo $id_dev_crc ?>);" />
<?php
}
if($vue_qdp_crc==1){
?>
	<strong><?php echo $txt->qdp->$id_lng; ?></strong>
	<input <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> id="crc_qdp<?php echo $id_dev_crc ?>"  type="number" style="width: 30px; margin-right: 10px;" value="<?php echo $qdp_crc; ?>" onchange="maj('dev_crc','qdp',this.value,<?php echo $id_dev_crc ?>);" />
<?php
}
if($psg){
?>
	<strong>+ SGL TL</strong>
<?php
}
?>
	<span id="crc_err_rmn" class="fwb red"><?php if($bss_cnf > 0 and $sgl_crc + ($dbl_mat_crc + $dbl_twn_crc) * 2 + ($tpl_mat_crc + $tpl_twn_crc) * 3 + $qdp_crc * 4 != $bss_cnf + $ptl - $psg) {echo $txt->err_rmn->$id_lng;} ?></span>
	<span class="wsn fwb">
<?php
		if(isset($bss_crc)){
			echo $txt->mrq->$id_lng.' / '.$txt->bss->$id_lng.': ';
			foreach($bss_crc as $id_bss => $base){
				echo $base;
				if($ptl){echo '+1';}
?>
			<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="crc_bss_mrq<?php echo $id_bss ?>" type="text" style="width: 35px;" value="<?php echo $mrq_crc[$id_bss]*100 ?>" onChange="maj('dev_crc_bss','mrq',this.value.replace(',','.')/100,<?php echo $id_bss ?>)"/>
			<strong>% - </strong>
<?php
			}
		}
?>
	</span>
</td>
