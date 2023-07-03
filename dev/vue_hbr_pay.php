<table>
<?php
$rq_hbr_pay = select("*","dev_hbr_pay","id_hbr",$id_dev_hbr,"date");
while($dt_hbr_pay = ftc_ass($rq_hbr_pay)){
	$id_hbr_pay = $dt_hbr_pay['id'];
?>
	<tr>
		<td><input <?php if(!$aut['res']){echo ' disabled';} ?> id="hbr_pay_date<?php echo $id_hbr_pay; ?>" type="text" placeholder="jj/mm/aaaa" class="w74" value="<?php if($dt_hbr_pay['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_hbr_pay['date']));} ?>" onchange="maj('dev_hbr_pay','date',this.value,<?php echo $id_hbr_pay ?>)" /></td>
		<td><input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> id="hbr_pay_liq<?php echo $id_hbr_pay; ?>" class="w52" value="<?php echo number_format($dt_hbr_pay['liq'],$prm_crr_dcm[$dt_hbr_pay['crr']],'.','') ?>" onChange="maj('dev_hbr_pay','liq',this.value,<?php echo $id_hbr_pay ?>)" /></td>
		<td id="hbr_pay_crr<?php echo $id_hbr_pay ?>"><?php include("vue_hbr_pay_crr.php"); ?></td>
		<td><input <?php if(!$aut['cmp']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($dt_hbr_pay['pay']){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_hbr_pay','pay','1',<?php echo $id_hbr_pay.','.$id_dev_hbr ?>)}else{maj('dev_hbr_pay','pay','0',<?php echo $id_hbr_pay.','.$id_dev_hbr ?>)};" /></td>
		<td>
<?php
	if($dt_hbr_pay['pay']==0){
		if($aut['res']){
?>
		<span class="dib" onClick="sup_pay('hbr',<?php echo $id_hbr_pay.','.$id_dev_hbr ?>)"><img src="../prm/img/sup.png" /></span>
<?php
		}
	}
	elseif($dt_hbr_pay['crr']!=1){
?>
		<input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> id="hbr_pay_taux<?php echo $id_hbr_pay; ?>" class="w52" value="<?php echo number_format($dt_hbr_pay['taux'],$cfg_crr_dcm[$dt_hbr_pay['crr']],'.','') ?>" onChange="maj('dev_hbr_pay','taux',this.value,<?php echo $id_hbr_pay ?>)" />
<?php
	}
?>
		</td>
	</tr>
<?php
}
?>
</table>
