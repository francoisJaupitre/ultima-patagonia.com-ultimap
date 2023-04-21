<table>
<?php
$rq_clt = select("id,id_clt","cat_crc_clt","id_crc",$id);
while($dt_clt = ftc_ass($rq_clt)) {
	$lst_clt[] = $dt_clt['id_clt'];
?>
	<tr>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $dt_clt['id_clt']; ?>');"><?php echo stripslashes($clt[$dt_clt['id_clt']]); ?></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('crc_clt',<?php echo $dt_clt['id'] ?>,'crc',<?php echo $id ?>);"><img src="../prm/img/sup.png" /></td>
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
<span>
	<div class="sel" onclick="vue_cmd('sel_clt')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajt->$id_lng; ?></div>
	</div>
	<div id="sel_clt" class="cmd mw200">
		<div><input type="text" id="ipt_sel_clt" onkeyup="auto_lst('crc','clt',this.value,event);" /></div>
		<div id="lst_clt"><?php include("vue_lst_clt.php") ?></div>
	</div>
</span>
<?php
}
?>
