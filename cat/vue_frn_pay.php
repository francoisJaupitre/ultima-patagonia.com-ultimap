<div class="dsg">
	<strong><?php echo $txt->pay->$id_lng.' :'; ?></strong>
	<table>
<?php
$rq_pay = select("dev_crc.id AS id_crc,groupe,dev_prs.id AS id_dev_prs,id_frn,dev_srv_pay.id AS id_srv_pay,dev_srv_pay.date,liq,dev_srv_pay.crr,rva","dev_srv_pay INNER JOIN (dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id) ON dev_srv_pay.id_srv = dev_srv.id","pay='0' AND cnf>0 AND id_frn",$id,"date");
while($dt_pay = ftc_ass($rq_pay)) {
?>
		<tr>
			<td style="<?php if($dt_pay['date']<date("Y-m-d")) {echo 'color: red';} ?>"><?php if($dt_pay['date']!="0000-00-00") {echo date("d/m/Y", strtotime($dt_pay['date']));} ?></td>
			<td class="usa"><?php echo number_format($dt_pay['liq'],$prm_crr_dcm[$dt_pay['crr']],",","."); ?></td>
			<td class="usa"><?php echo $prm_crr_nom[$dt_pay['crr']] ?></td>
			<td class="lnk_cat" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_pay['id_crc'] ?>&scrl=<?php echo $dt_pay['id_dev_prs'] ?>');"><?php echo $dt_pay['groupe'] ?></td>
			<td class="usa"><?php echo $dt_pay['rva'] ?></td>
			<td><input <?php if(!$aut['cmp']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($dt_pay['pay']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('dev_srv_pay','pay','1',<?php echo $dt_pay['id_srv_pay'] ?>)}else{updateData('dev_srv_pay','pay','0',<?php echo $dt_pay['id_srv_pay'] ?>)};" /></td>
		</tr>
<?php
}
?>
	</table>
	<hr />
	<strong><?php echo $txt->conditions->$id_lng.' :'; ?></strong>
<?php
	if($aut['cat']) {
?>
	<span class="dib" onClick="ajt_frn_pay()"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
	<table>
<?php
$rq_pay = select("*","cat_frn_pay","id_frn",$id,"id DESC, delai DESC");
while($dt_pay = ftc_ass($rq_pay)) {
?>
		<tr>
			<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="w25" value="<?php echo $dt_pay['taux']*100 ?>" onChange="updateData('cat_frn_pay','taux',this.value,<?php echo $dt_pay['id'] ?>)" />%</td>
			<td><input type="number" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="w25" value="<?php echo $dt_pay['delai'] ?>" onChange="updateData('cat_frn_pay','delai',this.value,<?php echo $dt_pay['id'] ?>)" /><?php echo $txt->jours->$id_lng ?></td>
			<td id="frn_pay_ty_delai"><?php include("vue_frn_pay_ty_delai.php"); ?></td>
<?php
	if($aut['cat']) {
?>
			<td onclick="sup('frn_pay',<?php echo $dt_pay['id'] ?>,'frn',<?php echo $id ?>)"><img src="../prm/img/sup.png" /></td>
<?php
	}
?>
		</tr>
<?php
}
?>
	</table>
</div>
