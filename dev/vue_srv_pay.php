<table>
<?php
$rq_srv_pay = select("*","dev_srv_pay","id_srv",$id_dev_srv,"date");
while($dt_srv_pay = ftc_ass($rq_srv_pay)){
	$id_srv_pay = $dt_srv_pay['id'];
?>
	<tr>
		<td><input <?php if(!$aut['res']){echo ' disabled';} ?> id="srv_pay_date<?php echo $id_srv_pay; ?>" type="text" placeholder="jj/mm/aaaa" class="w74" value="<?php if($dt_srv_pay['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_srv_pay['date']));} ?>" onchange="maj('dev_srv_pay','date',this.value,<?php echo $id_srv_pay ?>)" /></td>
		<td><input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> id="srv_pay_liq<?php echo $id_srv_pay; ?>" class="w52" value="<?php echo number_format($dt_srv_pay['liq'],$prm_crr_dcm[$dt_srv_pay['crr']],'.','') ?>" onChange="maj('dev_srv_pay','liq',this.value,<?php echo $id_srv_pay ?>)" /></td>
		<td id="srv_pay_crr<?php echo $id_srv_pay ?>"><?php include("vue_srv_pay_crr.php"); ?></td>
		<td><input <?php if(!$aut['cmp']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if($dt_srv_pay['pay']){echo('checked="checked"');} ?> onclick="if(this.checked){maj('dev_srv_pay','pay','1',<?php echo $id_srv_pay.','.$id_dev_srv ?>)}else{maj('dev_srv_pay','pay','0',<?php echo $id_srv_pay.','.$id_dev_srv ?>)};" /></td>
		<td>
<?php
	if($dt_srv_pay['pay']==0){
		if($aut['res']){
?>
		<span class="dib" onClick="sup_pay('srv',<?php echo $id_srv_pay.','.$id_dev_srv ?>)"><img src="../prm/img/sup.png" /></span>
<?php
		}
	}
	elseif($dt_srv_pay['crr']!=1){
?>
		<input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> id="srv_pay_taux<?php echo $id_srv_pay; ?>" class="w52" value="<?php echo number_format($dt_srv_pay['taux'],$cfg_crr_dcm[$dt_srv_pay['crr']],'.','') ?>" onChange="maj('dev_srv_pay','taux',this.value,<?php echo $id_srv_pay ?>)" />
<?php
	}
?>
		</td>
	</tr>
<?php
}
?>
</table>
