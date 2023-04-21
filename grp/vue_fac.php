<div class="lsb">
	<span class="vdfp2"><?php echo $txt->fac->$id_lng ?></span>
<?php
	if($aut['dev']){
?>
	<span class="dib" onclick="ajt_fac();"><img src="../prm/img/ajt.png" /></span>
<?php
	}
?>
</div>
<table class="dsg w-100">
<?php
$rq_fac = sel_quo("*","grp_fac","id_grp",$id_grp,"fac,date");
while($dt_fac = ftc_ass($rq_fac)){
?>
<tr>
	<td class="td_acc"><input <?php if(!$aut['res']){echo ' disabled';} ?> id="fac_date<?php echo $dt_fac['id']; ?>" type="text" placeholder="jj/mm/aaaa" style="width: 70px; padding: 0 5px;" value="<?php if($dt_fac['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_fac['date']));}; ?>" onChange="maj('grp_fac','date',this.value,<?php echo $dt_fac['id']; ?>)" /></td>
	<td class="td_acc"><input <?php if(!$aut['res']){echo ' disabled';} ?> type="text" style="width: 150px; margin-right: 10px;" value="<?php echo stripslashes($dt_fac['nom']) ?>" onChange="maj('grp_fac','nom',this.value,<?php echo $dt_fac['id'] ?>)" /></td>
	<td class="td_acc"><?php echo stripslashes($dt_fac['fac']) ?></td>
	<td>
		<select <?php if(!$aut['dev']){echo ' disabled';} ?> style="width: 70px;" onchange="maj('grp_fac','att',this.value,<?php echo $dt_fac['id'] ?>)">
			<option value="0">EN ATTENTE</option>
			<option <?php if($dt_fac['att']==1){echo ' selected';} ?> value="1">OK</option>
			<option <?php if($dt_fac['att']==2){echo ' selected';} ?> value="2">PREV.</option>
		</select>
	</td>
<?php
	if($aut['dev'] and $dt_fac['att']!=1){
?>
	<td><span class="dib" onClick="sup_fac(<?php echo $dt_fac['id']; ?>);"><img src="../prm/img/sup.png" /></span></td>
<?php
	}
?>
</tr>
<?php
}
?>
</table>
