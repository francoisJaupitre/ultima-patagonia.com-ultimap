<table class="w-100">
<?php
$rq_txt = select("*","cat_lieu_txt","id_lieu",$id,"lgg");
while($dt_txt = ftc_ass($rq_txt)) {
	$id_lieu_txt = $dt_txt['id'];
	$lgg_exist[] = $dt_txt['lgg'];
?>
	<tr>
		<td class="nom_lgg"><?php echo $nom_lgg[$dt_txt['lgg']]; ?></td>
<?php
	if($aut['cat']) {
?>
		<td class="sup_lgg" onclick="sup_lgg(<?php echo $id_lieu_txt ?>);">
			<img src="../prm/img/sup.png" />
		</td>
<?php
	}
?>
		<td class="txt_lgg">
			<table class="w-100">
				<tr>
					<td class="w-100"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> placeholder="<?php echo $txt->phtitre->$id_lng; ?>" style="width: 100%;" value="<?php echo stripslashes(htmlspecialchars($dt_txt['titre'])) ?>" onchange="maj('cat_lieu_txt','titre',this.value,<?php echo $id_lieu_txt.','.$id ?>);" /></td>
				</tr>
			</table>
		</td>
	</tr>
<?php
}
?>
</table>
<?php
if($aut['cat']) {
?>
<span class="vdfp"><?php echo $txt->ajt->$id_lng.' :'; ?></span>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_lgg')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->lng->$id_lng; ?></div>
	</div>
	<div id="sel_lgg" class="cmd mw200">
		<div><input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('lieu','lgg',this.value,event);" /></div>
		<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
	</div>
</span>
<?php
}
?>