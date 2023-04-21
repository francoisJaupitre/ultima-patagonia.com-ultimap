<table>
<?php
$rq_lieu = select("id,id_lieu,ord","cat_jrn_lieu","id_jrn",$id,"ord");
while($dt_lieu = ftc_ass($rq_lieu)) {
?>
	<tr>
		<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $dt_lieu['ord']; ?>" onchange="maj('cat_jrn_lieu','ord',this.value,<?php echo $dt_lieu['id'].','.$id ?>)" /></td>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=lieu&id=<?php echo $dt_lieu['id_lieu']; ?>');"><?php echo $lieu[$dt_lieu['id_lieu']]; ?></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('jrn_lieu',<?php echo $dt_lieu['id'] ?>,'jrn',<?php echo $id ?>)"><img src="../prm/img/sup.png"></td>
<?php
	}
?>
	</tr>
<?php
}
?>
</table>
<?php
if($aut['cat']) {
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_lieu')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajt->$id_lng; ?></div>
	</div>
	<div id="sel_lieu" class="cmd mw200">
		<div><input type="text" id="ipt_sel_lieu" onkeyup="auto_lst('jrn','lieu',this.value,event);" /></div>
		<div id="lst_lieu"><?php include("vue_lst_lieu.php") ?></div>
	</div>
</span>
<?php
}
?>
