<?php
if(!$aut['cat']) {echo $prm_crr_nom[$dt_clt['crr']];}
else{
?> 
<div class="sel" onclick="vue_cmd('sel_crr')">
	<img src="../prm/img/sel.png" />
	<div><?php echo $prm_crr_nom[$dt_clt['crr']]; ?></div>
</div>
<div id="sel_crr" class="cmd mw200">
	<div><input type="text" id="ipt_sel_crr" class="ipt_crr" onkeyup="auto_lst('clt','crr',this.value,event);" /></div>
	<div id="lst_crr"><?php include("vue_lst_crr.php") ?></div>
</div>
<?php
}
?>