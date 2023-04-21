<div class="dsg">
	<strong><?php echo $txt->pay->$id_lng.' :'; ?></strong>
	<table>
<?php
$rq_pay = select("dev_crc.id AS id_crc,groupe,dev_prs.id AS id_dev_prs,dev_hbr_pay.id AS id_hbr_pay,dev_hbr_pay.date,liq,dev_hbr_pay.crr,rva,pay","dev_hbr_pay INNER JOIN (dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id) ON dev_hbr_pay.id_hbr = dev_hbr.id","pay='0' AND cnf>0 AND dev_hbr.id_cat",$id,"date");
while($dt_pay = ftc_ass($rq_pay)) {
?>
		<tr>
			<td style="<?php if($dt_pay['date']<date("Y-m-d")) {echo 'color: red';} ?>"><?php if($dt_pay['date']!="0000-00-00") {echo date("d/m/Y", strtotime($dt_pay['date']));} ?></td>
			<td class="usa"><?php echo number_format($dt_pay['liq'],$prm_crr_dcm[$dt_pay['crr']],",","."); ?></td>
			<td class="usa"><?php echo $prm_crr_nom[$dt_pay['crr']] ?></td>
			<td class="lnk_cat" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_pay['id_crc'] ?>&scrl=<?php echo $dt_pay['id_dev_prs'] ?>');"><?php echo $dt_pay['groupe'] ?></td>
			<td class="usa"><?php echo $dt_pay['rva'] ?></td>
			<td><input <?php if(!$aut['cmp']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($dt_pay['pay']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('dev_hbr_pay','pay','1',<?php echo $dt_pay['id_hbr_pay'] ?>)}else{maj('dev_hbr_pay','pay','0',<?php echo $dt_pay['id_hbr_pay'] ?>)};" /></td>
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
	<span class="dib" onClick="ajt_hbr_pay()"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
	<table>
<?php
$rq_pay = select("*","cat_hbr_pay","id_hbr",$id,"id DESC, delai DESC");
while($dt_pay = ftc_ass($rq_pay)) {
?>
		<tr>
			<td><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="w25" value="<?php echo $dt_pay['taux']*100 ?>" onChange="maj('cat_hbr_pay','taux',this.value,<?php echo $dt_pay['id'] ?>)" />%</td>
			<td><input type="number" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="w25" value="<?php echo $dt_pay['delai'] ?>" onChange="maj('cat_hbr_pay','delai',this.value,<?php echo $dt_pay['id'] ?>)" /><?php echo $txt->jours->$id_lng ?></td>
			<td id="hbr_pay_ty_delai"><?php include("vue_hbr_pay_ty_delai.php"); ?></td>
<?php
	if($aut['cat']) {
?>
			<td onclick="sup('hbr_pay',<?php echo $dt_pay['id'] ?>,'hbr',<?php echo $id ?>)"><img src="../prm/img/sup.png" /></td>
<?php
	}
?>
		</tr>
<?php
}
?>
	</table>
</div>
