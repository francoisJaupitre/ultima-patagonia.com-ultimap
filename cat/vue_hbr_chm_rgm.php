<?php
if(!$aut['cat'] or $vrl) {
?>
<span class="vdp">
<?php
	if($dt_chm['rgm']>0) {echo $rgm[$id_lng][$dt_chm['rgm']];}
	else{echo $txt->rgm->$id_lng;}
?>
</span>
<?php
}
else{
?>
<div class="sel" onclick="vue_cmd('sel_rgm_chm<?php echo $id_chm ?>')">
	<img src="../prm/img/sel.png" />
	<div style="<?php if($dt_chm['rgm']==0) {echo 'background-color: red; font-weight: bold;';}?>">
<?php
if($dt_chm['rgm']>0) {echo $rgm[$id_lng][$dt_chm['rgm']];}
else{echo $txt->rgm->$id_lng;}
?>
	</div>
</div>
<div id="sel_rgm_chm<?php echo $id_chm ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_rgm_chm<?php echo $id_chm ?>" onkeyup="auto_lst('hbr','rgm_chm<?php echo $id_chm ?>',this.value,event);" /></div>
	<div id="lst_rgm_chm<?php echo $id_chm ?>"><?php include("vue_lst_rgm.php") ?></div>
</div>
<?php } ?>
