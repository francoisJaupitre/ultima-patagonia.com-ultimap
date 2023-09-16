<?php
$dt_jrn = ftc_ass(select("*","cat_jrn","id",$id));
?>
<div class="tbl_jrn fr_w71">
	<table class="w-100">
		<tr>
			<td class="w-100">
				<table class="dsg w-100">
					<tr>
						<td class="fwb"><?php echo $txt->jrn->$id_lng; ?></td>
						<td class="w-100">
							<div class="div_cmd" onclick="vue_cmd('vue_cmd_jrn<?php echo $id ?>');">
<!--COMMANDES-->
								<img src="../prm/img/cmd.gif" />
								<div id="vue_cmd_jrn<?php echo $id ?>" class="cmd wsn">
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
								<div class="div_cat"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_jrn_<?php echo $id ?>" style="width: 100%;" type="text" value="<?php echo stripslashes($dt_jrn['nom']) ?>" onchange="updateData('cat_jrn','nom',this.value,<?php echo $id ?>);" /></div>
							</div>
						</td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->infos->$id_lng; ?></td>
						<td class="w-100">
							<table class="w-100">
								<tr>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_jrn['info']) ?>" onChange="updateData('cat_jrn','info',this.value,<?php echo $id ?>)" /></td>
									<td class="fwb text-left"><?php echo $txt->altdev->$id_lng; ?></td>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_jrn['alerte']) ?>" onChange="updateData('cat_jrn','alerte',this.value,<?php echo $id ?>)" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div id="jrn_txt"><?php include("vue_jrn_txt.php"); ?></div>
			</td>
			<td class="td_cat2">
				<div class="lcrl text-left" style="min-width: 140px">
					<span class="fwb"><?php echo $txt->vlls->$id_lng; ?></span>
					<span id="jrn_vll" class="list_jrn_vll"><?php include("vue_jrn_vll.php"); ?></span>
				</div>
				<div class="lmcf text-left">
					<span class="fwb"><?php echo $txt->rbk->$id_lng ?></span>
					<span id="jrn_lieu" class="list_jrn_lieu"><?php include("vue_jrn_lieu.php"); ?></span>
				</div>
			</td>
		</tr>
	</table>
	<hr/>
	<div id="jrn_prs" class="list_jrn_prs list_prs_srv list_prs_hbr list_prs" style="width: 99%"><?php include("vue_jrn_prs.php"); ?></div>
</div>
<div class="div_cat3">
	<div id="jrn_mdl" class="list_mdl_jrn up_mdl tbl_mdl"><?php include("vue_jrn_mdl.php"); ?></div>
	<div id="jrn_pic" class="list_jrn_pic"><?php include("vue_jrn_pic.php"); ?></div>
	<div id="jrn_dev" class="jrn_dev<?php echo $id ?> cat_dev tbl_mdl"><?php include("vue_jrn_dev.php"); ?></div>
</div>
