<?php 
if(!$aut['cat']) {echo $ctg_prs[$id_lng][$dt_prs['ctg']];}
else{
?>
<div class="sel" onclick="vue_cmd('sel_prs_ctg')">
	<img src="../prm/img/sel.png" />
	<div style="<?php if($dt_prs['ctg']==0) {echo 'background-color: red; font-weight: bold;';}?>">
		<input type="hidden" id="ctg_prs" value="<?php if($dt_prs['ctg']>0) {echo $dt_prs['ctg'];} else{echo '0';} ?>" />
<?php
	if($dt_prs['ctg']>0) {echo $ctg_prs[$id_lng][$dt_prs['ctg']];}
	else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_prs_ctg" class="cmd mw200">
	<div><input type="text" id="ipt_sel_prs_ctg" onkeyup="auto_lst('prs','ctg_prs',this.value,event);" /></div>
	<div id="lst_ctg_prs"><?php include("vue_lst_ctg_prs.php") ?></div>
</div>
<?php
}
?>