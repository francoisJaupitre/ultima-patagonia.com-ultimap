<?php
if(!$aut['cat']) {
	if($dt_clt['id_ctg']>0) {echo $nom_ctg_clt[$dt_clt['id_ctg']];}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<div class="sel" onclick="vue_cmd('sel_ctg')">
	<img src="../prm/img/sel.png" />
	<div style="<?php if($dt_clt['id_ctg']==0) {echo 'background-color: red; font-weight: bold;';}?>">
		<input type="hidden" id="ctg_clt" value="<?php if($dt_clt['id_ctg']>0) {echo $dt_clt['id_ctg'];} else{echo '0';} ?>" />
<?php
	if($dt_clt['id_ctg']>0) {echo $nom_ctg_clt[$dt_clt['id_ctg']];}
	else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_ctg" class="cmd mw200">
	<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('clt','ctg_clt',this.value,event);" /></div>
	<div id="lst_ctg_clt"><?php include("vue_lst_ctg_clt.php") ?></div>
</div>
<?php
}
?>
