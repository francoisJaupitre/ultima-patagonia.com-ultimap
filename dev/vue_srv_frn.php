<?php
$cbl = 'srv';
$id_frn = $dt_srv['id_frn'];
$dt_frn = ftc_ass(select("nom","cat_frn","id",$id_frn));
$dt = ftc_ass(select("id","frn_dsp","id_frn=".$id_frn." and date",$date_jrn));
if(!$aut['res'] or ($dt_srv['res']!=0 and $dt_srv['res']!=6)){
	if($id_frn>0){
?>
<span class="lnk inf<?php echo $id_frn ?>frn" onmouseover="vue_elem('inf',<?php echo $id_frn ?>,'frn')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn ?>');"><?php echo stripslashes($dt_frn['nom']); ?></span>
<?php
	}
	elseif($id_frn==0){echo $txt->nodef->$id_lng;}
	else{echo $txt->libre->$id_lng;}
}
else{
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_srv_frn<?php echo $id_dev_srv ?>')">
		<img src="../prm/img/sel.png" />
		<div <?php if(!empty($dt['id'])){echo ' style="text-decoration: line-through"';} ?>>
			<input type="hidden" id="srv_frn<?php echo $id_dev_srv ?>" value="<?php echo $id_frn ?>" />
<?php
	if($id_frn>0){echo stripslashes($dt_frn['nom']);}
	elseif($id_frn==0){echo $txt->nodef->$id_lng;}
	else{echo $txt->libre->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_srv_frn<?php echo $id_dev_srv ?>" class="cmd mw200">
		<input type="text" id="ipt_sel_srv_frn<?php echo $id_dev_srv ?>" class="frn_fll" onkeyup="auto_lst('srv','frn<?php echo $id_dev_srv ?>',this.value,event);" />
		<div id="lst_frn<?php echo $id_dev_srv ?>"><?php include("vue_lst_frn.php") ?></div>
	</div>
</span>
<?php
}
?>
