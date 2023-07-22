<?php
$nb_prs = ftc_ass(select("COUNT(*) as total","cat_jrn_prs","id_jrn",$id));
if($nb_prs['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->prss->$id_lng.' :'; ?></div>
<table class="dsg w-100">
<?php
	$ord_prs = 0;
	$rq_jrn_prs = select("cat_jrn_prs.*,cat_prs.nom,cat_prs.ctg,cat_prs.info","cat_jrn_prs LEFT JOIN cat_prs ON cat_jrn_prs.id_prs = cat_prs.id","id_jrn",$id,"ord, opt DESC, nom");
	while($dt_jrn_prs = ftc_ass($rq_jrn_prs)) {
		$id_jrn_prs = $dt_jrn_prs['id'];
		$id_prs = $dt_jrn_prs['id_prs'];
		$opt_prs = $dt_jrn_prs['opt'];
		if($dt_jrn_prs['ord']!=$ord_prs) {
			if($ord_prs!=0) {
?>
	<tr>
		<td id="prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>"><input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->prs->$id_lng ?>" onclick="vue_elem('prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>','<?php if(isset($prs_opt_id)) {echo implode("_",$prs_opt_id);}else{echo 0;} ?>');" /></td>
	</tr>
			</table>
		</td>
	</tr>
<?php
			}
			unset($prs_opt_id);
			$ord_prs = $dt_jrn_prs['ord'];
			$ctg_opt = $dt_jrn_prs['ctg'];
			$id_prs_sel = $id_prs;
?>
	<tr>
		<td class="td_cat"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $ord_prs; ?>" onchange="updateData('cat_jrn_prs','ord',this.value,<?php echo $id_jrn_prs.','.$id ?>)" /></td>
		<td>
			<table class="w-100">
<?php
		}
		$prs_opt_id[] = $id_prs;
		$inf = ' ';
?>
				<tr>
					<td width="30%" class="td_cat">
						<table class="w-100">
							<tr>
								<td><?php echo $ctg_prs[$id_lng][$dt_jrn_prs['ctg']]; ?></td>
								<td>
									<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id_prs; ?>');"><?php echo stripslashes($dt_jrn_prs['nom']); if(!empty($dt_jrn_prs['info'])) {echo stripslashes(' ['.$dt_jrn_prs['info'].']');} ?></span>
									<br/>
<?php
		echo '( ';
		$rq_lgg = select("lgg","cat_prs_txt","id_prs",$id_prs);
		while($dt_lgg = ftc_ass($rq_lgg)) {echo $lgg[$dt_lgg['lgg']].' ';}
		echo ')';
?>
								</td>
								<td><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($opt_prs) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_jrn_prs','opt','1',<?php echo $id_jrn_prs.','.$id ?>)}else{updateData('cat_jrn_prs','opt','0',<?php echo $id_jrn_prs.','.$id ?>)};" /></td>
							</tr>
						</table>
					</td>
<?php
		if($aut['cat']) {
?>
					<td>
						<span class="dib" <?php if($opt_prs == 1) {echo ' onclick="sup_prs('.$id_jrn_prs.','.$ord_prs.')"';} else{echo ' onclick="sup_prs_opt('.$id_jrn_prs.','.$ord_prs.')"';} ?> ><img src="../prm/img/sup.png" /></span>
					</td>
<?php
		}
?>
					<td width="65%">
						<div class="tbl_prs" style="width: 99%"><?php include("vue_dt_jrn.php"); ?></div>
					</td>
				</tr>
<?php
	}
?>
	<tr>
		<td id="prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>"><input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->prs->$id_lng ?>" onclick="vue_elem('prs_opt<?php echo $id_prs_sel.'__'.$ord_prs.'__'.$ctg_opt ?>','<?php if(isset($prs_opt_id)) {echo implode("_",$prs_opt_id);}else{echo 0;} ?>');" /></td>
	</tr>
<?php
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
if($aut['cat']) {
?>
<hr/>
<div class="dsg">
	<span class="vdfp"><?php echo $txt->ajtprs->$id_lng.' :'; ?></span>
	<span id="jrn_prs_vll_ctg" class="vll prs"><?php $cbl='jrn_prs'; include("vue_jrn_vll_prs_ctg.php"); ?></span>
</div>
<?php
}
?>
