<?php
$nb_mdl = ftc_ass(select("COUNT(*) as total","cat_crc_mdl","id_crc",$id));
if($nb_mdl['total']!=0) {
?>
<div class="fwb">
	<div class="tbl_crc" style="float:right">
		<div id="crc_trf" class="lsb crc_trf"><?php include("vue_crc_trf.php"); ?></div>
	</div>
	<div class="div_cat lslm"><?php echo $txt->mdls->$id_lng.' :'; ?></div>
</div>
<table class="w-100">
<?php
	$nb_j=1;
	$rq_crc_mdl = select("*","cat_crc_mdl","id_crc",$id,"ord");
	while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {
		$id_crc_mdl = $dt_crc_mdl['id'];
		$ord_mdl = $dt_crc_mdl['ord'];
		if(!empty($dt_crc_mdl['sel_mdl_jrn'])) {$sel_mdl_jrn = explode(",",$dt_crc_mdl['sel_mdl_jrn']);}
		else{unset($sel_mdl_jrn);}
		$id_mdl = $dt_crc_mdl['id_mdl'];
		$dt_mdl = ftc_ass(select("nom,info","cat_mdl","id",$id_mdl));
?>
	<tr>
		<td class="td_cat dsg"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $ord_mdl; ?>" onchange="maj('cat_crc_mdl','ord',this.value,<?php echo $id_crc_mdl.','.$id ?>);" /></td>
		<td width="20%" class="td_cat dsg">
			<span class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $id_mdl ?>');"><?php echo stripslashes($dt_mdl['nom']); if(!empty($dt_mdl['info'])) {echo stripslashes(' ['.$dt_mdl['info'].']');} ?></span>
			<br/>
<?php
		echo '( ';
		$rq_lgg = select("lgg","cat_mdl_txt","id_mdl",$id_mdl);
		while($dt_lgg = ftc_ass($rq_lgg)) {echo $lgg[$dt_lgg['lgg']].' ';}
		echo ')';
?>
		</td>
<?php
		if($aut['cat']) {
?>
		<td class="dsg">
			<span class="dib" onclick="sup_mdl(<?php echo $id_crc_mdl.','.$ord_mdl ?>);"><img src="../prm/img/sup.png" /></span>
		</td>
<?php
		}
?>
		<td width="75%">
			<div class="tbl_mdl" style="width: 99%">
<?php
		$nb_jrn = ftc_ass(select("COUNT(*) as total","cat_mdl_jrn","id_mdl",$id_mdl));
		if($nb_jrn['total']!=0) {
?>
				<div class="lcrl fwb"><?php echo $txt->jrns->$id_lng.' :'; ?></div>
				<table class="w-100">
<?php
			$ord_jrn = 0;
			$rq_mdl_jrn = sel_quo("cat_mdl_jrn.*,cat_jrn.nom,cat_jrn.info","cat_mdl_jrn LEFT JOIN cat_jrn ON cat_mdl_jrn.id_jrn = cat_jrn.id","id_mdl",$id_mdl,"ord, opt DESC, nom");
			while ($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)) {
				$id_mdl_jrn = $dt_mdl_jrn['id'];
				$id_jrn = $dt_mdl_jrn['id_jrn'];
				$opt_jrn = $dt_mdl_jrn['opt'];
				if($opt_jrn or $dt_mdl_jrn['ord']!=$ord_jrn) {$flg_jrn = true;}
				if($flg_jrn) {
?>
					<tr>
						<td width="30px" class="td_cat <?php if($opt_jrn or isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {echo 'dsg';} else{echo 'dsg2';} ?>">
<?php
					unset($maj_sel_mdl_jrn);
					if($opt_jrn) {
						echo $nb_j;
						$nb_j++;
						$flg_jrn = false;//option journees independantes uniquement pour website
					}
					else{
						if(isset($sel_mdl_jrn)) {
							$maj_sel_mdl_jrn = $sel_mdl_jrn;
							if (!in_array($id_jrn,$sel_mdl_jrn)) {
								$rq_opt_jrn = sel_quo("id_jrn","cat_mdl_jrn",array("id_mdl","ord"),array($id_mdl,$dt_mdl_jrn['ord']));
								while ($dt_opt_jrn = ftc_ass($rq_opt_jrn)) {
									if (($key = array_search($dt_opt_jrn['id_jrn'], $maj_sel_mdl_jrn)) !== false) {unset($maj_sel_mdl_jrn[$key]);}
								}
								$maj_sel_mdl_jrn[] = $id_jrn;
							}
							else{
								unset($maj_sel_mdl_jrn[array_search($id_jrn, $maj_sel_mdl_jrn)]);
								echo $nb_j;
								$nb_j++;
							}
						}
						else{$maj_sel_mdl_jrn[] = $id_jrn;}
?>
						<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if (isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {echo('checked="checked"');} ?> onclick="maj('cat_crc_mdl','sel_mdl_jrn','<?php echo implode(",",$maj_sel_mdl_jrn); ?>',<?php echo $id_crc_mdl.','.$id ?>);" />
<?php
					}
?>
						</td>
						<td width="20%" class="td_cat <?php if($opt_jrn or isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {echo 'dsg';} else{echo 'dsg2';} ?>">
							<span class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $id_jrn ?>');"><?php echo stripslashes($dt_mdl_jrn['nom']); if(!empty($dt_mdl_jrn['info'])) {echo stripslashes(' ['.$dt_mdl_jrn['info'].']');} ?></span>
							<br/>
<?php
					echo '( ';
					$rq_lgg = select("lgg","cat_jrn_txt","id_jrn",$id_jrn);
					while($dt_lgg = ftc_ass($rq_lgg)) {echo $lgg[$dt_lgg['lgg']].' ';}
					echo ')';
?>
						</td>
						<td width="75%" class="dsg">
							<div class="tbl_jrn" style="width: 99%"><?php include("vue_dt_mdl.php"); ?></div>
						</td>
					</tr>
<?php
				}
				$ord_jrn = $dt_mdl_jrn['ord'];
			}
?>
				</table>
<?php
		}
		else{
?>
				<div class="lcrl fwb"><?php echo $txt->nojrn->$id_lng; ?></div>
<?php
		}
?>
			</div>
		</td>
	</tr>
<?php
		if($dt_crc_mdl['ord']<$nb_mdl['total']) {
?>
</table>
<div class="dsg">
	<strong><?php echo $txt->fus->$id_lng; ?></strong>
	<input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_crc_mdl['fus']) {echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_crc_mdl','fus','1',<?php echo $id_crc_mdl ?>,<?php echo $id ?>)}else{maj('cat_crc_mdl','fus','0',<?php echo $id_crc_mdl ?>,<?php echo $id ?>)};" />
</div>
<table class="w-100">
<?php
			if($dt_crc_mdl['fus']==1) {$nb_j--;}
		}
	}
?>
</table>
<?php
}
else{
?>
<div class="lslm fwb"><?php echo $txt->nomdl->$id_lng; ?></div>
<?php
}
if($aut['cat']) {
?>
<hr/>
<div class="dsg">
	<span class="vdfp"><?php echo $txt->ajtmdl->$id_lng.' :'; ?></span>
	<span id="crc_rgn" class="rgn"><?php include("vue_crc_rgn.php"); ?></span>
</div>
<?php
}
?>
