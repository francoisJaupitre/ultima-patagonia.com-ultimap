<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rgn')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="rgn" value="<?php echo $id_rgn ?>" />
<?php
if(isset($id_rgn) and $id_rgn>0) {echo $rgn[$id_rgn];}
else{echo $txt->rgn->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_rgn" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('crc','rgn',this.value,event);" /></div>
		<div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
	</div>
</span>
<?php
if(isset($id_rgn) and $id_rgn>0) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_mdl')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->mdl->$id_lng; ?></div>
	</div>
	<div id="sel_mdl" class="cmd mw200">
		<div><input type="text" id="ipt_sel_mdl" onkeyup="auto_lst('crc','mdl',this.value,event);" /></div>
		<div id="lst_mdl"><?php include("vue_lst_mdl.php") ?></div>
	</div>
</span>
<?php
}
?>