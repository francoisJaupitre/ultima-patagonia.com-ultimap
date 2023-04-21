<?php
$nb_prs = ftc_ass(select("COUNT(*) as total","cat_jrn_prs","id_jrn",$id_jrn));
if($nb_prs['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->prss->$id_lng.' :'; ?></div>
<table class="w-100">
<?php
	$ord_prs = 0;
	$rq_jrn_prs = select("*","cat_jrn_prs","id_jrn",$id_jrn,"ord, opt DESC");
	while($dt_jrn_prs = ftc_ass($rq_jrn_prs)) {
		$id_jrn_prs = $dt_jrn_prs['id'];
		$id_prs = $dt_jrn_prs['id_prs'];
		$opt_prs = $dt_jrn_prs['opt'];
		$dt_prs = ftc_ass(select("ctg,nom,info","cat_prs","id",$id_prs));
		if($dt_jrn_prs['ord']!=$ord_prs) {
			if($ord_prs!=0) {
?>
			</table>
		</td>
	</tr>
<?php
			}

			$ord_prs = $dt_jrn_prs['ord'];
			$id_prs_opt = $id_prs;
?>
	<tr>
		<td class="td_cat"><?php echo $ord_prs; ?></td>
		<td class="w-100">
			<table class="td_cat w-100">
<?php
		}
?>
				<tr>
					<td width="20%"><?php echo $ctg_prs[$id_lng][$dt_prs['ctg']]; ?></td>
					<td width="75%">
						<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id_prs ?>');"><?php echo stripslashes($dt_prs['nom']); if(!empty($dt_prs['info'])) {echo stripslashes(' ['.$dt_prs['info'].']');} ?></span>
						<br/
<?php
		echo '( ';
		$rq_lgg = select("lgg,titre,dsc","cat_prs_txt","id_prs",$id_prs);
		while($dt_lgg = ftc_ass($rq_lgg)) {echo $lgg[$dt_lgg['lgg']].' ';}
		echo ')';
?>
					</td>
					<td width="5%"><input type="checkbox" <?php if ($opt_prs) {echo 'checked="checked"';} ?> disabled /></td>
				</tr>
<?php
	}
?>
			</table>
		</td>
	</tr>
</table>
<?php
}
else{
?>
<div class="lmcf fwb"><?php echo $txt->noprs->$id_lng; ?></div>
<?php
}
?>
