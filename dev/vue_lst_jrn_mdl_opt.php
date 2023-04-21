<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(!isset($lst_jrn_mdl_opt)){include("lst_jrn_mdl_opt.php");}
if(isset($lst_jrn_mdl_opt)){
	foreach($lst_jrn_mdl_opt as $id => $nom){
		if(substr(upnoac($nom),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_jrn_mdl_opt'.$id_dev_mdl.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_jrn_mdl_opt<?php echo $id.'_'.$id_dev_mdl ?>','cmd_jrn_mdl_opt<?php echo $id_dev_mdl ?>');"><?php echo stripslashes($nom); ?></span>
		<ul id="ul_jrn_mdl_opt<?php echo $id.'_'.$id_dev_mdl ?>" class="cmd_jrn_mdl_opt<?php echo $id_dev_mdl ?>" style="display: none">
			<li onClick="ajt_jrn(<?php echo $id.','.$id_dev_mdl.',-1' ?>);document.getElementById('sel_jrn_mdl_opt<?php echo $id_dev_mdl ?>').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $id ?>');"><?php echo $txt->opn->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
