<?php
if($dt_res2['id_frn']>0){
?>
<div style="float: right; padding-left: 5px; height: 22px; position: relative;" onclick="vue_cmd('vue_cmd_srv<?php echo $dt_res2['id_dev_srv'] ?>');">
<!--COMMANDES-->
	<img src="../prm/img/cmd.gif" />
	<div id="vue_cmd_srv<?php echo $dt_res2['id_dev_srv'] ?>" class="cmd wsn">
		<strong><?php echo $txt->commandes->$id_lng; ?></strong>
		<ul>
			<li onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt_res2['id_frn'] ?>');document.getElementById('vue_cmd_srv<?php echo $dt_res2['id_dev_srv']; ?>').style.display='none';"><?php echo $txt->opn->$id_lng; ?></li>
<?php
	if($aut['res']){
?>
			<li onclick="mel_frn(<?php echo $dt_res2['id_frn'].','.$dt_res['id_crc'] ?>);document.getElementById('vue_cmd_srv<?php echo $dt_res2['id_dev_srv'] ?>').style.display='none';"><?php echo $txt->mails->$id_lng; ?></li>
<?php
	}
?>
			<li onclick="window.open('../fct/docx_frn.php?id=<?php echo $dt_res['id_crc'] ?>&frn=<?php echo $dt_res2['id_frn'] ?>');document.getElementById('vue_cmd_srv<?php echo $dt_res2['id_dev_srv']; ?>').style.display='none';"><?php echo $txt->lst_res->$id_lng; ?></li>
		</ul>
	</div>
</div>
<?php
}
?>
