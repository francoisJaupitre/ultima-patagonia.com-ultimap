<?php
if(!isset($id_cat_hbr)){$flg_sel = true;}
else{$flg_sel = false;}
if($opt_hbr){
?>
<input type="hidden" id="uid_hbr<?php echo $id_dev_hbr ?>" value="<?php echo $id_hbr ?>" />
<input type="hidden" id="uid_prs_vll<?php echo $id_dev_prs ?>" value="<?php echo $id_vll ?>" />
<input type="hidden" id="uid_prs_rgm<?php echo $id_dev_prs ?>" value="<?php echo $id_rgm ?>" />
<input type="hidden" id="uid_prs_hbr<?php echo $id_dev_prs ?>" value="<?php if($flg_sel){echo $id_hbr;} else{echo 0;} ?>" />
<?php
}
$cbl='hbr';
if($id_hbr == 0){
?>
<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="nom_hbr<?php echo $id_dev_hbr ?>" type="text" style="background-color: tomato; width: 100%;" value="<?php echo stripslashes($nom_hbr) ?>" onChange="maj('dev_hbr','nom',this.value,<?php echo $id_dev_hbr ?>)" />
<?php
}
elseif(($id_hbr == -1 and !$flg_sel) or ($id_hbr!=-2 and $flg_sel)){
	if(!$aut['dev']){
		if($id_hbr > 0){echo stripslashes($nom_hbr);}
		else{echo $txt->nodef->$id_lng;}
	}
	else{
?>
<div class="sel" onclick="vue_cmd('sel_hbr_hbr<?php echo $id_dev_hbr ?>')">
	<img src="../prm/img/sel.png" />
	<div>

<?php
		if($id_hbr > 0){echo stripslashes($nom_hbr);}
		else{echo $txt->nodef->$id_lng;}
?>
	</div>
</div>
<div id="sel_hbr_hbr<?php echo $id_dev_hbr ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_hbr_hbr<?php echo $id_dev_hbr ?>" class="hbr_fll" onkeyup="auto_lst('hbr','hbr_hbr<?php echo $id_dev_hbr ?>',this.value,event);" /></div>
	<div id="lst_hbr_hbr<?php echo $id_dev_hbr ?>"><?php include("vue_lst_hbr.php") ?></div>
</div>
<?php
	}
	if($id_hbr < 1 and $id_rgm > 0 and $id_vll > 0 and isset($rq_lst_hbr) and num_rows($rq_lst_hbr) > 0){
?>
<span class="dib" onClick="vue_trf_hbr(<?php echo $id_dev_prs.',1,0' ?>);"><img src="../prm/img/hbr.jpg" /></span>
<?php
	}
}
elseif($id_hbr == -2){echo $txt->libre->$id_lng;}
else{
?>
<span class="lnk inf<?php echo $id_cat_hbr ?>hbr" onmouseover="vue_elem('inf',<?php echo $id_cat_hbr ?>,'hbr')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id_cat_hbr ?>');"><?php echo stripslashes($nom_hbr); ?></span>
<?php
}
?>
