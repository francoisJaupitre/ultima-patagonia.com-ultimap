<table>
	<tr>
		<td class="fwb">
<?php
echo $txt->contact->$id_lng.'<br/>';
?>
			<span <?php if($id_frn) { ?> class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn ?>');" <?php } ?>><?php echo $txt->frn->$id_lng.':'; ?></span>
		</td>
		<td>
<?php
if(!$aut['cat'] or $vrl) {
	if($id_frn) {echo $frn[$id_frn];}
	else{echo $txt->unique->$id_lng;}
}
else{
?>
			<div class="sel" onclick="vue_cmd('sel_frn')">
				<img src="../prm/img/sel.png" />
				<div>
<?php
	if($id_frn) {echo $frn[$id_frn];}
	else{echo $txt->unique->$id_lng;}
?>
				</div>
			</div>
			<div id="sel_frn" class="cmd mw200">
				<div><input type="text" id="ipt_sel_frn" onkeyup="auto_lst('hbr','frn',this.value,event);" /></div>
				<div id="lst_frn"><?php include("vue_lst_frn.php") ?></div>
			</div>
<?php
}
?>
		</td>
	</tr>
<?php
if(!$id_frn) {
	$mel_hbr = $dt_hbr['mail'];
	$ctc_hbr = $dt_hbr['contact'];
	$tel_hbr = $dt_hbr['tel_res'];
	$ctg_res_hbr = $dt_hbr['ctg_res'];
	$bnq_hbr = $dt_hbr['bnq'];
	$id_bnq_hbr = $dt_hbr['id_bnq'];
	$frs_hbr = $dt_hbr['frs'];
	$notfrs_hbr = $dt_hbr['notfrs'];
}
else{
	$dt_frn = ftc_ass(select("*","cat_frn","id",$id_frn));
	$mel_hbr = $dt_frn['mail'];
	$ctc_hbr = $dt_frn['contact'];
	$tel_hbr = $dt_frn['tel'];
	$ctg_res_hbr = $dt_frn['ctg_res'];
	$bnq_hbr = $dt_frn['bnq'];
	$id_bnq_hbr = $dt_frn['id_bnq'];
	$frs_hbr = $dt_frn['frs'];
	$notfrs_hbr = $dt_frn['notfrs'];
}
?>
	<tr>
		<td id="hbr_mail" class="fwb"><?php include("vue_hbr_mail.php"); ?></td>
		<td><input type="text" <?php if(!$aut['cat'] or $id_frn) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($mel_hbr) ?>" onChange="maj('cat_hbr','mail',this.value,<?php echo $id ?>)" /></td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->contact->$id_lng.':'; ?></td>
		<td><input type="text" <?php if(!$aut['cat'] or $id_frn) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($ctc_hbr) ?>" onChange="maj('cat_hbr','contact',this.value,<?php echo $id ?>)" /></td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->telres->$id_lng.':'; ?></td>
		<td><input type="text" <?php if(!$aut['cat'] or $id_frn) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($tel_hbr) ?>" onChange="maj('cat_hbr','tel_res',this.value,<?php echo $id ?>)" /></td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->res->$id_lng.':'; ?></td>
		<td id="hbr_ctg_res"><?php include("vue_hbr_ctg_res.php"); ?></td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->bnq->$id_lng.':'; ?></td>
		<td id="hbr_bnq" class="bnq"><?php include("vue_hbr_bnq.php"); ?></td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->infosbnq->$id_lng.':'; ?></td>
		<td>
			<textarea <?php if(!$aut['cat'] or $id_frn) {echo ' readonly';} ?> style="height: 100px;" onChange="maj('cat_hbr','bnq',this.value,<?php echo $id ?>)"><?php echo stripslashes($bnq_hbr) ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="fwb"><?php echo $txt->frsfin->$id_lng.':'; ?></td>
		<td>
			<div class="wsn">
				<input <?php if(!$aut['adm_fin'] or $id_frn) {echo ' disabled';} ?> id="hbr_frs<?php echo $id ?>" type="text" style="width: 35px;" value="<?php echo $frs_hbr*100 ?>" onChange="maj('cat_hbr','frs',this.value,<?php echo $id ?>)" />
				%
				<input type="text" <?php if(!$aut['adm_fin'] or $id_frn) {echo ' disabled';} ?> value="<?php echo stripslashes($notfrs_hbr) ?>" onChange="maj('cat_hbr','notfrs',this.value,<?php echo $id ?>)" />
			</div>
		</td>
	</tr>
</table>
