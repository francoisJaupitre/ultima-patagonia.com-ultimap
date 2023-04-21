<?php
$cbl = 'srv';
if(!$aut['res'] or $dt_res2['id_frn']==0){
?>
<div class="noselcol" style="background-color: <?php echo $col_res_srv[$dt_res2['id_srv_res']] ?>;"><?php echo $res_srv[$id_lng][$dt_res2['id_srv_res']]; ?></div>
<?php
}
else{
?>
<span class="dib" onClick="auto_lst('srv','srv_res<?php echo $dt_res2['id_dev_srv'] ?>',''); this.onclick=null;">
	<div style="background-color: <?php echo $col_res_srv[$dt_res2['id_srv_res']] ?>;" class="sel" onclick="vue_cmd('sel_res_srv<?php echo $dt_res2['id_dev_srv'] ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="res_srv<?php echo $dt_res2['id_dev_srv'] ?>" value="<?php echo $dt_res2['id_srv_res'] ?>" />
<?php
	echo $res_srv[$id_lng][$dt_res2['id_srv_res']];
?>
		</div>
	</div>
	<div id="sel_res_srv<?php echo $dt_res2['id_dev_srv'] ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_res_srv<?php echo $dt_res2['id_dev_srv'] ?>" onkeyup="auto_lst('srv','srv_res<?php echo $dt_res2['id_dev_srv'] ?>',this.value,event);" />
		<div id="lst_srv_res<?php echo $dt_res2['id_dev_srv'] ?>"><img src="../prm/img/loader.gif"></div>
	</div>
</span>
<br/>
<?php
}
if(($dt_res2['id_srv_res']==2 or $dt_res2['id_srv_rva']!='') and $dt_res['id_prs_ctg']!=19 and $dt_res['id_prs_ctg']!=20){
?>
<input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> placeholder="<?php echo $txt->codrva->$id_lng; ?>" style="width: 120px;" value="<?php echo stripslashes($dt_res2['id_srv_rva']) ?>" onChange="maj('dev_srv','rva',this.value,<?php echo $dt_res2['id_dev_srv'] ?>)" />
<?php
}
?>
