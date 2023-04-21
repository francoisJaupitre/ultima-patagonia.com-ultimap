<div class="sel" onclick="vue_cmd('sel_lgg')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="lgg" value="<?php echo $id_lgg ?>" />
<?php
echo $nom_lgg[$id_lgg];
?>
	</div>
</div>
<div id="sel_lgg" class="cmd mw200">
	<input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('cfg','lgg',this.value,event);" />
	<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
</div>