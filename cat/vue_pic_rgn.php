<?php
if(!$aut['cat']) {
	if($dt_pic['id_rgn']>0) {echo $rgn[$dt_pic['id_rgn']];}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_rgn')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
	if($dt_pic['id_rgn']>0) {echo $rgn[$dt_pic['id_rgn']];}
	else{echo $txt->nodef->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_rgn" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('pic','rgn',this.value,event);" /></div>
		<div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
	</div>
</span>
<?php
}
?>