<?php
$dt_grp = ftc_ass(select("nomgrp","grp_dev","id",$grp_crc));
if(!$aut['dev'] or !$flg_grp or $cnf>0){   //remplacer $flg_grp par un message d'erreur expliquant le motif du rejet.
?>
<div class="nosel lnk" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $grp_crc; ?>');"><?php echo stripslashes($dt_grp['nomgrp']); ?></div>
<?php
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_grp')">
		<img src="../prm/img/sel.png" />
		<div><?php echo stripslashes($dt_grp['nomgrp']); ?></div>
	</div>
	<div id="sel_grp" class="cmd mw200">
		<div><input type="text" id="ipt_sel_grp" onkeyup="auto_lst('crc','grp',this.value,event);" /></div>
		<div id="lst_grp"><?php include("vue_lst_grp.php") ?></div>
	</div>
</span>
<?php
}
?>
