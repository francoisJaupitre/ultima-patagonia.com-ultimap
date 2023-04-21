<?php
if(!$aut['cat'] or $vrl) {
	if(!$id_frn) {echo $txt->nodef->$id_lng;}
	else{
?>
		<span class="lnk" onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn; ?>');"><?php echo $frn[$id_frn]; ?></span>
<?php
	}
}
else{
?>
<div class="sel" onclick="vue_cmd('sel_frn<?php echo $id_bss ?>')">
	<img src="../prm/img/sel.png" />
	<div>
<?php
	if(!$id_frn) {echo $txt->nodef->$id_lng;}
	else{echo $frn[$id_frn];}
?>
	</div>
</div>
<div id="sel_frn<?php echo $id_bss ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_frn<?php echo $id_bss ?>" onkeyup="auto_lst('srv','frn<?php echo $id_bss ?>',this.value,event);" /></div>
	<div id="lst_frn<?php echo $id_bss ?>"><?php include("vue_lst_frn.php") ?></div>
</div>
<?php
}
?>
