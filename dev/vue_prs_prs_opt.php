<?php
include("lst_prs_prs_opt.php");
if(isset($rq_lst_prs_prs_opt) and num_rows($rq_lst_prs_prs_opt)-count($prs_opt_id_cat)>0){
?>
<span class="vdfp"><?php echo $txt->ajtopt->$id_lng.':'; ?></span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="prs_opt_id_cat<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" value="<?php if(isset($prs_opt_id_cat)){echo implode("_",$prs_opt_id_cat);} ?>" />
<?php
	echo $txt->prss->$id_lng;
?>
		</div>
	</div>
	<div id="sel_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>" class="prs_fll" onkeyup="auto_lst('prs_prs_opt','prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>',this.value,event);" /></div>
		<div id="lst_prs_prs_opt<?php echo $id_dev_jrn.'__'.$ord_prs.'__'.$id_ant_prs ?>"><?php include("vue_lst_prs_prs_opt.php") ?></div>
	</div>
</span>
<?php
	unset($rq_lst_prs_prs_opt);
}
elseif($id_cat_jrn >0){echo $txt->nooptprs1->$id_lng;}
else{echo $txt->nooptprs->$id_lng;}
?>
