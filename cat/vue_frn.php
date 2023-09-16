<?php
$dt_frn = ftc_ass(select("*","cat_frn","id",$id));
?>
<div class="fr_w71">
	<div style="float:right;" class="tbl_prs">
		<div id="frn_ctg_srv" class="dsg"><?php include("vue_frn_ctg_srv.php"); ?></div>
		<hr/>
		<div id="frn_vll" class="dsg"><?php include("vue_frn_vll.php"); ?></div>
	</div>
	<div class="div_cat2">
		<div class="tbl_prs">
			<table class="dsg" style="width:100%">
				<tr>
					<td>
						<table style="width:100%">
							<tr>
								<td>
									<table style="width:100%">
										<tr>
											<td class="fwb"><?php echo $txt->frn->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['nom']) ?>" onChange="updateData('cat_frn','nom',this.value,<?php echo $id ?>);" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->titre->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['titre']) ?>" onChange="updateData('cat_frn','titre',this.value,<?php echo $id ?>);" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->tel->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['tel']) ?>" onChange="updateData('cat_frn','tel',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->adresse->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['adresse']) ?>" onChange="updateData('cat_frn','adresse',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td id="frn_mail" class="fwb"><?php include("vue_frn_mail.php"); ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['mail']) ?>" onChange="updateData('cat_frn','mail',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->contact->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" value="<?php echo stripslashes($dt_frn['contact']) ?>" onChange="updateData('cat_frn','contact',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->infos->$id_lng; ?></td>
											<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> style="width: 100%;" maxlength="50" value="<?php echo stripslashes($dt_frn['info']) ?>" onChange="updateData('cat_frn','info',this.value,<?php echo $id ?>)" /></td>
										</tr>
									</table>
								</td>
								<td>
									<table style="width:100%">
										<tr>
											<td class="fwb" style="min-width: 112px;"><?php echo $txt->nvtrf->$id_lng.' :' ?></td>
											<td id="frn_nvtrf" class="nvtrf"><?php include("vue_frn_nvtrf.php"); ?></td>
											<td class="fwb"><?php echo $txt->lstrg->$id_lng.' :' ?></td>
											<td><input type="checkbox" autocomplete="off" <?php if(!$aut['cat']) {echo ' disabled';} ?> <?php if ($dt_frn['lstrg']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_frn','lstrg','1',<?php echo $id ?>)}else{updateData('cat_frn','lstrg','0',<?php echo $id ?>)};" /></td>
											<td class="fwb" style="width: 55px;"><?php echo $txt->ferme->$id_lng.' :' ?></td>
											<td><input type="checkbox" autocomplete="off" <?php if(!$aut['cat']) {echo ' disabled';} ?> <?php if ($dt_frn['ferme']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_frn','ferme','1',<?php echo $id ?>)}else{updateData('cat_frn','ferme','0',<?php echo $id ?>)};" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->res->$id_lng.' :'; ?></td>
											<td id="frn_ctg_res"><?php include("vue_frn_ctg_res.php"); ?></td>
											<td class="fwb"><?php echo $txt->vch->$id_lng.' :'; ?></td>
											<td>
												<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_frn['vch']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_frn','vch','1',<?php echo $id ?>)}else{updateData('cat_frn','vch','0',<?php echo $id ?>)};" />
											</td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->bnq->$id_lng; ?></td>
											<td id="frn_bnq" class="bnq"><?php include("vue_frn_bnq.php"); ?></td>
											<td class="fwb" style="min-width: 110px;"><?php echo $txt->frsfin->$id_lng.' :'; ?></td>
											<td class="wsn"><input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="frn_frs<?php echo $id ?>" type="text" style="width: 35px;" value="<?php echo $dt_frn['frs']*100 ?>" onChange="updateData('cat_frn','frs',this.value,<?php echo $id ?>)" />%</td>
											<td colspan="2"><input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> type="text" value="<?php echo stripslashes($dt_frn['notfrs']) ?>" onChange="updateData('cat_frn','notfrs',this.value,<?php echo $id ?>)" /></td>
										</tr>
										<tr>
											<td class="fwb"><?php echo $txt->infosbnq->$id_lng; ?></td>
											<td colspan="5">
												<textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> style="height: 80px;" onChange="updateData('cat_frn','bnq',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_frn['bnq']) ?></textarea>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table style="width:100%">
							<tr>
								<td class="fwb"><?php echo $txt->notes->$id_lng; ?></td>
								<td style="width: 100%; overflow:hidden;">
									<textarea <?php if(!$aut['cat']) {echo ' readonly';} ?> onChange="updateData('cat_frn','notes',this.value,<?php echo $id ?>)"><?php echo stripslashes($dt_frn['notes']) ?></textarea>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div>
			<table style="width:100%">
				<tr class="vat">
					<td class="vat">
						<div id="frn_hbr" class="frn_hbr hbr vatdib tbl_prs"><?php include("vue_frn_hbr.php"); ?></div>
					</td>
					<td class="vat">
						<div id="frn_srv" class="frn_srv srv vatdib tbl_prs"><?php include("vue_frn_srv.php"); ?></div>
					</td>
					<td class="vat">
						<div id="frn_dsp" class="frn_dsp vatdib"><?php include("vue_frn_dsp.php"); ?></div>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="div_cat2">
	<div id="frn_pay" class="tbl_prs srv_pay frn_ope"><?php include("vue_frn_pay.php"); ?></div>
	<div id="frn_dev" class="tbl_prs frn_ope"><?php include("vue_frn_dev.php"); ?></div>
</div>
