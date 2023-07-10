<?php
$dt_srv = ftc_ass(select("*","cat_srv","id",$id));
$vrl = $dt_srv['vrl'];
$id_ctg = $dt_srv['ctg'];
$id_vll = $dt_srv['id_vll'];
?>
<div class="tbl_prs fr_w71">
	<table width="100%" class="dsg">
		<tr>
			<td class="fwb"><?php echo $txt->srv->$id_lng; ?></td>
			<td width="95%">
				<div class="div_cmd" onclick="vue_cmd('vue_cmd_srv<?php echo $id ?>');">
<!--COMMANDES-->
					<img src="../prm/img/cmd.gif" />
					<div id="vue_cmd_srv<?php echo $id ?>" class="cmd wsn">
						<strong><?php echo $txt->cmd->$id_lng; ?></strong>
						<ul>
							<li id="copElem"><?php echo $txt->cop->$id_lng; ?></li>
							<li onclick="cop2('srv',<?php echo $id ?>);"><?php echo $txt->cop2->$id_lng; ?></li>
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
						<span class="vdfp"><?php echo $txt->vll->$id_lng.' :'; ?></span>
						<span id="srv_vll" class="vll srv_vll<?php echo $id ?>"><?php include("vue_srv_vll.php"); ?></span>
						<span class="vdfp"><?php echo $txt->ctg->$id_lng.' :'; ?></span>
						<span id="srv_ctg" class="srv_ctg<?php echo $id ?>"><?php include("vue_srv_ctg.php"); ?></span>
						<span id="srv_lgg" style="display: inline-block"><?php include("vue_srv_lgg.php"); ?></span>
						<input id="chk_res<?php echo $id ?>" class="cat_img chk_img" <?php if(!$aut['adm_res']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_srv['res']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_srv','res','1',<?php echo $id ?>)}else{maj('cat_srv','res','0',<?php echo $id ?>)};" />
						<label class="dib" for="chk_res<?php echo $id ?>"><img src="../prm/img/res.png" /></label>
					</div>
					<div class="div_cat"><input type="text" id="nom_srv_<?php echo $id ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_srv['nom']) ?>" onChange="maj('cat_srv','nom',this.value,<?php echo $id ?>);" /></div>
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
								<td><?php echo $txt->infos->$id_lng.' :'; ?></td>
								<td><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_srv['info']) ?>" onChange="maj('cat_srv','info',this.value,<?php echo $id ?>)" /></td>
							</tr>
							<tr>
								<td><?php echo $txt->altdev->$id_lng.' :'; ?></td>
								<td><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_srv['alerte']) ?>" onChange="maj('cat_srv','alerte',this.value,<?php echo $id ?>)" /></td>
							</tr>
						</table>
					</div>
					<div class="div_cat">
						<textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> onChange="maj('cat_srv','notes',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_srv['notes']) ?></textarea>
					</div>
				</div>
			</td>
		</tr>
	</table>
	<hr/>
	<div id="srv_txt" class="dsg"><?php include("vue_srv_txt.php"); ?></div>
	<hr/>
	<div id="dt_srv" class="dt_srv<?php echo $id ?>"><?php include("vue_dt_srv.php") ?></div>
</div>
<div class="div_cat2">
	<div id="srv_prs" class="up_prs tbl_prs" ><?php include("vue_srv_prs.php"); ?></div>
	<div id="srv_dev" class="srv_dev<?php echo $id ?> cat_dev tbl_prs"><?php include("vue_srv_dev.php"); ?></div>
</div>
