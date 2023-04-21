<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
?>
	<li id="enter_mdl<?php echo $id_dev_crc ?>" style="background-color: Chocolate;" onClick="ajt_mdl(0,<?php echo $id_cat_crc.','.$id_rgn ?>);"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
$rq_lst_mdl = select("cat_mdl.id,nom,info","cat_mdl_rgn INNER JOIN cat_mdl ON cat_mdl_rgn.id_mdl = cat_mdl.id","id_rgn",$id_rgn,"nom","DISTINCT");
while($dt_lst_mdl = ftc_ass($rq_lst_mdl)){
	if(substr(upnoac($dt_lst_mdl['nom']),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_mdl'.$id_dev_crc.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_mdl<?php echo $dt_lst_mdl['id'] ?>','cmd_mdl<?php echo $id_dev_crc ?>');"><?php echo stripslashes($dt_lst_mdl['nom']); if(!empty($dt_lst_mdl['info'])){echo stripslashes(' ['.$dt_lst_mdl['info'].']');} ?></span>
		<ul id="ul_mdl<?php echo $dt_lst_mdl['id'] ?>" class="cmd_mdl<?php echo $id_dev_crc ?>" style="display: none">
			<li onClick="ajt_mdl(<?php echo $dt_lst_mdl['id'].','.$id_cat_crc.','.$id_rgn ?>);document.getElementById('sel_mdl<?php echo $id_dev_crc ?>').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $dt_lst_mdl['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
