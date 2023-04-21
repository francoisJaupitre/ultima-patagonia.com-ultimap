<br/>
<table class="ts2">
	<tr>
		<td class="cs6"><?php echo upnoac($txt_prg->jours->$id_lgg); ?></td>
		<td class="cs6"><?php echo $txt_prg->vll->$id_lgg; ?></td>
		<td class="cs6"><?php echo $txt_prg->ctg->$id_lgg; ?></td>
		<td class="cs6"><?php echo $txt_prg->hbr->$id_lgg; ?></td>
		<td class="cs6"><?php echo $txt_prg->chm->$id_lgg; ?></td>
	</tr>
<?php
foreach($hbr_id as $i => $id_hbr){
?>
	<tr>
<?php
	if($id_hbr>0){
		$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
		<td class="cs7"><?php echo $hbr_jrn[$id_hbr][$chm_id[$i]]; ?></td>
		<td class="cs7"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
		<td class="cs7"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
		<td class="cs7">
<?php
		if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
		elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
		else{echo stripslashes($dt_hbr['titre']);}
?>
		</td>
		<td class="cs7">
<?php
		if($chm_id[$i]!=0){
			$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id[$i]));
			if(!empty($dt_chm['titre'])){echo stripslashes($dt_chm['titre']);}
			else{echo stripslashes($dt_chm['nom']);}
		}
		else{echo $txt->err->chm->$id_lng;}
?>
		</td>
<?php
	}
	else{
?>
		<td class="cs7"><?php echo $hbr_jrn[$id_hbr][$vll_hbr[$i]]; ?></td>
		<td class="cs7"><?php echo stripslashes($vll[$vll_hbr[$i]]); ?></td>
		<td class="cs7"></td>
<?php
		if($id_hbr==-2){
?>
		<td class="cs7"><?php echo $txt_prg->libre->$id_lgg; ?></td>
		<td class="cs7"></td>
<?php
		}
		else{
?>
		<td class="cs7"><?php echo $txt->err->hbr->$id_lng; ?></td>
		<td class="cs7"></td>
<?php
		}
	}
?>
	</tr>
<?php
}
?>
</table>
<br/>
