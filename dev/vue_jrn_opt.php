<?php
include("lst_jrn_opt.php");
if(isset($rq_jrn_opt) and num_rows($rq_jrn_opt)-count($jrn_opt_id_cat)>0){
?>
<span class="vdfp"><?php echo $txt->ajtopt->$id_lng.':'; ?></span>
<div class="sel" onclick="vue_cmd('sel_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="jrn_opt_id_cat<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" value="<?php if(isset($jrn_opt_id_cat)){echo implode("_",$jrn_opt_id_cat);} ?>" />
<?php
	echo $txt->jrns->$id_lng;
?>
	</div>
</div>
<div id="sel_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>" class="jrn_fll" onkeyup="auto_lst('jrn_opt','jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>',this.value,event);" /></div>
	<div id="lst_jrn_opt<?php echo $id_dev_mdl.'__'.$ord_jrn.'__'.$id_sel_jrn ?>"><?php include("vue_lst_jrn_opt.php") ?></div>
</div>
<?php
	unset($rq_jrn_opt);
}
elseif($id_cat_mdl !=0){echo $txt->nooptjrn2->$id_lng;}
else{echo $txt->nooptjrn->$id_lng;}
?>
