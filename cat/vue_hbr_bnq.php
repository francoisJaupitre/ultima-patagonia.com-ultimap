<?php
if(!$aut['cat'] or $id_frn) {
	if($id_bnq_hbr) {echo $bnq[$id_bnq_hbr].' ('.$pays[$id_lng][$bnq_pays[$id_bnq_hbr]].')';}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<div class="sel" onclick="vue_cmd('sel_bnq')">
	<img src="../prm/img/sel.png" />
	<div>
<?php
	if($id_bnq_hbr) {echo $bnq[$id_bnq_hbr].' ('.$pays[$id_lng][$bnq_pays[$id_bnq_hbr]].')';}
	else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_bnq" class="cmd mw200">
	<div><input type="text" id="ipt_sel_bnq" onkeyup="auto_lst('hbr','bnq',this.value,event);" /></div>
	<div id="lst_bnq"><?php include("vue_lst_bnq.php") ?></div>
</div>
<?php
}
?>
