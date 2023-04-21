<?php
$cbl = 'jrn';
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_vll_jrn<?php echo $id_dev_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll_jrn<?php echo $id_dev_jrn ?>" value="<?php echo $id_vll ?>" />
<?php
if($id_vll>0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll_jrn<?php echo $id_dev_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll_jrn<?php echo $id_dev_jrn ?>" class="vll_fll" onkeyup="auto_lst('jrn','jrn_vll<?php echo $id_dev_jrn ?>',this.value,event);" /></div>
		<div id="lst_jrn_vll<?php echo $id_dev_jrn ?>"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_ctg_prs_jrn<?php echo $id_dev_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="ctg_jrn<?php echo $id_dev_jrn ?>" value="<?php echo $id_ctg_prs ?>" />
<?php
if($id_ctg_prs>0){echo $ctg_prs[$id_lng][$id_ctg_prs];}
else{echo $txt->ctg->$id_lng;}
?>
</div>
	</div>
	<div id="sel_ctg_prs_jrn<?php echo $id_dev_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg_prs_jrn<?php echo $id_dev_jrn ?>" onkeyup="auto_lst('jrn','jrn_ctg<?php echo $id_dev_jrn ?>',this.value,event);" /></div>
		<div id="lst_jrn_ctg<?php echo $id_dev_jrn ?>"><?php include("vue_lst_ctg_prs.php") ?></div>
	</div>
</span>
<?php
if($id_vll>0 and $id_ctg_prs>0){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_prs<?php echo $id_dev_jrn ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->prs->$id_lng; ?></div>
	</div>
	<div id="sel_prs<?php echo $id_dev_jrn ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_prs<?php echo $id_dev_jrn ?>" class="prs_fll" onkeyup="auto_lst('jrn','prs<?php echo $id_dev_jrn ?>',this.value,event);" /></div>
		<div id="lst_prs<?php echo $id_dev_jrn ?>"><?php include("vue_lst_prs.php") ?></div>
	</div>
</span>
<?php
}
?>
