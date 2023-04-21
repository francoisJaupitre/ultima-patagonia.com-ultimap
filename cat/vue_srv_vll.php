<?php
if(!$aut['cat']) {
?>
<span class="vdp"><?php echo $vll[$id_vll]; ?></span>
<?php
}
else{
?>
<div style="display: inline-block">
	<div class="sel" onclick="vue_cmd('sel_vll')">
		<img src="../prm/img/sel.png" />
		<div style="<?php if(!$id_vll) {echo 'background-color: red; font-weight: bold;';}?>">
			<input type="hidden" id="vll" value="<?php if($id_vll) {echo $id_vll;} else{echo '0';} ?>" />
	<?php
		if($id_vll) {echo $vll[$id_vll];}
		else{echo $txt->nodef->$id_lng;}
	?>
		</div>
	</div>
	<div id="sel_vll" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll" onkeyup="auto_lst('srv','vll',this.value,event);" /></div>
		<div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
	</div>
</div>
<?php
}
?>
