<div style="float: right; padding-left: 5px; height: 22px; position: relative;" onclick="vue_cmd('vue_cmd_hbr<?php echo $dt_res2['id_dev_hbr'] ?>');">
<!--COMMANDES-->
	<img src="../prm/img/cmd.gif" />
	<div id="vue_cmd_hbr<?php echo $dt_res2['id_dev_hbr'] ?>" class="cmd wsn">
		<strong><?php echo $txt->commandes->$id_lng; ?></strong>
		<ul>
			<li onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_res2['id_cat_hbr'] ?>');document.getElementById('vue_cmd_hbr<?php echo $dt_res2['id_dev_hbr']; ?>').style.display='none';"><?php echo $txt->opn->$id_lng; ?></li>
<?php
if($aut['res']){
?>
			<li onclick="mailHbr(<?php echo $dt_res2['id_cat_hbr'].','.$dt_res2['id_cat_chm'].','.$dt_res['id_crc'] ?>);document.getElementById('vue_cmd_hbr<?php echo $dt_res2['id_dev_hbr'] ?>').style.display='none';"><?php echo $txt->mails->$id_lng; ?></li>
<?php
}
?>
			<li onclick="window.open('../fct/docx_hbr.php?id=<?php echo $dt_res['id_crc'];?>&hbr=<?php echo $dt_res2['id_cat_hbr'] ?>');document.getElementById('vue_cmd_hbr<?php echo $dt_res2['id_dev_hbr']; ?>').style.display='none';"><?php echo $txt->lst_res->$id_lng; ?></li>
		</ul>
	</div>
</div>
