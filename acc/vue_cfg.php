<?php
include("../prm/ty_mrq.php");
include("../prm/ref_tsk.php");
include("../cfg/css.php");
include("../cfg/crr.php");
include("../cfg/ctg_clt.php");
include("../cfg/fin.php");
include("../cfg/pst.php");
?>
<div class="floating-box">
	<h4><?php echo $txt->lst->cfg->tarif->$id_lng; ?></h4>
	<table class="text-center">
		<tr>
			<td></td>
<?php
foreach($nom_ctg_clt as $id => $nom) {
?>
			<td>
				<input type="text" autocomplete="off" style="width: 100px;" <?php if(!$aut['mrq']) {echo ' disabled';} ?> value="<?php echo stripslashes($nom); ?>" onchange="maj('cfg_ctg_clt','nom',this.value,<?php echo $id ?>);" />
<?php
	if($aut['mrq'] and count($nom_ctg_clt)>1) {
?>
				<span onclick="sup_cfg('ctg_clt',<?php echo $id ?>);"><img src="../prm/img/sup.png" /></span>
<?php
	}
?>
			</td>
<?php
}
if($aut['mrq']) {
?>
			<td onclick="ajt_cfg('ctg_clt');"><img src="../prm/img/ajt.png" /></td>
<?php
}
?>
		</tr>
		<tr>
			<td><?php echo $txt->lst->cfg->typemarque->$id_lng; ?></td>
<?php
foreach($ty_mrq_ctg_clt as $id => $tymrq) {
?>
			<td id="cfg_ty_mrq<?php echo $id ?>"><?php include("vue_cfg_ty_mrq.php"); ?></td>
<?php
}
?>
		</tr>
		<tr>
			<td style="max-width: 180px;"><?php echo $txt->lst->cfg->tauxmarque->$id_lng; ?></td>
<?php
foreach($nom_ctg_clt as $id => $mrq) {
?>
			<td>
<?php
	$rq_mrq = sel_quo("*","cfg_mrq","id_ctg_clt",$id,"bs_min");
	if(num_rows($rq_mrq)>0) {
?>
				<table class="wsn">
<?php
		while($dt_mrq = ftc_ass($rq_mrq)) {
?>
					<tr>
						<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="mrq_bs_min<?php echo $dt_mrq['id'] ?>" style="width: 30px" value="<?php echo $dt_mrq['bs_min']; ?>" onChange="maj('cfg_mrq','bs_min',this.value,<?php echo $dt_mrq['id'].','.$id ?>)" /></td>
						<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="mrq_bs_max<?php echo $dt_mrq['id'] ?>" style="width: 30px" value="<?php echo $dt_mrq['bs_max']; ?>" onChange="maj('cfg_mrq','bs_max',this.value,<?php echo $dt_mrq['id'].','.$id ?>)" /></td>
						<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="mrq_mrq<?php echo $dt_mrq['id'] ?>" style="width: 30px" value="<?php echo number_format($dt_mrq['mrq']*100,2,'.',''); ?>" onChange="maj('cfg_mrq','mrq',this.value.replace(',','.')/100,<?php echo $dt_mrq['id'] ?>)" />%</td>
<?php
			if($aut['mrq'] and num_rows($rq_mrq)>1) {
?>
						<td onclick="sup_mrq(<?php echo $dt_mrq['id'] ?>);"><img src="../prm/img/sup.png" /></td>
<?php
			}
?>
					</tr>
<?php
		}
?>
				</table>
<?php
	}
	if($aut['mrq']) {
?>
				<span class="dib" onclick="ajt_mrq(<?php echo $id ?>);"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
			</td>
<?php
}
?>
		</tr>
		<tr>
			<td style="max-width: 180px;"><?php echo $txt->lst->cfg->tauxcom->$id_lng; ?></td>
<?php
foreach($com_ctg_clt as $id => $com) {
?>
			<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="ctg_clt_com<?php echo $id ?>" style="width: 30px" value="<?php echo number_format($com*100,2,'.',''); ?>" onChange="maj('cfg_ctg_clt','com',this.value.replace(',','.')/100,<?php echo $id ?>)" />%</td>
<?php
}
?>
		</tr>
		<tr>
			<td style="max-width: 180px;"><?php echo $txt->lst->cfg->marquehbr->$id_lng; ?></td>
<?php
foreach($mrq_hbr_ctg_clt as $id => $mrq_hbr) {
?>
			<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="ctg_clt_mrq_hbr<?php echo $id ?>" style="width: 30px" value="<?php echo number_format($mrq_hbr*100,2,'.',''); ?>" onChange="maj('cfg_ctg_clt','mrq_hbr',this.value.replace(',','.')/100,<?php echo $id ?>)" />%</td>
<?php
}
?>
		</tr>
		<tr>
			<td><?php echo $txt->lst->cfg->frais->$id_lng; ?></td>
<?php
foreach($frs_ctg_clt as $id => $frs) {
?>
			<td><input type="text" <?php if(!$aut['mrq']) {echo ' disabled';} ?> id="ctg_clt_frs<?php echo $id ?>" style="width: 30px" value="<?php echo number_format($frs*100,2,'.',''); ?>" onChange="maj('cfg_ctg_clt','frs',this.value.replace(',','.')/100,<?php echo $id ?>)" />%</td>
<?php
}
?>

		</tr>
	</table>
</div>
<div class="floating-box">
	<h4><?php echo $txt->lst->cfg->langue->$id_lng; ?></h4>
	<table class="text-center">
		<tr>
			<td><?php echo $txt->lst->cfg->utilisateur->$id_lng; ?></td>
			<td>
				<div class="sel" onclick="vue_cmd('sel_lng')">
					<img src="../prm/img/sel.png" />
					<div>
						<input type="hidden" id="lng" value="<?php echo $id_lng ?>" />
<?php
echo $lgg_nom[$id_lng];
?>
					</div>
				</div>
				<div id="sel_lng" class="cmd mw200">
					<input type="text" id="ipt_sel_lng" onkeyup="auto_lst('cfg','lng',this.value,event);" />
					<div id="lst_lng"><?php include("vue_lst_lng.php") ?></div>
				</div>
			</td>
		</tr>
		<tr>
			<td><?php echo $txt->lst->cfg->programme->$id_lng; ?></td>
			<td id="cfg_lgg"><?php include("vue_cfg_lgg.php"); ?></td>
		</tr>
		<tr>
			<td><?php echo $txt->lst->cfg->mail->$id_lng; ?></td>
			<td>
<?php
$dt_usr = ftc_ass(sel_quo("mail","cfg_usr","id",$id_cfg_usr));
?>
				<input type="text" autocomplete="off" style="width: 200px;" value="<?php echo stripslashes($dt_usr['mail']); ?>" onchange="maj('cfg_usr','mail',this.value,<?php echo $id_cfg_usr ?>);" />
			</td>
		</tr>
	</table>
</div>
<div class="floating-box">
	<h4>
<?php
 	echo $txt->tsk->$id_lng;
	if($aut['tsk']) {
?>
		<span class="dib" onClick="ajt_cfg('tsk');"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
	</h4>
	<table class="text-center">
<?php
$rq_tsk = sel_whe("*","cfg_tsk","","ord");
while($dt_tsk = ftc_ass($rq_tsk)) {
?>
		<tr>
			<td><input <?php if(!$aut['tsk']) {echo ' disabled';} ?> id="tsk_ord<?php echo $dt_tsk['id']; ?>" type="text" autocomplete="off" style="width: 30px;" value="<?php echo $dt_tsk['ord']; ?>" onchange="maj('cfg_tsk','ord',this.value,<?php echo $dt_tsk['id']; ?>);" /></td>
			<td><input <?php if(!$aut['tsk']) {echo ' disabled';} ?> id="tsk_nom<?php echo $dt_tsk['id']; ?>" type="text" autocomplete="off" style="width: 70px;" value="<?php echo $dt_tsk['nom']; ?>" onchange="maj('cfg_tsk','nom',this.value,<?php echo $dt_tsk['id']; ?>);" /></td>
			<td>
				<select <?php if(!$aut['tsk']) {echo ' disabled';} ?>  onchange="maj('cfg_tsk','ref',this.value,<?php echo $dt_tsk['id']; ?>)">
<?php
	foreach ($ref_tsk[$id_lng] as $id => $nom) {
?>
	        <option <?php if($dt_tsk['ref']==$id) {echo ' selected';} ?> value="<?php echo $id ?>"><?php echo $nom; ?></option>
<?php
	}
?>
	      </select>
			</td>
			<td>
				<input <?php if(!$aut['tsk']) {echo ' disabled';} ?> id="tsk_delai<?php echo $dt_tsk['id']; ?>" type="text" autocomplete="off" style="width: 30px;" value="<?php if($dt_tsk['delai']>0) {echo '+';} echo $dt_tsk['delai']; ?>" onchange="maj('cfg_tsk','delai',this.value,<?php echo $dt_tsk['id']; ?>);" />
<?php
	echo $txt->lst->dev->jours->$id_lng;
?>
			</td>
			<td>
				<select <?php if(!$aut['tsk']) {echo ' disabled';} ?>  onchange="maj('cfg_tsk','ctg_clt',this.value,<?php echo $dt_tsk['id']; ?>)">
					<option <?php if($dt_tsk['ctg_clt']==0) {echo ' selected';} ?> value="0"><?php echo $txt->clt->$id_lng; ?></option>
<?php
	foreach ($nom_ctg_clt as $id => $nom) {
?>
					<option <?php if($dt_tsk['ctg_clt']==$id) {echo ' selected';} ?> value="<?php echo $id ?>"><?php echo $nom; ?></option>
					<option <?php if($dt_tsk['ctg_clt']=='-'.$id) {echo ' selected';} ?> value="<?php echo '-'.$id ?>"><?php echo '≠ '.$nom; ?></option>
<?php
	}
?>
				</select>
			</td>
<?php
	if($aut['adm_fin']) {
?>
			<td onclick="sup_cfg('tsk',<?php echo $dt_tsk['id']; ?>);"><img src="../prm/img/sup.png" /></td>
<?php
	}
?>
		</tr>
<?php
}
?>
	</table>
</div>
<?php
if($aut['fin']) {
?>
<div class="floating-box">
	<h4>
<?php
	echo $txt->lst->cfg->caisses->$id_lng;
	if($aut['adm_fin']) {
?>
		<span class="dib" onClick="ajt_cfg('css');"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
	</h4>
	<table class="text-center">
<?php
	foreach($css as $css_id => $nom) {
		if($css_id>0) {
?>
		<tr>
			<td><input type="text" autocomplete="off" style="width: 100px;" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> value="<?php echo stripslashes($nom); ?>" onchange="maj('fin_css','css',this.value,<?php echo $css_id ?>);" /></td>
			<td id="fin_crr_css<?php echo $css_id ?>"><?php include("vue_fin_crr.php"); ?></td>
<?php
			if($aut['adm_fin']) {
?>
			<td onclick="sup_cfg('css',<?php echo $css_id ?>);"><img src="../prm/img/sup.png" /></td>
			<?php
			}
?>
		</tr>
<?php
		}
	}
?>
	</table>
</div>
<div class="floating-box">
	<h4>
<?php
	echo $txt->lst->cfg->pst->$id_lng;
	if($aut['adm_fin']) {
?>
		<span class="dib" onClick="ajt_cfg('pst');"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
	</h4>
	<table class="text-center">
<?php
	foreach($pst as $pst_id => $nom) {
?>
		<tr>
			<td><input type="text" autocomplete="off" style="width: 100px;" <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> value="<?php echo stripslashes($nom); ?>" onchange="maj('fin_pst','pst',this.value,<?php echo $pst_id ?>);" /></td>
			<td>
				<select <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> onchange="maj('fin_pst','rsl',this.value,<?php echo $pst_id ?>)">
	        <option <?php if($rsl_pst[$pst_id]==0) {echo ' selected';} ?> value="0"><?php echo $txt->lst->cfg->pst0->$id_lng; ?></option>
					<option <?php if($rsl_pst[$pst_id]==1) {echo ' selected';} ?> value="1"><?php echo $txt->lst->cfg->pst1->$id_lng; ?></option>
					<option <?php if($rsl_pst[$pst_id]==2) {echo ' selected';} ?> value="2"><?php echo $txt->lst->cfg->pst2->$id_lng; ?></option>
	      </select>
			</td>
<?php
			if($aut['adm_fin']) {
?>
			<td onclick="sup_cfg('pst',<?php echo $pst_id ?>);"><img src="../prm/img/sup.png" /></td>
<?php
			}
?>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class="floating-box" style="max-width: 700px;">
	<table class="text-center">
		<tr>
			<td>
				<h4><?php echo $txt->lst->cfg->crr_fin->$id_lng; ?></h4>
				<span id="fin_crr_fin1"><?php include("vue_crr_fin.php"); ?></span>
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->ini->$id_lng ?></h4>
<?php
	$dt_fin = ftc_ass(sel_quo("excfsc,inv","cfg_fin","id","1"));
?>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_inv1" type="text" autocomplete="off" style="width: 70px;" value="<?php echo number_format($dt_fin['inv'],$prm_crr_dcm[$id_crr_fin],',',''); ?>" onchange="maj('cfg_fin','inv',this.value,1);" />
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->dat_min->$id_lng; ?></h4>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_date1" type="text" autocomplete="off" placeholder="<?php echo $txt->lst->cfg->phdate->$id_lng; ?>" style="width: 70px;" value="<?php if($dat_min!='0000-00-00') {echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="maj('cfg_fin','date',this.value,'1');" />
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->excfsc->$id_lng; ?></h4>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_excfsc1" type="text" autocomplete="off" style="width: 25px;" value="<?php echo $dt_fin['excfsc'] ?>" onchange="maj('cfg_fin','excfsc',this.value,1);" />
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->crr_cmp->$id_lng; ?></h4>
				<span id="fin_crr_cmp1"><?php include("vue_crr_cmp.php"); ?></span>
			</td>
		</tr>
		<tr>
			<td>
				<h4><?php echo $txt->lst->cfg->inv->$id_lng; ?></h4>
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->caisses->$id_lng; ?>
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->dvs->$id_lng; ?>
			</td>
			<td>
				<h4><?php echo $txt->lst->cfg->dates->$id_lng; ?></h4>
			</td>
			<td>
				<h4><?php echo $txt->commen->$id_lng; ?></h4>
			</td>
			<td>
<?php
	if($aut['adm_fin']) {
?>
				<span class="dib" onClick="ajt_cfg('inv');"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
			</td>
		<tr>
<?php
	$rq_fin = sel_whe("id,id_css,dvs,date,inv,commen","cfg_fin","id>1");
	while($dt_fin = ftc_ass($rq_fin)) {
?>
		<tr>
			<td>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_inv<?php echo $dt_fin['id'] ?>" type="text" autocomplete="off" style="width: 70px;" value="<?php echo number_format($dt_fin['inv'],$prm_crr_dcm[$id_crr_fin],',',''); ?>" onchange="maj('cfg_fin','inv',this.value,<?php echo $dt_fin['id'] ?>);" />
			</td>
			<td>
				<select <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> style="width: 90px;" onchange="maj('cfg_fin','id_css',this.value,<?php echo $dt_fin['id'] ?>);">
					<option <?php if($dt_fin['id_css']=='0') {echo ' selected';} ?> value="0"><?php echo $txt->lst->cfg->nodef->$id_lng; ?></option>
<?php
		foreach($css as $css_id => $nom) {
?>
					<option <?php if($css_id == $dt_fin['id_css']) {echo ' selected';} ?> value="<?php echo $css_id ?>"><?php echo stripslashes($nom); ?></option>
<?php
		}
?>
				</select>
			</td>
			<td>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_dvs<?php echo $dt_fin['id'] ?>" type="text" autocomplete="off" style="width: 70px;" value="<?php if($dt_fin['id_css']>0){echo number_format($dt_fin['dvs'],$prm_crr_dcm[$cfg_crr_css[$dt_fin['id_css']]],',','');} else{echo $dt_fin['dvs'];} ?>" onchange="maj('cfg_fin','dvs',this.value,<?php echo $dt_fin['id'] ?>);" />
			</td>
			<td>
				<input <?php if(!$aut['adm_fin']) {echo ' disabled';} ?> id="fin_date<?php echo $dt_fin['id'] ?>" type="text" autocomplete="off" placeholder="<?php echo $txt->lst->cfg->phdate->$id_lng; ?>" style="width: 70px;" value="<?php if($dt_fin['date']!='0000-00-00') {echo date("d/m/Y", strtotime($dt_fin['date']));} ?>" onchange="maj('cfg_fin','date',this.value,<?php echo $dt_fin['id'] ?>);" />
			</td>
			<td>
	<?php
			if(!$aut['adm_fin']){echo stripslashes($dt_fin['commen']);}
			else{
	?>
				<input type="text" maxlength="60" style="width: 200px; width: 96%;" value="<?php echo stripslashes($dt_fin['commen']) ?>" onChange="maj('cfg_fin','commen',this.value,<?php echo $dt_fin['id']; ?>)" />
	<?php
			}
	?>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<?php
}
?>
