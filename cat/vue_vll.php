<?php
$dt_vll = ftc_ass(select("*","cat_vll","id",$id));
?>
<div class="tbl_prs" style="float:right;">
	<div class="tbl_prs">
		<div class="tht fwb"><?php echo $txt->defhbr->$id_lng.' :'; ?></div>
		<table class="dsg">
<?php
foreach($hbr_def[$id_lng] as $id_hbr_def => $nom_hbr_def) {
?>
			<tr>
				<td colspan="3" style="font-weight: bold; text-align: center"><?php echo $nom_hbr_def; ?></td>
			</tr>
<?php
	foreach($rgm[$id_lng] as $id_rgm => $nom_rgm) {
		$dt_vll_hbr = ftc_ass(select("id_hbr,id_chm","cat_vll_hbr","id_vll=".$id." AND hbr_def=".$id_hbr_def." AND rgm",$id_rgm));
		$id_hbr = $dt_vll_hbr['id_hbr'];
		$id_chm = $dt_vll_hbr['id_chm'];
?>
			<tr>
				<td><?php echo $nom_rgm; ?></td>
				<td>
					<table>
						<tr id="vll_hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>" class="hbr"><?php include("vue_vll_hbr.php"); ?></tr>
					</table>
				</td>
			</tr>
<?php
	}
?>
			<tr>
				<td colspan="3" class="fwb"><hr/></td>
			</tr>
<?php
}
?>
		</table>
	</div>
</div>
<div class="div_cat2">
	<div class="tbl_jrn">
		<table style="padding: 0px 5px;" class="w-100">
			<tr>
				<td class="vat">
					<table class="dsg w-100">
						<tr>
							<td class="fwb"><?php echo $txt->vll->$id_lng; ?></td>
							<td class="w-100"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_vll" style="min-width: 150px;" value="<?php echo stripslashes($dt_vll['nom']) ?>" onChange="updateData('cat_vll','nom',this.value,<?php echo $id ?>);" /></td>
						</tr>
						<tr>
							<td class="fwb"><?php echo $txt->rgn->$id_lng; ?></td>
							<td id="vll_rgn" class="rgn"><?php include("vue_vll_rgn.php"); ?></td>
						</tr>
						<tr>
							<td class="fwb"><?php echo $txt->pays->$id_lng; ?></td>
							<td id="vll_pays" class="pays"><?php include("vue_vll_pays.php"); ?></td>
						</tr>
					</table>
				</td>
				<td class="w-100">
					<div id="vll_txt"><?php include("vue_vll_txt.php"); ?></div>
				</td>
			</tr>
			<tr>
				<td class="vat">
					<div id="vll_jrn" class="jrn"><?php include("vue_vll_jrn.php"); ?></div>
				</td>
				<td class="vat w-100" class="tbl_prs">
					<input type="text" id="vll_lat<?php echo $id ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 60px" value="<?php echo $dt_vll['lat']; ?>" onChange="updateData('cat_vll','lat',this.value,<?php echo $id.',0' ?>);">(N+/S-)<br/>
					<input type="text" id="vll_lon<?php echo $id ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 60px" value="<?php echo $dt_vll['lon']; ?>" onChange="updateData('cat_vll','lon',this.value,<?php echo $id.',0' ?>);">(E+/W-)
					<div id="map" class="w-100" style="height: 580px;"></div>
				</td>
			</tr>
		</table>
	</div>
</div>
