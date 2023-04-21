<?php
$cbl='hbr';
?>
<div class="sel" onclick="vue_cmd('sel_rgm_hbr<?php echo $id_dev_hbr ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="rgm_hbr<?php echo $id_dev_hbr ?>" value="<?php echo $id_rgm ?>" />
<?php
if($id_rgm > 0){echo $rgm[$id_lng][$id_rgm];}
else{echo $txt->rgm->$id_lng;}
?>
	</div>
</div>
<div id="sel_rgm_hbr<?php echo $id_dev_hbr ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_rgm_hbr<?php echo $id_dev_hbr ?>" onkeyup="auto_lst('hbr','hbr_rgm<?php echo $id_dev_hbr ?>',this.value,event);" /></div>
	<div id="lst_hbr_rgm<?php echo $id_dev_hbr ?>"><?php include("vue_lst_rgm.php") ?></div>
</div>