<?php
if(!isset($id_ctg_srv)){$id_ctg_srv=0;}
$id_dev_hbr = 0;
$cbl = 'prs';
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_vll_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll_prs<?php echo $id_dev_prs ?>" value="<?php echo $id_vll ?>" />
<?php
if($id_vll>0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll_prs<?php echo $id_dev_prs ?>" class="vll_fll" onkeyup="auto_lst('prs','prs_vll<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_prs_vll<?php echo $id_dev_prs ?>"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_ctg_srv_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="ctg_prs<?php echo $id_dev_prs ?>" value="<?php echo $id_ctg_srv ?>" />
<?php
if($id_ctg_srv>0){echo $ctg_srv[$id_lng][$id_ctg_srv];}
else{echo $txt->ctg->$id_lng;}
?>
</div>
	</div>
	<div id="sel_ctg_srv_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg_srv_prs<?php echo $id_dev_prs ?>" onkeyup="auto_lst('prs','prs_ctg<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_prs_ctg<?php echo $id_dev_prs ?>"><?php include("vue_lst_ctg_srv.php") ?></div>
	</div>
</span>
<?php
if($id_ctg_srv>1){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_srv_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->srv->$id_lng; ?></div>
	</div>
	<div id="sel_srv_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_srv_prs<?php echo $id_dev_prs ?>" class="srv_fll" onkeyup="auto_lst('prs','prs_srv<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_prs_srv<?php echo $id_dev_prs ?>"><?php include("vue_lst_srv.php") ?></div>
	</div>
</span>
<?php
}
elseif($id_ctg_srv == 1){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rgm_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="rgm_prs<?php echo $id_dev_prs ?>" value="<?php echo $id_rgm ?>" />
<?php
	if($id_rgm>0){echo $rgm[$id_lng][$id_rgm];}
	else{echo $txt->rgm->$id_lng;}
?>
</div>
	</div>
	<div id="sel_rgm_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgm_prs<?php echo $id_dev_prs ?>" onkeyup="auto_lst('prs','prs_rgm<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_prs_rgm<?php echo $id_dev_prs ?>"><?php include("vue_lst_rgm.php") ?></div>
	</div>
</span>
<?php
	include("vue_prs_hbr.php");
}
?>
