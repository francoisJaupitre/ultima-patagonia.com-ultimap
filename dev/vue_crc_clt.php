<?php
if(!$aut['dev'] or !$flg_clt or $cnf>0){
?>
<div class="nosel lnk inf<?php echo $clt_crc ?>clt" onmouseover="vue_elem('inf',<?php echo $clt_crc ?>,'clt')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $clt_crc; ?>');"><?php echo stripslashes($clt[$clt_crc]); ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_clt')">
		<img src="../prm/img/sel.png" />
		<div><?php echo stripslashes($clt[$clt_crc]); ?></div>
	</div>
	<div id="sel_clt" class="cmd mw200">
		<div><input type="text" id="ipt_sel_clt" onkeyup="auto_lst('crc','clt',this.value,event);" /></div>
		<div id="lst_clt"><?php include("vue_lst_clt.php") ?></div>
	</div>
</span>
<?php
}
?>
