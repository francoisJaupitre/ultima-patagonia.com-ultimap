<?php
$dt_hbr = ftc_ass(select("*","cat_hbr","id",$id));
$vrl = $dt_hbr['vrl'];
$id_vll = $dt_hbr['id_vll'];
$id_frn = $dt_hbr['id_frn'];
$mail_frt_hbr = $dt_hbr['mail_frt'];
?>
<div class="tbl_prs fr_w71">
	<table class="w-100">
		<tr>
			<td class="vat">
				<table style="width:100%">
					<tr>
						<td>
							<table class="dsg" style="width:100%">
								<tr>
									<td class="fwb"><?php echo $txt->hbr->$id_lng; ?></td>
									<td class="w-100">
										<div style="float:right; padding-left: 5px;">
											<span class="vdfp"><?php echo $txt->vll->$id_lng ?></span>
											<span id="hbr_vll" class="vll dib"><?php include("vue_hbr_vll.php"); ?></span>
											<span class="vdfp"><?php echo $txt->ctg->$id_lng ?></span>
											<span id="hbr_ctg" class="dib"><?php include("vue_hbr_ctg.php"); ?></span>
										</div>
										<div class="div_cat"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> id="nom_hbr" style="width: 200px;" value="<?php echo stripslashes($dt_hbr['nom']) ?>" onChange="updateData('cat_hbr','nom',this.value,<?php echo $id ?>);" /></div>
									</td>
								</tr>
								<tr>
									<td class="fwb"><?php echo $txt->notes->$id_lng; ?></td>
									<td width="95%">
										<div class="div_cat">
											<div style="float:right; padding-left: 5px;" class="fwb">
												<table>
													<tr>
														<td id="hbr_frt_mail" class="wsn"><?php include("vue_hbr_frt_mail.php"); ?></td>
														<td colspan="5"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($mail_frt_hbr) ?>" onChange="updateData('cat_hbr','mail_frt',this.value,<?php echo $id ?>)" /></td>
													</tr>
													<tr>
														<td><?php echo $txt->infos->$id_lng.' :' ?></td>
														<td colspan="5"><input type="text" style="width: 100%; min-width: 200px;" maxlength="50" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_hbr['info']) ?>" onChange="updateData('cat_hbr','info',this.value,<?php echo $id ?>)" /></td>
													</tr>
													<tr>
														<td><?php echo $txt->altdev->$id_lng.' :' ?></td>
														<td colspan="5"><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_hbr['alerte']) ?>" onChange="updateData('cat_hbr','alerte',this.value,<?php echo $id ?>)" /></td>
													</tr>
													<tr>
														<td><?php echo $txt->nvtrf->$id_lng.' :' ?></td>
														<td id="hbr_nvtrf" class="nvtrf"><?php include("vue_hbr_nvtrf.php"); ?></td>
														<td><?php echo $txt->lstrg->$id_lng.' :' ?></td>
														<td><input type="checkbox" autocomplete="off" <?php if(!$aut['cat']) {echo ' disabled';} ?> <?php if ($dt_hbr['lstrg']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_hbr','lstrg','1',<?php echo $id ?>)}else{updateData('cat_hbr','lstrg','0',<?php echo $id ?>)};" /></td>
														<td><?php echo $txt->ferme->$id_lng.' :' ?></td>
														<td><input type="checkbox" autocomplete="off" <?php if(!$aut['cat']) {echo ' disabled';} ?> <?php if ($dt_hbr['ferme']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_hbr','ferme','1',<?php echo $id ?>)}else{updateData('cat_hbr','ferme','0',<?php echo $id ?>)};" /></td>
													</tr>
												</table>
											</div>
											<div class="div_cat">
												<textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> style="min-height: 100px;" onChange="updateData('cat_hbr','notes',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_hbr['notes']) ?></textarea>
											</div>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table class="tht" style="width:100%">
								<tr>
									<td class="fwb"><?php echo $txt->telhbr->$id_lng; ?></td>
									<td><input type="text" style="width: 100%;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_hbr['tel_hbr']) ?>" onChange="updateData('cat_hbr','tel_hbr',this.value,<?php echo $id ?>)" /></td>
									<td class="fwb text-center"><?php echo $txt->checkinout->$id_lng ?></td>
								</tr>
								<tr>
									<td class="fwb"><?php echo $txt->adresse->$id_lng; ?></td>
									<td><input type="text" style="width: 100%; min-width: 200px;" <?php if(!$aut['cat']) {echo ' disabled';} ?> value="<?php echo stripslashes($dt_hbr['adresse']) ?>" onChange="updateData('cat_hbr','adresse',this.value,<?php echo $id ?>)" /></td>
									<td class="fwb text-center">
										<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="time" value="<?php if(!is_null($dt_hbr['chk_in'])) {echo date("H:i", strtotime($dt_hbr['chk_in']));} ?>" onblur="updateData('cat_hbr','chk_in',this.value,<?php echo $id ?>)" /></strong>
										<strong>/</strong>
										<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="time" value="<?php if(!is_null($dt_hbr['chk_out'])) {echo date("H:i", strtotime($dt_hbr['chk_out']));} ?>" onblur="updateData('cat_hbr','chk_out',this.value,<?php echo $id ?>)" /></strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<hr/>
				<div id="hbr_txt"><?php include("vue_hbr_txt.php"); ?></div>
			</td>
			<td class="dsg">
				<div id="hbr_frn" class="frn hbr_frn"><?php include("vue_hbr_frn.php"); ?></div>
			</td>
		</tr>
	</table>
	<hr/>
	<div id="hbr_chm" class="hbr_chm<?php echo $id ?>"><?php include("vue_hbr_chm.php") ?></div>
	<hr/><hr/>
	<div id="hbr_rgm" class="hbr_rgm<?php echo $id ?>"><?php include("vue_hbr_rgm.php") ?></div>
</div>
<div class="div_cat2">
	<div id="hbr_prs" class="list_prs_hbr up_prs tbl_prs"><?php include("vue_hbr_prs.php"); ?></div>
	<div class="tht">
		<div class="fwb">
			<input type="text" id="hbr_lat<?php echo $id ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 60px" value="<?php echo $dt_hbr['lat']; ?>" onChange="updateData('cat_hbr','lat',this.value,<?php echo $id.',0' ?>);">(N+/S-) /
			<input type="text" id="hbr_lon<?php echo $id ?>" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 60px" value="<?php echo $dt_hbr['lon']; ?>" onChange="updateData('cat_hbr','lon',this.value,<?php echo $id.',0' ?>);">(E+/W-)
		</div>
		<div id="map" style="width: 100%; height: 220px;"></div>
	</div>
	<div id="hbr_pay" class="tbl_prs hbr_pay"><?php include("vue_hbr_pay.php"); ?></div>
	<div id="hbr_dev" class="hbr_dev<?php echo $id ?> cat_dev tbl_prs"><?php include("vue_hbr_dev.php"); ?></div>
</div>
