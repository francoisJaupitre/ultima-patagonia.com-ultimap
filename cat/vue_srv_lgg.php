<?php
if($dt_srv['ctg']>0) {
	if(!$aut['cat']) {
		if($lgg_ctg_srv[$dt_srv['ctg']]) {echo $nom_lgg_lgg[$id_lng][$dt_srv['lgg']];}
	}
	elseif($lgg_ctg_srv[$dt_srv['ctg']]) {
?>
<div class="sel" onclick="vue_cmd('sel_ctg_lgg')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="ctg_lgg" value="<?php if($dt_srv['lgg']>0) {echo $dt_srv['lgg'];} else{echo '0';} ?>" />
<?php
		if($dt_srv['lgg']>0) {echo $nom_lgg_lgg[$id_lng][$dt_srv['lgg']];}
		else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_ctg_lgg" class="cmd mw200">
	<div><input type="text" id="ipt_sel_ctg_lgg" onkeyup="auto_lst('srv','ctg_lgg',this.value,event);" /></div>
	<div id="lst_ctg_lgg"><?php include("vue_lst_ctg_lgg.php") ?></div>
</div>
<?php
	}
}
