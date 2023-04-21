<?php
$dt_crc = ftc_ass(select("*","cat_crc","id",$id));
?>
<div class="tbl_crc fr_w71">
	<table class="w-100">
		<tr>
			<td class="w-100">
				<table class="dsg w-100">
					<tr>
						<td class="fwb"><?php echo $txt->crc->$id_lng; ?></td>
						<td class="w-100">
							<div class="div_cmd" onclick="vue_cmd('vue_cmd_crc<?php echo $id ?>');">
<!--COMMANDES-->
								<img src="../prm/img/cmd.gif" />
								<div id="vue_cmd_crc<?php echo $id ?>" class="cmd wsn">
									<strong><?php echo $txt->cmd->$id_lng; ?></strong>
									<ul>
										<li onclick="ajt_dev(<?php echo $id ?>);"><?php echo $txt->ajtdev->$id_lng; ?></li>
										<li onclick="cop('crc',<?php echo $id ?>);"><?php echo $txt->cop->$id_lng; ?></li>
										<li onclick="cop2('crc',<?php echo $id ?>);"><?php echo $txt->cop2->$id_lng; ?></li>
<?php
if($aut['cat']) {
?>
										<li onclick="del('crc',<?php echo $id ?>);"><?php echo $txt->del->$id_lng; ?></li>
<?php
}
?>
									</ul>
								</div>
							</div>
							<div class="div_cat"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_crc_<?php echo $id ?>" value="<?php echo stripslashes($dt_crc['nom']) ?>" onchange="maj('cat_crc','nom',this.value,<?php echo $id ?>);" /></div>
						</td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->infos->$id_lng; ?></td>
						<td class="w-100">
							<table class="w-100">
								<tr>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_crc['info']) ?>" onChange="maj('cat_crc','info',this.value,<?php echo $id ?>)" /></td>
									<td class="fwb text-left"><?php echo $txt->altdev->$id_lng; ?></td>
									<td style="padding-right: 10px;"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_crc['alerte']) ?>" onChange="maj('cat_crc','alerte',this.value,<?php echo $id ?>)" /></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<div id="crc_txt"><?php include("vue_crc_txt.php"); ?></div>
			</td>
			<td class="td_cat2">
				<div class="lsb text-light">
					<strong><?php echo $txt->clts->$id_lng; ?></strong>
					<span id="crc_clt" class="clt"><?php include("vue_crc_clt.php"); ?></span>
				</div>
			</td>
		</tr>
	</table>
	<hr/>
	<div id="crc_mdl" class="mdl jrn dt_jrn prs srv hbr" style="width: 99%"><?php include("vue_crc_mdl.php"); ?></div>
</div>
<div class="div_cat3">
	<div class="up_dev tbl_crc"><?php include("vue_crc_dev.php"); ?></div>
</div>
