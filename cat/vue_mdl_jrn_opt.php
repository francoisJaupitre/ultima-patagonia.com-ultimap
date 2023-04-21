<?php
include("lst_jrn_opt.php");
if(isset($rq_jrn_opt) and num_rows($rq_jrn_opt)-count($jrn_opt_id)>0) {
?>
<span class="vdfp"><?php echo $txt->ajtopt->$id_lng.':'; ?></span>
<div class="sel" onclick="vue_cmd('sel_jrn_opt<?php echo $id_jrn_sel.'__',$ord_jrn ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="jrn_opt_id<?php echo $id_jrn_sel.'__',$ord_jrn ?>" value="<?php echo implode("_",$jrn_opt_id); ?>" />
<?php
	echo $txt->jrns->$id_lng;
?>
	</div>
</div>
<div id="sel_jrn_opt<?php echo $id_jrn_sel.'__',$ord_jrn ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_jrn_opt<?php echo $id_jrn_sel.'__',$ord_jrn ?>" onkeyup="auto_lst('mdl_jrn_opt','jrn_opt<?php echo $id_jrn_sel.'__',$ord_jrn ?>',this.value,event);" /></div>
	<div id="lst_jrn_opt<?php echo $id_jrn_sel.'__',$ord_jrn ?>"><?php include("vue_lst_jrn_opt.php") ?></div>
</div>
<?php
	unset($rq_jrn_opt);
}
else{echo $txt->nooptjrn->$id_lng;}
?>
