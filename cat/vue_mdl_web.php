<?php
if(strlen($dt_txt['titre'])) {
?>
<td>
<?php
	if($aut['web']) {
?>
	<button onclick="insertWebsite('mdl','<?php echo $dt_txt['web_uid'] ?>',<?php echo $dt_txt['id']; ?>,'<?php echo $dt_txt['lgg'] ?>','<?php echo $lgg[$dt_txt['lgg']] ?>');document.getElementById('vue_cmd_mdl<?php echo $id ?>').style.display='none';"><?php if(strlen($dt_txt['web_mdp'])>0) {echo $txt->web_edt->$id_lng;}elseif(strlen($dt_txt['titre'])>0) {echo $txt->web_pub->$id_lng;} ?></button>
<?php
	}
?>
</td>
<td></td>
<td class="w-100">
<?php
	if(!empty($dt_txt['web_uid'])) {
?>
	<span <?php if(strlen($dt_txt['web_mdp'])>0){echo 'onclick="window.open(\''.$url.$lgg[$dt_txt['lgg']].'/module/'.$dt_txt['web_uid'].'\');"';} ?>>
		<input type="text" <?php if(!$aut['web'] or strlen($dt_txt['web_mdp'])>0) {echo ' disabled';} ?> id="mdl_txt_web_uid<?php echo $id_mdl_txt ?>" style="width: 100%;" value="<?php echo $dt_txt['web_uid']; ?>" onchange="updateData('cat_mdl_txt','web_uid',this.value,<?php echo $id_mdl_txt ?>);" />
	</span>
<?php
	}
?>
	<input type="hidden" id="mdp<?php echo $dt_txt['lgg']; ?>" value="<?php if(!empty($dt_txt['web_mdp'])) {echo $dt_txt['web_mdp'];} ?>" />
</td>
<?php
}
?>
