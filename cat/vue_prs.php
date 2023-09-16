<?php
$dt_prs = ftc_ass(select("*","cat_prs","id",$id));
?>
<div class="tbl_prs fr_w71">
	<table class="w-100">
		<tr>
			<td class="w-100">
				<table class="dsg w-100">
					<tr>
						<td class="fwb"><?php echo $txt->prs->$id_lng; ?></td>
						<td class="w-100">
							<div class="div_cmd" onclick="vue_cmd('vue_cmd_prs<?php echo $id ?>');">
<!--COMMANDES-->
								<img src="../prm/img/cmd.gif" />
								<div id="vue_cmd_prs<?php echo $id ?>" class="cmd wsn">
									<strong><?php echo $txt->cmd->$id_lng; ?></strong>
									<ul>
										<li id="copElem"><?php echo $txt->cop->$id_lng; ?></li>
										<li id="lightCopElem"><?php echo $txt->cop2->$id_lng; ?></li>
<?php
if($aut['cat']) {
?>
										<li id="delElem"><?php echo $txt->del->$id_lng; ?></li>
<?php
}
?>
									</ul>
								</div>
							</div>
							<div class="div_cat">
								<div style="float:right; padding-left: 5px;">
									<span id="prs_ctg" style="display: inline-block"><?php include("vue_prs_ctg.php"); ?></span>
									<span class="vatdib">
										<strong><?php echo $txt->out->$id_lng; ?></strong>
										<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_prs['is_out']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_prs','is_out','1',<?php echo $id ?>)}else{updateData('cat_prs','is_out','0',<?php echo $id ?>)};" />
										<strong><?php echo $txt->duree->$id_lng; ?></strong>
										<input id="prs_duree<?php echo $id; ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> type="time" value="<?php if(!is_null($dt_prs['duree'])) {echo date("H:i", strtotime($dt_prs['duree']));} ?>" onblur="updateData('cat_prs','duree',this.value,<?php echo $id ?>);" />
										<input id="prs_jours<?php echo $id; ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $dt_prs['jours']; ?>" onchange="updateData('cat_prs','jours',this.value,<?php echo $id ?>);" />
										<strong><?php echo $txt->jours->$id_lng; ?></strong>
									</span>
								</div>
								<div class="div_cat"><input type="text" id="nom_prs_<?php echo $id ?>" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_prs['nom']) ?>" autocomplete="off" onchange="updateData('cat_prs','nom',this.value,<?php echo $id ?>);" /></div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->notes->$id_lng; ?></td>
						<td width="95%">
							<div class="div_cat">
								<div style="float:right; padding-left: 5px;" class="fwb">
									<table>
										<tr>
											<td><?php echo $txt->ref->$id_lng.' :'; ?></td>
											<td><input type="text" style="width: 100%;" <?php if(!$aut['adm_res']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_prs['ref']) ?>" onChange="updateData('cat_prs','ref',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td><?php echo $txt->infos->$id_lng.' :'; ?></td>
											<td><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_prs['info']) ?>" onChange="updateData('cat_prs','info',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td><?php echo $txt->altdev->$id_lng.' :'; ?></td>
											<td><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_prs['alerte']) ?>" onChange="updateData('cat_prs','alerte',this.value,<?php echo $id ?>)" /></td>
										</tr>
									</table>
								</div>
								<div class="div_cat">
									<textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> style="min-height: 75px;" onChange="updateData('cat_prs','notes',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_prs['notes']) ?></textarea>
								</div>
							</div>
						</td>
					</tr>
				</table>
				<div id="prs_txt"><?php include("vue_prs_txt.php"); ?></div>
				<hr/>
				<div>
					<div id="prs_srv" class="list_prs_srv list_srv"><?php include("vue_prs_srv.php"); ?></div>
					<div id="prs_hbr" class="list_prs_hbr"><?php include("vue_prs_hbr.php"); ?></div>
<?php
if($aut['cat']) {
?>
					<div class="dsg fwb"><?php echo $txt->ajt->$id_lng.' :'; ?></div>
					<div id="prs_vll_ctg" class="vll srv dsg"><?php include("vue_prs_vll_ctg.php"); ?></div>
<?php
}
?>
				</div>
			</td>
			<td class="td_cat2">
				<div class="lmcf text-left">
					<div style="float: right; margin-right:15px" class="fwb"><?php echo $txt->mrk->$id_lng.'<br />'.$txt->resa->$id_lng; ?></div>
					<div style="margin-left:30px" class="fwb"><?php echo $txt->lieux->$id_lng; ?></div>
					<span id="prs_lieu" class="list_prs_lieu"><?php include("vue_prs_lieu.php"); ?></span>
				</div>
			</td>
		</tr>
	</table>
</div>
<div class="div_cat2">
	<div id="prs_jrn" class="list_jrn_prs up_jrn tbl_jrn" ><?php include("vue_prs_jrn.php"); ?></div>
	<div id="prs_dev" class="prs_dev<?php echo $id ?> cat_dev tbl_jrn"><?php include("vue_prs_dev.php"); ?></div>
</div>
