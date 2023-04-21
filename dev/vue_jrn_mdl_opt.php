<?php
include("lst_jrn_mdl_opt.php");
if(isset($lst_jrn_mdl_opt)){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_jrn_mdl_opt<?php echo $id_dev_mdl ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->jrns->$id_lng; ?></div>
	</div>
	<div id="sel_jrn_mdl_opt<?php echo $id_dev_mdl ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_jrn_mdl_opt<?php echo $id_dev_mdl ?>" class="jrn_fll" onkeyup="auto_lst('jrn_mdl_opt','jrn_mdl_opt<?php echo $id_dev_mdl ?>',this.value,event);" /></div>
		<div id="lst_jrn_mdl_opt<?php echo $id_dev_mdl ?>"><?php include("vue_lst_jrn_mdl_opt.php") ?></div>
	</div>
</span>
<?php
	unset($lst_jrn_mdl_opt);
}
else{
?>
<span class="vdp"><?php echo $txt->nooptjrn2->$id_lng; ?></span>
<?php
}
?>
