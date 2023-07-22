<table>
<?php
$rq_lieu = select("id,id_lieu,ord,shw","cat_prs_lieu","id_prs",$id,"ord");
while($dt_lieu = ftc_ass($rq_lieu)) {
?>
	<tr>
		<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $dt_lieu['ord']; ?>" onchange="updateData('cat_prs_lieu','ord',this.value,<?php echo $dt_lieu['id'].','.$id ?>)" /></td>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=lieu&id=<?php echo $dt_lieu['id_lieu']; ?>');"><?php echo $lieu[$dt_lieu['id_lieu']]; ?></td>
		<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_lieu['shw']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_prs_lieu','shw','1',<?php echo  $dt_lieu['id'] ?>)}else{updateData('cat_prs_lieu','shw','0',<?php echo  $dt_lieu['id'] ?>)};" /></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('prs_lieu',<?php echo $dt_lieu['id'] ?>,'prs',<?php echo $id ?>)"><img src="../prm/img/sup.png"></td>
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
		<div><input type="text" id="ipt_sel_lieu" onkeyup="auto_lst('prs','lieu',this.value,event);" /></div>
		<div id="lst_lieu"><?php include("vue_lst_lieu.php") ?></div>
	</div>
</span>
<?php
}
?>
