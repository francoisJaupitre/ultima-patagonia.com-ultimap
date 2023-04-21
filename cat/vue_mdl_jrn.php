<?php
$nb_jrn = ftc_ass(select("COUNT(*) as total","cat_mdl_jrn","id_mdl",$id));
if($nb_jrn['total']!=0) {
	if(!empty($dt_mdl['sel_mdl_jrn'])) {$sel_mdl_jrn = explode(",",$dt_mdl['sel_mdl_jrn']);}
	else{unset($sel_mdl_jrn);}
?>
<div class="fwb">
	<div class="tbl_crc" style="float:right">
		<div id="mdl_trf" class="lsb mdl_trf"><?php include("vue_mdl_trf.php"); ?></div>
	</div>
	<div class="div_cat lcrl"><?php echo $txt->jrns->$id_lng.' :'; ?></div>
</div>
<table class="w-100" >
<?php
	$ord_jrn = 0;
	$ord_sql = "ord, opt DESC,";
	if(isset($sel_mdl_jrn)) {
		$ord_sql .= "field(id_jrn";
		foreach ($sel_mdl_jrn as $id_jrn) {$ord_sql .= ",".$id_jrn;}
		$ord_sql .= ") DESC,";
	}
	$ord_sql .= " nom";
	$rq_mdl_jrn = sel_quo("cat_mdl_jrn.*,cat_jrn.nom,cat_jrn.info","cat_mdl_jrn LEFT JOIN cat_jrn ON cat_mdl_jrn.id_jrn = cat_jrn.id","id_mdl",$id,$ord_sql);
	while ($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)) {
		$id_mdl_jrn = $dt_mdl_jrn['id'];
		$id_jrn = $dt_mdl_jrn['id_jrn'];
		$opt_jrn = $dt_mdl_jrn['opt'];
		if($dt_mdl_jrn['ord']!=$ord_jrn) {
			$flg_sel_mdl_jrn  = true;
			if($ord_jrn!=0) {
				if($aut['cat']) {
?>
	<tr>
		<td class="dsg2" id="jrn_opt<?php echo $id_jrn_sel.'__'.$ord_jrn ?>"><input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->jrn->$id_lng ?>" onclick="vue_elem('jrn_opt<?php echo $id_jrn_sel.'__'.$ord_jrn ?>','<?php if(isset($jrn_opt_id)) {echo implode("_",$jrn_opt_id);}else{echo 0;} ?>');" /></td>
	</tr>
<?php
				}
?>
			</table>
		</td>
	</tr>
<?php
			}
			unset($jrn_opt_id);
			$ord_jrn = $dt_mdl_jrn['ord'];
			$id_jrn_sel = $id_jrn;
?>
	<tr>
		<td class="td_cat <?php if($opt_jrn or isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {echo 'dsg';} else{echo 'dsg2';} ?>"><input <?php if(!$aut['cat']) {echo ' disabled';} ?> type="number" class="w25" value="<?php echo $ord_jrn; ?>" onchange="maj('cat_mdl_jrn','ord',this.value,<?php echo $id_mdl_jrn.','.$id ?>)" /></td>
		<td>
			<table class="w-100">
<?php
		}
		$jrn_opt_id[] = $id_jrn;
?>
				<tr>
					<td width="45%" class="td_cat <?php if($opt_jrn or isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {echo 'dsg';} else{echo 'dsg2';} ?>">
						<table class="w-100">
							<tr>
								<td>
									<span class="lnk" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $id_jrn; ?>');"><?php echo stripslashes($dt_mdl_jrn['nom']); if(!empty($dt_mdl_jrn['info'])) {echo stripslashes(' ['.$dt_mdl_jrn['info'].']');} ?></span>
									<br/>
<?php
		echo '( ';
		$rq_lgg = select("lgg,titre,dsc","cat_jrn_txt","id_jrn",$id_jrn);
		while($dt_lgg = ftc_ass($rq_lgg)) {echo $lgg[$dt_lgg['lgg']].' ';}
		echo ')';
?>
								</td>
								<td><input <?php if(!$aut['cat'] or (isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) or !$flg_sel_mdl_jrn) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($opt_jrn) {$flg_sel_mdl_jrn  = false; echo('checked="checked"');} ?> onclick="if(this.checked) {maj('cat_mdl_jrn','opt','1',<?php echo $id_mdl_jrn.','.$id ?>)}else{maj('cat_mdl_jrn','opt','0',<?php echo $id_mdl_jrn.','.$id ?>)};" /></td>
								<td>
<?php
		unset($maj_sel_mdl_jrn);
		if(isset($sel_mdl_jrn)) {
			$maj_sel_mdl_jrn = $sel_mdl_jrn;
			if (!in_array($id_jrn,$sel_mdl_jrn)) {
				$rq_opt_jrn = sel_quo("id_jrn","cat_mdl_jrn",array("id_mdl","ord"),array($id,$dt_mdl_jrn['ord']));
				while ($dt_opt_jrn = ftc_ass($rq_opt_jrn)) {
					if (($key = array_search($dt_opt_jrn['id_jrn'], $maj_sel_mdl_jrn)) !== false) {unset($maj_sel_mdl_jrn[$key]);}
				}
				$maj_sel_mdl_jrn[] = $id_jrn;
			}
			else{
				unset($maj_sel_mdl_jrn[array_search($id_jrn, $maj_sel_mdl_jrn)]);
			}
		}
		else{$maj_sel_mdl_jrn[] = $id_jrn;}
?>
									<input <?php if(!$aut['cat'] or $opt_jrn or !$flg_sel_mdl_jrn) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if (!$opt_jrn and isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {$flg_sel_mdl_jrn  = false; echo('checked="checked"');} ?> onclick="maj('cat_mdl','sel_mdl_jrn','<?php echo implode(",",$maj_sel_mdl_jrn); ?>',<?php echo $id ?>);" />
								</td>
							</tr>
						</table>
					</td>
<?php
		if($aut['cat']) {
?>
					<td>
						<span class="dib"  <?php if($opt_jrn == 1) {echo ' onclick="sup_jrn('.$id_mdl_jrn.','.$ord_jrn.')"';} else{echo ' onclick="sup_jrn_opt('.$id_mdl_jrn.','.$ord_jrn.')"';} ?> ><img src="../prm/img/sup.png" /></span>
					</td>
<?php
		}
?>
					<td width="55%">
						<div class="jrn tbl_jrn dsg" style="width: 99%"><?php include("vue_dt_mdl.php"); ?></div>
					</td>
				</tr>
<?php
	}
	if($aut['cat']) {
?>
	<tr>
		<td class="dsg2" id="jrn_opt<?php echo $id_jrn_sel.'__0' ?>"><input type="button" value="<?php echo $txt->srcopt->$id_lng.' '.$txt->jrn->$id_lng ?>" onclick="vue_elem('jrn_opt<?php echo $id_jrn_sel.'__0' ?>','<?php if(isset($jrn_opt_id)) {echo implode("_",$jrn_opt_id);}else{echo 0;} ?>');" /></td>
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
<div class="lcrl fwb"><?php echo $txt->nojrn->$id_lng; ?></div>
<?php
}
if($aut['cat']) {
?>
<hr/>
<div class="dsg">
	<span class="vdfp"><?php echo $txt->ajtjrn->$id_lng.' :'; ?></span>
	<span id="mdl_vll" class="vll jrn"><?php include("vue_mdl_vll.php"); ?></span>
</div>
<?php
}
?>
