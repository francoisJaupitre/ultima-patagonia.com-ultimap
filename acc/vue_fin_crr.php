<?php
if(!$aut['adm_fin']){echo $prm_crr_nom[$cfg_crr_css[$css_id]];}
else{
?>
<div class="sel" onclick="vue_cmd('sel_css_crr<?php echo $css_id ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="css_crr<?php echo $css_id ?>" value="<?php echo $css_id ?>" />
<?php
	echo $prm_crr_nom[$cfg_crr_css[$css_id]];
?>
	</div>
</div>

<div id="sel_css_crr<?php echo $css_id ?>" class="cmd mw200">
	<input type="text" id="ipt_sel_css_crr<?php echo $css_id ?>" class="ipt_crr" onkeyup="auto_lst('cfg','css_crr<?php echo $css_id ?>',this.value,event);" />
	<div id="lst_css_crr<?php echo $css_id ?>"><?php include("vue_lst_css_crr.php") ?></div>
</div>
<?php
}
?>