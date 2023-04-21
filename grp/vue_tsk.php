<div class="lsb">
	<span class="vdfp2"><?php echo $txt->tsk->$id_lng ?></span>
<?php
include("../prm/usr.php");
?>
	<span class="dib" onclick="ajt_tsk();"><img src="../prm/img/ajt.png" /></span>
</div>
<table class="dsg w-100">
<?php
$rq_tsk = sel_quo("*","grp_tsk","id_grp",$id_grp,"date");
while($dt_tsk = ftc_ass($rq_tsk)){
?>
<tr>
	<td class="td_acc"><input <?php if(!$aut['tsk'] and $id_usr != $dt_tsk['respon']){echo ' disabled';} ?> id="tsk_date<?php echo $dt_tsk['id']; ?>" type="text" class="w74" placeholder="jj/mm/aaaa" style="padding: 0 5px;" value="<?php if($dt_tsk['date']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_tsk['date']));}; ?>" onChange="maj('grp_tsk','date',this.value,<?php echo $dt_tsk['id']; ?>)" /></td>
	<td class="td_acc">
		<select <?php if(!$aut['tsk'] and $id_usr != $dt_tsk['usr']) {echo ' disabled';} ?> onchange="maj('grp_tsk','respon',this.value,<?php echo $dt_tsk['id'] ?>)">
<?php
	foreach($lst_usr as $usr_id => $qui){
?>
			<option <?php if($usr_id==$dt_tsk['respon']){echo ' selected';} ?> value="<?php echo $usr_id ?>"><?php echo $qui; ?></option>
<?php
	}
?>
		</select>
	</td>
	<td class="td_acc">
		<select <?php if(!$aut['tsk'] and $id_usr != $dt_tsk['respon']){echo ' disabled';} ?> style="width:35px; background-color: <?php echo $col_stat_tsk[$dt_tsk['stat']] ?>;" onchange="maj('grp_tsk','stat',this.value,<?php echo $dt_tsk['id'] ?>)">
<?php
	foreach($stat_tsk[$id_lng] as $id_stat => $nom){
?>
			<option <?php if($id_stat==$dt_tsk['stat']){echo ' selected';} ?> value="<?php echo $id_stat ?>"><?php echo $nom; ?></option>
<?php
	}
?>
		</select>
	</td>
<?php
	if($dt_tsk['stat']==0 and ($dt_tsk['respon']==$id_usr or $aut['tsk'])){
?>
	<td class="w-100"><span class="dib" onClick="sup_tsk(<?php echo $dt_tsk['id']; ?>);"><img src="../prm/img/sup.png" /></span></td>
<?php
	}
	elseif($dt_tsk['dt_grp']!='0000-00-00'){
?>
	<td class="w-100"><?php echo date("d/m/Y",strtotime($dt_tsk['dt_grp'])); ?></td>
<?php
	}
?>
</tr>
<tr>
	<td class="td_acc" colspan="4"><input <?php if(!$aut['tsk'] and $id_usr != $dt_tsk['respon']){echo ' disabled';} ?> type="text" style="width: 380px;" value="<?php echo stripslashes($dt_tsk['nom']) ?>" onChange="maj('grp_tsk','nom',this.value,<?php echo $dt_tsk['id'] ?>)" /></td>
</tr>
<tr>
	<td colspan="4"><hr /></td>
</tr>
<?php
}
?>
</table>
