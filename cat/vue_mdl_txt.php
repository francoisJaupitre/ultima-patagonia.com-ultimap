<table class="lslm w-100">
<?php
$rq_txt = select("*","cat_mdl_txt","id_mdl",$id,"lgg");
while($dt_txt = ftc_ass($rq_txt)) {
	$id_mdl_txt = $dt_txt['id'];
	$lgg_exist[] = $dt_txt['lgg'];
?>
	<tr id="mdl_web<?php echo $id_mdl_txt; ?>"><?php include("vue_mdl_web.php"); ?></tr>
	<tr>
		<td class="nom_lgg"><?php echo $nom_lgg[$dt_txt['lgg']]; ?></td>
<?php
	if($aut['cat'])
	{
?>
		<td class="remove-lgg" id="<?php echo $id_mdl_txt ?>">
			<img src="../prm/img/sup.png" />
		</td>
<?php
	}
?>
		<td class="txt_lgg">
			<table class="w-100">
				<tr>
					<td class="w-100"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="website" id="mdl_txt_titre<?php echo $id_mdl_txt ?>" placeholder="<?php echo $txt->phtitre->$id_lng; ?>" style="width: 100%;" value="<?php echo stripslashes(htmlspecialchars($dt_txt['titre'])) ?>" onchange="updateData('cat_mdl_txt','titre',this.value,<?php echo $id_mdl_txt.','.$id ?>);" /></td>
				</tr>
<?php
	if(!empty($dt_txt['web_uid'])) {
?>
				<tr>
					<td>
						<div style="position: relative;">
							<div id="ld_mdl_txt_web_dsc<?php echo $dt_txt['lgg'] ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../resources/gif/loader.gif"></div>
							<div id="mdl_txt_web_dsc<?php echo $dt_txt['lgg'] ?>" class="ust rich website" <?php if($aut['cat']) { ?> onclick="richTxtInit(this.id,'cat_mdl_txt','web_dsc',<?php echo $id_mdl_txt ?>);this.onclick=null;" <?php } ?> ><?php if(empty($dt_txt['web_dsc'])) {echo '<em>Website module description</em>';} else{echo nl2br(stripslashes($dt_txt['web_dsc']));} ?></div>
							<div id="tool_mdl_txt_web_dsc<?php echo $dt_txt['lgg'] ?>" class="tool"></div>
						</div>
					</td>
				</tr>
<?php
	}
?>
				<tr>
					<td>
						<div style="position: relative;">
							<div id="ld_mdl_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../resources/gif/loader.gif"></div>
							<div id="mdl_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="ust rich" <?php if($aut['cat']) { ?> onclick="richTxtInit(this.id,'cat_mdl_txt','dsc',<?php echo $id_mdl_txt ?>);this.onclick=null;" <?php } ?> ><?php  if(empty($dt_txt['dsc'])) {echo '<em>Quotation module description</em>';} else{echo nl2br(stripslashes($dt_txt['dsc']));} ?></div>
							<div id="tool_mdl_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="tool"></div>
						</div>
					</td>
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
<div class="dsg">
	<span class="vdfp"><?php echo $txt->ajt->$id_lng.' :'; ?></span>
	<span class="dib">
		<div class="sel" onclick="vue_cmd('sel_lgg')">
			<img src="../prm/img/sel.png" />
			<div><?php echo $txt->lng->$id_lng; ?></div>
		</div>
		<div id="sel_lgg" class="cmd mw200">
			<div><input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('mdl','lgg',this.value,event);" /></div>
			<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
		</div>
	</span>
</div>
<?php
}
?>
