<?php
$dt_mdl = ftc_ass(sel_quo("*","cat_mdl","id",$id));
$sel_mdl_jrn = $dt_mdl['sel_mdl_jrn'];
?>
<div class="tbl_mdl fr_w71">
	<table class="w-100">
		<tr>
			<td class="w-100">
				<table class="dsg w-100">
					<tr>
						<td class="fwb"><?php echo $txt->mdl->$id_lng; ?></td>
						<td class="w-100">
							<div class="div_cmd" onclick="vue_cmd('vue_cmd_mdl<?php echo $id ?>');">
<!--COMMANDES-->
								<img src="../prm/img/cmd.gif" />
								<div id="vue_cmd_mdl<?php echo $id ?>" class="cmd wsn">
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
							<div class="div_cat"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_mdl_<?php echo $id ?>" style="width: 100%;" type="text" value="<?php echo stripslashes($dt_mdl['nom']) ?>" onchange="maj('cat_mdl','nom',this.value,<?php echo $id ?>);" /></div>
						</td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->infos->$id_lng; ?></td>
						<td class="w-100">
							<table class="w-100">
								<tr>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_mdl['info']) ?>" onChange="maj('cat_mdl','info',this.value,<?php echo $id ?>)" /></td>
									<td class="fwb text-right"><?php echo $txt->altdev->$id_lng; ?></td>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_mdl['alerte']) ?>" onChange="maj('cat_mdl','alerte',this.value,<?php echo $id ?>)" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div id="mdl_txt"><?php include("vue_mdl_txt.php"); ?></div>
			</td>
			<td class="td_cat2">
				<div class="lslm text-left">
					<strong><?php echo $txt->rgns->$id_lng; ?></strong>
					<span id="mdl_rgn" class="rgn"><?php include("vue_mdl_rgn.php"); ?></span>
				</div>
			</td>
		</tr>
	</table>
	<hr/>
	<div id="mdl_jrn" class="jrn dt_jrn prs" style="width: 99%"><?php include("vue_mdl_jrn.php"); ?></div>
</div>
<div class="div_cat3">
	<div id="mdl_crc" class="up_crc tbl_crc"><?php include("vue_mdl_crc.php"); ?></div>
	<div id="mdl_dev" class="mdl_dev<?php echo $id ?> cat_dev tbl_crc"><?php include("vue_mdl_dev.php"); ?></div>
</div>
