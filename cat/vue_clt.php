<?php
$dt_clt = ftc_ass(select("*","cat_clt","id",$id));
?>
<div>
	<table>
		<tr class="vat">
			<td style="max-width: 230px;" class="tbl_prs">
				<div id="clt_grp" class="grp"><?php include("vue_clt_grp.php"); ?></div>
			</td>
			<td class="tbl_prs">
				<table style="width:100%;" class="dsg">
					<tr class="lsb">
						<td class="fwb"><?php echo $txt->clt->$id_lng.' :'; ?></td>
						<td>
							<div class="div_cat"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_clt['nom']) ?>" onChange="updateData('cat_clt','nom',this.value,<?php echo $id ?>);" /></div>
						</td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->tyclt->$id_lng.' :'; ?></td>
						<td id="clt_ctg" class="ctg_clt"><?php include("vue_clt_ctg.php"); ?></td>
					</tr>
					<tr class="tht">
						<td class="fwb"><?php echo $txt->tel->$id_lng.' :'; ?></td>
						<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 300px;" value="<?php echo stripslashes($dt_clt['tel']) ?>" onChange="updateData('cat_clt','tel',this.value,<?php echo $id ?>)" /></td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->crr->$id_lng.' :'; ?></td>
						<td id="clt_crr" class="ctg_clt"><?php include("vue_clt_crr.php"); ?></td>
					</tr>
					<tr>
						<td class="fwb"><?php echo $txt->infos->$id_lng.' :'; ?></td>
						<td><textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> style="width: 300px;" onChange="updateData('cat_clt','info',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_clt['info']) ?></textarea></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
