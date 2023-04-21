<?php
if(!$aut['adm_fin']){echo $prm_crr_nom[$id_crr_cmp];}
else{
?>
<div class="sel" onclick="vue_cmd('sel_crr_cmp1')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="crr_cmp1" value="<?php echo $id_crr_cmp ?>" />
<?php
	if($id_crr_cmp>0){echo $prm_crr_nom[$id_crr_cmp];}
?>
	</div>
</div>

<div id="sel_crr_cmp1" class="cmd mw200">
	<input type="text" id="ipt_sel_crr_cmp1" class="ipt_crr" onkeyup="auto_lst('cfg','crr_cmp1',this.value,event);" />
	<div id="lst_crr_cmp1"><?php include("vue_lst_crr_cmp.php") ?></div>
</div>
<?php
}
?>
