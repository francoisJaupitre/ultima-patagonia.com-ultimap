<?php
$cbl = 'jrn_mdl';
$id =  $id_dev_mdl;
if(!isset($id_vll)){$id_vll=0;}
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_vll_mdl<?php echo $id_dev_mdl ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll_mdl<?php echo $id_dev_mdl ?>" value="<?php echo $id_vll ?>" />
<?php
if(isset($id_vll) and $id_vll>0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll_mdl<?php echo $id_dev_mdl ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll_mdl<?php echo $id_dev_mdl ?>" class="vll_fll" onkeyup="auto_lst('jrn_mdl','mdl_vll<?php echo $id_dev_mdl ?>',this.value,event);" /></div>
		<div id="lst_mdl_vll<?php echo $id_dev_mdl ?>"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_jrn_mdl<?php echo $id_dev_mdl ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->jrn->$id_lng; ?></div>
	</div>
	<div id="sel_jrn_mdl<?php echo $id_dev_mdl ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_jrn_mdl<?php echo $id_dev_mdl ?>" class="jrn_fll" onkeyup="auto_lst('jrn_mdl','jrn_mdl<?php echo $id_dev_mdl ?>',this.value,event);" /></div>
		<div id="lst_jrn_mdl<?php echo $id_dev_mdl ?>"><?php include("vue_lst_jrn.php") ?></div>
	</div>
</span>
