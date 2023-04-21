<?php
if(!$aut['dev']){
?>
<input type="hidden" id="lgg" value="<?php echo $lgg_crc ?>" />
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_lgg')">
		<img src="../prm/img/sel.png" />
		<input type="hidden" id="lgg" value="<?php echo $lgg_crc ?>" />
		<div><?php echo $nom_lgg[$lgg_crc]; ?></div>
	</div>
	<div id="sel_lgg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('crc','lgg',this.value,event);" /></div>
		<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
	</div>
</span>
<?php
}
?>