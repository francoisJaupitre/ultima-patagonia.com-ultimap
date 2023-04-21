<?php
$cbl = 'srv';
$id_crr = $id_crr_srv;
if(!$aut['dev']){echo $prm_crr_nom[$id_crr];}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_crr_srv<?php echo $id_dev_srv ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="crr_srv<?php echo $id_dev_srv ?>" value="<?php echo $id_crr ?>" />
<?php
	if($id_crr>0){echo $prm_crr_nom[$id_crr];}
	else{echo $txt->nodef->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_crr_srv<?php echo $id_dev_srv ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_crr_srv<?php echo $id_dev_srv ?>" class="crr_fll" onkeyup="auto_lst('srv','srv_crr<?php echo $id_dev_srv ?>',this.value,event);" />
		<div id="lst_srv_crr<?php echo $id_dev_srv ?>"><?php include("vue_lst_crr.php") ?></div>
	</div>
</span>
<?php
}
?>
<span class="vdp"><?php	if($tx_srv!=1){echo ' $'.$tx_srv;} ?></span>
