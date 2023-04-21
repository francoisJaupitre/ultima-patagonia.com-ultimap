<?php
if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){
	if($dt_pax['ncn']>0){echo $ncn[$id_lng][$dt_pax['ncn']];}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_pax_ncn<?php echo $dt_pax['id']; ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php if($dt_pax['ncn']>0){echo $ncn[$id_lng][$dt_pax['ncn']];} else{echo $txt->nodef->$id_lng;} ?></div>
	</div>
	<div id="sel_pax_ncn<?php echo $dt_pax['id']; ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_pax_ncn<?php echo $dt_pax['id']; ?>" onkeyup="auto_lst('grp','pax_ncn<?php echo $dt_pax['id']; ?>',this.value,event);" /></div>
		<div id="lst_pax_ncn<?php echo $dt_pax['id']; ?>"><?php include("vue_lst_ncn.php") ?></div>
	</div>
</span>
 <?php
}
?>
