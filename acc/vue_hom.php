<?php
include("../prm/crr.php");
include("../prm/stat_tsk.php");
if($nb_hoy>0){
?>
<div class="floating-box"><?php include("vue_hoy.php"); ?></div>
<?php
}
$rq_tsk = sel_whe("*","grp_tsk LEFT JOIN grp_dev ON grp_tsk.id_grp=grp_dev.id","date<=CURDATE()+INTERVAL 8 DAY AND (dt_grp=CURDATE() OR stat<4)","date,id_grp");
$nb_tsk = num_rows($rq_tsk);
if($nb_tsk>0){
?>
<div class="floating-box"><?php include("vue_dt_tsk.php"); ?></div>
<?php
}
if($aut['fin']){
	$rq = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr_pay.id AS id_hbr_pay,dev_hbr_pay.date,dev_hbr_pay.crr,liq,fin,dev_prs.id AS id_dev_prs,dev_crc.id AS id_crc,dev_crc.groupe","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_hbr_pay ON dev_hbr.id = dev_hbr_pay.id_hbr","dev_hbr_pay.date<=CURDATE()+INTERVAL 8 DAY AND cnf>0 AND pay='0'","date, nom");
	$nb = num_rows($rq);
	if($nb>0){
		$flg_nb_date = $flg_nb_hbr = $flg_nb_crc = false;
		$nb_date = $nb_hbr = $nb_crc = 0;
		$dt_all = ftc_all($rq);
?>
<div class="floating-box"><?php include("vue_pay_hbr.php"); ?></div>
<?php
	}
	$rq = sel_whe("id_frn,dev_srv_pay.id AS id_srv_pay,dev_srv_pay.date,dev_srv_pay.crr,liq,fin,dev_prs.id AS id_dev_prs,dev_crc.id AS id_crc,dev_crc.groupe","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_srv_pay ON dev_srv.id = dev_srv_pay.id_srv","dev_srv_pay.date<=CURDATE()+INTERVAL 8 DAY AND cnf>0 AND pay='0'","date, id_frn");
	$nb = num_rows($rq);
	if($nb>0){
		$flg_nb_date = $flg_nb_frn = $flg_nb_crc = false;
		$nb_date = $nb_frn = $nb_crc = 0;
		$dt_all = ftc_all($rq);
?>
<div class="floating-box"><?php include("vue_pay_frn.php"); ?></div>
<?php
	}
}
if($flg_err_cat){
?>
<div class="floating-box"><?php include("vue_err_cat.php"); ?></div>
<?php
}
if(isset($crc_web) or isset($mdl_web)){
?>
<div class="floating-box"><?php include("vue_web.php"); ?></div>
<?php
}
?>
<div class="floating-box">
	<h4><?php echo $txt->lst->cfg->devises->$id_lng; ?></h4>
	<?php
		if(count($cfg_crr_tx)>1){
	?>
	<table class="text-center">
		<tr>
			<td></td>
			<td></td>
			<td><h5><?php echo $txt->dev->$id_lng; ?></h5></td>
			<td><h5><?php echo $txt->fin->$id_lng; ?></h5></td>
			<td><h5><?php echo $txt->dcm->$id_lng; ?></h5></td>
			<td></td>
		</tr>
<?php
	foreach($cfg_crr_tx as $id => $taux){
		if($id>1){
?>
		<tr>
			<td>
				<input <?php if(!$aut['crr']){echo ' disabled';} ?> id="chk_sp<?php echo $cfg_crr_inv[$id] ?>" class="chk_img" type="checkbox" autocomplete="off" <?php if($cfg_crr_sp[$id]){echo 'checked';} ?> onclick="if(this.checked){maj('cfg_crr','sup','1',<?php echo $cfg_crr_inv[$id] ?>)}else{maj('cfg_crr','sup','0',<?php echo $cfg_crr_inv[$id] ?>)};" />
				<label for="chk_sp<?php echo $cfg_crr_inv[$id] ?>"><img src="../prm/img/inv.png" /></label>
			</td>
			<td>
<?php
			if($cfg_crr_sp[$id]==1){echo $prm_crr_nom[$id].'/'.$prm_crr_nom[1];}
			else{echo $prm_crr_nom[1].'/'.$prm_crr_nom[$id];}
?>
			</td>
			<td><input type="text" <?php if(!$aut['crr']){echo ' disabled';} ?> id="crr_taux<?php echo $cfg_crr_inv[$id] ?>" style="width: 40px" value="<?php echo number_format($taux,$cfg_crr_dcm[$id],'.',''); ?>" onChange="maj('cfg_crr','taux',this.value,<?php echo $cfg_crr_inv[$id] ?>)" /></td>
			<td><input type="text" <?php if(!$aut['crr']){echo ' disabled';} ?> id="crr_tauxf<?php echo $cfg_crr_inv[$id] ?>" style="width: 40px" value="<?php echo number_format($cfg_crr_txf[$id],$cfg_crr_dcm[$id],'.',''); ?>" onChange="maj('cfg_crr','tauxf',this.value,<?php echo $cfg_crr_inv[$id] ?>)" /></td>
			<td><input type="number" <?php if(!$aut['crr']){echo ' disabled';} ?> id="crr_dcm<?php echo $cfg_crr_inv[$id] ?>" style="width: 40px" value="<?php echo $cfg_crr_dcm[$id]; ?>" onChange="maj('cfg_crr','dcm',this.value,<?php echo $cfg_crr_inv[$id] ?>)" /></td>
			<td class="text-center"><?php echo $prm_crr_ttr[$id_lng][$id] ?></td>
			<td onclick="sup_cfg('crr',<?php echo $cfg_crr_inv[$id] ?>);"><img src="../prm/img/sup.png" /></td>
		</tr>
<?php
			}
		}
?>
	</table>
	<br />
<?php
	}
	if($aut['crr']){
?>
	<div class="sel" onclick="vue_cmd('sel_crr')">
		<img src="../prm/img/sel.png" />
		<div><?php echo ' '.$txt->lst->cfg->ajouter->$id_lng; ?></div>
	</div>
	<div id="sel_crr" class="cmd mw200">
		<input type="text" id="ipt_sel_crr" onkeyup="auto_lst('cfg','crr',this.value,event);" />
		<div id="lst_crr"><?php include("vue_lst_crr.php") ?></div>
	</div>
<?php
	}
?>
</div>
<div class="stats">
	<strong><?php echo $txt->lst->acc->bonjour->$id_lng.' '.$qui.' ! '; ?></strong>
<?php
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone('Europe/Paris'));
$dt->setTimestamp($timestamp);
print($txt->lst->acc->date->$id_lng.' '.date("d/m/Y")." / ".$txt->lst->acc->heure->$id_lng.' '.date("H:i").' '.$txt->lst->acc->en->$id_lng.' '.$pays[$id_lng][$id_pys]." / ".$txt->lst->acc->heure->$id_lng.' '.$dt->format("H:i").' '.$txt->lst->acc->france->$id_lng." / ".$txt->lst->acc->ip->$id_lng.' : '.$_SERVER['REMOTE_ADDR'].".");
?>
	<br />
	<strong><?php echo $txt->lst->acc->stats->$id_lng; ?></strong>
<?php
print(mb_strtolower($nb_dev['total'].' '.$txt->dev->$id_lng.' '.$txt->encours->$id_lng." / ".$nb_arc['total'].' '.$txt->dev->$id_lng.' '.$txt->archives->$id_lng." / ".$nb_cnf['total'].' '.$txt->cnf->$id_lng.' '.$txt->encours->$id_lng." / ".$nb_fin['total'].' '.$txt->cnf->$id_lng.' '.$txt->archives->$id_lng."<br/>".$nb_crc['total'].' '.$txt->crc->$id_lng." / ".$nb_mdl['total'].' '.$txt->mdl->$id_lng." / ".$nb_jrn['total'].' '.$txt->jrn->$id_lng." / ".$nb_prs['total'].' '.$txt->prs->$id_lng." / ".$nb_srv['total'].' '.$txt->srv->$id_lng." / ".$nb_hbr['total'].' '.$txt->hbr->$id_lng." / ".$nb_clt['total'].' '.$txt->clt->$id_lng." / ".$nb_frn['total'].' '.$txt->frn->$id_lng." / ".$nb_pic['total'].' '.$txt->pic->$id_lng." / ".$nb_rgn['total'].' '.$txt->rgn->$id_lng." / ".$nb_vll['total'].' '.$txt->vll->$id_lng." / ".$nb_lieu['total'].' '.$txt->lieu->$id_lng."."));
?>
</div>
<?php
