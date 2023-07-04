<?php
if(!$aut['res'] or ($dt_res2['id_srv_res']!=0 and $dt_res2['id_srv_res']!=6)){
	if($id_frn>0){
?>
			<span class="dib lnk" onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn; ?>')"><?php echo $frn[$id_frn]; ?></span>
<?php
	}
	elseif($id_frn==0){echo $txt->nodef->$id_lng;}
	else{echo $txt->libre->$id_lng;}
}
else{
?>
<span class="dib" onClick="auto_lst('srv','frn<?php echo $id_dev_srv ?>',''); this.onclick=null;">
	<div class="sel" onclick="vue_cmd('sel_srv_frn<?php echo $id_dev_srv ?>')">
		<img src="../prm/img/sel.png" />
		<div>
			<input type="hidden" id="srv_frn<?php echo $id_dev_srv ?>" value="<?php echo $id_frn ?>" />
<?php
	if($id_frn>0){echo $frn[$id_frn];}
	elseif($id_frn==0){echo $txt->nodef->$id_lng;}
	else{echo $txt->libre->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_srv_frn<?php echo $id_dev_srv ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_srv_frn<?php echo $id_dev_srv ?>" onkeyup="auto_lst('srv','frn<?php echo $id_dev_srv ?>',this.value,event);" />
		<div id="lst_frn<?php echo $id_dev_srv ?>"><img src="../resources/gif/loader.gif"></div>
	</div>
</span>
<?php
}
?>
