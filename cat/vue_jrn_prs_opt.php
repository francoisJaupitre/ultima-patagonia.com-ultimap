<?php
include("lst_prs_opt.php");
if(isset($rq_prs_opt) and num_rows($rq_prs_opt)-count($prs_opt_id)>0) {
?>
<span class="vdfp"><?php echo $txt->ajtopt->$id_lng.':'; ?></span>
<div class="sel" onclick="vue_cmd('sel_prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="prs_opt_id<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>" value="<?php echo implode("_",$prs_opt_id); ?>" />
<?php
	echo $txt->prss->$id_lng;
?>
	</div>
</div>
<div id="sel_prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>" onkeyup="auto_lst('jrn_prs_opt','prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>',this.value,event);" /></div>
	<div id="lst_prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>"><?php include("vue_lst_prs_opt.php") ?></div>
</div>
<?php
	unset($rq_prs_opt);
}
else{echo $txt->nooptprs->$id_lng;}
?>