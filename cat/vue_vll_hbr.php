<td>
<?php
if(!$aut['cat']) {
	if($id_hbr>0) {
		$dt_hbr = ftc_ass(select("nom","cat_hbr","id",$id_hbr));
		echo $dt_hbr['nom'];
	}
	else{echo $txt->nodef->$id_lng;}
}
else{
?>
	<div class="sel" onclick="vue_cmd('sel_hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
	if($id_hbr>0) {
		$dt_hbr = ftc_ass(select("nom","cat_hbr","id",$id_hbr));
		echo $dt_hbr['nom'];
	}
	else{echo $txt->nodef->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>" onkeyup="auto_lst('vll','hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>',this.value,event);" /></div>
		<div id="lst_hbr<?php echo $id_hbr_def.'_'.$id_rgm ?>"><?php include("vue_lst_hbr.php") ?></div>
	</div>
<?php
}
?>
</td>
<td>
<?php
if($id_hbr>0) {
	if(!$aut['cat']) {
		if($id_chm>0) {
			$dt_chm = ftc_ass(select("nom","cat_hbr_chm","id",$id_chm));
			echo $dt_chm['nom'];
		}
		else{echo $txt->nodef->$id_lng;}
	}
	else{
?>
	<div class="sel" onclick="vue_cmd('sel_chm<?php echo $id_hbr_def.'_'.$id_rgm ?>')">
		<img src="../prm/img/sel.png" />
		<div>
<?php
		if($id_chm>0) {
			$dt_chm = ftc_ass(select("nom","cat_hbr_chm","id",$id_chm));
			echo $dt_chm['nom'];
		}
		else{echo $txt->nodef->$id_lng;}
?>
		</div>
	</div>
	<div id="sel_chm<?php echo $id_hbr_def.'_'.$id_rgm ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_chm<?php echo $id_hbr_def.'_'.$id_rgm ?>" onkeyup="auto_lst('vll','chm<?php echo $id_hbr_def.'_'.$id_rgm ?>',this.value,event);" /></div>
		<div id="lst_chm<?php echo $id_hbr_def.'_'.$id_rgm ?>"><?php include("vue_lst_chm.php") ?></div>
	</div>
<?php
	}
}
?>
</td>
