<?php
$cbl='hbr';
if($id_hbr == 0 or ($id_hbr > 0 and $id_chm == 0)){
?>
<input <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> id="nom_chm<?php echo $id_dev_hbr ?>" type="text" style="background-color: tomato; width: 100%;" value="<?php echo stripslashes($nom_chm) ?>" onChange="maj('dev_hbr','nom_chm',this.value,<?php echo $id_dev_hbr ?>)" />
<?php
}
elseif($id_hbr>0){
	if($id_chm == -1){
		if(($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0)){
?>
<span>
	<div class="sel" onclick="vue_cmd('sel_chm_hbr<?php echo $id_dev_hbr ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->nodef->$id_lng; ?></div>
	</div>
	<div id="sel_chm_hbr<?php echo $id_dev_hbr ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_chm_hbr<?php echo $id_dev_hbr ?>" class="hbr_fll" onkeyup="auto_lst('hbr','hbr_chm<?php echo $id_dev_hbr ?>',this.value,event);" /></div>
		<div id="lst_hbr_chm<?php echo $id_dev_hbr ?>"><?php include("vue_lst_chm.php") ?></div>
	</div>
</span>
<?php
			if($id_rgm > 0 and $id_vll > 0 and num_rows($rq_lst_chm) > 0){
?>
<span class="dib" onClick="vue_trf_hbr(<?php echo $id_dev_prs.',1,0' ?>);"><img src="../prm/img/hbr.jpg" /></span>
<?php
			}
		}
		else{echo $txt->nodef->$id_lng;}
	}
	elseif($id_chm == -2){echo $txt->libre->$id_lng;}
	else{
		echo stripslashes($nom_chm);
		if($dt_hbr['crr_rgm']!=0){echo '<br />'.$rgm[$id_lng][$id_rgm];}
	}
}
?>
