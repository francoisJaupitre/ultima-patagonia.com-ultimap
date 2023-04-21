<?php 
$cbl = 'hbr_pay';
$id_crr = $dt_hbr_pay['crr'];
if(!$aut['res']){echo $prm_crr_nom[$id_crr];}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_crr_hbr_pay<?php echo $id_hbr_pay ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="crr_hbr_pay<?php echo $id_hbr_pay ?>" value="<?php echo $id_crr ?>" />
<?php
	echo $prm_crr_nom[$id_crr];
?>
		</div>
	</div>
	<div id="sel_crr_hbr_pay<?php echo $id_hbr_pay ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_crr_hbr_pay<?php echo $id_hbr_pay ?>" class="crr_fll" onkeyup="auto_lst('hbr_pay','hbr_pay_crr<?php echo $id_hbr_pay ?>',this.value,event);" />
		<div id="lst_hbr_pay_crr<?php echo $id_hbr_pay ?>"><?php include("vue_lst_crr.php") ?></div>
	</div>
</span>	
<?php
}
?>