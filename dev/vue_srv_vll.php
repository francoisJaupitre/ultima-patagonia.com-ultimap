<?php
$cbl = 'srv';
?>
<div class="sel" onclick="vue_cmd('sel_vll_srv<?php echo $id_dev_srv ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="vll_srv<?php echo $id_dev_srv ?>" value="<?php echo $id_vll ?>" />
<?php
if($id_vll>0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
	</div>
</div>
<div id="sel_vll_srv<?php echo $id_dev_srv ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_vll_srv<?php echo $id_dev_srv ?>" class="vll_fll" onkeyup="auto_lst('srv','srv_vll<?php echo $id_dev_srv ?>',this.value,event);" /></div>
	<div id="lst_srv_vll<?php echo $id_dev_srv ?>"><?php include("vue_lst_vll.php") ?></div>
</div>
