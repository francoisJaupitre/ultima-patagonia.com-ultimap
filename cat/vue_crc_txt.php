<table class="w-100" class="lsb">
<?php

$rq_txt = select("*","cat_crc_txt","id_crc",$id,"lgg");
while($dt_txt = ftc_ass($rq_txt)) {
	$id_crc_txt = $dt_txt['id'];
	$lgg_exist[] = $dt_txt['lgg'];
	if($aut['web']) {
		$flg_web = true;
		$rq_mdp = sel_quo("web_mdp","cat_mdl_txt INNER JOIN cat_crc_mdl ON cat_mdl_txt.id_mdl = cat_crc_mdl.id_mdl",array("id_crc","lgg"),array($id,$dt_txt['lgg']));
		if(num_rows($rq_mdp)) {
			while($dt_mdp = ftc_ass($rq_mdp)) {
				if(!strlen($dt_mdp['web_mdp'])) {$flg_web = false;}
			}
		}
		else{$flg_web = false;}
	}
	else{$flg_web = false;}
?>
	<tr id="crc_web<?php echo $id_crc_txt; ?>"><?php include("vue_crc_web.php"); ?></tr>
	<tr>
		<td class="nom_lgg"><?php echo $nom_lgg[$dt_txt['lgg']]; ?></td>
<?php
	if($aut['cat']) {
?>
		<td class="remove-lgg" id="<?php echo $id_crc_txt ?>">
			<img src="../prm/img/sup.png" />
		</td>
<?php
	}
?>
		<td class="txt_lgg">
			<table class="w-100">
				<tr>
					<td class="w-100"><input type="text" <?php if(!$aut['cat']) {echo ' disabled';} ?> class="website" id="crc_txt_titre<?php echo $id_crc_txt ?>" placeholder="<?php echo $txt->phtitre->$id_lng; ?>" style="width: 100%;" value="<?php echo stripslashes(htmlspecialchars($dt_txt['titre'])) ?>" onchange="updateData('cat_crc_txt','titre',this.value,<?php echo $id_crc_txt.','.$id ?>);" /></td>
				</tr>
				<tr>
					<td>
						<div style="position: relative;">
							<div id="ld_crc_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="loader"><img style="position:relative;top:50%;transform: translateY(-50%)" src="../resources/gif/loader.gif"></div>
							<div id="crc_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="ust rich website" <?php if($aut['cat']) { ?> onclick="richTxtInit(this.id,'cat_crc_txt','dsc',<?php echo $id_crc_txt ?>);this.onclick=null;" <?php } ?> ><?php echo nl2br(stripslashes($dt_txt['dsc'])) ?></div>
							<div id="tool_crc_txt_dsc<?php echo $dt_txt['lgg'] ?>" class="tool"></div>
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
			<div><input type="text" id="ipt_sel_lgg" onkeyup="auto_lst('crc','lgg',this.value,event);" /></div>
			<div id="lst_lgg"><?php include("vue_lst_lgg.php") ?></div>
		</div>
	</span>
</div>
<?php
}
?>
