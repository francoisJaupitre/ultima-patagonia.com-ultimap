<?php
if(!isset($id_vll)) {$id_vll=0;}
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_vll')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
if(isset($id_vll) and $id_vll>0) {echo $vll[$id_vll];}
else{echo $txt->vlldep->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_vll" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll" onkeyup="auto_lst('mdl','vll',this.value,event);" /></div>
		<div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<?php
if(isset($id_vll) and $id_vll>0) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_jrn')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->jrn->$id_lng; ?></div>
	</div>
	<div id="sel_jrn" class="cmd mw200">
		<div><input type="text" id="ipt_sel_jrn" onkeyup="auto_lst('mdl','jrn',this.value,event);" /></div>
		<div id="lst_jrn"><?php include("vue_lst_jrn.php") ?></div>
	</div>
</span>
<?php
}
?>