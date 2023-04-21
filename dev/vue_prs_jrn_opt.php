<?php
include("lst_prs_jrn_opt.php");
if(isset($lst_prs_jrn_opt)){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_prs_jrn_opt<?php echo $id_dev_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->prss->$id_lng; ?></div>
	</div>
	<div id="sel_prs_jrn_opt<?php echo $id_dev_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_prs_jrn_opt<?php echo $id_dev_jrn ?>" class="prs_fll" onkeyup="auto_lst('prs_jrn_opt','prs_jrn_opt<?php echo $id_dev_jrn ?>',this.value,event);" /></div>
		<div id="lst_prs_jrn_opt<?php echo $id_dev_jrn ?>"><?php include("vue_lst_prs_jrn_opt.php") ?></div>
	</div>
</span>
<?php
	unset($lst_prs_jrn_opt);
}
else{
?>
<span class="vdp"><?php echo $txt->nooptprs2->$id_lng; ?></span>
<?php
}
?>
