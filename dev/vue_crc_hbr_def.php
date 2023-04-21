<?php
if($aut['dev'] and $cnf<1){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_hbr_def')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->hbrdef->$id_lng; ?></div>
	</div>
	<div id="sel_hbr_def" class="cmd mw200">
		<input type="text" id="ipt_sel_hbr_def" class="ipt_hbr_def" onkeyup="auto_lst('crc','hbr_def',this.value,event);" />
		<div id="lst_hbr_def"><?php include("vue_lst_hbr_def.php") ?></div>
	</div>
</span>
<?php
}
?>
