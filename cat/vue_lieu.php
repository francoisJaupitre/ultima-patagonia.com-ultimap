<?php
$dt_lieu = ftc_ass(select("*","cat_lieu","id",$id));
$id_vll = $dt_lieu['id_vll'];
?>
<div>
	<table style="padding: 0px 5px;">
		<tr>
			<td>
				<table class="tbl_prs">
					<tr>
						<td class="dsg" style="font-weight: bold; width: 100px;"><?php echo $txt->lieu->$id_lng; ?></td>
						<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_lieu" style="width: 150px;" value="<?php echo stripslashes($dt_lieu['nom']) ?>" onChange="updateData('cat_lieu','nom',this.value,<?php echo $id ?>);" /></td>
					</tr>
					<tr class="lmcf">
						<td style="font-weight: bold; width: 100px;"><?php echo $txt->mrk->$id_lng.'<BR />'.$txt->rpr->$id_lng; ?></td>
						<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_lieu['rpr']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_lieu','rpr','1',<?php echo $id ?>)}else{updateData('cat_lieu','rpr','0',<?php echo $id ?>)};" /></td>
					</tr>
					<tr class="lmcf">
						<td style="font-weight: bold; width: 100px;"><?php echo $txt->mrk->$id_lng.'<BR />'.$txt->rbk->$id_lng; ?></td>
						<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_lieu['rbk']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_lieu','rbk','1',<?php echo $id ?>)}else{updateData('cat_lieu','rbk','0',<?php echo $id ?>)};" /></td>
					</tr>
					<tr class="lmcf">
						<td style="font-weight: bold; width: 100px;"><?php echo $txt->hbr->$id_lng; ?></td>
						<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_lieu['hbr']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_lieu','hbr','1',<?php echo $id ?>)}else{updateData('cat_lieu','hbr','0',<?php echo $id ?>)};" /></td>
					</tr>
					<tr class="lmcf">
						<td style="font-weight: bold; width: 100px;"><?php echo $txt->apt->$id_lng; ?></td>
						<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_lieu['apt']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_lieu','apt','1',<?php echo $id ?>)}else{updateData('cat_lieu','apt','0',<?php echo $id ?>)};" /></td>
					</tr>
					<tr class="lmcf">
						<td class="fwb"><?php echo $txt->vll->$id_lng; ?></td>
						<td id="lieu_vll" class="vll"><?php include("vue_lieu_vll.php"); ?></td>
					</tr>
				</table>
				<div class="tbl_prs">
					<div id="lieu_txt" class="lmcf"><?php include("vue_lieu_txt.php"); ?></div>
					<div id="lieu_prs" class="up_prs"><?php include("vue_lieu_prs.php"); ?></div>
				</div>
			</td>
			<td class="tbl_prs w-100">
				<input type="text" id="lieu_lat<?php echo $id ?>" style="width: 60px" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo $dt_lieu['lat']; ?>" onChange="updateData('cat_lieu','lat',this.value,<?php echo $id.',0' ?>);">(N+/S-)<br/>
				<input type="text" id="lieu_lon<?php echo $id ?>" style="width: 60px" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo $dt_lieu['lon']; ?>" onChange="updateData('cat_lieu','lon',this.value,<?php echo $id.',0' ?>);">(E+/W-)
				<div id="map" style="width: 100%; height: 580px;"></div>
			</td>
		</tr>
	</table>
</div>
