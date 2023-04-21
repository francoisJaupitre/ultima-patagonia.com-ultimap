<?php
if(!$aut['cat']) {
	if($dt_vll['id_pays']>0) {echo $pays[$id_lng][$dt_vll['id_pays']];}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_pays')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
	if($dt_vll['id_pays']>0) {echo $pays[$id_lng][$dt_vll['id_pays']];}
	else{echo $txt->nodef->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_pays" class="cmd mw200">
		<div><input type="text" id="ipt_sel_pays" onkeyup="auto_lst('vll','pays',this.value,event);" /></div>
		<div id="lst_pays"><?php include("vue_lst_pays.php") ?></div>
	</div>
</span>
<?php
}
?>
<input type="hidden" id="nom_pays" value="<?php if($dt_vll['id_pays']>0) {echo $pays[$id_lng][$dt_vll['id_pays']];} ?>" />
