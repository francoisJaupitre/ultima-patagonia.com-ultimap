<strong><?php echo $txt->ctg->$id_lng ?></strong>
<table>
<?php
$rq_ctg = select("id,ctg_srv","cat_frn_ctg_srv","id_frn",$id);
while($dt_ctg = ftc_ass($rq_ctg)) {
?>
	<tr>
		<td class="td_cat"><?php echo $ctg_srv[$id_lng][$dt_ctg['ctg_srv']]; ?></td>
<?php
	if($aut['cat']) {
?>
		<td onclick="sup('frn_ctg_srv',<?php echo $dt_ctg['id'] ?>,'frn',<?php echo $id ?>)"><img class="text-center" src="../prm/img/sup.png" /></td>
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
	<div class="sel" onclick="vue_cmd('sel_ctg')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajt->$id_lng; ?></div>
	</div>
	<div id="sel_ctg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('frn','ctg_srv',this.value,event);" /></div>
		<div id="lst_ctg_srv"><?php include("vue_lst_ctg_srv.php") ?></div>
	</div>
</span>
<?php 
}
?>