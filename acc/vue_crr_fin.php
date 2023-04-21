<?php
if(1==1 or !$aut['adm_fin']){echo $prm_crr_nom[$id_crr_fin];} //choix non programmé dans bdd -> dollar only
else{
?>
<div class="sel" onclick="vue_cmd('sel_crr_fin1')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="crr_fin1" value="<?php echo $id_crr_fin ?>" />
<?php
	if($id_crr_fin>0){echo $prm_crr_nom[$id_crr_fin];}
?>
	</div>
</div>

<div id="sel_crr_fin1" class="cmd mw200">
	<input type="text" id="ipt_sel_crr_fin1" class="ipt_crr" onkeyup="auto_lst('cfg','crr_fin1',this.value,event);" />
	<div id="lst_crr_fin1"><?php include("vue_lst_crr_fin.php") ?></div>
</div>
<?php
}
?>
