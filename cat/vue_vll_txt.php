<table class="lcrl w-100">
	<tr>
		<td class="fwb"><?php echo $txt->dsc->$id_lng; ?></td>
	</tr>
<?php
$rq_txt = select("*","cat_vll_txt","id_vll",$id,"lgg");
while($dt_txt = ftc_ass($rq_txt)) {
	$id_vll_txt = $dt_txt['id'];
	$lgg_exist[] = $dt_txt['lgg'];
?>
	<tr>
		<td class="nom_lgg"><?php echo $nom_lgg[$dt_txt['lgg']]; ?></td>
<?php
	if($aut['cat']) {
?>
		<td class="sup_lgg" onclick="sup_lgg(<?php echo $id_vll_txt ?>);">
			<img src="../prm/img/sup.png" />
		</td>
<?php
	}
?>
		<td class="txt_lgg">
			<table class="w-100">
				<tr>
					<td>
						<div style="position: relative;">
							<div id="ld_vll_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../prm/img/loader.gif"></div>
							<div id="vll_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="ust rich" <?php if($aut['cat']) { ?> onclick="richTxtInit(this.id,'cat_vll_txt','dsc',<?php echo $id_vll_txt ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dt_txt['dsc'])) ?></div>
							<div id="tool_vll_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="tool"></div>
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
			<div><input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('vll','lgg',this.value,event);" /></div>
			<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
		</div>
	</span>
</div>
<?php
}
?>
