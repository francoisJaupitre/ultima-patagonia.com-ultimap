<?php
$cbl = 'hbr';
$id_res = $dt_hbr['res'];
if(!$aut['res']){
	?>
<div class="noselcol" style="background-color: <?php echo $col_res_srv[$id_res] ?>;"><?php echo $res_srv[$id_lng][$id_res]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div style="background-color: <?php echo $col_res_srv[$id_res] ?>;" class="sel" onclick="vue_cmd('sel_res_hbr<?php echo $id_dev_hbr ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="res_hbr<?php echo $id_dev_hbr ?>" value="<?php echo $id_res ?>" />
<?php
	echo $res_srv[$id_lng][$id_res];
?>
		</div>
	</div>
	<div id="sel_res_hbr<?php echo $id_dev_hbr ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_res_hbr<?php echo $id_dev_hbr ?>" onkeyup="auto_lst('hbr','hbr_res<?php echo $id_dev_hbr ?>',this.value,event);" />
		<div id="lst_hbr_res<?php echo $id_dev_hbr ?>"><?php include("vue_lst_res_srv.php") ?></div>
	</div>
</span>	
<br/>
<?php
}
if($dt_hbr['res']==2 or $dt_hbr['rva']!=''){
?>
<input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> placeholder="<?php echo $txt->codrva->$id_lng; ?>" style="width: 120px;" value="<?php echo stripslashes($dt_hbr['rva']) ?>" onChange="maj('dev_hbr','rva',this.value,<?php echo $id_dev_hbr ?>)" />
<?php
}
?>