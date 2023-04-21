<?php
$cbl = 'srv';
?>
<div class="sel" onclick="vue_cmd('sel_ctg_srv<?php echo $id_dev_srv ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="ctg_srv<?php echo $id_dev_srv ?>" value="<?php echo $id_ctg_srv ?>" />
<?php
if($id_ctg_srv>0){echo $ctg_srv[$id_lng][$id_ctg_srv];}
else{echo $txt->ctg->$id_lng;}
?>
	</div>
</div>
<div id="sel_ctg_srv<?php echo $id_dev_srv ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_ctg_srv<?php echo $id_dev_srv ?>" onkeyup="auto_lst('srv','srv_ctg<?php echo $id_dev_srv ?>',this.value,event);" /></div>
	<div id="lst_srv_ctg<?php echo $id_dev_srv ?>"><?php include("vue_lst_ctg_srv.php") ?></div>
</div>
