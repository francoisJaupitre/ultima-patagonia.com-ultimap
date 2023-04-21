<?php
$cbl = 'rgm';
$id_crr = $id_crr_rgm;
if(!$aut['dev']){echo $prm_crr_nom[$id_crr];}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_crr_rgm<?php echo $id_dev_hbr ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="crr_rgm<?php echo $id_dev_hbr ?>" value="<?php echo $id_crr ?>" />
<?php
	echo $prm_crr_nom[$id_crr];
?>
		</div>
	</div>
	<div id="sel_crr_rgm<?php echo $id_dev_hbr ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_crr_rgm<?php echo $id_dev_hbr ?>" class="crr_fll" onkeyup="auto_lst('rgm','rgm_crr<?php echo $id_dev_hbr ?>',this.value,event);" />
		<div id="lst_rgm_crr<?php echo $id_dev_hbr ?>"><?php include("vue_lst_crr.php") ?></div>
	</div>
</span>
<?php
}
?>
<span class="vdp"><?php	if($tx_rgm!=1){echo ' $'.$tx_rgm;} ?></span>
