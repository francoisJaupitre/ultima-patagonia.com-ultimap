<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_hbr_<?php echo $cbl.$id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="hbr_<?php echo $cbl.$id_dev_prs ?>" value="<?php echo $id_hbr ?>" />
<?php
if($id_hbr>0){
	$dt_hbr = ftc_ass(select("nom","cat_hbr","id",$id_hbr));
	echo stripslashes($dt_hbr['nom']);
	}
else{echo $txt->hbr->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_hbr_<?php echo $cbl.$id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_hbr_<?php echo $cbl.$id_dev_prs ?>" class="hbe_fll" onkeyup="auto_lst('<?php echo $cbl ?>','<?php echo $cbl ?>_hbr<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_<?php echo $cbl ?>_hbr<?php echo $id_dev_prs ?>"><?php include("vue_lst_hbr.php") ?></div>
	</div>
<?php
if($id_rgm >0 and $id_vll>0 and num_rows($rq_lst_hbr) > 0){
?>
	<span class="dib" onClick="vue_trf_hbr(<?php echo $id_dev_prs.',1,'.$id_hbr ?>);"><img src="../prm/img/hbr.jpg" /></span>
<?php
}
?>
</span>
<?php
if($id_hbr > 0 and $id_rgm > 0){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_chm_<?php echo $cbl.$id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->chm->$id_lng; ?></div>
	</div>
	<div id="sel_chm_<?php echo $cbl.$id_dev_prs ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_chm_<?php echo $cbl.$id_dev_prs ?>" class="hbr_fll" onkeyup="auto_lst('<?php echo $cbl ?>','<?php echo $cbl ?>_chm<?php echo $id_dev_prs ?>',this.value,event);" /></div>
		<div id="lst_<?php echo $cbl ?>_chm<?php echo $id_dev_prs ?>"><?php include("vue_lst_chm.php") ?></div>
	</div>
</span>
<?php
}
