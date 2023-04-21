<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rgn_crc<?php echo $id_dev_crc ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="rgn_crc<?php echo $id_dev_crc ?>" value="<?php echo $id_rgn ?>" />
<?php
if(isset($id_rgn) and $id_rgn>0){echo stripslashes($rgn[$id_rgn]);}
else{echo $txt->rgn->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_rgn_crc<?php echo $id_dev_crc ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgn_crc<?php echo $id_dev_crc ?>" class="rgn_fll" onkeyup="auto_lst('crc','crc_rgn<?php echo $id_dev_crc ?>',this.value,event);" /></div>
		<div id="lst_crc_rgn<?php echo $id_dev_crc ?>"><?php include("vue_lst_rgn.php") ?></div>
	</div>
</span>
<?php
if(isset($id_rgn) and $id_rgn>0){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_mdl<?php echo $id_dev_crc ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->mdl->$id_lng; ?></div>
	</div>
	<div id="sel_mdl<?php echo $id_dev_crc ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_mdl<?php echo $id_dev_crc ?>" class="mdl_fll" onkeyup="auto_lst('crc','mdl<?php echo $id_dev_crc ?>',this.value,event);" /></div>
		<div id="lst_mdl<?php echo $id_dev_crc ?>"><?php include("vue_lst_mdl.php") ?></div>
	</div>
</span>
<?php
}
?>
