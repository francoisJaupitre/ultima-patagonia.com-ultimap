<?php
if(!$aut['dev'] and !$aut['res']){
?>
<div class="nosel"><?php if($dt_rmn_pax['room']>0){echo $room[$id_lng][$dt_rmn_pax['room']];} else{echo $txt->nodef->$id_lng;} ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_<?php echo $cbl?>_pax_room<?php echo $dt_rmn_pax['id']; ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php if($dt_rmn_pax['room']>0){echo $room[$id_lng][$dt_rmn_pax['room']];} else{echo $txt->nodef->$id_lng;} ?></div>
	</div>
	<div id="sel_<?php echo $cbl?>_pax_room<?php echo $dt_rmn_pax['id']; ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_<?php echo $cbl?>_pax_room<?php echo $dt_rmn_pax['id']; ?>" onkeyup="auto_lst('<?php echo $cbl ?>','<?php echo $cbl.'_pax_room'.$dt_rmn_pax['id']; ?>',this.value,event);" /></div>
		<div id="lst_<?php echo $cbl?>_pax_room<?php echo $dt_rmn_pax['id']; ?>"><?php include("vue_lst_room.php") ?></div>
	</div>
</span>
 <?php
}
?>
<span class="vatdib"><input type="number" <?php if(!$aut['dev'] and !$aut['res']){echo' disabled';} ?> style="width: 40px;" maxlength="8" value="<?php echo $dt_rmn_pax['nc']; ?>" onchange="maj('dev_<?php echo $cbl ?>_rmn_pax','nc',this.value,<?php echo $dt_rmn_pax['id'] ?>);" /></span>
<?php
if($aut['dev'] or $aut['res']){
?>
<span class="dib" onClick="sup_rmn_pax('<?php echo $cbl ?>',<?php echo $id_rmn.','.$id_pax ?>);"><img src="../prm/img/sup.png" /></span>
<?php
}
?>
