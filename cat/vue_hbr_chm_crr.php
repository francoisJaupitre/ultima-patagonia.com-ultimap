<?php
if(!$aut['cat'] or $vrl) {echo $prm_crr_nom[$dt_trf['crr']];}
else{
?>
<div class="sel" onclick="vue_cmd('sel_crr_chm<?php echo $id_trf ?>')">
	<img src="../prm/img/sel.png" />
	<div><?php echo $prm_crr_nom[$dt_trf['crr']]; ?></div>
</div>
<div id="sel_crr_chm<?php echo $id_trf ?>" class="cmd mw200" style="width: 90px;">
	<div><input type="text" id="ipt_sel_crr_chm<?php echo $id_trf ?>" class="ipt_crr" onkeyup="auto_lst('hbr','crr_chm<?php echo $id_trf ?>',this.value,event);" /></div>
	<div id="lst_crr_chm<?php echo $id_trf ?>"><?php include("vue_lst_crr.php") ?></div>
</div>
<?php
}
?>
