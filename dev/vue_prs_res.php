<?php
if(!$aut['dev'] and !$aut['res']){
?>
<div class="noselcol" style="background-color: <?php echo $col_res_prs[$id_res_prs] ?>;"><?php echo $res_prs[$id_lng][$id_res_prs]; ?></div>
<?php
}
else{
?>
<span class="dib">
	<div style="background-color: <?php echo $col_res_prs[$id_res_prs] ?>;" class="sel" onclick="vue_cmd('sel_res_prs<?php echo $id_dev_prs ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="res_prs<?php echo $id_dev_prs ?>" value="<?php echo $id_res_prs ?>" />
<?php
	echo $res_prs[$id_lng][$id_res_prs];
?>
		</div>
	</div>
	<div id="sel_res_prs<?php echo $id_dev_prs ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_res_prs<?php echo $id_dev_prs ?>" onkeyup="auto_lst('prs','prs_res<?php echo $id_dev_prs ?>',this.value,event);" />
		<div id="lst_prs_res<?php echo $id_dev_prs ?>"><?php include("vue_lst_res_prs.php") ?></div>
	</div>
</span>
<?php
}


if($dt_res_prs!='0000-00-00'){
?>
<span class="dib vat">
	<div style="padding: 2px; border: 1px solid grey">
		<span onmouseover="this.style.cursor='help'; this.title='<?php echo $txt->prstx->$id_lng; ?>'">
<?php
	if($tx_prs!=0 and $tx_prs!=1){echo ' $'.$tx_prs.' - ';}
	echo '('.$dt_res_prs.')';
?>
		</span>
	</div>
</span>
<?php
}
?>
