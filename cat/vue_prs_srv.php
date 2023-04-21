<?php
$nb_srv = ftc_ass(select("COUNT(*) as total","cat_prs_srv","id_prs",$id));
if($nb_srv['total']!=0) {
?>
<div class="tht fwb"><?php echo $txt->srvs->$id_lng.' :'; ?></div>
<table class="dsg">
<?php
	$rq_srv = select("cat_srv.id as id_srv,lgg, cat_prs_srv.id as id_prs_srv, cat_prs_srv.opt as opt, cat_srv.id_vll as id_vll, cat_srv.ctg as ctg, cat_srv.nom as nom,cat_srv.info as info","cat_prs_srv INNER JOIN cat_srv ON cat_srv.id = cat_prs_srv.id_srv","id_prs",$id,"opt DESC,ctg,id_vll,nom");
	while($dt_srv = ftc_ass($rq_srv)) {
		$id_srv = $dt_srv['id_srv'];
		$id_prs_srv = $dt_srv['id_prs_srv'];
		$inf = ' ';
		if ($dt_srv['lgg'] >0) {$inf .= '['.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].']';}
		if (!empty($dt_srv['info'])) {$inf .= '['.$dt_srv['info'].']';}
?>
	<tr>
		<td width="30%" class="td_cat"><?php echo $vll[$dt_srv['id_vll']]; ?></td>
		<td width="30%" class="td_cat"><?php echo $ctg_srv[$id_lng][$dt_srv['ctg']]; ?></td>
		<td width="30%" class="lnk_cat">
			<span class="dib" onClick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $id_srv; ?>');"><?php echo stripslashes($dt_srv['nom'].$inf); ?></span>
		</td>

		<td class="td_cat">
			<input id="chk_opt<?php echo $id_prs_srv ?>" class="cat_img chk_img" <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_srv['opt']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_prs_srv','opt','1',<?php echo $id_prs_srv ?>)}else{maj('cat_prs_srv','opt','0',<?php echo $id_prs_srv ?>)};" />
			<label class="dib" for="chk_opt<?php echo $id_prs_srv ?>"><img src="../prm/img/opt.png" /></label>
		</td>
<?php
		if($aut['cat']) {
?>
		<td>
			<span class="dib" onclick="sup_srv(<?php echo $id_prs_srv ?>)"><img src="../prm/img/sup.png" /></span>
		</td>
<?php
		}
?>
	<tr/>
<?php
	}
?>
</table>
<hr/>
<?php
}
?>
