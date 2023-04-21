<ul class="lst_ul">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
	$event = 'ajt_srv(0,'.$id_dev_prs.','.$id_vll.','.$id_ctg_srv.');';
?>
	<li id="enter_prs_srv<?php echo $id_dev_prs ?>" style="background-color: Chocolate;" onClick="<?php echo $event; ?>"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(isset($id_vll) and $id_vll>0){
	$rq_lst_srv = select("id,nom,info,lgg","cat_srv","ctg=".$id_ctg_srv." AND id_vll",$id_vll,"nom","DISTINCT");
	while($dt_lst_srv = ftc_ass($rq_lst_srv)){
		if(substr(upnoac($dt_lst_srv['nom']),0,strlen($src))==$src){
			$event = 'ajt_srv('.$dt_lst_srv['id'].','.$id_dev_prs.','.$id_vll.','.$id_ctg_srv.');';
?>
	<li <?php if($flg_enter){echo 'id="enter_prs_srv'.$id_dev_prs.'" style="background-color: Chocolate;"';} ?>>
		<span class="dib" onClick="vue_cmd_ul('ul_<?php echo $cbl ?>_srv<?php echo $dt_lst_srv['id'].'_'; if($cbl=='prs'){echo $id_dev_prs;} elseif($cbl=='srv'){echo $id_dev_srv;} ?>','cmd_<?php echo $cbl ?>_srv<?php if($cbl=='prs'){echo $id_dev_prs;} elseif($cbl=='srv'){echo $id_dev_srv;} ?>');">
<?php
			$inf = ' ';
			if(!empty($dt_lst_srv['info'])){$inf .= '['.$dt_lst_srv['info'].']';}
			if($dt_lst_srv['lgg']>0){$inf .= '['.$nom_lgg_lgg[$id_lng][$dt_lst_srv['lgg']].']';}
 			echo stripslashes($dt_lst_srv['nom'].$inf);
?>
		</span>
		<ul id="ul_<?php echo $cbl ?>_srv<?php echo $dt_lst_srv['id'].'_'; if($cbl=='prs'){echo $id_dev_prs;} elseif($cbl=='srv'){echo $id_dev_srv;} ?>" class="cmd_<?php echo $cbl ?>_srv<?php if($cbl=='prs'){echo $id_dev_prs;} elseif($cbl=='srv'){echo $id_dev_srv;} ?>" style="display: none">
			<li onClick="<?php echo $event; ?>;document.getElementById('sel_srv_prs<?php echo $id_dev_prs ?>').style.display='none';"><?php echo $txt->ajt->$id_lng ?></li>
			<li onClick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_lst_srv['id'] ?>');"><?php echo $txt->cat->$id_lng ?></li>
		</ul>
	</li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
