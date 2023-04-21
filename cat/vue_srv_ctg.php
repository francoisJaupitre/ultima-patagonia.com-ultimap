<?php
if(!$aut['cat']) {
?>
<span class="vdp">
<?php
	if($dt_srv['ctg']>0) {echo $ctg_srv[$id_lng][$dt_srv['ctg']];}
	else{echo $txt->nodef->$id_lng;}
?>
</span>
<?php
}
else{
?>
<div style="display: inline-block">
	<div class="sel" onclick="vue_cmd('sel_ctg')">
		<img src="../prm/img/sel.png" />
		<div style="<?php if($dt_srv['ctg']==0) {echo 'background-color: red; font-weight: bold;';}?>">
			<input type="hidden" id="ctg_srv" value="<?php if($dt_srv['ctg']>0) {echo $dt_srv['ctg'];} else{echo '0';} ?>" />
	<?php
		if($dt_srv['ctg']>0) {echo $ctg_srv[$id_lng][$dt_srv['ctg']];}
		else{echo $txt->nodef->$id_lng;}
	?>
		</div>
	</div>
	<div id="sel_ctg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('srv','ctg_srv',this.value,event);" /></div>
		<div id="lst_ctg_srv"><?php include("vue_lst_ctg_srv.php") ?></div>
	</div>
</div>
<?php
}
?>
