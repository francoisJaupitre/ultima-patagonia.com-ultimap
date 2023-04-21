<strong><?php echo $txt->vlls->$id_lng ?></strong>
<table>
<?php
$rq_vll = select("id,id_vll","cat_frn_vll","id_frn",$id);
while($dt_vll = ftc_ass($rq_vll)) {
?>
	<tr>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=vll&id=<?php echo $dt_vll['id_vll'] ?>');"><?php  echo stripslashes($vll[$dt_vll['id_vll']]);?></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('frn_vll',<?php echo $dt_vll['id'] ?>,'frn',<?php echo $id ?>)"><img src="../prm/img/sup.png" /></td>
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
	<div class="sel" onclick="vue_cmd('sel_vll')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajt->$id_lng; ?></div>
	</div>
	<div id="sel_vll" class="cmd mw200">
		<div><input type="text" id="ipt_sel_vll" onkeyup="auto_lst('frn','vll',this.value,event);" /></div>
		<div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
	</div>
</span>
<?php 
}
?>