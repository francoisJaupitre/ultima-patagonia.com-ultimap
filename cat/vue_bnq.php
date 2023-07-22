<?php
$dt_bnq = ftc_ass(select("*","cat_bnq","id",$id));
?>
<div class="tbl_prs" style="width: 300px;">
	<table class="w-100">
		<tr class="tht">
			<td class="fwb"><?php echo $txt->bnq->$id_lng.' :'; ?></td>
			<td>
				<div class="div_cat"><input type="text" id="nom_bnq" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_bnq['nom']) ?>" onChange="updateData('cat_bnq','nom',this.value,<?php echo $id ?>);" /></div>
			</td>
		</tr>
		<tr>
			<td class="dsg fwb"><?php echo $txt->pays->$id_lng.' :'; ?></td>
			<td id="bnq_pays"><?php include("vue_bnq_pays.php"); ?></td>
		</tr>
	</table>
</div>
