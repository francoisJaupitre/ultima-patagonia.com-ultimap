<?php 
if(!$aut['cat']) { 
	if($dt_frn['id_bnq']>0) {echo $bnq[$dt_frn['id_bnq']].' ('.$pays[$id_lng][$bnq_pays[$dt_frn['id_bnq']]].')';}
	else{echo $txt->nodef->$id_lng;}	
}
else{
?> 
<div class="sel" onclick="vue_cmd('sel_bnq')">
	<img src="../prm/img/sel.png" />
	<div>
<?php
	if($dt_frn['id_bnq']>0) {echo $bnq[$dt_frn['id_bnq']].' ('.$pays[$id_lng][$bnq_pays[$dt_frn['id_bnq']]].')';}
	else{echo $txt->nodef->$id_lng;}	
?>
	</div>
</div>
<div id="sel_bnq" class="cmd mw200">
	<div><input type="text" id="ipt_sel_bnq" onkeyup="auto_lst('frn','bnq',this.value,event);" /></div>
	<div id="lst_bnq"><?php include("vue_lst_bnq.php") ?></div>
</div>
<?php 
}
?>