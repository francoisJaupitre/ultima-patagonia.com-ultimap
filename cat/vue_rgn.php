<?php
$dt_rgn = ftc_ass(select("*","cat_rgn","id",$id));
?>
<div class="tbl_crc" style="width: 450px;">
	<table class="w-100">
		<tr class="lsb">
			<td style="font-weight: bold; width: 100px;"><?php echo $txt->rgn->$id_lng.' :'; ?></td>
			<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_rgn" style="width: 150px;" value="<?php echo stripslashes($dt_rgn['nom']) ?>" onChange="updateData('cat_rgn','nom',this.value,<?php echo $id ?>);" /></td>
		</tr>
		<tr>
			<td class="dsg fwb">
				<span <?php if(!empty($dt_rgn['web'])) { ?> class="lnk" onclick="window.open('<?php echo $dt_rgn['web']; ?>');" <?php } ?>><?php echo $txt->web->$id_lng.' :'; ?></span>
			</td>
			<td>
				<div class="div_cat"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_rgn['web']) ?>" onChange="updateData('cat_rgn','web',this.value,<?php echo $id.','.$id ?>)" /></div>
			</td>
		</tr>
	</table>
</div>
