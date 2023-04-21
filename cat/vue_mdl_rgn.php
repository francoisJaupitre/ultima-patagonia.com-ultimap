<table>
<?php
$rq_rgn = select("id,id_rgn","cat_mdl_rgn","id_mdl",$id);
while($dt_rgn = ftc_ass($rq_rgn)) {
	$lst_rgn[] = $dt_rgn['id_rgn'];
?>
	<tr>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=rgn&id=<?php echo $dt_rgn['id_rgn']; ?>');"><?php echo stripslashes($rgn[$dt_rgn['id_rgn']]); ?></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('mdl_rgn',<?php echo $dt_rgn['id'] ?>,'mdl',<?php echo $id ?>)"><img src="../prm/img/sup.png" /></td>
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
	<div class="sel" onclick="vue_cmd('sel_rgn')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajt->$id_lng; ?></div>
	</div>
	<div id="sel_rgn" class="cmd mw200">
		<div><input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('mdl','rgn',this.value,event);" /></div>
		<div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
	</div>
</span>
<?php
}
?>
