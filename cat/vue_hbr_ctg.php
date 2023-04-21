<?php
if(!$aut['cat']) {
	if($dt_hbr['ctg']>0) {echo $ctg_hbr[$id_lng][$dt_hbr['ctg']];}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<div class="sel" onclick="vue_cmd('sel_ctg')">
	<img src="../prm/img/sel.png" />
	<div style="<?php if($dt_hbr['ctg']==0) {echo 'background-color: red; font-weight: bold;';}?>">
		<input type="hidden" id="ctg_hbr" value="<?php if($dt_hbr['ctg']>0) {echo $dt_hbr['ctg'];} else{echo '0';} ?>" />
<?php
	if($dt_hbr['ctg']>0) {echo $ctg_hbr[$id_lng][$dt_hbr['ctg']];}
	else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_ctg" class="cmd mw200">
	<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('hbr','ctg_hbr',this.value,event);" /></div>
	<div id="lst_ctg_hbr"><?php include("vue_lst_ctg_hbr.php") ?></div>
</div>
<?php
}
?>
