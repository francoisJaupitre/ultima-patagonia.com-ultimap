<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if($id_frn>0 and substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_frn'.$id_dev_srv.'" style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $id_frn; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if($id_frn!=0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_frn'.$id_dev_srv.'" style="background-color: Chocolate;"';} ?> onClick="maj('dev_srv','id_frn','0',<?php echo $id_dev_srv ?>);src_srv(<?php echo $id_frn.',0,0,'.$id_dev_srv ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if($id_frn>-1 and substr(upnoac($txt->libre->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_frn'.$id_dev_srv.'" style="background-color: Chocolate;"';} ?> onClick="maj('dev_srv','id_frn','-1',<?php echo $id_dev_srv ?>);src_srv(<?php echo $id_frn.','.$id_ctg_srv.','.$id_vll.','.$id_dev_srv ?>);"><?php echo $txt->libre->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
$rq_frn = sel_whe("cat_frn.id,nom,info","cat_frn_vll INNER JOIN (cat_frn INNER JOIN cat_frn_ctg_srv ON cat_frn_ctg_srv.id_frn = cat_frn.id) ON cat_frn_vll.id_frn = cat_frn.id","cat_frn.id!=".$id_frn." AND ctg_srv = ".$id_ctg_srv." AND id_vll = ".$id_vll." AND lstrg = 0 AND ferme = 0","nom");
while($dt_lst_frn = ftc_ass($rq_frn)){
	if(substr(upnoac($dt_lst_frn['nom']),0,strlen($src))==$src){
		$dt = ftc_ass(sel_quo("id","frn_dsp",array("id_frn","date"),array($dt_lst_frn['id'],$date_jrn)));
?>
	<li <?php if($flg_enter){echo 'id="enter_frn'.$id_dev_srv.'" style="background-color: Chocolate;"';} ?>>
		<span <?php if(!empty($dt['id'])){echo ' style="text-decoration: line-through"';} ?> onClick="vue_cmd_ul('ul_srv_frn<?php echo $id_dev_srv.'_'.$dt_lst_frn['id']; ?>','cmd_srv<?php echo $id_dev_srv; ?>');"><?php echo stripslashes($dt_lst_frn['nom']); if(!empty($dt_lst_frn['info'])){echo stripslashes(' ['.$dt_lst_frn['info'].']');} ?></span>
		<ul id="ul_srv_frn<?php echo $id_dev_srv.'_'.$dt_lst_frn['id']; ?>" class="cmd_srv<?php echo $id_dev_srv; ?>" style="display: none">
			<li onClick="maj('dev_srv','id_frn',<?php echo $dt_lst_frn['id'].','.$id_dev_srv ?>); src_srv(<?php echo $dt_lst_frn['id'].','.$id_ctg_srv.','.$id_vll.','.$id_dev_srv ?>);"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt_lst_frn['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
