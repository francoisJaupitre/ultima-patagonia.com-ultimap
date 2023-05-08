<?php
if(isset($ids_rgn)){
?>
<span class="vdp">
<?php
	echo $txt->rgn->$id_lng.'(s) : ';
	foreach ($ids_rgn as $id_rgn) {echo '<strong>'.$rgn[$id_rgn].'</strong> | ';}
?>
</span>
<?php
	if($aut['dev']) {
?>
			<span class="dib">
				<div class="sel" onclick="vue_cmd('sel_rgn_mdl<?php echo $id_dev_mdl ?>')">
					<img src="../prm/img/sel.png" />
					<div><?php echo $txt->ajt->$id_lng; ?></div>
				</div>
				<div id="sel_rgn_mdl<?php echo $id_dev_mdl ?>" class="cmd mw200">
					<div><input type="text" id="ipt_sel_rgn_mdl<?php echo $id_dev_mdl ?>" onkeyup="auto_lst('mdl','mdl_rgn<?php echo $id_dev_mdl ?>',this.value,event);" /></div>
					<div id="lst_mdl_rgn<?php echo $id_dev_mdl ?>"><?php include("vue_lst_rgn.php") ?></div>
				</div>
			</span>
<?php
	}
}
?>
