<?php
$cbl = 'srv';
$id_res = $dt_srv['res'];
if(!$aut['res'] or $dt_srv['id_frn']==0){
?>
<div class="noselcol" style="background-color: <?php echo $col_res_srv[$id_res] ?>;"><?php echo $res_srv[$id_lng][$id_res]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div style="background-color: <?php echo $col_res_srv[$id_res] ?>;" class="sel" onclick="vue_cmd('sel_res_srv<?php echo $id_dev_srv ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="res_srv<?php echo $id_dev_srv ?>" value="<?php echo $id_res ?>" />
<?php
	echo $res_srv[$id_lng][$id_res];
?>
		</div>
	</div>
	<div id="sel_res_srv<?php echo $id_dev_srv ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_res_srv<?php echo $id_dev_srv ?>" onkeyup="auto_lst('srv','srv_res<?php echo $id_dev_srv ?>',this.value,event);" />
		<div id="lst_srv_res<?php echo $id_dev_srv ?>"><?php include("vue_lst_res_srv.php") ?></div>
	</div>
</span>
<br/>
<?php
}
if(($dt_srv['res']==2 or $dt_srv['rva']!='') and $id_ctg_prs != 19 and $id_ctg_prs != 20){
?>
<input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> placeholder="<?php echo $txt->codrva->$id_lng; ?>" style="width: 120px;" value="<?php echo stripslashes($dt_srv['rva']) ?>" onChange="maj('dev_srv','rva',this.value,<?php echo $id_dev_srv ?>)" />
<?php
}
?>
