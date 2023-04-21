<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
?>
	<li id="enter_prs<?php echo $id_dev_jrn ?>" style="background-color: Chocolate;" onClick="ajt_prs(0,<?php echo $id_dev_jrn.',0,'.$id_ctg_prs.','.$id_cat_jrn.','.$id_dev_mdl ?>);"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(isset($id_vll) and $id_vll>0){
	$rq_lst_prs = select("cat_prs.id,cat_prs.nom,cat_prs.info","cat_prs INNER JOIN (cat_prs_lieu INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id) ON cat_prs_lieu.id_prs = cat_prs.id","ctg=".$id_ctg_prs." AND id_vll",$id_vll,"nom","DISTINCT");
	while($dt_lst_prs = ftc_ass($rq_lst_prs)){
		if(substr(upnoac($dt_lst_prs['nom']),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_prs'.$id_dev_jrn.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_prs<?php echo $dt_lst_prs['id'].'_'.$id_dev_jrn ?>','cmd_prs<?php echo $id_dev_jrn ?>');"><?php echo stripslashes($dt_lst_prs['nom']); if(!empty($dt_lst_prs['info'])){echo stripslashes(' ['.$dt_lst_prs['info'].']');}; ?></span>
		<ul id="ul_prs<?php echo $dt_lst_prs['id'].'_'.$id_dev_jrn ?>" class="cmd_prs<?php echo $id_dev_jrn ?>" style="display: none">
			<li onClick="ajt_prs(<?php echo $dt_lst_prs['id'].','.$id_dev_jrn.',0,'.$id_ctg_prs.','.$id_cat_jrn.','.$id_dev_mdl ?>);document.getElementById('sel_prs<?php echo $id_dev_jrn ?>').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_lst_prs['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>

<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
