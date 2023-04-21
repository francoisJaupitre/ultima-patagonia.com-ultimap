<?php
if(!$aut['dev'] or $id_cat_prs !=0 or $nb_srv > 0 or $nb_hbr > 0){
?>
<span class="vdfp">
<?php
	if($id_ctg_prs>0){echo $ctg_prs[$id_lng][$id_ctg_prs];}
	else{echo $txt->ctg->$id_lng;}
?>
</span>
<?php
}
else{
	$cbl = 'prs';
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_ctg_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
	if($id_ctg_prs>0){echo $ctg_prs[$id_lng][$id_ctg_prs];}
	else{echo $txt->ctg->$id_lng;}
?>
	</div>
	</div>
	<div id="sel_ctg_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg_prs<?php echo $id_dev_prs ?>" onkeyup="auto_lst('prs','ctg_prs<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_ctg_prs<?php echo $id_dev_prs ?>"><?php include("vue_lst_ctg_prs.php") ?></div>
	</div>
</span>
<?php
}
?>
