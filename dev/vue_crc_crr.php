<?php
$cbl = 'crc';
$id_crr = $id_crr_crc;
if(!$aut['dev'] or $cnf>0){
?>
<div class="nosel"><?php echo $prm_crr_nom[$id_crr]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_crr')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="crr" value="<?php echo $id_crr ?>" />
<?php
	echo $prm_crr_nom[$id_crr];
?>
		</div>
	</div>
	<div id="sel_crr" class="cmd mw200">
		<input type="text" id="ipt_sel_crr" class="ipt_crr crr_fll" onkeyup="auto_lst('crc','crr',this.value,event);" />
		<div id="lst_crr"><?php include("vue_lst_crr.php") ?></div>
	</div>
</span>	
<?php
}
?>