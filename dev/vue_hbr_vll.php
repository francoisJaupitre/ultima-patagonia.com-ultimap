<?php
$cbl='hbr';
?>
<div class="sel" onclick="vue_cmd('sel_vll_hbr<?php echo $id_dev_hbr ?>')">
	<img src="../prm/img/sel.png" />
	<div>
		<input type="hidden" id="vll_hbr<?php echo $id_dev_hbr ?>" value="<?php echo $id_vll ?>" />
<?php
if($id_vll > 0){echo stripslashes($vll[$id_vll]);}
else{echo $txt->vll->$id_lng;}
?>
	</div>
</div>
<div id="sel_vll_hbr<?php echo $id_dev_hbr ?>" class="cmd mw200">
	<div><input type="text" id="ipt_sel_vll_hbr<?php echo $id_dev_hbr ?>" class="vll_fll" onkeyup="auto_lst('hbr','hbr_vll<?php echo $id_dev_hbr ?>',this.value,event);" /></div>
	<div id="lst_hbr_vll<?php echo $id_dev_hbr ?>"><?php include("vue_lst_vll.php") ?></div>
</div>
